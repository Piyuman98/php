<?php
// pages/add_injury.php
session_start();
require_once '../includes/db.php';
require_once '../includes/functions.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $artist_id = sanitize($_POST['artist_id']);
    $injury_date = sanitize($_POST['injury_date']);
    $description = sanitize($_POST['description']);
    $status = sanitize($_POST['status']);

    $stmt = $pdo->prepare("INSERT INTO injury_records (artist_id, injury_date, description, status) VALUES (:artist_id, :injury_date, :description, :status)");
    $stmt->bindParam(':artist_id', $artist_id);
    $stmt->bindParam(':injury_date', $injury_date);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':status', $status);

    if ($stmt->execute()) {
        $message = "Injury record added successfully!";
    } else {
        $message = "Failed to add injury record!";
    }
}

$artists = $pdo->query("SELECT id, first_name, last_name FROM artists")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Injury</title>
    <style>
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

nav ul {
    list-style-type: none;
    padding: 0;
    margin: 0;
}

nav ul li {
    display: inline;
    margin: 0 15px;
}

nav ul li a {
    color: #fff;
    text-decoration: none;
    font-size: 18px;
}

nav ul li a:hover {
    text-decoration: underline;
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
.form-group textarea {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

textarea {
    height: 100px;
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
        <h2>Add Injury</h2>
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
                <label for="injury_date">Injury Date:</label>
                <input type="date" name="injury_date" id="injury_date" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea name="description" id="description" required></textarea>
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <select name="status" id="status" required>
                    <option value="ongoing">Ongoing</option>
                    <option value="recovered">Recovered</option>
                </select>
            </div>
            <input type="submit" value="Add Injury" class="btn">
        </form>
    </div>
</body>
</html>
