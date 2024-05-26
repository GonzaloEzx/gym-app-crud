<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $payment_status = $_POST['payment_status'];

    $stmt = $pdo->prepare("INSERT INTO clients (name, email, phone, payment_status) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $email, $phone, $payment_status]);

    header('Location: list_clients.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Client</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Add Client</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" required>
            </div>
            <div class="mb-3">
                <label for="payment_status" class="form-label">Payment Status</label>
                <input type="text" class="form-control" id="payment_status" name="payment_status" required>
            </div>
            <button type="submit" class="btn btn-success">Add Client</button>
        </form>
    </div>
</body>
</html>
