<?php
//change servername when we actually put it online
$servername = "localhost";
$dBUsername = "root";
$dBPassword = "";
$dBName = "elgg";

$conn2 = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);

if (!$conn2) {
  die("Connection failed: ".mysqli_connect_error());
}
