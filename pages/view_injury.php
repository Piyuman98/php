<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$injury_records = $pdo->query("SELECT ir.*, ar.first_name, ar.last_name FROM injury_records ir JOIN artists ar ON ir.artist_id = ar.id")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Injury Records</title>
    <style>
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            overflow: hidden;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
<?php include '../templates/header.php'; ?>
    <div class="content">
        <h2>Injury Records</h2>
        <table>
            <thead>
                <tr>
                    <th>Artist</th>
                    <th>Injury Date</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Recorded At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($injury_records as $record): ?>
                    <tr>
                        <td><?= htmlspecialchars($record['first_name'] . ' ' . $record['last_name']) ?></td>
                        <td><?= htmlspecialchars($record['injury_date']) ?></td>
                        <td><?= htmlspecialchars($record['description']) ?></td>
                        <td><?= htmlspecialchars($record['status']) ?></td>
                        <td><?= htmlspecialchars($record['created_at']) ?></td>
                        <td>
                            <a href="update_injury.php?id=<?= htmlspecialchars($record['id']) ?>">Update</a>
                            <a href="delete_injury.php?id=<?= htmlspecialchars($record['id']) ?>" onclick="return confirm('Are you sure you want to delete this record?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
