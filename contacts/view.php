<?php
session_start();
require_once "../config/db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION["user_id"];

$query = "SELECT * FROM contacts WHERE user_id = ? ORDER BY created_at DESC";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Contacts</title>
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f1f1f1;
        }

        tr:hover {
            background-color: #f9f9f9;
        }

        .btn {
            padding: 8px 12px;
            border-radius: 6px;
            text-decoration: none;
            color: #fff;
            font-size: 14px;
            display: inline-block;
            margin-right: 5px;
        }

        .edit {
            background-color: #ffc107;
            color: #000;
        }

        .delete {
            background-color: #dc3545;
        }

        .top-actions {
            margin-bottom: 15px;
        }

        .top-actions a {
            text-decoration: none;
            margin-right: 10px;
            color: #007bff;
            font-weight: bold;
        }

        .no-data {
            text-align: center;
            color: #666;
            margin-top: 20px;
        }

        .btn:hover {
            opacity: 0.85;
        }
    </style>
</head>
<body>

<div class="container">

    <h2>My Contacts 📋</h2>

    <div class="top-actions">
        <a href="add.php">➕ Add New Contact</a>
        <a href="../index.php">🏠 Dashboard</a>
    </div>

    <?php if (mysqli_num_rows($result) > 0) { ?>

        <table>
            <tr>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>

            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?= htmlspecialchars($row["name"]) ?></td>
                    <td><?= htmlspecialchars($row["phone"]) ?></td>
                    <td><?= htmlspecialchars($row["email"]) ?></td>
                    <td>
                        <a class="btn edit" href="edit.php?id=<?= $row["id"] ?>">✏️ Edit</a>
                        <a class="btn delete delete-btn" href="delete.php?id=<?= $row["id"] ?>">🗑️ Delete</a>
                    </td>
                </tr>
            <?php } ?>

        </table>

    <?php } else { ?>

        <p class="no-data">No contacts found. Add your first contact.</p>

    <?php } ?>

</div>

<script>
    // js confirmation logic before deleting
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            if (!confirm('⚠️ Are you sure you want to delete this contact?')){
                e.preventDefault();
            }
        });
    });
</script>
</body>
</html>
