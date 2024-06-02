<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) {
    header('Location: index.php');
    exit;
}

require_once 'config.php';

$id = $_POST['id'];

try {
    $pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$id]);

    header('Location: admin_dashboard.php');
    exit;
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}
?>
