<?php
require 'config.php';

function determineObligationStatus($billing_date, $payment_due_date) {
    $today = new DateTime();
    $billingDate = new DateTime($billing_date);
    $dueDate = new DateTime($payment_due_date);
    $daysUntilDue = $today->diff($dueDate)->days;

    if ($today > $dueDate) {
        return 'Vencida';
    } elseif ($daysUntilDue <= 3) {
        return 'Se vence pronto';
    } else {
        return 'No ha vencido';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $payment_status = $_POST['payment_status'];
    $billing_date = $_POST['billing_date'];
    $payment_due_date = $_POST['payment_due_date'];
    $obligation_status = determineObligationStatus($billing_date, $payment_due_date);

    $stmt = $pdo->prepare("UPDATE clients SET name = ?, email = ?, phone = ?, payment_status = ?, billing_date = ?, payment_due_date = ?, obligation_status = ? WHERE id = ?");
    $stmt->execute([$name, $email, $phone, $payment_status, $billing_date, $payment_due_date, $obligation_status, $id]);

    header('Location: list_clients.php');
    exit();
}
?>

