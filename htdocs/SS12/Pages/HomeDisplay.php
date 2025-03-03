<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Coampatible" content="IE-edge">
    <link rel="stylesheet" href="HomeDisplay.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" >
    <title>Lechon house</title>
</head>
<body>
    <style>
            /* Sidebar styling */
.sidebar {
    width: 200px;
    height: 100vh;
    background-color: #333;
    color: white;
    position: fixed;
    top: 0;
    left: 0;
    padding-top: 20px;
}

.sidebar ul {
    list-style-type: none;
    padding: 0;
    margin: 0;
    border-bottom: 1px solid #555;
    padding-bottom: 10px;
    margin-bottom: 10px;
}

.sidebar ul li {
    padding: 10px 0;
}

.sidebar ul li a {
    color: white;
    text-decoration: none;
    font-size: 17px;
    display: block;
    padding: 10px 15px;
    border-radius: 4px;
    transition: background-color 0.3s;
}

.sidebar ul li a:hover {
    background-color: #ff5722;
}

    </style>

        <div class="sidebar">
            <ul>
                <li><b>DM&'S LECHON</b></a></li>
            </ul>
            <ul>
                <li><b><a href="Home.html">Home</b></a></li>
                <li><b><a href="Menu.html">Menu</b></a></li>
                <li><b><a href="Orders.html">Orders</b></a>
                <li><b><a href="Home.html">Home</b></a></li>
            </ul>
        </div>

     <div class="container">
        <header>
            <h1>DM&'S LECHON HOUSE</h1>
            <input type="text" placeholder="Search..." class="search-box">
        </header>
        
        <nav class="category-nav">
            <button class="active">Food-package</button>
            <button>Papular-Orders</button>
            <button>Best-Selling</button>
            <button>Whole-lechon</button>
            <button>Lechon-belly</button>
            <button>Chocinillio</button>
        </nav>
        
        <section class="popular-orders">

            <h2>Popular Orders</h2>
            <div class="order-list">
                <div class="order-item">
                    <img src="https://i.pinimg.com/736x/38/08/f5/3808f53a985580a55bf49dcc29beec89.jpg" alt="20-Kilos" width="200%" height="50%">
                    <h3>20-Kilos</h3>
                    <p>Price:<span>14,000</span></p>
                    <button>Order</button>
                </div>

                <div class="order-item">
                    <img src="https://i.pinimg.com/736x/d5/23/93/d52393d4892b9e8851e04738f6cd651f.jpg" alt="7-Kilos" width="100%" height="50%">
                    <h3>5-Kilos</h3>
                    <p>Price:<span>2,600</span></p>
                    <button>Order</button>
                </div>

                <div class="order-item">
                    <img src="https://i.pinimg.com/1200x/f7/21/5d/f7215d48dd6b560d750de8a9a700705d.jpg" alt="15-Kilos" width="100%" height="50%">
                    <h3>15-kilos</h3>
                    <p>Price:<span>12,000</span></p>
                    <button>Order</button>
                </div>
            </div>
        </section>

      <section class="popular-orders">

            <h2>Best Selling</h2>
            <div class="order-list">
                <div class="order-item">
                    <img src="lamp-chops.jpg" alt="Grilled Lamp Chops">
                    <h3>Grilled Lamp Chops</h3>
                    <p>$25.18 <span>$31.86</span></p>
                    <button>Order</button>
                </div>

                <div class="order-item">
                    <img src="noodles.jpg" alt="Instant Noodles">
                    <h3>Instant Noodles</h3>
                    <p>$45.28</p>
                    <button>Order</button>
                </div>

                <div class="order-item">
                    <img src="goose-liver.jpg" alt="Goose Liver Paste">
                    <h3>Goose Liver Paste</h3>
                    <p>$30.12</p>
                    <button>Order</button>
                </div>
            </div>
        </section>

       <section class="popular-orders">
            <h2>Whole lechon</h2>
            <div class="order-list">
                <div class="order-item">
                    <img src="lamp-chops.jpg" alt="Grilled Lamp Chops">
                    <h3>Grilled Lamp Chops</h3>
                    <p>$25.18 <span>$31.86</span></p>
                    <button>Order</button>
                </div>

                <div class="order-item">
                    <img src="noodles.jpg" alt="Instant Noodles">
                    <h3>Instant Noodles</h3>
                    <p>$45.28</p>
                    <button>Order</button>
                </div>

                <div class="order-item">
                    <img src="goose-liver.jpg" alt="Goose Liver Paste">
                    <h3>Goose Liver Paste</h3>
                    <p>$30.12</p>
                    <button>Order</button>
                </div>
            </div>
        </section>
        
    </div>
</body>
</html>
