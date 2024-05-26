<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $payment_status = $_POST['payment_status'];

    $stmt = $pdo->prepare("UPDATE clients SET name = ?, email = ?, phone = ?, payment_status = ? WHERE id = ?");
    $stmt->execute([$name, $email, $phone, $payment_status, $id]);

    header('Location: list_clients.php');
    exit();
} else {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM clients WHERE id = ?");
    $stmt->execute([$id]);
    $client = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Client</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Edit Client</h2>
        <form method="POST">
            <input type="hidden" name="id" value="<?= $client['id'] ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= $client['name'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= $client['email'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?= $client['phone'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="payment_status" class="form-label">Payment Status</label>
                <input type="text" class="form-control" id="payment_status" name="payment_status" value="<?= $client['payment_status'] ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
        <form method="POST" action="delete_client.php" class="mt-3">
            <input type="hidden" name="id" value="<?= $client['id'] ?>">
            <button type="submit" class="btn btn-danger">Delete Client</button>
        </form>
    </div>
</body>
</html>
