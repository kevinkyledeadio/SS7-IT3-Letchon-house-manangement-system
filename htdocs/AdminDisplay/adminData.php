<?php
session_start();

// Redirect to login page if the admin is not logged in
if (!isset($_SESSION['admin_username'])) {
    header("Location: log-in.php");
    exit();
}

// Include the database connection file
require_once 'db_connection.php'; // Add this line to include the connection file

// Fetch admin data
$sql_admins = "SELECT * FROM admins";
$result_admins = $conn->query($sql_admins);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="adminData.css">
</head>
<body>
    <header class="bg-dark text-white p-3">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="text-center">Admin Panel</h1>
            <nav>
                <a href="dashboard.php" class="btn btn-light btn-sm">Dashboard</a>
                <a href="menuDisplay.php" class="btn btn-light btn-sm">Menu Display</a>
                <a href="Order-list.php" class="btn btn-light btn-sm">Order List</a>
                <a href="logout.php" class="btn btn-danger btn-sm">Logout</a> <!-- Ensure this points to the correct logout.php file -->
            </nav>
        </div>
    </header>

    <div class="container mt-4">
        <h2>Admin Data</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result_admins->num_rows > 0) {
                    while ($row = $result_admins->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['username'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3' class='text-center'>No admin data found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<?php $conn->close(); ?>
