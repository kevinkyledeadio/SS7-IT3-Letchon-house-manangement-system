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
    die("Connection failed: " . $conn->connect_error);
}

// Handle order submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $client_email = $_SESSION['client_email'];
    $total_price = $_POST['total_price'];
    $delivery_option = $_POST['delivery_option'];
    $order_date = $_POST['order_date'];

    // Get client ID
    $sql_client = "SELECT id FROM clients WHERE email = ?";
    $stmt_client = $conn->prepare($sql_client);
    $stmt_client->bind_param("s", $client_email);
    $stmt_client->execute();
    $result_client = $stmt_client->get_result();
    $client = $result_client->fetch_assoc();

    // Insert order
    $sql_order = "INSERT INTO orders (client_id, total_price, order_date, delivery_option) VALUES (?, ?, ?, ?)";
    $stmt_order = $conn->prepare($sql_order);
    $stmt_order->bind_param("idss", $client['id'], $total_price, $order_date, $delivery_option);

    if ($stmt_order->execute()) {
        $order_id = $stmt_order->insert_id;

        // Insert order items
        foreach ($_POST['items'] as $item) {
            $sql_item = "INSERT INTO order_items (order_id, item_name, quantity, price) VALUES (?, ?, ?, ?)";
            $stmt_item = $conn->prepare($sql_item);
            $stmt_item->bind_param("isid", $order_id, $item['name'], $item['quantity'], $item['price']);
            $stmt_item->execute();
        }

        header("Location: orderConfirmation.php");
        exit();
    } else {
        $error = "Failed to place order. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Checkout</h2>
        <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="order_date" class="form-label">Order Date:</label>
                <input type="date" id="order_date" name="order_date" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="delivery_option" class="form-label">Delivery Option:</label>
                <select id="delivery_option" name="delivery_option" class="form-select" required>
                    <option value="Delivery">Delivery</option>
                    <option value="Pickup">Pickup</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="total_price" class="form-label">Total Price:</label>
                <input type="text" id="total_price" name="total_price" class="form-control" readonly>
            </div>
            <button type="submit" class="btn btn-primary">Place Order</button>
        </form>
    </div>
</body>
</html>
