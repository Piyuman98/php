<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = isset($_POST['username']) ? sanitize($_POST['username']) : null;
    $password = isset($_POST['password']) ? password_hash(sanitize($_POST['password']), PASSWORD_BCRYPT) : null;
    $age = isset($_POST['age']) ? intval(sanitize($_POST['age'])) : null;
    $role = isset($_POST['role']) ? sanitize($_POST['role']) : null;

    if ($username && $password && $age && $role) {
        $stmt = $pdo->prepare("INSERT INTO users (username, password, age, parental_consent, role) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$username, $password, $age, $age < 13 ? 0 : 1, $role]);
        $user_id = $pdo->lastInsertId();

        if ($age < 13) {
            // Redirect to parental consent page
            header("Location: parental_consent.php?child_id=$user_id");
            exit;
        } else {
            header("Location: login.php");
            exit;
        }
    } else {
        $message = "Please fill in all the required fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../styles/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 5px;
            text-align: left;
        }
        input[type="text"],
        input[type="password"],
        input[type="role"],
        input[type="number"] {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"],
        .login-btn {
            background-color: #28a745;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            margin-bottom: 10px;
        }
        input[type="submit"]:hover,
        .login-btn:hover {
            background-color: #218838;
        }
        .login-btn {
            background-color: #007bff;
        }
        .login-btn:hover {
            background-color: #0056b3;
        }
        .message {
            color: red;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <?php if (!empty($message)) { echo "<p class='message'>$message</p>"; } ?>
        <form method="POST" action="register.php">
        <label for="username">Username:</label>
            <input type="text" name="username" required>
            <label for="password">Password:</label>
            <input type="password" name="password" required>
            <label for="age">Age:</label>
            <input type="number" name="age" required>
            <label for="role">Role:</label>
            <select name="role" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
            <input type="submit" value="Register">
            <a href="login.php" class="login-btn">Login</a>
        </form>
        
    </div>
</body>
</html>
