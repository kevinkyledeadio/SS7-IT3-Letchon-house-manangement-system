<?php
session_start();

// Redirect to login page if the admin is not logged in
if (!isset($_SESSION['admin_username'])) {
    header("Location: log-in.php");
    exit();
}

// Include the database connection file
require_once 'db_connection.php';

// Get the customer email from the query string
$customer_email = isset($_GET['email']) ? $_GET['email'] : '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = htmlspecialchars($_POST['message']);
    $admin_name = "D&M'S Lechon House Owner";

    // Fetch the customer ID using the email
    $sql_customer = "SELECT id FROM clients WHERE email = ?";
    $stmt_customer = $conn->prepare($sql_customer);
    $stmt_customer->bind_param("s", $customer_email);
    $stmt_customer->execute();
    $result_customer = $stmt_customer->get_result();
    $customer = $result_customer->fetch_assoc();
    $customer_id = $customer['id'];

    // Insert the message into the admin_feedback table
    $sql_feedback = "INSERT INTO admin_feedback (customer_id, admin_name, message) VALUES (?, ?, ?)";
    $stmt_feedback = $conn->prepare($sql_feedback);
    $stmt_feedback->bind_param("iss", $customer_id, $admin_name, $message);

    if ($stmt_feedback->execute()) {
        $success = "Message sent successfully.";
    } else {
        $error = "Failed to send the message. Please try again.";
    }

    $stmt_feedback->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message Customer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-center mb-4">Message Customer</h2>
        <?php if (isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
        <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="customer_email" class="form-label">Customer Email:</label>
                <input type="email" id="customer_email" name="customer_email" class="form-control" value="<?= htmlspecialchars($customer_email) ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Message:</label>
                <textarea id="message" name="message" class="form-control" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary w-100">Send Message</button>
        </form>
    </div>
</body>
</html>
<?php $conn->close(); ?>
