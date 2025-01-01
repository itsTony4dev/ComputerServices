<?php
session_start();
if($_SESSION['role'] === 1){
    header("Location: admin.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
robot ioname="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/buy.css" />
    <link rel="icon" href="pictures/loginlogo.png">
    <title>CT ZONE</title>
    <script src="js/addToCart.js"></script>
    <script src="https://kit.fontawesome.com/9d214354b3.js" crossorigin="anonymous"></script>
</head>

<body>
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
                    <?php 
                    if ($_SESSION['is_logged_in']) {
                        echo '<li class="dropdown">
                    <a href="#" onclick="show()">' . $_SESSION['name'] . '</a>
                    <ul class="dropdown-menu" id="dropdown-menu">
                        <li><a href="cart.php">Cart</a></li>
                        <li><a href="history.php?page=buy">History</a></li>
                        <li><a href="logout.php?page=buy">Logout</a></li>
                    </ul>
                </li>';
                    } else {
                        echo '<li><a href="login.php">Login</a></li>';
                    } ?>
                </ul>
            </div>

        </nav>
    </header>

    <main >
        <section class="hero">
            <h1>Buy Pre-built PCs</h1>
            <p>
                Find the perfect pre-built PC for your needs at an affordable price.
            </p>
        </section>

        <section class="pc-listings">
            <h2>Available PCs</h2>

            <table  width="50%">
                <th>IMAGE</th>
                <th>SPECS</th>
                <th>PRICE</th>

                <?php
                require_once "connection.php";
                $res = mysqli_query(mysql: $conn, query: "SELECT products.*, category.name as cat_name FROM products 
                                     JOIN category ON products.category_id = category.id WHERE category.id = 1;");

                while ($row = mysqli_fetch_array(result: $res)) {
                    echo "<tr style='border: 2px solid white;'>";
                    echo "<td ><img src=uploads\\" . $row["image"] . "></td>";
                    echo "<td>";
                    $sentences = explode(separator: "\n", string: $row["description"]);

                    foreach ($sentences as $sentence) {
                        $sentence = trim(string: $sentence);
                        echo "<li>" . $sentence . "</li>";
                    }
                    echo "</td>";
                    echo "<td> <p>$" . $row["price"] . "</p>
                    <button class='btn addToCartBtn' data-component-id='" . $row["id"] . "'>Add to cart</button>
                    </td>";
                    echo "</tr>";
                }
                ?>

                <script>
                    const show = () => {
                        if (document.getElementById('dropdown-menu').style.display != "block") {
                            document.getElementById('dropdown-menu').style.display = "block";
                        } else {
                            return document.getElementById('dropdown-menu').style.display = "none";
                        }
                    }
                </script>


            </table>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 CT ZONE Repair & Buy. All rights reserved.</p>
    </footer>
</body>
<style>
</style>

</html>