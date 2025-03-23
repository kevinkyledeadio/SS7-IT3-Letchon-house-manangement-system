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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_id = $_SESSION['customer_id'];
    $order_id = intval($_POST['order_id']);
    $item_name = htmlspecialchars($_POST['item_name']);
    $quantity = intval($_POST['quantity']);
    $price = floatval($_POST['price']);
    $total_price = $quantity * $price;
    $order_date = htmlspecialchars($_POST['order_date']);
    $order_time = htmlspecialchars($_POST['order_time']);
    $delivery_option = htmlspecialchars($_POST['delivery_option']);
    $address = htmlspecialchars($_POST['address']);

    // Validate required fields
    if (empty($item_name) || $quantity <= 0 || $price <= 0 || empty($delivery_option) || empty($address)) {
        die("Invalid input data.");
    }

    // Combine order date and time
    $order_datetime = $order_date . ' ' . $order_time;

    // Insert into orders table
    $sql_order = "INSERT INTO orders (client_id, total_price, order_date, delivery_option, address, status) VALUES (?, ?, ?, ?, ?, 'Pending')";
    $stmt_order = $conn->prepare($sql_order);
    $stmt_order->bind_param("idsss", $customer_id, $total_price, $order_datetime, $delivery_option, $address);
    $stmt_order->execute();
    $new_order_id = $stmt_order->insert_id;

    // Insert into order_items table
    $sql_order_item = "INSERT INTO order_items (order_id, item_name, quantity, price) VALUES (?, ?, ?, ?)";
    $stmt_order_item = $conn->prepare($sql_order_item);
    $stmt_order_item->bind_param("isid", $new_order_id, $item_name, $quantity, $price);
    $stmt_order_item->execute();

    // Redirect to order history
    header("Location: orderHistory.php?message=Reorder successful");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit or Reorder</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Edit or Reorder</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address" value="<?php echo isset($order['address']) ? htmlspecialchars($order['address']) : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="delivery_option" class="form-label">Delivery Option</label>
                <select class="form-control" id="delivery_option" name="delivery_option" required>
                    <option value="Pickup" <?php echo isset($order['delivery_option']) && $order['delivery_option'] === 'Pickup' ? 'selected' : ''; ?>>Pickup</option>
                    <option value="Delivery" <?php echo isset($order['delivery_option']) && $order['delivery_option'] === 'Delivery' ? 'selected' : ''; ?>>Delivery</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="order_date" class="form-label">Order Date</label>
                <input type="date" class="form-control" id="order_date" name="order_date" value="<?php echo isset($order['order_date']) ? htmlspecialchars($order['order_date']) : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="order_time" class="form-label">Order Time</label>
                <input type="time" class="form-control" id="order_time" name="order_time" value="<?php echo isset($order['order_time']) ? htmlspecialchars($order['order_time']) : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="item_name" class="form-label">Item Name</label>
                <input type="text" class="form-control" id="item_name" name="item_name" required>
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" class="form-control" id="quantity" name="quantity" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" step="0.01" class="form-control" id="price" name="price" required>
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="orderHistory.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>
