<?php
    session_start();

    // Redirect to login page if the admin is not logged in
    if (!isset($_SESSION['admin_username'])) {
        header("Location: log-in.php");
        exit();
    }

    // Include the database connection file
    require_once 'db_connection.php';

    // Handle search functionality
    $search_query = '';
    if (isset($_GET['search'])) {
        $search_query = $_GET['search'];
        $sql = "SELECT o.id, c.name AS client_name, o.total_price, o.order_date, o.delivery_option, o.status, o.address, o.phone_number, o.delivery_datetime 
                FROM orders o 
                JOIN clients c ON o.client_id = c.id 
                WHERE c.name LIKE ? OR o.id LIKE ?";
        $stmt = $conn->prepare($sql);
        $search_term = '%' . $search_query . '%';
        $stmt->bind_param("ss", $search_term, $search_term);
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        $sql = "SELECT o.id, c.name AS client_name, o.total_price, o.order_date, o.delivery_option, o.status, o.address, o.phone_number, o.delivery_datetime 
                FROM orders o 
                JOIN clients c ON o.client_id = c.id";
        $result = $conn->query($sql);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="order-list.css"> <!-- Link to external CSS file -->
</head>
<body>
    <header class="bg-dark text-white p-3">
        <div class="container d-flex justify-content-between align-items-center">
            <h1>Order List</h1>
            <nav>
                <a href="menuDisplay.php" class="btn btn-light btn-sm">Menu</a>
                <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
            </nav>
        </div>
    </header>

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <form method="GET" action="" class="d-flex">
                <input type="text" name="search" class="form-control w-25" placeholder="Search for an order..." value="<?= htmlspecialchars($search_query) ?>">
                <button type="submit" class="btn btn-primary ms-2">Search</button>
            </form>
        </div>
        <div class="table-container">
            <h2 class="text-center mb-4">Order List</h2>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Client Name</th>
                        <th>Total Price</th>
                        <th>Order Date</th>
                        <th>Delivery Option</th>
                        <th>Scheduled Delivery/Pickup</th>
                        <th>Status</th>
                        <th>Address</th>
                        <th>Phone Number</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['id'] . "</td>";
                            echo "<td>" . htmlspecialchars($row['client_name']) . "</td>";
                            echo "<td>₱" . htmlspecialchars(number_format($row['total_price'], 2)) . "</td>";
                            echo "<td>" . htmlspecialchars($row['order_date']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['delivery_option']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['delivery_datetime']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['address']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['phone_number']) . "</td>";
                            echo '<td class="table-actions">';
                            if ($row["status"] == "Pending") {
                                echo '<button class="btn btn-success btn-sm me-2" data-value="' . $row['id'] . '">Out for Delivery</button>';
                            } elseif ($row["status"] == "Out for Delivery") {
                                echo '<button class="btn btn-primary btn-sm me-2" data-value="' . $row['id'] . '">Completed</button>';
                            } elseif ($row["status"] == "Completed") {
                                echo '<span class="badge bg-success">Completed</span>';
                                echo '<button class="btn btn-danger btn-sm" data-value="' . $row['id'] . '">Delete</button>';
                            }
                            echo '<button class="btn btn-danger btn-sm" data-value="' . $row['id'] . '">Remove</button>';
                            echo '</td>';
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='10' class='text-center'>No orders found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            <div class="d-flex justify-content-between align-items-center mt-3">
                <p class="mb-0">Showing 1 to 10 of 50 entries</p>
                <nav>
                    <ul class="pagination pagination-sm mb-0">
                        <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Out for Delivery
            $(document).on('click', '.btn-success', function(e) {
                if (confirm('Are you sure you want to mark this order as Out for Delivery?')) {
                    var orderId = $(this).data('value');
                    $.ajax({
                        url: 'update-order-status.php',
                        type: 'POST',
                        data: { orderId: orderId, status: 'Out for Delivery' },
                        success: function(response) {
                            if (response === 'success') {
                                alert('Order marked as Out for Delivery.');
                                location.reload();
                            } else {
                                alert('An error occurred. Please try again.');
                            }
                        }
                    });
                }
            });

            // Completed
            $(document).on('click', '.btn-primary', function(e) {
                if (confirm('Are you sure you want to mark this order as Completed?')) {
                    var orderId = $(this).data('value');
                    $.ajax({
                        url: 'update-order-status.php',
                        type: 'POST',
                        data: { orderId: orderId, status: 'Completed' },
                        success: function(response) {
                            if (response === 'success') {
                                alert('Order marked as Completed.');
                                location.reload();
                            } else {
                                alert('An error occurred. Please try again.');
                            }
                        }
                    });
                }
            });

            // Remove order from order list
            $(document).on('click', '.btn-danger', function(e) {
                if (confirm('Are you sure you want to remove this order?')) {
                    var orderId = $(this).data('value');

                    $.ajax({
                        url: 'remove-orderlist.php',
                        type: 'POST',
                        data: { orderId: orderId },
                        success: function(response) {
                            console.log(response);
                            if (response === 'success') {
                                alert('Order removed successfully.');
                                location.reload();
                            } else {
                                alert('An error occurred. Please try again.');
                            }
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
<?php $conn->close(); ?>