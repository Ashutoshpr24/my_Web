<?php
session_start();
require_once "../config/db.php";

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    // basic validation
    if (empty($name) || empty($email) || empty($password)) {
        $error = "All fields are required";
    } else {

        // checking if email already exists
        $checkQuery = "SELECT id FROM users WHERE email = ?";
        $stmt = mysqli_prepare($conn, $checkQuery);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            $error = "Email already registered";
        } else {

            // hashing password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // insert user
            $insertQuery = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($conn, $insertQuery);
            mysqli_stmt_bind_param($stmt, "sss", $name, $email, $hashedPassword);

            if (mysqli_stmt_execute($stmt)) {
                $success = "Registration successful. You can login now.";
            } else {
                $error = "Something went wrong. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 0;
        }

        .register-box {
            max-width: 420px;
            margin: 90px auto;
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
            color: white;
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

        .login-link {
            text-align: center;
            margin-top: 15px;
        }

        .login-link a {
            text-decoration: none;
            color: #007bff;
        }
    </style>
</head>
<body>

<div class="register-box">

    <h2>Sign Up 📝</h2>

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

        <label>Email</label>
        <input type="email" name="email" required>

        <br><br>

        <label>Password</label>
        <input type="password" name="password" required>

        <br>

        <button type="submit">Register</button>
    </form>

    <div class="login-link">
        Already have an account? <a href="login.php">Login</a>
    </div>

</div>

</body>
</html>
