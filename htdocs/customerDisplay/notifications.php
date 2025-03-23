<?php
include 'db_connect.php';

$sql = "SELECT admin_name, message, created_at FROM admin_messages ORDER BY created_at DESC LIMIT 5";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='notification'>";
        echo "<strong>{$row['admin_name']}:</strong> {$row['message']} <br>";
        echo "<small>{$row['created_at']}</small>";
        echo "</div><hr>";
    }
} else {
    echo "<p>No new notifications.</p>";
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="common.css">
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
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Message</th>
                    <th>Received At</th>
                </tr>
            </thead>
            <tbody>
                <!-- Display admin feedback -->
                <?php
                if ($result_feedback->num_rows > 0) {
                    while ($row = $result_feedback->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td><strong>" . htmlspecialchars($row['admin_name']) . ":</strong> " . htmlspecialchars($row['message']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3' class='text-center'>No feedback found.</td></tr>";
                }

                // Display admin messages
                if ($result_admin_messages->num_rows > 0) {
                    while ($row = $result_admin_messages->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td><strong>" . htmlspecialchars($row['admin_name']) . ":</strong> " . htmlspecialchars($row['message']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3' class='text-center'>No admin messages found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<?php
$stmt_feedback->close();
$conn->close();
?>
