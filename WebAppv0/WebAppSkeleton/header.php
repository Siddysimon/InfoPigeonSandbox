<?php
session_start();
?>
<html>
<style>
* {box-sizing: border-box;}

/* Style the navbar */
.topnav {
  overflow: hidden;
  background-color: #000000;
}

/* Navbar links */


/* Navbar links on mouse-over */
.topnav a {
  padding:20;
  margin:0;
  font-family: arial;
  color:white;
  text-decoration: underline overline;
}

/* Style the input container */
.topnav .login-container {
  float: right;
}

/* Style the input field inside the navbar */
.topnav input[type=text] {
  display: block;
  padding: 1px;
  margin: 0 auto;
  font-size: 14px;
  border: none;
  width: 300px; /* adjust as needed (as long as it doesn't break the topnav) */
}

.topnav input[type=password] {
  display: block;
  padding: 1px;
  margin: 0 auto;
  font-size: 14px;
  border: none;
  width: 300px; /* adjust as needed (as long as it doesn't break the topnav) */
}

/* Style the button inside the input container */
.topnav .login-container button {
  float: right;
  padding: 6px;
  margin-top: 8px;
  margin-right: 16px;
  background: #000000;
  font-size: 17px;
  border: none;
  cursor: pointer;
}

.topnav .login-container button:hover {
  background-color:#000000;

}

/* Add responsiveness - On small screens, display the navbar vertically instead of horizontally */
@media screen and (max-width: 600px) {
  .topnav .login-container {
    float: none;
  }
  .topnav a, .topnav input[type=text], .topnav input[type=passwword], .topnav .login-container button {
    float: none;
    display: block;
    text-align: left;
    width: 100%;
    margin: 0;
    padding: 5px;
  }
  .topnav input[type=text], .topnav input[type=passwword] {
    border: 1px solid #fff;
  }
}
body{
    background-color:black;
    padding:0;
    margin:0;
}
  h1{
    padding:20;
    margin:0;
    font-family: sans-serif;
    color:white;
    text-decoration: underline;
  }

  form > div {
    margin-bottom: 20px;
  }

  .button, button, input {
    background-color:black;
    color:white;
    display: block;
    font-family: arial;
    font-size: 100%;
    padding: 0;
    margin: 0 auto;
    box-sizing: border-box;
    width: 40%;
    padding: 5px;
    height: 30px;
  }


  button {
    width: 40%;
    margin: 0 auto;
  }

  header{
      background-color:#000000;
  }
</style>
</head>
<header>
 <h1 style="text-align: center;"><img src="infopigeon.png" alt="infopigeon" width="288" height="41" /></h1>


</header>
<body>

</body>
