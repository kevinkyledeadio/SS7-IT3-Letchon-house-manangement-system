<?php
session_start();

if (!isset($_SESSION['admin_username'])) {
    echo 'unauthorized';
    exit();
}

if (!isset($_POST['orderId']) || !isset($_POST['status'])) {
    echo 'invalid_request';
    exit();
}

$order_id = intval($_POST['orderId']);
$status = $_POST['status'];

$servername = "localhost";
$username = "mariadb";
$password = "mariadb";
$dbname = "mariadb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo 'db_error';
    exit();
}

$sql_update = "UPDATE orders SET status = ? WHERE id = ?";
$stmt_update = $conn->prepare($sql_update);
$stmt_update->bind_param("si", $status, $order_id);

if ($stmt_update->execute()) {
    echo 'success';
} else {
    echo 'error';
}

$stmt_update->close();
$conn->close();
?>
