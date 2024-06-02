<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 2) {
    header('Location: index.php');
    exit;
}

require_once 'config.php';

try {
    $pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener todos los clientes del manager actual
    $stmt = $pdo->prepare("SELECT * FROM clients WHERE manager_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Manager Dashboard</h1>
        <p>Welcome, <?= htmlspecialchars($_SESSION['username']); ?></p>
        <a href="logout.php" class="btn btn-secondary">Logout</a>

        <h2 class="mt-4">Clients</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clients as $client): ?>
                    <tr>
                        <td><?= htmlspecialchars($client['id']); ?></td>
                        <td><?= htmlspecialchars($client['name']); ?></td>
                        <td><?= htmlspecialchars($client['email']); ?></td>
                        <td><?= htmlspecialchars($client['phone']); ?></td>
                        <td>
                            <button class="btn btn-primary editClientBtn" data-id="<?= $client['id']; ?>">Edit</button>
                            <button class="btn btn-danger deleteClientBtn" data-id="<?= $client['id']; ?>">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addClientModal">Add Client</button>

        <!-- Add Client Modal -->
        <div class="modal fade" id="addClientModal" tabindex="-1" aria-labelledby="addClientModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addClientModalLabel">Add Client</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="add_client.php" method="post">
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
                            <button type="submit" class="btn btn-success">Add Client</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Client Modal -->
        <div class="modal fade" id="editClientModal" tabindex="-1" aria-labelledby="editClientModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editClientModalLabel">Edit Client</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editClientForm" action="edit_client.php" method="post">
                            <input type="hidden" id="editClientId" name="id">
                            <div class="mb-3">
                                <label for="editName" class="form-label">Name</label>
                                <input type="text" class="form-control" id="editName" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="editEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" id="editEmail" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="editPhone" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="editPhone" name="phone" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Update Client</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Client Modal -->
        <div class="modal fade" id="deleteClientModal" tabindex="-1" aria-labelledby="deleteClientModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteClientModalLabel">Delete Client</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this client?</p>
                        <form id="deleteClientForm" action="delete_client.php" method="post">
                            <input type="hidden" id="deleteClientId" name="id">
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        // Pass client data to the edit modal
        $('.editClientBtn').on('click', function() {
            var id = $(this).data('id');
            $.ajax({
                url: 'get_client.php',
                type: 'GET',
                data: { id: id },
                success: function(data) {
                    var client = JSON.parse(data);
                    $('#editClientId').val(client.id);
                    $('#editName').val(client.name);
                    $('#editEmail').val(client.email);
                    $('#editPhone').val(client.phone);
                    $('#editClientModal').modal('show');
                }
            });
        });

        // Pass client ID to the delete modal
        $('.deleteClientBtn').on('click', function() {
            var id = $(this).data('id');
            $('#deleteClientId').val(id);
            $('#deleteClientModal').modal('show');
        });
    </script>
</body>
</html>
