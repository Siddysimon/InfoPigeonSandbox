<?php
//only get to this page by hitting submit button
if (isset($_POST['login-submit'])) {

require 'dbh.inc.php';
require 'elgg.inc.php';

//user has option of either using email or username
$mailuid = $_POST['mailuid'];
$password = $_POST['pwd'];
if (empty($mailuid) || empty($password)){
  //not returning username for login attempts
  header("Location: ../index.php?error=emptyfields");
  exit();
}
else {
  //as stated in signup.inc.php, prepared statements = secure database
$sql = "SELECT * FROM users WHERE uidUsers=? OR emailUsers=?";
$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt, $sql)) {
  //sql error
  header("Location: ../index.php?error=sqlerror1");
  exit();
}
else{
  //are the mailuid and passwword correct?
  mysqli_stmt_bind_param($stmt, "ss", $mailuid, $mailuid);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  //is $result empty or not? (aka is there a user w/ this mailuid)
  // ...associative array should be created
  if ($row = mysqli_fetch_assoc($result)){
    //check if pwd is correct and act accordingly
    $pwdCheck = password_verify($password, $row['pwdUsers']);
    if ($pwdCheck == false){
      header("Location: ../index.php?error=wrongpassword");
      exit();
    }
    else if ($pwdCheck == true){

      //starting a session
      session_start();
      $_SESSION['userId'] = $row['idUsers'];
      $_SESSION['userUid'] = $row['uidUsers'];
      $_SESSION['userEmail'] = $row['emailUsers'];

      //login elgg user
      //don't need to use elgg_authenticate, since already authenticated

      $username = $row['uidUsers'];
      SESSION_DESTROY();
      require_once('/Applications/XAMPP/xamppfiles/htdocs/sites/elgg/elgg-2.3.14/vendor/elgg/elgg/engine/start.php');
      $user = get_user_by_username ($username);
      login($user, false);
      
      //CHANGE THIS WHEN UPLOADED:
      header("Location: http://localhost/sites/elgg/elgg-2.3.14/activity");
      exit();
    }
    //if $pwdCheck is somehow not a bool
    else{
      header("Location: ../index.php?error=wrongpassword");
      exit();
    }
  }
  else{
    header('Location: ../index.php?error=nouser2');
    exit();
  }
}

}
}
else{
  header("Location: ../index.php");
  exit();
}
