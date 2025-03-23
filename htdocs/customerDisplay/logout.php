<?php
session_start();
session_destroy();
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        header {
            background: linear-gradient(to right, #ff7e5f, #feb47b);
            padding: 1rem 0;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        header h1 {
            font-size: 2rem;
            font-weight: bold;
            margin: 0;
            color: white;
        }
        header nav {
            display: flex;
            gap: 1rem;
        }
        header nav a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }
        header nav a:hover {
            color: #343a40;
        }
    </style>
</head>
<body>
    <header>
        <div class="container d-flex justify-content-between align-items-center">
            <h1>DM'S Lechon House</h1>
            <nav>
                <a href="homeDisplay.php">Home</a>
                <a href="menuDisplay.php">Menu</a>
                <a href="orderHistory.php">Order History</a>
                <a href="ContactUs.php">Contact Us</a>
            </nav>
        </div>
    </header>
<?php
header("Location: login.php");
exit();
?>
</body>
