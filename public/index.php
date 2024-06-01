<?php
// Iniciar la sesión
session_start();

// Redirigir al usuario si ya está logueado
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] == 1) {
        header('Location: admin_dashboard.php');
    } else {
        header('Location: owner_dashboard.php');
    }
    exit;
}

// Incluir la configuración y la base de datos
require_once 'config.php';

try {
    $pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}

// Obtener los usuarios de la base de datos
$stmt = $pdo->prepare("SELECT username FROM users WHERE role_id = 2");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gym App - Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Bienvenido al sistema de gestion de clientes: Team di paola 🥋</h1>
        <h2>Selecione el usuario que va a utilizar 🔑</h2>
        <form action="login.php" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Seleccionar usuario</label>
                <select class="form-select" id="username" name="username" required>
                    <option value="">Seleccionar...</option>
                    <?php foreach ($users as $user): ?>
                        <option value="<?= htmlspecialchars($user['username']); ?>"><?= htmlspecialchars($user['username']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</body>
</html>
