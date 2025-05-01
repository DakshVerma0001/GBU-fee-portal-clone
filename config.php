<?php
// config.php

$host = "localhost";
$user = "root"; // default user for XAMPP
$password = ""; // default password for XAMPP
$dbname = "college_fee_portal";

$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
