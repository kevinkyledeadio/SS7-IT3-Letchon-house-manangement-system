<?php
    include 'db_connection.php';

    if (isset($_POST['orderId'])) {
        $orderId = $_POST['orderId'];

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
