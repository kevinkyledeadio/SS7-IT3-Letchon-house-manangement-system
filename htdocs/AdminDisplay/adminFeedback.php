<?php
session_start();

// Redirect to login page if the admin is not logged in
if (!isset($_SESSION['admin_username'])) {
    header("Location: log-in.php");
    exit();
}

// Include the database connection file
require_once 'db_connection.php';

// Fetch all customers
$sql_customers = "SELECT id, name, email FROM clients";
$result_customers = $conn->query($sql_customers);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_id = intval($_POST['customer_id']);
    $message = htmlspecialchars($_POST['message']);
    $admin_name = "D&M'S Lechon House Owner";

    // Insert feedback into the admin_feedback table
    $sql_feedback = "INSERT INTO admin_feedback (customer_id, admin_name, message) VALUES (?, ?, ?)";
    $stmt_feedback = $conn->prepare($sql_feedback);
    $stmt_feedback->bind_param("iss", $customer_id, $admin_name, $message);

    if ($stmt_feedback->execute()) {
        $success = "Feedback sent successfully.";
    } else {
        $error = "Failed to send feedback. Please try again.";
    }

    $stmt_feedback->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Feedback</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-center mb-4">Send Feedback to Customers</h2>
        <?php if (isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
        <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="customer_id" class="form-label">Select Customer:</label>
                <select id="customer_id" name="customer_id" class="form-control" required>
                    <option value="">-- Select Customer --</option>
                    <?php
                    if ($result_customers->num_rows > 0) {
                        while ($customer = $result_customers->fetch_assoc()) {
                            echo "<option value='" . $customer['id'] . "'>" . htmlspecialchars($customer['name']) . " (" . htmlspecialchars($customer['email']) . ")</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Message:</label>
                <textarea id="message" name="message" class="form-control" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary w-100">Send Feedback</button>
        </form>
    </div>
</body>
</html>
<?php $conn->close(); ?>
