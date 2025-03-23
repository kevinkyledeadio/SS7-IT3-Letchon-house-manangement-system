<?php
session_start();

if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['order_id'])) {
    header("Location: orderHistory.php");
    exit();
}

$order_id = $_GET['order_id'];

// Database connection
$servername = "localhost";
$username = "mariadb";
$password = "mariadb";
$dbname = "mariadb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_address = $_POST['address'];
    $new_delivery_option = $_POST['delivery_option'];
    $new_order_date = $_POST['order_date'];
    $new_order_time = $_POST['order_time'];

    // Update the order details and reset the status to 'Pending'
    $sql = "UPDATE orders SET address = ?, delivery_option = ?, order_date = CONCAT(?, ' ', ?), status = 'Pending' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $new_address, $new_delivery_option, $new_order_date, $new_order_time, $order_id);

    if ($stmt->execute()) {
        header("Location: orderHistory.php");
        exit();
    } else {
        echo "Error updating order: " . $conn->error;
    }
}

$sql = "SELECT address, delivery_option, DATE(order_date) AS order_date, TIME(order_date) AS order_time FROM orders WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();
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
                <input type="text" class="form-control" id="address" name="address" value="<?php echo htmlspecialchars($order['address']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="delivery_option" class="form-label">Delivery Option</label>
                <select class="form-control" id="delivery_option" name="delivery_option" required>
                    <option value="Pickup" <?php echo $order['delivery_option'] === 'Pickup' ? 'selected' : ''; ?>>Pickup</option>
                    <option value="Delivery" <?php echo $order['delivery_option'] === 'Delivery' ? 'selected' : ''; ?>>Delivery</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="order_date" class="form-label">Order Date</label>
                <input type="date" class="form-control" id="order_date" name="order_date" value="<?php echo htmlspecialchars($order['order_date']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="order_time" class="form-label">Order Time</label>
                <input type="time" class="form-control" id="order_time" name="order_time" value="<?php echo htmlspecialchars($order['order_time']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="orderHistory.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>