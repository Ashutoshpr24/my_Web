<?php
session_start();
require_once "../config/db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: ../auth/login.php");
    exit;
}

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST["name"]);
    $phone = trim($_POST["phone"]);
    $email = trim($_POST["email"]);
    $user_id = $_SESSION["user_id"];

    if (empty($name) || empty($phone)) {
        $error = "Name and phone are required";
    } else {
//insert contacts
        $query = "INSERT INTO contacts (user_id, name, phone, email) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "isss", $user_id, $name, $phone, $email);

        if (mysqli_stmt_execute($stmt)) {
            $success = "✅ Contact added successfully!";
        } else {
            $error = "❌ Something went wrong. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Contact</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 0;
        }

        .form-box {
            max-width: 450px;
            margin: 80px auto;
            background: #ffffff;
            padding: 25px;
            border-radius: 6px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-top: 0;
            color: #333;
        }

        label {
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: #ffffff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover {
            background-color: #218838;
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }

        .success {
            color: green;
            text-align: center;
            margin-bottom: 10px;
        }

        .back {
            text-align: center;
            margin-top: 15px;
        }

        .back a {
            text-decoration: none;
            color: #007bff;
        }
    </style>
</head>
<body>

<div class="form-box">

    <h2>Add Contact ➕</h2>

    <?php if ($error) { ?>
        <p class="error"><?= $error ?></p>
    <?php } ?>

    <?php if ($success) { ?>
        <p class="success"><?= $success ?></p>
    <?php } ?>

    <form method="POST">
        <label>Name</label>
        <input type="text" name="name" required>

        <br><br>

        <label>Phone</label>
        <input type="text" name="phone" required>

        <br><br>

        <label>Email</label>
        <input type="email" name="email">

        <br>

        <button type="submit">Save Contact</button>
    </form>

    <div class="back">
        <a href="view.php">← Back to Contacts</a>
    </div>

</div>

</body>
</html>
