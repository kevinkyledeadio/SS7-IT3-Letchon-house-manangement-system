<?php
session_start();

// Redirect to login page if the user is not logged in
if (!isset($_SESSION['customer_id'])) {
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
    die("Connection failed: " . $conn->connect_error);
}

// Fetch orders for the logged-in customer
$customer_id = $_SESSION['customer_id'];

$sql = "SELECT o.id AS order_id, o.total_price, o.order_date, o.delivery_option, o.status, oi.item_name, oi.quantity, oi.price, o.address 
        FROM orders o 
        JOIN order_items oi ON o.id = oi.order_id 
        WHERE o.client_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$result = $stmt->get_result();

// Fetch canceled orders for the logged-in customer
$sql_canceled = "SELECT o.id AS order_id, o.total_price, o.order_date, o.delivery_option, o.status, oi.item_name, oi.quantity, oi.price, o.address, o.phone_number 
                 FROM orders o 
                 JOIN order_items oi ON o.id = oi.order_id 
                 WHERE o.client_id = ? AND o.status = 'Cancelled'";

$stmt_canceled = $conn->prepare($sql_canceled);
$stmt_canceled->bind_param("i", $customer_id);
$stmt_canceled->execute();
$result_canceled = $stmt_canceled->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="common.css">
    <link rel="stylesheet" href="orderHistory.css">
    <style>
        .order-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 16px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .order-header {
            font-weight: bold;
            font-size: 1.2rem;
            margin-bottom: 8px;
        }
        .order-details {
            margin-bottom: 8px;
        }
        .order-actions a {
            margin-right: 8px;
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
                <a href="notifications.php">Notifications</a> <!-- Added link to notifications -->
                <a href="ContactUs.php">Contact Us</a>
                <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
            </nav>
        </div>
    </header>

    <div class="container mt-4">
        <h2 class="text-center mb-4">Your Order History</h2>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='order-card'>";
                echo "<div class='order-header'>Order #" . htmlspecialchars($row['order_id']) . " - " . htmlspecialchars($row['status']) . "</div>";
                echo "<div class='order-details'>";
                echo "<p><strong>Item:</strong> " . htmlspecialchars($row['item_name']) . " (x" . htmlspecialchars($row['quantity']) . ")</p>";
                echo "<p><strong>Price:</strong> ₱" . htmlspecialchars(number_format($row['price'], 2)) . "</p>";
                echo "<p><strong>Order Date:</strong> " . htmlspecialchars($row['order_date']) . "</p>";
                echo "<p><strong>Delivery Option:</strong> " . htmlspecialchars($row['delivery_option']) . "</p>";
                echo "<p><strong>Address:</strong> " . htmlspecialchars($row['address']) . "</p>";
                echo "</div>";
                echo "<div class='order-actions'>";
                echo "<a href='editOrder.php?order_id=" . htmlspecialchars($row['order_id']) . "' class='btn btn-primary btn-sm'>Edit</a>";
                echo "<a href='cancelOrder.php?order_id=" . htmlspecialchars($row['order_id']) . "' class='btn btn-danger btn-sm'>Cancel</a>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<p class='text-center'>No active orders found.</p>";
        }
        ?>

        <h2 class="text-center mt-5 mb-4">Cancelled Orders</h2>
        <?php
        if ($result_canceled->num_rows > 0) {
            while ($row = $result_canceled->fetch_assoc()) {
                echo "<div class='order-card'>";
                echo "<div class='order-header'>Order #" . htmlspecialchars($row['order_id']) . " - " . htmlspecialchars($row['status']) . "</div>";
                echo "<div class='order-details'>";
                echo "<p><strong>Item:</strong> " . htmlspecialchars($row['item_name']) . " (x" . htmlspecialchars($row['quantity']) . ")</p>";
                echo "<p><strong>Price:</strong> ₱" . htmlspecialchars(number_format($row['price'], 2)) . "</p>";
                echo "<p><strong>Order Date:</strong> " . htmlspecialchars($row['order_date']) . "</p>";
                echo "<p><strong>Delivery Option:</strong> " . htmlspecialchars($row['delivery_option']) . "</p>";
                echo "<p><strong>Address:</strong> " . htmlspecialchars($row['address']) . "</p>";
                echo "<p><strong>Phone Number:</strong> " . htmlspecialchars($row['phone_number']) . "</p>";
                echo "</div>";
                echo "<div class='order-actions'>";
                echo "<form method='POST' action='reorder.php' style='display:inline;'>";
                echo "<input type='hidden' name='order_id' value='" . htmlspecialchars($row['order_id']) . "'>";
                echo "<button type='submit' class='btn btn-success btn-sm'>Reorder</button>";
                echo "</form>";
                echo "<form method='POST' action='removeOrder.php' style='display:inline;' onsubmit='return confirmRemove();'>";
                echo "<input type='hidden' name='order_id' value='" . htmlspecialchars($row['order_id']) . "'>";
                echo "<button type='submit' class='btn btn-danger btn-sm'>Remove</button>";
                echo "</form>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<p class='text-center'>No canceled orders found.</p>";
        }
        ?>
        <script>
            function confirmRemove() {
                return confirm("Are you sure you want to remove this order?");
            }
        </script>
    </div>
</body>
</html>

<?php
$stmt->close();
$stmt_canceled->close();
$conn->close();
?>