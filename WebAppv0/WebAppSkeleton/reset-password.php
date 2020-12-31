<?php require "header.php"; ?>

<style>
<?php include 'infopigeon.css'; ?>
</style>
//change header text to a proper logo later?
?>
  <main>
    <div class="wrapper-main">
      <section class="section-default">
    <h1 style= "text-align: center;">Reset your password</h1>
    <p style= "text-align: center;">An email will be sent to you to reset your password.</p>
    <form action="includes/reset-request.inc.php" method="post">
      <input type="text" name="email" placeholder="Enter Your Email Address">
      <button type="submit" name="reset-request-submit">Reset Password</button>
    </form>
    <?php
    if (isset($_GET["reset"])) {
      if($_GET["reset"] == "success") {
        echo '<p class="signupsuccess">Check your email!</p>';
      }
    }
    //change header text to a proper logo later?
    ?>
  </section>
  </div>
  </main>
