<?php
require "header.php";
?>
  <main>
    <?php
    //EXPORT DATABASE WHEN UPLOADED ONLINE
    //this is where we change content based on if you're logged in or not
    if (isset($_SESSION['userId'])) {
      echo '<p style="color:#ffffff" align = "center">You are logged in.</p>';
    }
    else{
      //password reset?
      if (isset($_GET['newpwd'])) {
        if ($_GET["newpwd" == "passwordupdated"]){
          echo '<p class= "signupsuccess" style="color:#ffffff" align = "center">Your password has been reset.</p>';
        }
      }
          else {
          echo '<p style="color:#ffffff" align = "center">You are logged out.</p>';
        }
    }
     ?>
  </main>
