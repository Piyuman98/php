<?php
// index.php
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: pages/home.php");
} else {
    header("Location: pages/login.php");
}
?>
