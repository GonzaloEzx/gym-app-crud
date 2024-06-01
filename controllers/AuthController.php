<?php
class AuthController {
    public function login() {
        require_once '../config/config.php';
        require_once '../core/Database.php';
        
        $db = new Database();
        $stmt = $db->query('SELECT * FROM users WHERE username = :username');
        $db->execute($stmt, ['username' => $_POST['username']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($_POST['password'], $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role_id'];
            if ($user['role_id'] == 1) {
                header('Location: /admin_dashboard.php');
            } else {
                header('Location: /owner_dashboard.php');
            }
        } else {
            echo 'Invalid username or password';
        }
    }
}
