<?php
require_once('PHPMailer/PHPMailerAutoload.php');
//only get to this page by hitting submit button
if (isset($_POST['reset-request-submit'])) {
  //creating token...translating to hex for later
$selector = bin2hex(random_bytes(8));
//this one has to be a bit more secure:
$token = random_bytes(32);

//this should really be the website url attached with:
// "/forgottenpwd/create-new-password.php?selector=".$selector."&validator=".bin2hex($token)"
$url = "http://localhost/WebAppv0/create-new-password.php?selector=".$selector."&validator=".bin2hex($token);

//time in seconds since 1970, adding 1 hour, which is on the longer side
$expires = date("U") + 1800;

//database connection file:
require 'dbh.inc.php';

//getting form info:
$userEmail = $_POST['email'];

//need to access database & delete any existing tokens for user:
$sql = "DELETE FROM pwdReset WHERE pwdResetEmail=?;"; //using prepared statements (hence the "?")
$stmt = mysqli_stmt_init($conn);

if (!mysqli_stmt_prepare($stmt, $sql)) {
  echo "There was an error! (statement prep failed)";
  exit();
} else{
  mysqli_stmt_bind_param($stmt, "s", $userEmail);
  mysqli_stmt_execute($stmt);
}
//now inserting into database:
$sql = "INSERT INTO pwdReset (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) VALUES (?, ?, ?, ?);";
$stmt = mysqli_stmt_init($conn);

if (!mysqli_stmt_prepare($stmt, $sql)) {
  echo "There was an error! (statement insertion failed)";
  exit();
} else{
  //using bcrypt
  $hashedToken = password_hash($token, PASSWORD_DEFAULT);
  mysqli_stmt_bind_param($stmt, "ssss", $userEmail, $selector, $hashedToken, $expires);
  mysqli_stmt_execute($stmt);
}
 mysqli_stmt_close($stmt);
 mysqli_close($conn);

//sending email:

$mail = new PHPMailer();
$mail->isSMTP();
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'ssl';
$mail->Host = 'smtp.gmail.com';
$mail->Port = '465';
$mail->isHTML(); //allows for html emails
    //your email credentials:
$mail->Username = 'siddysimon@gmail.com';
$mail->Password = '...'; //
$mail->SetFrom('siddysimon@gmail.com');

$message = '<p> We received a password reset request. If you did not make this request,
you can ignore this message. Here is the link to reset your password:</p></br>';
//"continuation trick":
$message .= '<a href ="' . $url . '">' . $url . '</a></p>';
$mail->Subject = $message;

$mail->AddAddress($userEmail);

$mail->Send();

if(!$mail->Send())
        echo "Mailer Error: " . $mail->ErrorInfo;
    else
        echo "Message has been sent";
//
// $to = $userEmail;
// $subject = 'Reset your InfoPigeon password';
//
// //which info to send with email:
// $header = "From: Team <theteam@infopigeon.com>\r\n";
// $header .= "Reply-To: theteam@infopigeon.com\r\n";
// $header .= "Content-type: text/html\r\n";
//
// mail($to, $subject, $message, $headers);

header("Location:../reset-password.php?Reset=Successful");
}
else{
  //if submit button wasn't pressed, send back to index page
  header("Location: ../reset-password.php");
  exit();
}
