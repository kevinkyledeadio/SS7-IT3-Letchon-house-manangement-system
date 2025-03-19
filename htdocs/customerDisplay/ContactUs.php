<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - DM'S Lechon House</title>
    <link rel="stylesheet" href="ContactUs.css"> <!-- Link to your CSS file -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome for icons -->
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">DM'S Lechon House</div>
            <ul class="nav-links">
                <li><a href="homeDisplay.php">Home</a></li>
                <li><a href="menuDisplay.php">Menu</a></li>
                <li><a href="contact.php">Contact Us</a></li>
            </ul>
        </nav>
    </header>

    <div class="contact-section">
        <h2>Contact Us</h2>
        <div class="contact-divider"></div>
        <p>If you have any questions, feel free to reach out to us using the form below.</p>
        
        <form class="contact-form" action="submit_contact.php" method="POST">
            <label for="fullname">Full Name:</label>
            <input type="text" id="fullname" name="fullname" required>

            <label for="email">Email Address:</label>
            <input type="email" id="email" name="email" required>

            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="5" required></textarea>

            <button type="submit" class="submit-btn">Send Message</button>
        </form>

        <div class="contact-info">
            <h3>Contact Information</h3>
            <p>Email: <a href="mailto:your_email@example.com">Deadiokevin@gmail.com</a></p>
            <div class="social-media">
                <a href="https://www.facebook.com/yourpage" target="_blank" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                <a href="https://www.instagram.com/yourpage" target="_blank" class="social-icon"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2023 DM'S Lechon House. All rights reserved.</p>
    </footer>
</body>
</html>