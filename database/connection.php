<?php
$servername = "localhost";
$dbname = "db_nt3101";
$username = "root";
$password = "";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("" . $conn->connect_error);
}
?>

 <?php

//  $sql = "SELECT * FROM tbadminacc AS acc JOIN tbempinfo AS emp ON acc.empid = emp.empid";