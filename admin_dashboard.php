<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) {
    header('Location: index.php');
    exit;
}

require_once 'config.php';

try {
    $pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener todos los managers
    $stmt = $pdo->prepare("SELECT * FROM users WHERE role_id = 2");
    $stmt->execute();
    $managers = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Dashboard de Administrador 😎</h1>
        <p>Bienvenido, <?= htmlspecialchars($_SESSION['username']); ?></p>
        <a href="logout.php" class="btn btn-secondary">Logout</a>

        <h2 class="mt-4">Managers</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($managers as $manager): ?>
                    <tr>
                        <td><?= htmlspecialchars($manager['id']); ?></td>
                        <td><?= htmlspecialchars($manager['username']); ?></td>
                        <td><?= htmlspecialchars($manager['email']); ?></td>
                        <td>
                            <button class="btn btn-primary editManagerBtn" data-id="<?= $manager['id']; ?>">Edit</button>
                            <button class="btn btn-danger deleteManagerBtn" data-id="<?= $manager['id']; ?>">Delete</button>
                            <a href="manager_dashboard.php?id=<?= $manager['id']; ?>" class="btn btn-info">View Dashboard</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addManagerModal">Add Manager</button>

        <!-- Add Manager Modal -->
        <div class="modal fade" id="addManagerModal" tabindex="-1" aria-labelledby="addManagerModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addManagerModalLabel">Add Manager</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="add_manager.php" method="post">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-success">Add Manager</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Manager Modal -->
        <div class="modal fade" id="editManagerModal" tabindex="-1" aria-labelledby="editManagerModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editManagerModalLabel">Edit Manager</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editManagerForm" action="edit_manager.php" method="post">
                            <input type="hidden" id="editManagerId" name="id">
                            <div class="mb-3">
                                <label for="editUsername" class="form-label">Username</label>
                                <input type="text" class="form-control" id="editUsername" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="editEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" id="editEmail" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="editPassword" class="form-label">New Password (leave blank to keep current password)</label>
                                <input type="password" class="form-control" id="editPassword" name="password">
                            </div>
                            <button type="submit" class="btn btn-primary">Update Manager</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Manager Modal -->
        <div class="modal fade" id="deleteManagerModal" tabindex="-1" aria-labelledby="deleteManagerModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteManagerModalLabel">Delete Manager</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this Manager?</p>
                        <form id="deleteManagerForm" action="delete_manager.php" method="post">
                            <input type="hidden" id="deleteManagerId" name="id">
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        // Pass manager data to the edit modal
        $('.editManagerBtn').on('click', function() {
            var id = $(this).data('id');
            $.ajax({
                url: 'get_manager.php',
                type: 'GET',
                data: { id: id },
                success: function(data) {
                    var manager = JSON.parse(data);
                    $('#editManagerId').val(manager.id);
                    $('#editUsername').val(manager.username);
                    $('#editEmail').val(manager.email);
                    $('#editManagerModal').modal('show');
                }
            });
        });

        // Pass manager ID to the delete modal
        $('.deleteManagerBtn').on('click', function() {
            var id = $(this).data('id');
            $('#deleteManagerId').val(id);
            $('#deleteManagerModal').modal('show');
        });
    </script>
</body>
</html>
