<?php
session_start();
require_once '../includes/db.php';
require_once '../includes/functions.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: view_injury.php");
    exit;
}

$injury_id = sanitize($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $injury_date = sanitize($_POST['injury_date']);
    $description = sanitize($_POST['description']);
    $status = sanitize($_POST['status']);

    $stmt = $pdo->prepare("UPDATE injury_records SET injury_date = :injury_date, description = :description, status = :status WHERE id = :id");
    $stmt->bindParam(':injury_date', $injury_date);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':id', $injury_id);

    if ($stmt->execute()) {
        header("Location: view_injury.php");
        exit;
    } else {
        $message = "Failed to update injury record!";
    }
}

$injury_record = $pdo->prepare("SELECT * FROM injury_records WHERE id = :id");
$injury_record->bindParam(':id', $injury_id);
$injury_record->execute();
$record = $injury_record->fetch(PDO::FETCH_ASSOC);

if (!$record) {
    header("Location: view_injury.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Injury Record</title>
    <style>
        /* Add your styles here */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
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
        <h2>Update Injury Record</h2>
        <?php if (isset($message)): ?>
            <p class="message"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>
        <form method="post">
            <div class="form-group">
                <label for="injury_date">Injury Date:</label>
                <input type="date" name="injury_date" id="injury_date" value="<?= htmlspecialchars($record['injury_date']) ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea name="description" id="description" required><?= htmlspecialchars($record['description']) ?></textarea>
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <input type="text" name="status" id="status" value="<?= htmlspecialchars($record['status']) ?>" required>
            </div>
            <input type="submit" value="Update Injury Record" class="btn">
        </form>
    </div>
</body>
</html>
