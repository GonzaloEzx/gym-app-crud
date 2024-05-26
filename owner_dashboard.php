<?php
require 'config.php';

// Obtener el número de clientes
$stmt = $pdo->query("SELECT COUNT(*) as count FROM clients");
$clientCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

// Obtener el número de clientes con pagos realizados
$stmt = $pdo->query("SELECT COUNT(*) as count FROM clients WHERE payment_status = 'pagado'");
$paidClientsCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

// Obtener el número de clientes con pagos pendientes
$stmt = $pdo->query("SELECT COUNT(*) as count FROM clients WHERE payment_status != 'pagado'");
$unpaidClientsCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

// Obtener el número de administradores (Suponiendo que los roles están en una tabla separada)
$stmt = $pdo->query("SELECT COUNT(*) as count FROM users WHERE role = 'admin'");
$adminCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Owner Dashboard</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-header">Total Clients</div>
                    <div class="card-body">
                        <h5 class="card-title"><?= $clientCount ?></h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-header">Paid Clients</div>
                    <div class="card-body">
                        <h5 class="card-title"><?= $paidClientsCount ?></h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-header">Unpaid Clients</div>
                    <div class="card-body">
                        <h5 class="card-title"><?= $unpaidClientsCount ?></h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card text-white bg-info mb-3">
                    <div class="card-header">Total Admins</div>
                    <div class="card-body">
                        <h5 class="card-title"><?= $adminCount ?></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
