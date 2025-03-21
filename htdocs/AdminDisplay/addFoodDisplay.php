<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Redirect to login page if the admin is not logged in
if (!isset($_SESSION['admin_username'])) {
    header("Location: log-in.php");
    exit();
}

// Include the database connection file
require_once 'db_connection.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['foodName'] ?? '';
    $price = $_POST['price'] ?? 0;
    $description = $_POST['description'] ?? '';
    $imageUrl = $_POST['imageUrl'] ?? '';
    $category = $_POST['category'] ?? 'Uncategorized'; // Provide a default value for category

    $sql = "INSERT INTO menu_items (name, description, price, image_url, category) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdss", $name, $description, $price, $imageUrl, $category);

    if ($stmt->execute()) {
        $success = "Food added successfully!";
    } else {
        $error = "Failed to add food. Please try again.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Food</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header class="bg-dark text-white p-3">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="text-center">DM'S Lechon House</h1>
            <nav>
                <a href="menuDisplay.php" class="btn btn-light btn-sm">Menu</a>
                <a href="logout.php" class="btn btn-danger btn-sm">Logout</a> <!-- Ensure this points to the correct logout.php file -->
            </nav>
        </div>
    </header>

    <div class="container mt-4">
        <h2 class="text-center">Add Food</h2>
        <?php if (isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
        <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
        <form action="" method="POST" class="border p-4 bg-light shadow rounded" style="max-width: 600px; margin: 0 auto;">
            <div class="mb-3">
                <label for="foodName" class="form-label">Food Name</label>
                <input type="text" class="form-control" id="foodName" name="foodName" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" step="0.01" class="form-control" id="price" name="price" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="imageUrl" class="form-label">Image URL</label>
                <input type="url" class="form-control" id="imageUrl" name="imageUrl" required>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <input type="text" class="form-control" id="category" name="category" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Add Food</button>
        </form>
    </div>
</body>
</html>