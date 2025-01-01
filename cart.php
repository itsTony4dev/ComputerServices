<?php
session_start();
$total = 0;
$hasItems = false;
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
                if ($result && $result->num_rows > 0) {
                    $hasItems = true;
                }

                if (!$hasItems) {
                    echo '<p class="cart-empty">Your cart is empty.</p>';
                }

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
            <button class="checkout-btn" id="checkoutBtn" <?= !$hasItems ? 'disabled' : '' ?>>
                Proceed to Checkout
            </button>
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
                        <input type="text" id="phone" placeholder="Phone Number" required autocomplete="off">
                        <input type="email" id="email" placeholder="Email" required>
                    </div>
                    <button class="next-btn" data-next="2">Next <i class="fas fa-arrow-right"></i></button>
                </div>

                <!-- Step 2: Shipping Address -->
                <div class="step-content" id="step2">
                    <h2>Shipping Address</h2>
                    <div class="form-group">
                        <input type="text" id="fullName" placeholder="Full Name" required >
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
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Step 1 validation
        const step1Inputs = ['phone', 'email'];
        const step1Button = document.querySelector('#step1 .next-btn');

        step1Inputs.forEach(id => {
            document.getElementById(id).addEventListener('input', () => {
                step1Button.disabled = !step1Inputs.every(inputId =>
                    document.getElementById(inputId).value.trim() !== '');
            });
        });

        // Step 2 validation
        const step2Inputs = ['fullName', 'address', 'city', 'state'];
        const step2Button = document.querySelector('#step2 .next-btn');

        step2Inputs.forEach(id => {
            document.getElementById(id).addEventListener('input', () => {
                step2Button.disabled = !step2Inputs.every(inputId =>
                    document.getElementById(inputId).value.trim() !== '');
            });
        });

        // Initially disable buttons
        step1Button.disabled = true;
        step2Button.disabled = true;
    });


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

                const orderResponse = await fetch('saveOrder.php', {
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


                const customerResponse = await fetch('saveCustomerDetails.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(orderData)
                });

                const customerResult = await customerResponse.json();
                alert(customerResult.message);


                const orderItemResponse = await fetch('saveOrderItems.php', {
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