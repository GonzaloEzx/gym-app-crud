<?php
require 'config.php';

$stmt = $pdo->query("SELECT * FROM clients WHERE obligation_status IN ('Vencida', 'Se vence pronto')");
$alerts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Alertas de Clientes -->
<div class="container">
    <h3>Alertas de Clientes</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Estado de la Obligación</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($alerts as $alert): ?>
                <tr class="<?= $alert['obligation_status'] == 'Vencida' ? 'table-danger' : 'table-warning' ?>">
                    <td><?= $alert['name'] ?></td>
                    <td><?= $alert['email'] ?></td>
                    <td><?= $alert['phone'] ?></td>
                    <td><?= $alert['obligation_status'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
