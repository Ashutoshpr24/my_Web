<?php
// database configuration
$server = "localhost";
$user = "root";
$password = "";
$database = "contact_manager";

// create connection
$conn = mysqli_connect($server, $user, $password, $database);

// check connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
