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
        <h1 class="text-center">Sistema de gestion de Usuarios "GYm - Di paola" </h1>
        <form action="login.php" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Selecione el usuraio:</label>
                <select class="form-select" id="username" name="username" required>
                    <option value="">Usuarios...</option>
                    <?php
                    require 'config.php';
                    $stmt = $pdo->prepare("SELECT username FROM users WHERE role_id = 2");
                    $stmt->execute();
                    $results = $stmt->fetchAll();
                    foreach ($results as $row) {
                        echo "<option value=\"{$row['username']}\">{$row['username']}</option>";
                    }
                    ?>
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
