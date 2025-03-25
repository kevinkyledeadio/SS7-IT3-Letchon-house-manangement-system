<?php
session_start();

// Redirect to login page if the user is not logged in
if (!isset($_SESSION['client_email'])) {
    header("Location: login.php");
    exit();
}

// Include the database connection file
require_once '../AdminDisplay/db_connection.php'; // Ensure correct path to db_connection.php

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Save the message to the notifications table
    $sql = "INSERT INTO notifications (customer_name, customer_email, message) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $message);

    if ($stmt->execute()) {
        $success = "Thank you for contacting us, $name. Your message has been sent.";
    } else {
        $error = "Failed to send your message. Please try again.";
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="common.css">
    <link rel="stylesheet" href="contactUs.css">
</head>
<body>
    <header class="main-header">
        <div class="container d-flex justify-content-between align-items-center">
            <h1>DM'S Lechon House</h1>
            <nav>
                <a href="homeDisplay.php">Home</a>
                <a href="menuDisplay.php">Menu</a>
                <a href="orderHistory.php">Order History</a>
                <a href="notifications.php">Notifications</a> <!-- Added link to notifications -->
                <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
            </nav>
        </div>
    </header>

    <div class="container mt-5">
        <div class="contact-container p-4 shadow-lg rounded bg-light">
            <h2 class="text-center mb-4">Contact Us</h2>
            <?php if (isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
            <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
            <form method="POST" action="" class="text-center">
                <div class="mb-3">
                    <label for="name" class="form-label fw-bold">Name:</label>
                    <input type="text" id="name" name="name" class="form-control rounded-pill w-75 mx-auto" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label fw-bold">Email:</label>
                    <input type="email" id="email" name="email" class="form-control rounded-pill w-75 mx-auto" required>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label fw-bold">Message:</label>
                    <textarea id="message" name="message" class="form-control rounded w-75 mx-auto" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary w-50 rounded-pill mx-auto d-block">Send Message</button>
            </form>
            <div class="social-icons text-center mt-4">
                <h5>Connect with us:</h5>
                <a href="https://www.facebook.com/profile.php?id=100089774810887" target="_blank" class="me-3">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTtfbcYeYgf0wQJ-LSPm3CPbyB7T1p0f5bnaA&s" alt="Facebook" width="30">
                </a>
                <a href="https://myaccount.google.com/?hl=en&utm_source=OGB&utm_medium=act&gar=WzEyMF0" class="me-3">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQEMVDG8T0r0VAC_tDTkjiqP8QgJcEogo3sbQ&s" alt="Gmail" width="30">
                </a>
                <a href="0936 829 6783" class="me-3">
                    <img src="https://cdn-icons-png.flaticon.com/512/8748/8748459.png" alt="Phone" width="30">
                </a>
            </div>
        </div>
    </div>
</body>
</html>
