<?php
// db configuration
$server = "localhost";
$user = "root";
$password = "";
$database = "contact_manager";

$conn = mysqli_connect($server, $user, $password, $database);

// checking connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
