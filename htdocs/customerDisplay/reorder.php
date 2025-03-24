<?php
session_start();

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
    // Debug POST data
    var_dump($_POST);

    $customer_id = $_SESSION['customer_id'];
    $order_id = intval($_POST['order_id']);

    // Update the status of the canceled order to "Pending"
    $sql_update_status = "UPDATE orders SET status = 'Pending' WHERE id = ? AND client_id = ? AND status = 'Cancelled'";
    $stmt_update_status = $conn->prepare($sql_update_status);
    if (!$stmt_update_status) {
        die("Error preparing update query: " . $conn->error);
    }
    $stmt_update_status->bind_param("ii", $order_id, $customer_id);
    if (!$stmt_update_status->execute()) {
        die("Error executing update query: " . $stmt_update_status->error);
    }

    // Redirect back to order history
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
            <div class="mb-3">
                <label for="phone_number" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number" required>
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
