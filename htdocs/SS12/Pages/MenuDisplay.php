<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DM'S Lechon House - Menu</title>
    <link rel="stylesheet" href="MenuDisplay.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">DM'S <span>Lechon House</span></div>
            <ul class="nav-links">
                <li><a href="HomeDisplay.php">Home</a></li>
                <li><a href="MenuDisplay.php">Menu</a></li>
                <li><a href="#">Service</a></li>
                <li><a href="#">About Us</a></li>
                <li><a href="#">Gallery</a></li>
            </ul>
        </nav>
    </header>

    <div class="menu-section">
        <h2>Our Menu</h2>
        <div class="menu-filter">
            <a href="#" onclick="filterMenu('all')">All</a>
            <a href="#" onclick="filterMenu('whole-lechon')">Whole Lechon</a>
            <a href="#" onclick="filterMenu('lechon-belly')">Lechon Belly</a>
            <a href="#" onclick="filterMenu('cochinillo')">Cochinillo</a>
            <a href="#" onclick="filterMenu('packages')">Packages</a>
        </div>
    </div>

    <!-- Main Container (Wrap menu items and order form) -->
    <div class="container">
        <!-- Menu Items Section -->
        <div class="menu-items">
            <div class="menu-item whole-lechon">
                <h3>Whole Lechon</h3>
                <p>Traditional roasted pig with crispy skin.</p>
                <span class="price">₱5,500</span>
            </div>
            <div class="menu-item lechon-belly">
                <h3>Lechon Belly</h3>
                <p>Boneless, herb-infused roasted pork belly.</p>
                <span class="price">₱1,800</span>
            </div>
            <div class="menu-item cochinillo">
                <h3>Cochinillo</h3>
                <p>Spanish-style roasted suckling pig.</p>
                <span class="price">₱6,500</span>
            </div>
            <div class="menu-item packages">
                <h3>Whole Lechon Package</h3>
                <p>Whole lechon with side dishes and drinks.</p>
                <span class="price">₱7,500</span>
            </div>
            <div class="menu-item packages">
                <h3>Lechon Belly Package</h3>
                <p>Lechon belly with rice and drinks.</p>
                <span class="price">₱2,300</span>
            </div>
            <div class="menu-item packages">
                <h3>Cochinillo Package</h3>
                <p>Cochinillo with paella and drinks.</p>
                <span class="price">₱7,800</span>
            </div>
        </div>

        <!-- Order Form Section -->
        <div class="order-form">
            <h2>Place Your Order</h2>
            <form>
                <label for="fullname">Full Name:</label>
                <input type="text" id="fullname" name="fullname" required>
                <label for="email">Email Address:</label>
                <input type="email" id="email" name="email" required>
                <label for="contact">Contact Number:</label>
                <input type="tel" id="contact" name="contact" required>
                <label for="order-item">Select Item:</label>
                <select id="order-item" name="order-item">
                    <option value="whole-lechon">Whole Lechon</option>
                    <option value="lechon-belly">Lechon Belly</option>
                    <option value="cochinillo">Cochinillo</option>
                    <option value="whole-lechon-package">Whole Lechon Package</option>
                    <option value="lechon-belly-package">Lechon Belly Package</option>
                    <option value="cochinillo-package">Cochinillo Package</option>
                </select>
                <label for="quantity">Order Quantity:</label>
                <input type="number" id="quantity" name="quantity" min="1" required>
                <label for="price">Price:</label>
                <input type="text" id="price" name="price" readonly>
                <label for="total">Total Price:</label>
                <input type="text" id="total" name="total_price" readonly>
                <button type="submit">Submit Order</button>
            </form>
        </div>
    </div>

    <script>
        function filterMenu(category) {
            let items = document.querySelectorAll('.menu-item');
            items.forEach(item => {
                if (category === 'all' || item.classList.contains(category)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>
