<?php
session_start();
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role_id'] == 1) {
        header('Location: views/dashboard/admin_dashboard.php');
    } elseif ($_SESSION['role_id'] == 2) {
        header('Location: views/dashboard/manager_dashboard.php');
    }
    exit;
}

require_once 'config/config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gym App</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Welcome to Gym App</h1>
        <button id="openModal">Login</button>
    </div>

    <div id="loginModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Login</h2>
            <form id="loginForm" method="POST" action="login.php">
                <label for="username">Select User</label>
                <select name="username" id="username" required>
                    <option value="admin">Admin</option>
                    <option value="manager">Manager</option>
                </select>
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
                <button type="submit">Login</button>
            </form>
        </div>
    </div>

    <script src="js/scripts.js"></script>
</body>
</html>
