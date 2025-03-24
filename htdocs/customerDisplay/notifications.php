<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../AdminDisplay/db_connection.php';

// Handle remove notification request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_id'])) {
    $remove_id = $_POST['remove_id'];
    $sql_remove = "DELETE FROM admin_feedback WHERE id = ?";
    $stmt_remove = $conn->prepare($sql_remove);
    $stmt_remove->bind_param("i", $remove_id);
    $stmt_remove->execute();
    header("Location: notifications.php");
    exit();
}

// Fetch admin feedback
$sql_feedback = "SELECT id, admin_name, message, created_at FROM admin_feedback ORDER BY created_at DESC LIMIT 5";
$result_feedback = $conn->query($sql_feedback);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="common.css">
    <style>
        .notification {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .notification-content {
            flex-grow: 1;
        }
    </style>
</head>
<body>
    <header class="main-header">
        <div class="container d-flex justify-content-between align-items-center">
            <h1>DM'S Lechon House</h1>
            <nav>
                <a href="homeDisplay.php">Home</a>
                <a href="menuDisplay.php">Menu</a>
                <a href="orderHistory.php">Order History</a>
                <a href="ContactUs.php">Contact Us</a>
                <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
            </nav>
        </div>
    </header>

    <div class="container mt-4">
        <h2 class="text-center mb-4">Notifications</h2>
        <div>
            <!-- Display admin feedback -->
            <?php
            if ($result_feedback->num_rows > 0) {
                while ($row = $result_feedback->fetch_assoc()) {
                    echo "<div class='notification'>";
                    echo "<div class='notification-content'>";
                    echo "<strong>" . htmlspecialchars($row['admin_name']) . ":</strong> " . htmlspecialchars($row['message']) . " <br>";
                    echo "<small>" . htmlspecialchars($row['created_at']) . "</small>";
                    echo "</div>";
                    echo "<form method='POST' action='' style='margin-left: 10px;'>";
                    echo "<input type='hidden' name='remove_id' value='" . htmlspecialchars($row['id']) . "'>";
                    echo "<button type='submit' class='btn btn-danger btn-sm'>Remove</button>";
                    echo "</form>";
                    echo "</div>";
                }
            } else {
                echo "<p>No new feedback notifications.</p>";
            }

            $conn->close();
            ?>
        </div>
    </div>
</body>
</html>
