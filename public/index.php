<?php
// Iniciar sesión
session_start();

// Verificar si el usuario ya está logueado y redirigirlo al dashboard correspondiente
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] == 1) {
        header('Location: ../views/dashboard/admin_dashboard.php');
        exit;
    } elseif ($_SESSION['role'] == 2) {
        header('Location: ../views/dashboard/manager_dashboard.php');
        exit;
    }
}

// Incluir el archivo de configuración
require_once '../config/config.php';

// Obtener los usuarios desde la base de datos
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$sql = "SELECT id, username FROM users WHERE role_id IN (1, 2)";
$result = $conn->query($sql);

$users = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Gym App</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Welcome to Gym App</h1>
        <form action="../views/auth/login.php" method="post">
            <label for="user">Select User</label>
            <select name="user" id="user" required>
                <option value="">Choose...</option>
                <?php foreach ($users as $user): ?>
                    <option value="<?php echo $user['id']; ?>"><?php echo $user['username']; ?></option>
                <?php endforeach; ?>
            </select>
            <br>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
            <br>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
        <br>
        <a href="../views/auth/admin_login.php"><button class="btn btn-secondary">Admin Login</button></a>
    </div>
</body>
</html>
