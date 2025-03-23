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
    <title>DM'S Lechon House - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="common.css">
    <link rel="stylesheet" href="homeDisplay.css">
</head>
<body>
    <header class="main-header">
        <div class="container d-flex justify-content-between align-items-left">
            <h1 class="logo">DM'S Lechon House</h1>
            <nav class="d-flex justify-content-center">
                <a href="homeDisplay.php">Home</a>
                <a href="menuDisplay.php">Menu</a>
                <a href="orderHistory.php">Order History</a>
                <a href="notifications.php">Notifications</a>
                <a href="ContactUs.php">Contact Us</a>
            </nav>
            <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
        </div>
    </header>

   <div class="menu-section">
    <h2 class="menu-heading">Welcome to DM'S lechon house</h2>
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
            <a href="menuDisplay.php" class="explore-btn"><h1>Explore Our Menu</h1></a>
        </div>

        <div class="menu-container">
            <div class="menu-item">
                <img src="https://i.pinimg.com/236x/21/40/31/214031438b8bf201bcf76d13fe664c4d.jpg" alt="Lechon Baboy">
                <div class="menu-details">
                    <h3>whole lechon Baboy</h3>
                    <p>30-kilos Traditional Filipino roasted pig with crispy skin.</p>
                    <div class="price-order">
                        <span class="price">₱15,000</span>
                        <button class="order-btn">Order Now</button>
                    </div>
                </div>
            </div>
            <div class="menu-item">
                <img src="https://i.pinimg.com/736x/d5/23/93/d52393d4892b9e8851e04738f6cd651f.jpg" alt="Lechon Belly">
                <div class="menu-details">
                    <h3>Lechon Belly</h3>
                    <p>Boneless, herb-infused roasted pork belly.</p>
                    <div class="price-order">
                        <span class="price">₱1,800</span>
                        <button class="order-btn">Order Now</button>
                    </div>
                </div>
            </div>
            <div class="menu-item">
                <img src="https://i.pinimg.com/236x/f7/21/5d/f7215d48dd6b560d750de8a9a700705d.jpg" alt="Cochinillo">
                <div class="menu-details">
                    <h3>Cochinillo</h3>
                    <p>Spanish-style roasted suckling pig, tender and flavorful.</p>
                    <div class="price-order">
                        <span class="price">₱6,500</span>
                        <button class="order-btn">Order Now</button>
                    </div>
                </div>
            </div>
            <div class="menu-item">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQbav8QGPEO12Jc-5d5kY7YP-DQX14P4klgsD6DnEk8hCKrS8d0oU_5CwEJr1sVipACbZU&usqp=CAU" alt="Whole Lechon Package">
                <div class="menu-details">
                    <h3>Whole Lechon Package</h3>
                    <p>Complete feast with whole lechon, side dishes, and rice.</p>
                    <div class="price-order">
                        <span class="price">₱8,500</span>
                        <button class="order-btn">Order Now</button>
                    </div>
                </div>
            </div>
            <div class="menu-item">
                <img src="https://upload.wikimedia.org/wikipedia/commons/6/6d/Lechon_Manok.jpg" alt="Lechon Manok">
                <div class="menu-details">
                    <h3>Lechon Manok</h3>
                    <p>Rotisserie-style grilled chicken, crispy outside, juicy inside.</p>
                    <div class="price-order">
                        <span class="price">₱380</span>
                        <button class="order-btn">Order Now</button>
                    </div>
                </div>
            </div>
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
</body>
</html>
<?php
$conn->close();
?>
