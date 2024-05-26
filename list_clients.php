<?php
require 'config.php';

$stmt = $pdo->query("SELECT * FROM clients");
$clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clients List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Clients List</h2>
        <button class="btn btn-success mb-2" data-bs-toggle="modal" data-bs-target="#addClientModal">Add Client</button>
        <table class="table" id="clientsTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Payment Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clients as $client): ?>
                    <tr>
                        <td><?= $client['id'] ?></td>
                        <td><?= $client['name'] ?></td>
                        <td><?= $client['email'] ?></td>
                        <td><?= $client['phone'] ?></td>
                        <td><?= $client['payment_status'] ?></td>
                        <td>
                            <button class="btn btn-primary edit-btn" data-id="<?= $client['id'] ?>" data-bs-toggle="modal" data-bs-target="#editClientModal">Edit</button>
                            <form method="POST" action="delete_client.php" class="d-inline">
                                <input type="hidden" name="id" value="<?= $client['id'] ?>">
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Add Client Modal -->
    <div class="modal fade" id="addClientModal" tabindex="-1" aria-labelledby="addClientModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addClientModalLabel">Add Client</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="add_client.php">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="payment_status" class="form-label">Payment Status</label>
                            <input type="text" class="form-control" id="payment_status" name="payment_status" required>
                        </div>
                        <button type="submit" class="btn btn-success">Add Client</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Client Modal -->
    <div class="modal fade" id="editClientModal" tabindex="-1" aria-labelledby="editClientModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editClientModalLabel">Edit Client</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="edit_client.php" id="editClientForm">
                        <input type="hidden" id="editClientId" name="id">
                        <div class="mb-3">
                            <label for="editClientName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="editClientName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="editClientEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="editClientEmail" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="editClientPhone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="editClientPhone" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="editClientPaymentStatus" class="form-label">Payment Status</label>
                            <input type="text" class="form-control" id="editClientPaymentStatus" name="payment_status" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#clientsTable').DataTable();

            $('.edit-btn').on('click', function() {
                var clientId = $(this).data('id');
                $.ajax({
                    url: 'get_client.php?id=' + clientId,
                    method: 'GET',
                    success: function(data) {
                        var client = JSON.parse(data);
                        $('#editClientId').val(client.id);
                        $('#editClientName').val(client.name);
                        $('#editClientEmail').val(client.email);
                        $('#editClientPhone').val(client.phone);
                        $('#editClientPaymentStatus').val(client.payment_status);
                    }
                });
            });
        });
    </script>
</body>
</html>
