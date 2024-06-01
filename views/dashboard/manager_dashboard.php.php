<?php
session_start();

// Verificar si el usuario es Manager o Admin
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] != 1 && $_SESSION['role'] != 2)) {
    header('Location: index.php');
    exit;
}

require_once 'config.php';

try {
    $pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener el ID del manager de la URL si es Admin
    if ($_SESSION['role'] == 1 && isset($_GET['id'])) {
        $manager_id = $_GET['id'];
    } else {
        $manager_id = $_SESSION['user_id'];
    }

    // Obtener todos los clientes del manager
    $stmt = $pdo->prepare("SELECT * FROM clients WHERE manager_id = ?");
    $stmt->execute([$manager_id]);
    $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Manager Dashboard</h1>
        <p>Welcome, <?= htmlspecialchars($_SESSION['username']); ?></p>
        <a href="logout.php" class="btn btn-secondary">Logout</a>

        <h2 class="mt-4">Clients</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Payment Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clients as $client): ?>
                    <tr>
                        <td><?= htmlspecialchars($client['id']); ?></td>
                        <td><?= htmlspecialchars($client['name']); ?></td>
                        <td><?= htmlspecialchars($client['email']); ?></td>
                        <td><?= htmlspecialchars($client['phone']); ?></td>
                        <td><?= htmlspecialchars($client['payment_status']); ?></td>
                        <td>
                            <!-- Botones para editar/eliminar clientes -->
                            <a href="edit_client.php?id=<?= $client['id']; ?>" class="btn btn-primary">Edit</a>
                            <a href="delete_client.php?id=<?= $client['id']; ?>" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2 class="mt-4">Add Client</h2>
        <form action="add_client.php" method="post">
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
                <select class="form-select" id="payment_status" name="payment_status" required>
                    <option value="">Choose...</option>
                    <option value="paid">Paid</option>
                    <option value="pending">Pending</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Add Client</button>
        </form>
    </div>
</body>
</html>
