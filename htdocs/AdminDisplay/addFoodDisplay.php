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

// Fetch categories for the dropdown
$sql_categories = "SELECT DISTINCT category FROM menu_items";
$result_categories = $conn->query($sql_categories);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['foodName'] ?? '';
    $price = $_POST['price'] ?? 0;
    $description = $_POST['description'] ?? '';
    $category = $_POST['category'] ?? 'Uncategorized'; // Default category

    // Check if a new category is provided
    if (!empty($_POST['newCategory'])) {
        $newCategory = $_POST['newCategory'];
        $sql_new_category = "INSERT INTO menu_items (category) SELECT ? WHERE NOT EXISTS (SELECT 1 FROM menu_items WHERE category = ?)";
        $stmt_new_category = $conn->prepare($sql_new_category);
        $stmt_new_category->bind_param("ss", $newCategory, $newCategory);
        $stmt_new_category->execute();
        $stmt_new_category->close();
        $category = $newCategory; // Use the new category
    }

    // Handle file upload
    if (isset($_FILES['imageFile']) && $_FILES['imageFile']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        
        // Ensure the uploads directory exists
        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0777, true)) {
                $error = "Failed to create upload directory.";
            }
        }

        if (!isset($error)) {
            $imagePath = $uploadDir . basename($_FILES['imageFile']['name']);
            if (move_uploaded_file($_FILES['imageFile']['tmp_name'], $imagePath)) {
                $imageUrl = $imagePath;
            } else {
                $error = "Failed to upload image.";
            }
        }
    } else {
        $error = "Please upload a valid image.";
    }

    if (!isset($error)) {
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
        <form action="" method="POST" enctype="multipart/form-data" class="border p-4 bg-light shadow rounded" style="max-width: 600px; margin: 0 auto;">
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
                <label for="imageFile" class="form-label">Image</label>
                <input type="file" class="form-control" id="imageFile" name="imageFile" accept="image/*" required>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select class="form-control" id="category" name="category">
                    <option value="" disabled selected>Select a category</option>
                    <?php
                    if ($result_categories->num_rows > 0) {
                        while ($category = $result_categories->fetch_assoc()) {
                            echo '<option value="' . htmlspecialchars($category['category']) . '">' . htmlspecialchars($category['category']) . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="newCategory" class="form-label">Or Add New Category</label>
                <input type="text" class="form-control" id="newCategory" name="newCategory" placeholder="Enter new category">
            </div>
            <button type="submit" class="btn btn-primary w-100">Add Food</button>
        </form>
    </div>
</body>
</html>