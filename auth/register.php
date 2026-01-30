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
</head>
<body>

<h2>Sign Up</h2>

<?php
if ($error) {
    echo "<p style='color:red;'>$error</p>";
}
if ($success) {
    echo "<p style='color:green;'>$success</p>";
}
?>

<form method="POST">
    <label>Name:</label><br>
    <input type="text" name="name"><br><br>

    <label>Email:</label><br>
    <input type="email" name="email"><br><br>

    <label>Password:</label><br>
    <input type="password" name="password"><br><br>

    <button type="submit">Register</button>
</form>

</body>
</html>
