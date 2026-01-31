<?php
session_start();
require_once "../config/db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION["user_id"];
$error = "";
$success = "";

if (!isset($_GET["id"])) {
    header("Location: view.php");
    exit;
}

$contact_id = $_GET["id"];

// fetching contacts only if it belongs to logged-in user
$query = "SELECT * FROM contacts WHERE id = ? AND user_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "ii", $contact_id, $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$contact = mysqli_fetch_assoc($result);

if (!$contact) {
    header("Location: view.php");
    exit;
}

// update logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST["name"]);
    $phone = trim($_POST["phone"]);
    $email = trim($_POST["email"]);

    if (empty($name) || empty($phone)) {
        $error = "Name and phone are required";
    } else {

        $updateQuery = "UPDATE contacts SET name = ?, phone = ?, email = ? 
                        WHERE id = ? AND user_id = ?";
        $stmt = mysqli_prepare($conn, $updateQuery);
        mysqli_stmt_bind_param($stmt, "sssii", $name, $phone, $email, $contact_id, $user_id);

        if (mysqli_stmt_execute($stmt)) {
            $success = "✅ Contact updated successfully!";
            // updating $contact array to reflect changes
            $contact["name"] = $name;
            $contact["phone"] = $phone;
            $contact["email"] = $email;
        } else {
            $error = "❌ Something went wrong. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Contact</title>
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
            background-color: #ffc107;
            color: #000;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover {
            background-color: #e0a800;
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

    <h2>Edit Contact ✏️</h2>

    <?php if ($error) { ?>
        <p class="error"><?= $error ?></p>
    <?php } ?>

    <?php if ($success) { ?>
        <p class="success"><?= $success ?></p>
    <?php } ?>

    <form method="POST">
        <label>Name</label>
        <input type="text" name="name" value="<?= htmlspecialchars($contact["name"]) ?>" required>

        <br><br>

        <label>Phone</label>
        <input type="text" name="phone" value="<?= htmlspecialchars($contact["phone"]) ?>" required>

        <br><br>

        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($contact["email"]) ?>">

        <br>

        <button type="submit">Update Contact</button>
    </form>

    <div class="back">
        <a href="view.php">← Back to Contacts</a>
    </div>

</div>

</body>
</html>
