<?php
session_start();

// Verificar si el usuario es Admin (Owner)
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) {
    header('Location: index.php');
    exit;
}

require_once 'config.php';

try {
    $pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener todos los managers
    $stmt = $pdo->prepare("SELECT * FROM users WHERE role_id = 2");
    $stmt->execute();
    $managers = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Admin Dashboard</h1>
        <p>Welcome, <?= htmlspecialchars($_SESSION['username']); ?></p>
        <a href="logout.php" class="btn btn-secondary">Logout</a>

        <h2 class="mt-4">Managers</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($managers as $manager): ?>
                    <tr>
                        <td><?= htmlspecialchars($manager['id']); ?></td>
                        <td><?= htmlspecialchars($manager['username']); ?></td>
                        <td><?= htmlspecialchars($manager['email']); ?></td>
                        <td>
                            <!-- Botones para editar/eliminar managers -->
                            <a href="edit_manager.php?id=<?= $manager['id']; ?>" class="btn btn-primary">Edit</a>
                            <a href="delete_manager.php?id=<?= $manager['id']; ?>" class="btn btn-danger">Delete</a>
                            <!-- Botón para ver el dashboard del manager -->
                            <a href="manager_dashboard.php?id=<?= $manager['id']; ?>" class="btn btn-info">View Dashboard</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2 class="mt-4">Add Manager</h2>
        <form action="add_manager.php" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-success">Add Manager</button>
        </form>
    </div>
</body>
</html>
