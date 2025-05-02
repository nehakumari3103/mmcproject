<?php
$host = "localhost";
$user = "root"; // change if needed
$pass = "";     // change if needed
$db = "magadh_college";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
?>