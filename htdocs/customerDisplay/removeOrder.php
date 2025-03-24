<?php
session_start();

// Redirect to login page if the user is not logged in
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}

// Check if order_id is provided
if (!isset($_POST['order_id'])) {
    header("Location: orderHistory.php?error=Invalid request");
    exit();
}

$order_id = intval($_POST['order_id']);
$customer_id = $_SESSION['customer_id'];

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

// Verify that the order belongs to the logged-in customer
$sql_verify = "SELECT id FROM orders WHERE id = ? AND client_id = ?";
$stmt_verify = $conn->prepare($sql_verify);
$stmt_verify->bind_param("ii", $order_id, $customer_id);
$stmt_verify->execute();
$result_verify = $stmt_verify->get_result();

if ($result_verify->num_rows > 0) {
    // Delete the order
    $sql_delete = "DELETE FROM orders WHERE id = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("i", $order_id);

    if ($stmt_delete->execute()) {
        header("Location: orderHistory.php?message=Order removed successfully");
        exit();
    } else {
        header("Location: orderHistory.php?error=Failed to remove order");
        exit();
    }
} else {
    header("Location: orderHistory.php?error=Order not found or unauthorized");
    exit();
}


$stmt_verify->close();
$stmt_delete->close();
$conn->close();
?>
