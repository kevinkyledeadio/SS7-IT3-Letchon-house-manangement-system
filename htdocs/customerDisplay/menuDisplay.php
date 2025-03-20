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

// Fetch menu items
$sql = "SELECT * FROM menu_items";
$result = $conn->query($sql);

// Fetch additional items (sauces, drinks, side dishes)
$sql_additional = "SELECT * FROM additional_items";
$result_additional = $conn->query($sql_additional);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DM'S Lechon House - Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="MenuDisplay.css">
    <script>
        function calculateTotal() {
            const price = parseFloat(document.getElementById('price').value) || 0;
            const quantity = parseInt(document.getElementById('quantity').value) || 1;
            const additionalItems = document.querySelectorAll('.additional-item:checked');
            let additionalCost = 0;

            additionalItems.forEach(item => {
                additionalCost += parseFloat(item.dataset.price);
            });

            const total = (price * quantity) + additionalCost;
            document.getElementById('total').value = total.toFixed(2);
        }
    </script>
</head>
<body>
    <header class="bg-dark text-white p-3">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="text-center">DM'S Lechon House</h1>
            <nav>
                <a href="homeDisplay.php" class="btn btn-light btn-sm">Home</a>
                <a href="orderHistory.php" class="btn btn-light btn-sm">Order History</a>
                <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
            </nav>
        </div>
    </header>

    <div class="container mt-4">
        <h2 class="text-center">Menu</h2>
        <div class="row">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="col-md-4 mb-4">';
                    echo '<div class="card">';
                    echo '<img src="' . $row['image_url'] . '" class="card-img-top" alt="' . $row['name'] . '">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . $row['name'] . '</h5>';
                    echo '<p class="card-text">' . $row['description'] . '</p>';
                    echo '<p class="text-danger">₱' . $row['price'] . '</p>';
                    echo '<button class="btn btn-primary" onclick="showOrderForm(\'' . $row['name'] . '\', ' . $row['price'] . ')">Order Now</button>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p class="text-center">No menu items available.</p>';
            }
            ?>
        </div>
    </div>

   