<?php
session_start();
require_once "config/db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: auth/login.php");
    exit;
}

$user_name = $_SESSION["user_name"] ?? "User";

$user_id = $_SESSION["user_id"];
$countQuery = "SELECT COUNT(*) AS total FROM contacts WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $countQuery);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);
$totalContacts = $data["total"];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 900px;
            margin: 50px auto;
            background: #ffffff;
            padding: 25px;
            border-radius: 6px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h2 {
            margin-top: 0;
            color: #333;
        }

        hr {
            margin: 20px 0;
        }

        .stats {
            background: #eef2f5;
            padding: 15px;
            border-radius: 4px;
        }

        .cards {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .cards a.card {
            flex: 1;
            min-width: 220px;
            padding: 20px;
            border-radius: 6px;
            text-align: center;
            font-weight: bold;
            text-decoration: none;
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .cards a.card:hover {
            transform: scale(1.05);
        }

        .card.add { background-color: #28a745; }
        .card.view { background-color: #007bff; }
        .card.update { background-color: #ffc107; color: #000; }
        .card.delete { background-color: #dc3545; }

        .logout {
            color: red;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="container">

    <h2>Welcome, <?= htmlspecialchars($user_name) ?> 👋</h2>

    <p>This is your dashboard. You can manage your contacts from here.</p>

    <hr>

    <div class="stats">
        <strong>📊 Total Contacts:</strong> <?= $totalContacts ?>
    </div>

    <hr>

    <h3>Contact Management</h3>

    <div class="cards">

        <a href="contacts/add.php" class="card add">
            ➕<br>
            <strong>Add Contact</strong><br>
        </a>

        <a href="contacts/view.php" class="card view">
            📋<br>
            <strong>View Contacts</strong><br>
        </a>

        <a href="contacts/view.php" class="card update">
            ✏️<br>
            <strong>Edit Contacts</strong><br>
        </a>

        <a href="contacts/view.php" class="card delete">
            🗑️<br>
            <strong>Delete Contacts</strong><br>
        </a>

    </div>

    <hr>

    <a href="auth/logout.php" class="logout">🚪 Logout</a>

</div>

</body>
</html>
