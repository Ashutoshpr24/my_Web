<?php
session_start();
require_once "../config/db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: ../auth/login.php");
    exit;
}

if (!isset($_GET["id"])) {
    header("Location: view.php");
    exit;
}

$user_id = $_SESSION["user_id"];
$contact_id = $_GET["id"];

// deleting only if the contact belongs to logged-in user
$query = "DELETE FROM contacts WHERE id = ? AND user_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "ii", $contact_id, $user_id);
mysqli_stmt_execute($stmt);

// redirecting back to contacts page
header("Location: view.php");
exit;
