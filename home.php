<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/styles.css" />
    <link rel="icon" href="pictures/loginlogo.png">
    <script src="https://kit.fontawesome.com/9d214354b3.js" crossorigin="anonymous"></script>
    <title>Computer Services</title>
</head>

<body>
    <header>
        <nav>
            <div class="logo">
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
    <main>
        <section class="hero">
            <h1>Expert PC Repair & Buy Services</h1>
            <p>Get your PC fixed or buy your favourite specs.</p>
        </section>

        <section class="services" id="repair">
            <h2>PC Services</h2>
            <div class="service-cards">
                <div class="service-card">
                    <img src="pictures/home.webp" alt="Hardware Repair" style="width: 300px; height: 168px" />
                    <h3>Hardware Repair</h3>
                    <p>Our technicians can fix any hardware issues with your PC.</p>
                </div>
                <div class="service-card">
                    <img src="pictures/gpu.webp" alt="Software Repair" style="width: 300px; height: 168px" />
                    <h3>Software Repair</h3>
                    <p>
                        We can resolve software-related problems and optimize your system.
                    </p>
                </div>
                <div class="service-card">
                    <img src="pictures/buildOrBuy.webp" alt="Data Recovery" style="width: 300px; height: 168px" />
                    <h3>PC & PC Parts</h3>
                    <p>Buy a pre-built pc or get your brand new parts with the best prices.</p>
                </div>
            </div>
        </section>

        <section class="buy-Build" id="buy-Build">
            <h2>Pre-built and Parts</h2>
            <div class="buy-Build-cards">
                <div class="buy-Build-card">
                    <img src="pictures/R.jpeg" alt="Buy PC" style="width: 300px; height: 168px" />
                    <h3>Pre-built PC</h3>
                    <p>Browse our selection of pre-built PCs at affordable prices.</p>
                    <button class="btn"><a href="buy.php">Browse PCs</a></button>
                </div>
                <div class="buy-Build-card">
                    <img src="pictures/Build.jpeg" alt="Build PC" />
                    <h3>Available Parts</h3>
                    <p>Build your PC or get your parts at the best prices.</p>
                    <button class="btn"><a href="build.php">Browse Parts</a></button>
                </div>
            </div>
        </section>
        <section class="contact" id="contact">
            <h2>Get in Touch</h2>
            <form method="POST" action=home.php class="upload-form">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" autocomplete="off" required />
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" autocomplete="off" required />
                </div>
                <div class="form-group">
                    <label for="message">Message:</label>
                    <textarea id="message" name="message" required></textarea>
                </div>
                <button type="submit" class="btn">Submit</button>
            </form>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 CT ZONE Repair & Buy. All rights reserved.</p>
    </footer>
</body>

<script>
    const show = () => {
        if (document.getElementById('dropdown-menu').style.display != "block") {

            document.getElementById('dropdown-menu').style.display = "block";
        } else {
            return document.getElementById('dropdown-menu').style.display = "none";
        }
    }
</script>

</html>