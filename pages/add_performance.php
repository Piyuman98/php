<?php
session_start();
require_once '../includes/db.php';
require_once '../includes/functions.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $artist_id = sanitize($_POST['artist_id']);
    $performance_date = sanitize($_POST['performance_date']);
    $event_name = sanitize($_POST['event_name']);
    $role_description = sanitize($_POST['role_description']);
    $created_at = date('Y-m-d H:i:s');

    $stmt = $pdo->prepare("INSERT INTO performances (artist_id, performance_date, event_name, role_description, created_at) VALUES (:artist_id, :performance_date, :event_name, :role_description, :created_at)");
    $stmt->bindParam(':artist_id', $artist_id);
    $stmt->bindParam(':performance_date', $performance_date);
    $stmt->bindParam(':event_name', $event_name);
    $stmt->bindParam(':role_description', $role_description);
    $stmt->bindParam(':created_at', $created_at);

    if ($stmt->execute()) {
        $message = "Performance added successfully!";
    } else {
        $message = "Failed to add performance!";
    }
}

$artists = $pdo->query("SELECT id, first_name, last_name FROM artists")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Performance</title>
    <style>
        /* Add your styles here */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }

        header h1 {
            margin: 0;
            font-size: 24px;
        }

        .content {
            padding: 20px;
        }

        h2 {
            color: #333;
            margin-top: 0;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: auto;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group select,
        .form-group input[type="date"],
        .form-group input[type="text"],
        .form-group textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .btn {
            background-color: #333;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #555;
        }

        .message {
            color: green;
            font-weight: bold;
        }
    </style>
</head>
<body>
<?php include '../templates/header.php'; ?>
    <div class="content">
        <h2>Add Performance</h2>
        <?php if (isset($message)): ?>
            <p class="message"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>
        <form method="post">
            <div class="form-group">
                <label for="artist_id">Artist:</label>
                <select name="artist_id" id="artist_id" required>
                    <?php foreach ($artists as $artist): ?>
                        <option value="<?= htmlspecialchars($artist['id']) ?>">
                            <?= htmlspecialchars($artist['first_name']) ?> <?= htmlspecialchars($artist['last_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="performance_date">Performance Date:</label>
                <input type="date" name="performance_date" id="performance_date" required>
            </div>
            <div class="form-group">
                <label for="event_name">Event Name:</label>
                <input type="text" name="event_name" id="event_name" required>
            </div>
            <div class="form-group">
                <label for="role_description">Role Description:</label>
                <textarea name="role_description" id="role_description"></textarea>
            </div>
            <input type="submit" value="Add Performance" class="btn">
        </form>
    </div>
</body>
</html>
