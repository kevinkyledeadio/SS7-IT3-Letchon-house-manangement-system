<?php
session_start();

// Redirect to login page if the user is not logged in
if (!isset($_SESSION['client_email'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "mariadb";
$password = "mariadb";
$dbname = "mariadb";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    error_log("Connection failed: " . $conn->connect_error);
    die("Connection failed: " . $conn->connect_error);
}

// Fetch client orders
$client_email = $_SESSION['client_email'];
$sql = "SELECT o.id, o.total_price, o.order_date, o.delivery_option, o.status 
        FROM orders o 
        JOIN clients c ON o.client_id = c.id 
        WHERE c.email = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    error_log("Prepare failed: " . $conn->error);
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("s", $client_email);
if (!$stmt->execute()) {
    error_log("Execute failed: " . $stmt->error);
    die("Execute failed: " . $stmt->error);
}
$result = $stmt->get_result();
if (!$result) {
    error_log("Get result failed: " . $stmt->error);
    die("Get result failed: " . $stmt->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header class="bg-dark text-white p-3">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="text-center">Order History</h1>
            <nav>
                <a href="homeDisplay.php" class="btn btn-light btn-sm">Home</a>
                <a href="menuDisplay.php" class="btn btn-light btn-sm">Menu</a>
                <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
            </nav>
        </div>
    </header>

    <div class="container mt-4">
        <h2>Your Orders</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Total Price</th>
                    <th>Order Date</th>
                    <th>Delivery Option</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . $row['id'] . '</td>';
                        echo '<td>₱' . $row['total_price'] . '</td>';
                        echo '<td>' . $row['order_date'] . '</td>';
                        echo '<td>' . $row['delivery_option'] . '</td>';
                        echo '<td>' . $row['status'] . '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="5" class="text-center">No orders found.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
$conn->close();
?>
