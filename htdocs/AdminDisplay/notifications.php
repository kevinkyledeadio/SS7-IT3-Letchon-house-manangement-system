<?php
session_start();

// Redirect to login page if the admin is not logged in
if (!isset($_SESSION['admin_username'])) {
    header("Location: log-in.php");
    exit();
}

// Include the database connection file
require_once 'db_connection.php';

// Fetch notifications
$sql = "SELECT * FROM notifications ORDER BY created_at DESC";
$result = $conn->query($sql);

// Handle delete notification request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    $sql_delete = "DELETE FROM notifications WHERE id = ?";
    $stmt = $conn->prepare($sql_delete);
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    header("Location: notifications.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header class="bg-dark text-white p-3">
        <div class="container d-flex justify-content-between align-items-center">
            <h1>Notifications</h1>
            <nav>
                <a href="menuDisplay.php" class="btn btn-light btn-sm">Menu</a>
                <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
            </nav>
        </div>
    </header>

    <div class="container mt-4">
        <h2>Customer Messages</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer Name</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Received At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . htmlspecialchars($row['customer_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['customer_email']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['message']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
                        echo '<td>
                                <form method="POST" action="" style="display:inline;">
                                    <input type="hidden" name="delete_id" value="' . $row['id'] . '">
                                    <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                                </form>
                                <a href="messageCustomer.php?email=' . urlencode($row['customer_email']) . '" class="btn btn-primary btn-sm">Message</a>
                              </td>';
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center'>No notifications found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<?php $conn->close(); ?>
