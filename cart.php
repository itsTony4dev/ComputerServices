<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/cart.css">

<body>
    <script src="cart.js">

    </script>
    <header>
        <nav>
            <div class=" logo">
                <a href="home.php"><img src="pictures/Logo.png" alt="" /></a>
                <a href="home.php">CT ZONE</a>
            </div>
            <div class="nav-links">
                <ul>
                    <li><a href="home.php">Home</a></li>
                    <li><a href="home.php#buy-Build">Buy</a></li>
                    <li><a href="home.php#contact">Repair</a></li>
                    <?php session_start();
                    if ($_SESSION['is_logged_in']) {
                        echo '<li class="dropdown">
                    <a href="#" onclick="show()">' . $_SESSION['name'] . '</a>
                    <ul class="dropdown-menu" id="dropdown-menu">
                        <li><a href="cart.php">Cart</a></li>
                        <li><a href="history.php">History</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    </ul>
                </li>';
                    } else {
                        echo '<li><a href="login.php">Login</a></li>';
                    } ?>
                </ul>
            </div>
        </nav>
    </header>
    <div class="cart-container">
        <h1 class="cart-title">Your Cart</h1>
        <div class="cart-items">
            <!-- Example Product Card -->
            <div class="cart-card">
                <div class="product-info">
                    <h2 class="product-name">Gaming PC</h2>
                    <img src="uploads/i312th1650.jpg" alt="">
                    <p class="product-description">High-performance gaming setup.</p>
                    <p class="product-price">$1200</p>
                    <div class="quantity-controls">
                        <button id="decrement" class="quantity-btn minus" onclick="decrement()">-</button>
                        <span id="quantity" class="quantity">1</span>
                        <button id="increment" class="quantity-btn plus" onclick="increment()">+</button>
                    </div>
                </div>
                <button class="remove-btn">Remove</button>
            </div>

            <div class="cart-card">
                <div class="product-info">
                    <h2 class="product-name">Gaming PC</h2>
                    <img src="uploads/ASRock_4710483932311.jpg" alt="">
                    <p class="product-description">High-performance gaming setup.</p>
                    <p class="product-price">$1200</p>
                    <div class="quantity-controls">
                        <button class="quantity-btn minus">-</button>
                        <span class="quantity">1</span>
                        <button class="quantity-btn plus">+</button>
                    </div>
                </div>
                <button class="remove-btn">Remove</button>
            </div>

            <div class="cart-card">
                <div class="product-info">
                    <h2 class="product-name">Gaming PC</h2>
                    <img src="uploads/Cooler Master_884102056529.jpg" alt="">
                    <p class="product-description">High-performance gaming setup.</p>
                    <p class="product-price">$1200</p>
                    <div class="quantity-controls">
                        <button class="quantity-btn minus">-</button>
                        <span class="quantity">1</span>
                        <button class="quantity-btn plus">+</button>
                    </div>
                </div>
                <button class="remove-btn">Remove</button>
            </div>


            <div class="cart-card">
                <div class="product-info">
                    <h2 class="product-name">Gaming PC</h2>
                    <img src="uploads/Seagate_141412.jpg" alt="">
                    <p class="product-description">High-performance gaming setup.</p>
                    <p class="product-price">$1200</p>
                    <div class="quantity-controls">
                        <button class="quantity-btn minus">-</button>
                        <span class="quantity">1</span>
                        <button class="quantity-btn plus">+</button>
                    </div>
                </div>
                <button class="remove-btn">Remove</button>
            </div>

            <div class="cart-card">
                <div class="product-info">
                    <h2 class="product-name">Gaming PC</h2>
                    <img src="uploads/rgbFan.jpg" alt="">
                    <p class="product-description">High-performance gaming setup.</p>
                    <p class="product-price">$1200</p>
                    <div class="quantity-controls">
                        <button class="quantity-btn minus">-</button>
                        <span class="quantity">1</span>
                        <button class="quantity-btn plus">+</button>
                    </div>
                </div>
                <button class="remove-btn">Remove</button>
            </div>




        </div>
    </div>
    <div class="cart-summary">
        <h2>Total: $2400</h2>
        <button class="checkout-btn">Proceed to Checkout</button>
    </div>
    </div>
    <footer>
        <p>&copy; 2024 CT ZONE Repair & Buy. All rights reserved.</p>
    </footer>
</body>

</html>