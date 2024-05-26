<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gym App - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Welcome to Gym App</h2>
        <div class="row mt-4">
            <div class="col-md-6 offset-md-3">
                <form method="POST" action="login.php">
                    <div class="mb-3">
                        <label for="role" class="form-label">Select Role</label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="">Choose...</option>
                            <option value="admin">Admin</option>
                            <option value="owner">Owner</option>
                        </select>
                    </div>
                    <div class="mb-3" id="passwordField" style="display: none;">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary" id="loginButton" style="display: none;">Login</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('role').addEventListener('change', function() {
            var passwordField = document.getElementById('passwordField');
            var loginButton = document.getElementById('loginButton');
            if (this.value) {
                passwordField.style.display = 'block';
                loginButton.style.display = 'block';
            } else {
                passwordField.style.display = 'none';
                loginButton.style.display = 'none';
            }
        });
    </script>
</body>
</html>
