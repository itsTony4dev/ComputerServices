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
    <script src="https://kit.fontawesome.com/9d214354b3.js" crossorigin="anonymous"></script>

<body>
    <script src="js/cart.js"></script>
    <header>
        <nav>
            <div class="logo">
                <a href="home.php"><i class="fas fa-microchip"></i></a>
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
                                <button class="quantity-btn minus" data-cart-id="<?= $row['id']; ?>">-</button>
                                <span class="quantity" id="qtty-<?= $row['id']; ?>"> <?= $row['quantity']; ?> </span>
                                <button class="quantity-btn plus" data-cart-id="<?= $row['id']; ?>">+</button>
                            </div>
                        </div>
                        <button class="remove-btn"><a href="removeFromCart.php?id=<?= $row['id']; ?>" style="text-decoration: none; color:black;">Remove</a></button>
                    </div>
                <?php $total += $row['price'] * $row['quantity'];
                } ?>
            </div>
        </div>
        <div class="cart-summary">
            <h2 id="total-price">Total: $<?= $total; ?></h2>
            <button class="checkout-btn" id="checkoutBtn">Proceed to Checkout</button>
        </div>
    </div>
    <div id="checkoutModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div class="checkout-steps">
                <!-- Step indicators -->
                <div class="steps-indicator">
                    <div class="step active" data-step="1">
                        <i class="fas fa-user"></i>
                        <span>Contact</span>
                    </div>
                    <div class="step" data-step="2">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Address</span>
                    </div>
                    <div class="step" data-step="3">
                        <i class="fas fa-credit-card"></i>
                        <span>Payment</span>
                    </div>
                </div>

                <!-- Step 1: Contact Information -->
                <div class="step-content active" id="step1">
                    <h2>Contact Information</h2>
                    <div class="form-group">
                        <input type="text" id="phone" placeholder="Phone Number" required>
                        <input type="email" id="email" placeholder="Email" required>
                    </div>
                    <button class="next-btn" data-next="2">Next <i class="fas fa-arrow-right"></i></button>
                </div>

                <!-- Step 2: Shipping Address -->
                <div class="step-content" id="step2">
                    <h2>Shipping Address</h2>
                    <div class="form-group">
                        <input type="text" id="fullName" placeholder="Full Name" required>
                        <input type="text" id="address" placeholder="Street Address" required>
                        <div class="address-grid">
                            <input type="text" id="city" placeholder="City" required>
                            <input type="text" id="state" placeholder="State" required>
                        </div>
                    </div>
                    <div class="buttons-group">
                        <button class="back-btn" data-back="1"><i class="fas fa-arrow-left"></i> Back</button>
                        <button class="next-btn" data-next="3">Next <i class="fas fa-arrow-right"></i></button>
                    </div>
                </div>

                <!-- Step 3: Payment Method -->
                <div class="step-content" id="step3">
                    <h2>Payment Method</h2>
                    <div class="payment-options">
                        <label class="payment-option">
                            <input type="radio" name="payment" value="cash" checked>
                            <span class="option-content">
                                <i class="fas fa-money-bill-wave"></i>
                                <span>Cash on Delivery</span>
                            </span>
                        </label>
                    </div>
                    <div class="buttons-group">
                        <button class="back-btn" data-back="2"><i class="fas fa-arrow-left"></i> Back</button>
                        <button class="confirm-btn" id="confirmOrder">Confirm Order</button>
                    </div>
                </div>

                <div class="step-content" id="success">
                    <div class="success-message">
                        <i class="fas fa-check-circle"></i>
                        <h1>Thanks for shopping with us!</h1>
                        <p>Your order will be delivered to your address within 3 days max. <span>&#128666;</span></p>
                        <a href="home.php" class="proceed-btn">Back To Site</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<footer>
    <p>&copy; 2024 CT ZONE Repair & Buy. All rights reserved.</p>
