<?php 
// $dbServerName = "p4d-evo-clone-nlb-1068a1dbb7264bf1.elb.eu-west-2.amazonaws.com";
// $dbUsername = "admin";
// $dbPassword = "pTc78L7SSjAK7SyK";
// $dbName = "p4d";

$dbServerName = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "naijaart_lvi_db";

// create connection
$conn = new mysqli($dbServerName, $dbUsername, $dbPassword, $dbName) or die(mysqli_error());

// check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


?>