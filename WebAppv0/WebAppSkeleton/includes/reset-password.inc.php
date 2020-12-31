<?php
if (isset($_POST["reset-password-submit"])) {
$selector = $_POST["selector"];
$validator = $_POST["validator"];
$password = $_POST["pwd"];
$passwordRepeat = $_POST["pwd-repeat"];

if (empty($password) || empty($passwordRepeat)) {
  header("Location: ../create-new-password.php?newpwd=empty&selector=".$selector."&validator=".bin2hex($token));
  exit();
} else if ($password !== $passwordRepeat) {
  header("Location: ../create-new-password.php?pwdnotsameselector=".$selector."&validator=".bin2hex($token));
  exit();
}
$currentDate = date("U");

require 'dbh.inc.php';

//looking for pwdreset in accordance w/ selector token
$sql = "SELECT * FROM pwdReset WHERE pwdResetSelector=? AND pwdResetExpires >=?; "; //placeholder for date technically unneccesary
$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt, $sql)) {
  echo "There was an error! (statement prep failed)";
  exit();
} else{
  mysqli_stmt_bind_param($stmt, "ss", $selector, $currentDate);
  mysqli_stmt_execute($stmt);

  $result = mysqli_stmt_get_result($stmt);
  //if you can grab a row from the database
  if (!$row = mysqli_fetch_assoc($result)) {
    echo "Please resubmit your reset request.";
    exit();
  } else {
    //making sure the tokens match
     $tokenBin = hex2bin($validator);
     $tokenCheck = password_verify($tokenBin, $row["pwd-reset-token"]);
     if ($tokenCheck === false) {
       echo "Please resubmit your reset request.";
       exit();
     } else if ($tokenCheck === true) {
       //grabbing email:
       $tokenEmail = $row['pwdResetEmail'];

       //selecting user
       $sql = "SELECT * FROM users WHERE emailUsers=?;";
       $stmt = mysqli_stmt_init($conn);
       if (!mysqli_stmt_prepare($stmt, $sql)) {
         echo "There was an error! (statement prep failed)";
         exit();
       } else{
          mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
          mysqli_stmt_execute($stmt);

          $result = mysqli_stmt_get_result($stmt);
          //if you can grab a row from the database
          if (!$row = mysqli_fetch_assoc($result)) {
            echo "There was an error.";
            exit();
          } else {
            $sql = "UPDATE users SET pwdUsers=? WHERE emailUsers=?";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
              echo "There was an error! (statement prep failed)";
              exit();
            } else{
              //hashing new pwd before going into database:
              $newPwdHash = password_hash($password, PASSWORD_DEFAULT);
               mysqli_stmt_bind_param($stmt, "ss", $newPwdHash, $tokenEmail);
               mysqli_stmt_execute($stmt);}

               //deleting tokens:
               $sql = "DELETE FROM pwdReset WHERE pwdResetEmail=?;";
               $stmt = mysqli_stmt_init($conn);
               if (!mysqli_stmt_prepare($stmt, $sql)) {
                 echo "There was an error! (statement prep failed)";
                 exit();
               } else{
                  mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                  mysqli_stmt_execute($stmt);
                  header("Location: ../index.php?newpwd=passwordupdated");
                }



       }

     } else {
       echo "Please resubmit your reset request.";
       exit();
     }
  }
}

} else{
  header("Location: ../signup.php");
  exit();
}

 ?>
