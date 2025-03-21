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
    <link rel="stylesheet" href="homeDisplay.css">
</head>
<body>
    <header class="bg-dark text-white p-3">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="text-center">DM'S Lechon House</h1>
            <nav>
                <a href="menuDisplay.php" class="btn btn-light btn-sm">Menu</a>
                <a href="orderHistory.php" class="btn btn-light btn-sm">Order History</a>
                <a href="ContactUs.php" class="btn btn-info btn-sm">Contact Us</a>
                <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
            </nav>
        </div>
    </header>

    <section class="hero text-center py-5">
        <div class="container">
            <h1>Welcome to DM'S Lechon House</h1>
            <p>Experience the best lechon in town, made with love and tradition.</p>
            <a href="menuDisplay.php" class="btn btn-danger btn-lg">Explore Menu</a>
        </div>
    </section>

    <section class="featured-items py-5">
        <div class="container">
            <h2 class="text-center mb-4">Featured Items</h2>
            <div class="row">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="col-md-4 mb-4">';
                        echo '<div class="card shadow-sm">';
                        echo '<img src="' . $row['image_url'] . '" class="card-img-top" alt="' . $row['name'] . '">';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">' . $row['name'] . '</h5>';
                        echo '<p class="card-text">' . $row['description'] . '</p>';
                        echo '<p class="text-danger">₱' . number_format($row['price'], 2) . '</p>';
                        echo '<button class="btn btn-primary w-100">Order Now</button>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<p class="text-center">No featured items available.</p>';
                }
                ?>
            </div>
        </div>
    </section>
</body>
</html>
<?php
$conn->close();
?>