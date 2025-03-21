<?php
session_start();

// Redirect to home display if the customer is already logged in
if (isset($_SESSION['client_email'])) {
    header("Location: homeDisplay.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "mariadb";
$password = "mariadb";
$dbname = "mariadb";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM clients WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $client = $result->fetch_assoc();
        if (password_verify($password, $client['password'])) {
            $_SESSION['client_email'] = $email;
            header("Location: homeDisplay.php");
            exit();
        } else {
            $login_error = "Invalid email or password.";
        }
    } else {
        $login_error = "Invalid email or password.";
    }
}

// Handle registration form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "SELECT * FROM clients WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $register_error = "Email is already registered.";
    } else {
        $sql = "INSERT INTO clients (name, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $name, $email, $password);

        if ($stmt->execute()) {
            $_SESSION['client_email'] = $email;
            header("Location: homeDisplay.php");
            exit();
        } else {
            $register_error = "Registration failed. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Login/Register</title>
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
            document.getElementById('register-form').style.display = form === 'register' ? 'block' : 'none';
        }
    </script>
</head>
<body class="d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-lg p-5" style="width: 400px;">
        <h2 class="text-center mb-4">Welcome</h2>
        <div class="text-center mb-4">
            <button class="btn btn-primary btn-sm me-2" onclick="toggleForm('login')">Login</button>
            <button class="btn btn-secondary btn-sm" onclick="toggleForm('register')">Register</button>
        </div>

        <!-- Login Form -->
        <form id="login-form" method="POST" action="" style="display: block;">
            <?php if (isset($login_error)) echo "<div class='alert alert-danger'>$login_error</div>"; ?>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" id="email" name="email" class="form-control rounded-pill" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" id="password" name="password" class="form-control rounded-pill" required>
            </div>
            <button type="submit" name="login" class="btn btn-primary w-100 rounded-pill">Login</button>
        </form>

        <!-- Register Form -->
        <form id="register-form" method="POST" action="" style="display: none;">
            <?php if (isset($register_error)) echo "<div class='alert alert-danger'>$register_error</div>"; ?>
            <div class="mb-3">
                <label for="name" class="form-label">Full Name:</label>
                <input type="text" id="name" name="name" class="form-control rounded-pill" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" id="email" name="email" class="form-control rounded-pill" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" id="password" name="password" class="form-control rounded-pill" required>
            </div>
            <button type="submit" name="register" class="btn btn-secondary w-100 rounded-pill">Register</button>
        </form>
    </div>
</body>
</html>