</footer>

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

    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 500px;
        border-radius: 10px;
        text-align: center;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    .proceed-btn {
        display: inline-block;
        padding: 10px 20px;
        background-color: #c70000;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        margin: 20px 0;
    }

    .proceed-btn:hover {
        background-color: #c70000;
    }

    .checkout-info {
        color: #666;
        margin-top: 10px;
    }

    .checkout-steps {
        width: 100%;
        max-width: 600px;
        margin: 0 auto;
    }

    .steps-indicator {
        display: flex;
        justify-content: space-between;
        margin-bottom: 30px;
        position: relative;
    }

    .steps-indicator::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 2px;
        background: #ddd;
        z-index: 1;
    }

    .step {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        z-index: 2;
        background: white;
        padding: 0 15px;
    }

    .step i {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #ddd;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 5px;
    }

    .step.active i {
        background: #c70000;
    }

    .step-content {
        display: none;
        padding: 20px;
    }

    .step-content.active {
        display: block;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 15px;
        margin-bottom: 20px;
    }

    .form-group input {
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 16px;
        margin-top: 20px;
    }

    .address-grid {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 10px;
    }

    .buttons-group {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
    }

    .next-btn,
    .back-btn,
    .confirm-btn {
        padding: 12px 24px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-weight: bold;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .next-btn,
    .confirm-btn {
        background: #c70000;
        color: white;
    }

    .back-btn {
        background: #f5f5f5;
        color: #333;
    }

    .payment-options {
        display: flex;
        flex-direction: column;
        gap: 15px;
        margin-top: 20px;
    }

    .payment-option {
        display: flex;
        align-items: center;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        cursor: pointer;
    }

    .payment-option input {
        margin-right: 15px;
    }

    .option-content {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .success-message {
        text-align: center;
        padding: 30px;
    }

    .success-message i {
        font-size: 60px;
        color: #c70000;
        margin-bottom: 20px;
    }
</style>
<script>
    var modal = document.getElementById("checkoutModal");

    var btn = document.getElementById("checkoutBtn");

    var span = document.getElementsByClassName("close")[0];

    btn.onclick = function() {
        modal.style.display = "block";
    }

    span.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    document.addEventListener('DOMContentLoaded', async function() {
        const steps = document.querySelectorAll('.step');
        const contents = document.querySelectorAll('.step-content');
        const nextBtns = document.querySelectorAll('.next-btn');
        const backBtns = document.querySelectorAll('.back-btn');
        const confirmBtn = document.getElementById('confirmOrder');


        nextBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const nextStep = btn.dataset.next;
                showStep(nextStep);
            });
        });


        backBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const prevStep = btn.dataset.back;
                showStep(prevStep);
            });
        });


        confirmBtn.addEventListener('click', async () => {
            try {

                const priceData = {
                    total_price: <?= $total ?>
                };

                const orderResponse = await fetch('save_order.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(priceData)
                });

                const orderResult = await orderResponse.json();

                if (!orderResult.success) {
                    throw new Error(orderResult.message);
                }



                const orderId = orderResult.order_id;


                const orderData = {
                    phone: document.getElementById('phone').value,
                    email: document.getElementById('email').value,
                    fullName: document.getElementById('fullName').value,
                    address: document.getElementById('address').value,
                    city: document.getElementById('city').value,
                    state: document.getElementById('state').value,
                    paymentMethod: document.querySelector('input[name="payment"]:checked').value,
                    orderId
                };


                const customerResponse = await fetch('save_customer_details.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(orderData)
                });

                const customerResult = await customerResponse.json();
                alert(customerResult.message);


                const orderItemResponse = await fetch('save_order_items.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        orderId: orderId
                    })
                });

                if (!orderItemResponse.ok) {
                    throw new Error(`HTTP error! status: ${orderItemResponse.status}`);
                }

                const orderItemResult = await orderItemResponse.json();
                console.log('Order items result:', orderItemResult)

                if (orderItemResult.success) {

                    document.getElementById('success').classList.add('active');
                    document.querySelectorAll('.step-content:not(#success)').forEach(el => {
                        el.classList.remove('active');
                    });
                } else {
                    throw new Error(orderItemResult.message);
                }

            } catch (error) {
                alert('Error: ' + error.message);
            }
        });

        function showStep(stepNumber) {
            steps.forEach(step => {
                step.classList.remove('active');
                if (step.dataset.step <= stepNumber) {
                    step.classList.add('active');
                }
            });

            contents.forEach(content => {
                content.classList.remove('active');
            });

            const currentContent = document.getElementById(`step${stepNumber}`);
            if (currentContent) {
                currentContent.classList.add('active');
            }
        }

    });
</script>