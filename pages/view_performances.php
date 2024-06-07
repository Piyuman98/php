<?php
session_start();
require_once '../includes/db.php';
require_once '../includes/functions.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$performances = $pdo->query("SELECT p.id, a.first_name, a.last_name, p.performance_date, p.event_name, p.role_description, p.created_at 
                             FROM performances p
                             JOIN artists a ON p.artist_id = a.id")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Performances</title>
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
<?php include '../templates/header.php'; ?>
    <div class="content">
        <h2>View Performances</h2>
        <table>
            <tr>
                <th>Artist Name</th>
                <th>Performance Date</th>
                <th>Event Name</th>
                <th>Role Description</th>
                <th>Created At</th>
            </tr>
            <?php foreach ($performances as $performance): ?>
                <tr>
                    <td><?= htmlspecialchars($performance['first_name']) ?> <?= htmlspecialchars($performance['last_name']) ?></td>
                    <td><?= htmlspecialchars($performance['performance_date']) ?></td>
                    <td><?= htmlspecialchars($performance['event_name']) ?></td>
                    <td><?= htmlspecialchars($performance['role_description']) ?></td>
                    <td><?= htmlspecialchars($performance['created_at']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
