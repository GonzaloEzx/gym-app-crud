<?php
session_start();
require_once 'config.php';

// Conectar a la base de datos
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obtener los datos del formulario
$username = $_POST['username'];
$password = $_POST['password'];

// Consultar la base de datos para el usuario
$stmt = $conn->prepare("SELECT id, username, password, role_id FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    // Verificar la contraseña
    if (password_verify($password, $user['password'])) {
        // Guardar la información del usuario en la sesión
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role_id'] = $user['role_id'];

        // Redirigir según el rol del usuario
        if ($user['role_id'] == 1) {
            header("Location: views/dashboard/admin_dashboard.php");
        } elseif ($user['role_id'] == 2) {
            header("Location: views/dashboard/manager_dashboard.php");
        } else {
            // Redirigir a una página predeterminada si el rol no es reconocido
            header("Location: index.php");
        }
        exit;
    } else {
        // Contraseña incorrecta
        $_SESSION['error'] = "Invalid password.";
    }
} else {
    // Usuario no encontrado
    $_SESSION['error'] = "Invalid username.";
}

$stmt->close();
$conn->close();

// Redirigir de vuelta al formulario de inicio de sesión en caso de error
header("Location: index.php");
exit;
?>
