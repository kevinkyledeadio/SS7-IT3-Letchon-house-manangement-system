<?php
session_start();

// Redirect to login page if the admin is not logged in
if (!isset($_SESSION['admin_username'])) {
    header("Location: log-in.php");
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

// Check if the menu item ID is provided
if (isset($_GET['id'])) {
    $menu_id = $_GET['id'];

    // Delete the menu item from the database
    $sql_delete = "DELETE FROM menu_items WHERE id = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("i", $menu_id);

    if ($stmt_delete->execute()) {
        echo "<script>alert('Menu item deleted successfully!'); window.location.href='menuDisplay.php';</script>";
    } else {
        echo "<script>alert('Failed to delete menu item. Please try again.'); window.location.href='menuDisplay.php';</script>";
    }

    $stmt_delete->close();
} else {
    echo "<script>alert('Invalid menu item ID.'); window.location.href='menuDisplay.php';</script>";
}

$conn->close();
?>
