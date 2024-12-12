<?php
session_start();
$total = 0;
?>

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
            <?php
            require_once 'connection.php';
            $user_id = $_SESSION['user_id'];
            $stmt = "SELECT `cart`.*, `products`.`name`, `products`.`category_id`, `products`.`price`, `products`.`image` FROM `cart` 
                     JOIN `products` ON `cart`.`product_id` = `products`.`id` WHERE `user_id` = $user_id";
            $result = $conn->query($stmt);
            while ($row = $result->fetch_assoc()) { ?>
                <div class="cart-card" style="position: relative; min-height: 380px;">
                    <div class="product-info">
                        <h2 class="product-name"><?= trim($row['name']) == '' ? 'Gaming Pc' : $row['name']; ?></h2>
                        <img src="uploads/<?= $row['image']; ?>" alt="">
                        <p class="product-price">$<?= $row['price']; ?></p>
                        <div class="quantity-controls">
                            <button class="quantity-btn minus">-</button>
                            <span class="quantity" id="qtty"> <?= $row['quantity']; ?> </span>
                            <button class="quantity-btn plus">+</button>
                        </div>
                    </div>
                    <button class="remove-btn"><a href="removeFromCart.php?id=<?= $row['id']; ?>" style="text-decoration: none; color:black;">Remove</a></button>
                </div>
                <?php $total += $row['price'] * $row['quantity']; ?>
            <?php  } ?>
        </div>
    </div>
    <div class="cart-summary">
        <h2>Total: $<?= $total; ?></h2>
        <button class="checkout-btn">Proceed to Checkout</button>
    </div>
    </div>
    <footer>
        <p>&copy; 2024 CT ZONE Repair & Buy. All rights reserved.</p>
    </footer>
</body>

</html>
<style>
    .remove-btn {
        position: absolute;
        bottom: 10px;
        left: 50%;
        transform: translateX(-50%);
    }

    .quantity-controls {
        position: absolute;
        bottom: 55px;
        left: 50%;
        transform: translateX(-50%);
    }

    .product-price {
        position: absolute;
        bottom: 22%;
        left: 50%;
        transform: translateX(-50%);
    }

    .cart-card img {
        position: absolute;
        bottom: 50%;
        left: 50%;
        transform: translate(-50%, 50%);
    }

    .cart-summary h2 {
        font-size: 2.5em;
        color: #333;
        padding: 20px;
    }
</style>