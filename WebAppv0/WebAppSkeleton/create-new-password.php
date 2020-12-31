<?php
require "header.php";
//change header text to a proper logo later?
?>
  <main>
    <div class="wrapper-main">
      <section class="section-default">
    <?php
    //getting info from URL
    $selector = $_GET["selector"];
    $validator = $_GET["validator"];

    if (empty($selector) || empty($validator)) {
      echo "Could not validate your request!";
    } else{
      //checking if they're legit tokens
      if (ctype_xdigit($selector) === true && ctype_xdigit($validator) === true) {
        ?>
        <form  action="reset-password.inc.php" method="post">
          <input type="hidden" name="selector" value="<?php echo $selector; ?>">
          <input type="hidden" name="validator" value="<?php echo $validator; ?>">
          <input type="password" name="pwd" placeholder="Enter a new password...">
          <input type="password" name="pwd-repeat" placeholder="Retype new password...">
          <button  type="submit" name="reset-password-submit">Reset Password</button>
        </form>
        <?php
      }
    }
     ?>
  </section>
  </div>
  </main>
