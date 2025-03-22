<?php
    session_start();

    // Redirect to login page if the admin is not logged in
    if (!isset($_SESSION['admin_username'])) {
        header("Location: log-in.php");
        exit();
    }

    // Include the database connection file
    require_once 'db_connection.php';

    // Fetch all orders
    $sql = "SELECT o.id, c.name AS client_name, o.total_price, o.order_date, o.delivery_option, o.status, o.address, o.phone_number, o.delivery_datetime 
            FROM orders o 
            JOIN clients c ON o.client_id = c.id";
    $result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
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
        <h2 class="text-center">Order List</h2>
        <table class="table table-striped table-hover shadow rounded">
            <thead class="table-dark">
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
                        if ($row["status"] == "Completed") {
                            // If the order is completed, show the "Set to Pending" button
                            echo '<td><button class="btn btn-warning" id="setPending" data-value="' . $row["id"] . '">Set to Pending</button></td>';
                        } else {
                            // If the order is not completed, show the "Complete Order" button
                            echo '<td><button class="btn btn-success" id="completeOrder" data-value="' . $row["id"] . '">Complete Order</button></td>';
                        }
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9' class='text-center'>No orders found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            // Complete order
            $('#completeOrder').on('click', function(e){
                if (confirm('Are you sure you want to complete this order?')) {
                    // Get the order ID through the data-value attribute
                    var orderId = $(this).data('value');

                    // Send an AJAX request
                    $.ajax({
                        url: 'complete-order.php',
                        type: 'POST',
                        data: {
                            orderId: orderId
                        },
                        success: function(response) {
                            if (response === 'success') {
                                alert('Order setted to completed successfully.');
                                location.reload();
                            } else {
                                alert('An error occurred. Please try again.');
                            }
                        }
                    });
                }
            })

            $('#setPending').on('click', function(e){
                if (confirm('Are you sure you want to set this order to pending?')) {
                    // Get the order ID through the data-value attribute
                    var orderId = $(this).data('value');

                    // Send an AJAX request
                    $.ajax({
                        url: 'set-pending.php',
                        type: 'POST',
                        data: {
                            orderId: orderId
                        },
                        success: function(response) {
                            if (response === 'success') {
                                alert('Order setted to pending successfully.');
                                location.reload();
                            } else {
                                alert('An error occurred. Please try again.');
                            }
                        }
                    });
                }
            })
        });
    </script>
</body>
</html>
<?php $conn->close(); ?>