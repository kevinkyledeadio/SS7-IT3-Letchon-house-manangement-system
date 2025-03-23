<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


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

// Fetch menu items
$sql = "SELECT * FROM menu_items";
$result = $conn->query($sql);

// Fetch categories
$sql_categories = "SELECT DISTINCT category FROM menu_items";
$result_categories = $conn->query($sql_categories);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
    $customer_id = $_SESSION['customer_id'];
    $menu_item_id = $_POST['menu_item_id'];
    $quantity = $_POST['quantity'];
    $delivery_option = $_POST['delivery_option'];
    $address = $_POST['address'];
    $phone_number = $_POST['phone_number'];

    // Fetch client ID
    $sql_client = "SELECT * FROM clients WHERE id = ?";
    $stmt_client = $conn->prepare($sql_client);
    $stmt_client->bind_param("i", $customer_id);
    $stmt_client->execute();
    $result_client = $stmt_client->get_result();
    $client = $result_client->fetch_assoc();


    // Fetch menu item details
    $sql_item = "SELECT name, price FROM menu_items WHERE id = ?";
    $stmt_item = $conn->prepare($sql_item);
    $stmt_item->bind_param("i", $menu_item_id);
    $stmt_item->execute();
    $result_item = $stmt_item->get_result();
    $item = $result_item->fetch_assoc();
    $item_name = $item['name'];
    $item_price = $item['price'];
    $total_price = $item_price * $quantity;
    $DateTime_Delivery = $_POST['delivery_datetime'];

    // Insert into orders table
    $sql_order = "INSERT INTO orders (client_id, total_price, delivery_option, address, phone_number, delivery_datetime) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt_order = $conn->prepare($sql_order);
    $stmt_order->bind_param("idssss", $customer_id, $total_price, $delivery_option, $address, $phone_number, $DateTime_Delivery);
    $stmt_order->execute();

    $customer_placed_orderID = $stmt_order->insert_id;

    // Insert into order_items table
    $sql_order_item = "INSERT INTO order_items (order_id, item_name, quantity, price) VALUES (?, ?, ?, ?)";
    $stmt_order_item = $conn->prepare($sql_order_item);
    $stmt_order_item->bind_param("isid", $customer_placed_orderID, $item_name, $quantity, $item_price);
    $stmt_order_item->execute();

    // Redirect to order history
    header("Location: orderHistory.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DM'S Lechon House - Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/jquery.datetimepicker.min.css">
    <link rel="stylesheet" href="MenuDisplay.css">
    <script src="orderform.js"></script>
</head>
<body>
    <header class="bg-dark text-white p-3">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="text-center">DM'S Lechon House</h1>
            <nav>
                <a href="homeDisplay.php" class="btn btn-light btn-sm">Home</a>
                <a href="orderHistory.php" class="btn btn-light btn-sm">Order History</a>
                <a href="ContactUs.php" class="btn btn-info btn-sm">Contact Us</a>
                <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
            </nav>
        </div>
    </header>

    <div class="container mt-4">
        <h2 class="text-center mb-4">Menu</h2>

        <!-- Category Filter -->
        <div class="menu-filter text-center mb-4">
            <button class="btn btn-outline-dark btn-sm mx-1" onclick="filterMenu('all')">All</button>
            <?php
            if ($result_categories->num_rows > 0) {
                while ($category = $result_categories->fetch_assoc()) {
                    echo '<button class="btn btn-outline-dark btn-sm mx-1" onclick="filterMenu(\'' . htmlspecialchars($category['category']) . '\')">' . htmlspecialchars($category['category']) . '</button>';
                }
            }
            ?>
        </div>

        <div class="row">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="col-md-4 mb-4 menu-item" data-category="' . htmlspecialchars($row['category']) . '">';
                        echo '<div class="card h-100 shadow-sm">';
                            echo '<img src="' . htmlspecialchars($row['image_url']) . '" class="card-img-top" alt="' . htmlspecialchars($row['name']) . '">';
                                echo '<div class="card-body d-flex flex-column">';
                                    echo '<h5 class="card-title">' . htmlspecialchars($row['name']) . '</h5>';
                                    echo '<p class="card-text text-muted">' . htmlspecialchars($row['description']) . '</p>';
                                    echo '<p class="text-danger fw-bold">₱' . htmlspecialchars(number_format($row['price'], 2)) . '</p>';
                                    echo '<button class="order-btn mt-auto" onclick="showOrderForm(' . $row['id'] . ', \'' . $row['name'] . '\', ' . $row['price'] . ')">Order Now</button>';
                                echo '</div>';
                        echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p class="text-center">No menu items available.</p>';
            }
            ?>

            <script>
                    function filterMenu(category) {
                        const items = document.querySelectorAll('.menu-item');
                        items.forEach(item => {
                            if (category === 'all' || item.dataset.category === category) {
                                item.style.display = 'block';
                            } else {
                                item.style.display = 'none';
                            }
                        });
                    }
                </script>

        </div>
    </div>

    <!-- Order Form Modal -->
    <div class="order-form-overlay" onclick="closeOrderForm()"></div>
    <div class="order-form">
        <button class="close-btn" onclick="closeOrderForm()">X</button>
        <h2>Place Your Order</h2>
        <form method="POST" action="">
            <input type="hidden" name="menu_item_id" id="menu_item_id">
            <label for="quantity">Order Quantity:</label>
            <input type="number" name="quantity" id="quantity" min="1" required oninput="calculateTotal()">

            <label for="price">Price:</label>
            <input type="text" id="price" readonly>

            <label for="total">Total Price:</label>
            <input type="text" id="total" readonly>

            <label for="address">Address:</label>
            <textarea name="address" id="address" required></textarea>

            <label for="phone_number">Phone Number:</label>
            <input type="text" name="phone_number" id="phone_number" required>

            <label for="delivery_datetime">Scheduled Pickup/Delivery Date:</label>
            <input type="text" name="delivery_datetime" id="delivery_datetime" required>

            <label for="delivery_option">Delivery Option:</label>
            <select name="delivery_option" id="delivery_option" required>
                <option value="pickup">Pickup</option>
                <option value="delivery">Delivery</option>
            </select>

            <button type="submit" name="place_order" class="submit-btn">Submit Order</button>
        </form>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <!-- Include jQuery datetimepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/jquery.datetimepicker.full.min.js"></script>

    <script>
        function showOrderForm(id, name, price) {
            document.querySelector('.order-form').style.display = 'block';
            document.querySelector('.order-form-overlay').style.display = 'block';
            document.getElementById('menu_item_id').value = id;
            document.getElementById('price').value = price;
        }

        function closeOrderForm() {
            document.querySelector('.order-form').style.display = 'none';
            document.querySelector('.order-form-overlay').style.display = 'none';
        }

        function calculateTotal() {
            let quantity = document.getElementById('quantity').value;
            let price = document.getElementById('price').value;
            document.getElementById('total').value = quantity * price;
        }
        $(document).ready(function() {
            $('#delivery_datetime').datetimepicker({
                format: 'Y-m-d H:i', // Date and time format (Year-Month-Day Hour:Minute)
                minDate: 0, // Disables past dates (optional)
                step: 30, // Time step in minutes (optional, set to 30 for 30-minute intervals)
                scrollInput: false, // Disables scrolling in the input fields
                allowTimes: ['00:00', '06:00', '12:00', '18:00'], // Specific allowed times (optional)
            });
        });

    </script>
</body>
</html>

<?php $conn->close(); ?>
