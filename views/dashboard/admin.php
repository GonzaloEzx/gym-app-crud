<?php
session_start();
if ($_SESSION['role'] != 1) {
    header('Location: /index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <h1>Panel del administrador</h1>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Admin Dashboard</h1>
        <h1>Panel del administrador logout</h1>
        <a href="logout.php" class="btn btn-danger">Logout</a>
        <h2>Clients List</h2>
        <?php include '../clients/list.php'; ?>
    </div>
</body>
</html>
