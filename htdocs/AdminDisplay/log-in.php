<?php
session_start();

// Redirect to menu display if the admin is already logged in
if (isset($_SESSION['admin_username'])) {
    header("Location: menuDisplay.php");
    exit();
}

// Include the database connection file
require_once 'db_connection.php';

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate admin credentials
    $sql = "SELECT * FROM admins WHERE email = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $admin = $result->fetch_assoc();
            // Verify the hashed password
            if (password_verify($password, $admin['password'])) {
                $_SESSION['admin_username'] = $admin['username'];
                $_SESSION['admin_id'] = $admin['id'];
                header("Location: menuDisplay.php");
                exit();
            } else {
                $error = "Invalid email or password.";
            }
        } else {
            $error = "Invalid email or password.";
        }
        $stmt->close();
    } else {
        $error = "Database query failed: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('background.jpg') no-repeat center center fixed;
            background-size: cover;
        }
        .card {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
        }
        .btn-primary, .btn-secondary {
            border-radius: 20px;
        }
    </style>
    <script>
        function toggleForm(form) {
            document.getElementById('login-form').style.display = form === 'login' ? 'block' : 'none';
        }
    </script>
</head>
<body class="d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-lg p-5" style="width: 400px;">
        <h2 class="text-center mb-4">Admin Login</h2>
        <form id="login-form" method="POST" action="">
            <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" id="email" name="email" class="form-control rounded-pill" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" id="password" name="password" class="form-control rounded-pill" required>
            </div>
            <button type="submit" class="btn btn-primary w-100 rounded-pill">Login</button>
        </form>
        <p class="text-center mt-3">Don't have an account? <a href="register.php">Register here</a>.</p>
    </div>
</body>
</html>