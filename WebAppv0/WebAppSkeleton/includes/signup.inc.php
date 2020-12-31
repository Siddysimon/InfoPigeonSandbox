<?php
//only get to this page by hitting submit button
if (isset($_POST['signup-submit'])) {

//connect to regular & elgg databases
  require 'dbh.inc.php';
  require 'elgg.inc.php';

  $username = $_POST['uid'];
  $email = $_POST['mail'];
  $displayname = $_POST['dispname'];
  $password = $_POST['pwd'];
  $passwordRepeat = $_POST['pwd-repeat'];
//blank fields?
  if (empty($username) || empty($email) || empty($displayname) || empty($password) || empty($passwordRepeat)) {
    header("Location: ../signup.php?error=emptyfields&uid=".$username."&mail=".$email."&displayname=".$displayname);
    exit();
  }
//if email and username are invalid...changes what we return
  else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)){
    header("Location: ../signup.html?error=InvalidUsernameAndEmail&displayname=".$displayname);
    exit();
  }
  //only email invalid
  else if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
    header("Location: ../signup.html?error=InvalidEmail&uid=".$username."&displayname=".$displayname);
    exit();
  }
  //only username invalid
  else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)){
    header("Location: ../signup.html?error=InvalidUsername&mail=".$email."&displayname=".$displayname);
    exit();
  }
  //password retyped incorrectly
  else if ($password !== $passwordRepeat){
    header("Location: ../signup.html?error=passwordcheck&uid=".$username."&mail=".$email."&displayname=".$displayname);
    exit();
  }

   //username taken?...skipping lines between else & bracket cuz I like it more
  else{
    //can't just use username, because then ppl could destroy mysql database by typing code as username
    $sql = "SELECT uidUsers FROM users WHERE uidUsers=?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      //sql error
      header("Location: ../signup.html?error=sqlerror");
      exit();
    }
    else{
      mysqli_stmt_bind_param($stmt, "s", $username);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_store_result($stmt);
      $resultCheck = mysqli_stmt_num_rows($stmt);
      if ($resultCheck > 0) {
        //user taken error
        header("Location: ../signup.html?error=existingusername&mail=".$email."&displayname=".$displayname);
        exit();
      }


      //all errors avoided, so now insert user info:
      else {
          $sql = "INSERT INTO users (uidUsers, emailUsers, displaynameUsers, pwdUsers) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_stmt_init($conn);
          if (!mysqli_stmt_prepare($stmt, $sql)) {
            //sql error
            header("Location: ../signup.php?error=sqlerror");
            exit();
          }
          else{
            //using bcrypt hash
            $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
            mysqli_stmt_bind_param($stmt, "ssss", $username, $email, $displayname, $hashedPwd);
            mysqli_stmt_execute($stmt); //just inserting no fetching so ..._store_result(); is unneeded

            //CHANGE THIS WHEN UPLOADED:
            require_once('/Applications/XAMPP/xamppfiles/htdocs/sites/elgg/elgg-2.3.14/vendor/elgg/elgg/engine/start.php');

            $guid = register_user($username, $password, $displayname, $email, false);
            $new_user = get_entity($guid);
            $new_user->access_id = 2;
            $new_user->admin_created = false;
            $new_user->enable();
            //successful signup
            header("Location: http://localhost/sites/elgg/elgg-2.3.14/activity?signup=success");
            exit();
          }
      }
    }
  }
  //disconnecting database to save resources, instead of relying on auto close
  //UNCLEAR IF WE WANT TO KEEP THIS LATER ON:
  mysqli_stmt_close($stmt);
  mysqli_close($conn);
}
//if submit button wasn't pressed, send back to signup page
else{
  header("Location: ../signup.html");
  exit();
}
