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

$stmt = $pdo->prepare("DELETE FROM injury_records WHERE id = :id");
$stmt->bindParam(':id', $injury_id);

if ($stmt->execute()) {
    header("Location: view_injury.php");
    exit;
} else {
    $message = "Failed to delete injury record!";
}
?>
