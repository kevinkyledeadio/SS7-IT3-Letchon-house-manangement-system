<?php
session_start();

if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['order_id'])) {
    header("Location: orderHistory.php?error=Invalid request");
    exit();
}

$order_id = intval($_GET['order_id']);
$customer_id = $_SESSION['customer_id'];

$servername = "localhost";
$username = "mariadb";
$password = "mariadb";
$dbname = "mariadb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_verify = "SELECT id FROM orders WHERE id = ? AND client_id = ?";
$stmt_verify = $conn->prepare($sql_verify);
$stmt_verify->bind_param("ii", $order_id, $customer_id);
$stmt_verify->execute();
$result_verify = $stmt_verify->get_result();

if ($result_verify->num_rows > 0) {
    $sql_update = "UPDATE orders SET status = 'Order Received' WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("i", $order_id);

    if ($stmt_update->execute()) {
        header("Location: orderHistory.php?message=Order marked as received");
    } else {
        header("Location: orderHistory.php?error=Failed to update order status");
    }
} else {
    header("Location: orderHistory.php?error=Order not found or unauthorized");
}

$stmt_verify->close();
$stmt_update->close();
$conn->close();
?>
