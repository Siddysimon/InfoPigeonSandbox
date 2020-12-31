<?php
require "header.php";
//change header text to a proper logo later?
?>
  <main>
    <div class="wrapper-main">
      <section class="section-default">
    <h1 style= "text-align: center;">Sign Up</h1>
    <?php
      if (isset($_GET['error'])){
        if ($_GET['error']=="emptyfields"){
           echo '<p  style="color:#ffffff" align = "center">Field(s) left empty.</p>';
        }
      }
     ?>
    <form action="includes/signup.inc.php" method="post">
      <input type="text" name="uid" placeholder="Username">
      <input type="text" name="mail" placeholder="Email">
      <input type="text" name="dispname" placeholder="Name of Individual/Organization">
      <input type="password" name="pwd" placeholder="Password">
      <input type="password" name="pwd-repeat" placeholder="Re-Type Password">
      <button type="submit" name="signup-submit">Sign Up</button>
    </form>
  </section>
  </div>
  </main>
