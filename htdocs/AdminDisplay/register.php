<?php
session_start();

// Redirect to menu display if the admin is already logged in
if (isset($_SESSION['admin_username'])) {
    header("Location: menuDisplay.php");
    exit();
}

// Include the database connection file
require_once 'db_connection.php'; // Add this line to include the connection file

// Handle registration form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

    // Check if email already exists
    $sql = "SELECT * FROM admins WHERE email = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "Email is already registered.";
        } else {
            // Insert new admin into the database
            $sql = "INSERT INTO admins (username, email, password) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("sss", $username, $email, $password);
                if ($stmt->execute()) {
                    $_SESSION['admin_username'] = $username; // Store admin username in session
                    $_SESSION['admin_id'] = $stmt->insert_id; // Store admin ID in session
                    header("Location: menuDisplay.php");
                    exit();
                } else {
                    $error = "Registration failed. Please try again.";
                }
            } else {
                $error = "Database query failed: " . $conn->error;
            }
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
    <title>Admin Register</title>
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
</head>
<body class="d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-lg p-5" style="width: 400px;">
        <h2 class="text-center mb-4">Admin Register</h2>
        <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" id="username" name="username" class="form-control rounded-pill" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" id="email" name="email" class="form-control rounded-pill" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" id="password" name="password" class="form-control rounded-pill" required>
            </div>
            <button type="submit" class="btn btn-primary w-100 rounded-pill">Register</button>
        </form>
        <p class="text-center mt-3">Already have an account? <a href="log-in.php">Login here</a>.</p>
    </div>
</body>
</html>
