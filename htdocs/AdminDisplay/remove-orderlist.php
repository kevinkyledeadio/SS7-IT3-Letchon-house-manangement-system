<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection file
include 'db_connection.php';


if (isset($_POST['orderId'])) {
    $orderId = intval($_POST['orderId']); // Ensure orderId is an integer
    
    $sql = "DELETE FROM orders WHERE id = ?"; // Adjusted to match the `order_id` column
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('i', $orderId);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo 'success'; // Return success if the deletion is successful
            } else {
                error_log("No rows affected. Order ID: $orderId");
                echo 'no_rows'; // Return no_rows if no rows were affected
            }
        } else {
            error_log("SQL Error: " . $stmt->error);
            echo 'error'; // Return error if the deletion fails
        }
        $stmt->close();
    } else {
        error_log("Statement Preparation Error: " . $conn->error);
        echo 'error'; // Return error if the statement preparation fails
    }
} else {
    error_log("Order ID not set in POST request.");
    echo 'error'; // Return error if orderId is not set
}
?>
