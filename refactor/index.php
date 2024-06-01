<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gym App - Home</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Welcome to Gym App</h1>
        <form action="login.php" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Select User</label>
                <select class="form-select" id="username" name="username" required>
                    <option value="">Choose...</option>
                    <?php
                    require 'config.php';
                    try {
                        $stmt = $pdo->prepare("SELECT username FROM users WHERE role = 'Manager'");
                        $stmt->execute();
                        $results = $stmt->fetchAll();
                        
                        // Depuración: Mostrar los resultados
                        var_dump($results); // Agregar para depuración
                        die(); // Detener la ejecución para ver el resultado

                        foreach ($results as $row) {
                            echo "<option value=\"{$row['username']}\">{$row['username']}</option>";
                        }
                    } catch (PDOException $e) {
                        echo "<option value=\"\">Error: " . $e->getMessage() . "</option>";
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
Z