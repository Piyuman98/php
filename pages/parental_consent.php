<?php
// pages/parental_consent.php
require_once '../includes/db.php';
require_once '../includes/functions.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $child_id = intval($_POST['child_id']);
    $parent_name = sanitize($_POST['parent_name']);
    $parent_email = sanitize($_POST['parent_email']);
    
    // Update parental consent in the database
    $stmt = $pdo->prepare("UPDATE users SET parental_consent = 1 WHERE id = ?");
    $stmt->execute([$child_id]);

    // Optionally, you could store additional parental consent information
    $stmt = $pdo->prepare("INSERT INTO parental_consent (child_id, parent_name, parent_email) VALUES (?, ?, ?)");
    $stmt->execute([$child_id, $parent_name, $parent_email]);

    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parental Consent</title>
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
        input[type="email"] {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #28a745;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            margin-bottom: 10px;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Parental Consent</h2>
        <form method="POST" action="parental_consent.php">
            <label for="parent_name">Parent's Name:</label>
            <input type="text" name="parent_name" required>
            <label for="parent_email">Parent's Email:</label>
            <input type="email" name="parent_email" required>
            <input type="hidden" name="child_id" value="<?php echo intval($_GET['child_id']); ?>">
            <input type="submit" value="Submit Consent">
        </form>
    </div>
</body>
</html>
