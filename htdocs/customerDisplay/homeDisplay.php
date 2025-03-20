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

// Fetch featured menu items
$sql = "SELECT * FROM menu_items WHERE is_featured = 1";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DM'S Lechon House</title>
    <link rel="stylesheet" href="homeDisplay.css">
</head>
<body>
    <header class="bg-dark text-white p-3">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="text-center">DM'S Lechon House</h1>
            <nav>
                <a href="menuDisplay.php" class="btn btn-light btn-sm">Menu</a>
                <a href="orderHistory.php" class="btn btn-light btn-sm">Order History</a>
                <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
            </nav>
        </div>
    </header>

    <div class="menu-section">
        <h2 class="menu-heading">Welcome to DM'S Lechon House</h2>
        <div class="menu-divider"></div>
    </div>
    
    <section class="hero">
        <div class="hero-content">
            <div class="hero-text">
                <h1>Order Your Best Food Anytime</h1>
                <p>Hey, Our delicious food is waiting for you.<br>We are always near you with fresh items of food.</p>
                <a href="Menu.html" class="hero-btn">Explore Menu</a>
            </div>
            <div class="hero-image">
                <img src="https://i.pinimg.com/736x/38/08/f5/3808f53a985580a55bf49dcc29beec89.jpg" alt="Delicious food">
            </div>
        </div>
    </section>

    <section class="explore">
        <div class="text">
            <h1>Explore Our Menu</h1>
        </div>

        <div class="menu-container">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="menu-item">';
                    echo '<img src="' . $row['image_url'] . '" alt="' . $row['name'] . '">';
                    echo '<div class="menu-details">';
                    echo '<h3>' . $row['name'] . '</h3>';
                    echo '<p>' . $row['description'] . '</p>';
                    echo '<div class="price-order">';
                    echo '<span class="price">₱' . $row['price'] . '</span>';
                    echo '<button class="order-btn">Order Now</button>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p>No featured items available.</p>';
            }
            ?>
        </div>
    </section>

    <section class="popular">
        <div class="text">
            <h1>Popular Lechon</h1>
        </div>
        <div class="popular-container">
            <div class="popular-item">
                <img src="https://i.pinimg.com/736x/29/ce/81/29ce81db5f379a9eb207421e7fd20800.jpg" alt="Lechon Baboy">
                <div class="popular-details">
                    <h3>Lechon Baboy</h3>
                    <p>A traditional Filipino roasted pig, known for its crispy golden-brown skin and juicy, flavorful meat. A must-have for celebrations!</p>
                </div>
            </div>
            <div class="popular-item">
                <img src="https://i.pinimg.com/736x/d5/23/93/d52393d4892b9e8851e04738f6cd651f.jpg" alt="Lechon Belly">
                <div class="popular-details">
                    <h3>Lechon Belly</h3>
                    <p>Boneless, rolled, and slow-roasted pork belly with a crispy skin and aromatic spices. Perfect for any feast!</p>
                </div>
            </div>
            <div class="popular-item">
                <img src="https://i.pinimg.com/736x/6f/5c/27/6f5c27464f19c6d8863eca274c03819d.jpg" alt="Cochinillo">
                <div class="popular-details">
                    <h3>Cochinillo</h3>
                    <p>A Spanish-style roasted suckling pig, tender inside and crispy outside. A gourmet experience for special occasions.</p>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
<?php
$conn->close();
?>