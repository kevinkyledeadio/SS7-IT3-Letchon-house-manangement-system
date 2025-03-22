<?php
    include 'db_connection.php';


    if (isset($_POST['orderId'])) {
        $orderId = $_POST['orderId'];

        $sql = "UPDATE orders SET status = 'Completed' WHERE id = ?";

        if ($stmt = $conn->prepare($sql)) {
            // Bind the order ID parameter
            $stmt->bind_param('i', $orderId);

            // Execute the query
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
