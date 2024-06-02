<?php
require_once 'config.php';

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$users = [
    ['username' => 'admin', 'password' => password_hash('adminpass', PASSWORD_DEFAULT), 'role' => 1],
    ['username' => 'manager', 'password' => password_hash('managerpass', PASSWORD_DEFAULT), 'role' => 2]
];

foreach ($users as $user) {
    $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $user['username'], $user['password'], $user['role']);
    $stmt->execute();
    $stmt->close();
}

$conn->close();

echo "Users added successfully";
?>
