<?php
// Include the database connection file
include 'db_connection.php';

if (isset($_POST['orderId'])) {
    $orderId = $_POST['orderId'];

    // Prepare the SQL statement to update the order status to "Pending"
    $sql = "UPDATE orders SET status = 'Pending' WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('i', $orderId);
        if ($stmt->execute()) {
            echo 'success';
        } else {
            echo 'error';
        }
        $stmt->close();
    } else {
        echo 'error';
    }
    $conn->close();
} else {
    echo 'error';
}
?>
