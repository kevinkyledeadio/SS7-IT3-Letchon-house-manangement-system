<?php
session_start();

// Redirect to login page if the admin is not logged in
if (!isset($_SESSION['admin_username'])) {
    header("Location: log-in.php");
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

// Update menu items with category 'whole-lechon' to 'Whole Lechon'
$sql_update_category = "UPDATE menu_items SET category = 'Whole Lechon' WHERE category = 'whole-lechon'";
$conn->query($sql_update_category);

// Handle delete menu item request
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql_delete = "DELETE FROM menu_items WHERE id = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("i", $delete_id);

    if ($stmt_delete->execute()) {
        echo "<script>alert('Menu item deleted successfully!'); window.location.href='menuDisplay.php';</script>";
    } else {
        echo "<script>alert('Failed to delete menu item. Please try again.');</script>";
    }
    $stmt_delete->close();
}

// Fetch menu items
$sql = "SELECT * FROM menu_items";
$result = $conn->query($sql);

// Fetch categories
$sql_categories = "SELECT DISTINCT category FROM menu_items";
$result_categories = $conn->query($sql_categories);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Menu Display</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="menuDsiplay.css">
</head>
<body>
    <header class="bg-dark text-white py-4">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="mb-0">Admin Dashboard</h1>
            <nav class="d-flex flex-grow-1 justify-content-center">
                <a href="dashboard.php" class="btn btn-light btn-sm mx-2">Dashboard</a>
                <a href="Order-list.php" class="btn btn-light btn-sm mx-2">Order List</a>
                <a href="addFoodDisplay.php" class="btn btn-success btn-sm mx-2">Add Food</a>
            </nav>
            <a href="logout.php" class="btn btn-danger btn-lg">Logout</a> <!-- Ensure this points to the correct logout.php file -->
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
                    echo '<div class="mt-auto">';
                    echo '<a href="editFood.php?id=' . $row['id'] . '" class="btn btn-warning btn-sm">Edit</a> ';
                    echo '<a href="deleteMenu.php?id=' . $row['id'] . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to delete this item?\')">Delete</a>';
                    echo '</div>';
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
</body>
</html>

<?php $conn->close(); ?>
