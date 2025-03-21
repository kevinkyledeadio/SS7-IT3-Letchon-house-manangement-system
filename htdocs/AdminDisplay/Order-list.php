<?php
session_start();

// Redirect to login page if the admin is not logged in
if (!isset($_SESSION['admin_username'])) {
    header("Location: log-in.php");
    exit();
}

// Include the database connection file
require_once 'db_connection.php';

// Fetch all orders
$sql = "SELECT o.id, c.name AS client_name, o.total_price, o.order_date, o.delivery_option, o.status 
        FROM orders o 
        JOIN clients c ON o.client_id = c.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header class="bg-dark text-white p-3">
        <div class="container d-flex justify-content-between align-items-center">
            <h1>Order List</h1>
            <nav>
                <a href="menuDisplay.php" class="btn btn-light btn-sm">Menu</a>
                <a href="logout.php" class="btn btn-danger btn-sm">Logout</a> <!-- Ensure this points to the correct logout.php file -->
            </nav>
        </div>
    </header>

    <div class="container mt-4">
        <h2 class="text-center">Order List</h2>
        <table class="table table-striped table-hover shadow rounded">
            <thead class="table-dark">
                <tr>
                    <th>Order ID</th>
                    <th>Client Name</th>
                    <th>Total Price</th>
                    <th>Order Date</th>
                    <th>Delivery Option</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        // Escape output to prevent XSS
                        $orderId = htmlspecialchars($row['id']);
                        $clientName = htmlspecialchars($row['client_name']);
                        $totalPrice = htmlspecialchars(number_format($row['total_price'], 2));
                        $orderDate = htmlspecialchars($row['order_date']);
                        $deliveryOption = htmlspecialchars($row['delivery_option']);
                        $status = htmlspecialchars($row['status']);

                        echo "<tr>";
                        echo "<td>{$orderId}</td>";
                        echo "<td>{$clientName}</td>";
                        echo "<td>₱{$totalPrice}</td>";
                        echo "<td>{$orderDate}</td>";
                        echo "<td>{$deliveryOption}</td>";
                        echo "<td>{$status}</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center'>No orders found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<?php $conn->close(); ?>
