<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="buy.css" />
    <link rel="icon" href="pictures/loginlogo.png">
    <title>Computer Services</title>
</head>

<body>
    <header>
        <nav>
            <div class="logo">
                <a href="index.php"><img src="pictures/Logo.png" alt=""></a>
                <a href="index.php">CT ZONE</a>
            </div>
            <div class="nav-links">
                <ul>
                    <li><a href="home.php">Home</a></li>
                    <li><a href="index.php#buy-Build">Buy </a></li>
                    <li><a href="index.php#contact">Repair</a></li>
                    <li><a href="login.php">Login</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <main>
        <section class="hero">
            <h1>Buy Pre-built PCs</h1>
            <p>
                Find the perfect pre-built PC for your needs at an affordable price.
            </p>
        </section>

        <section class="pc-listings">
            <h2>Available PCs</h2>

            <table border="1" width="50%">
                <th>IMAGE</th>
                <th>SPECS</th>
                <th>PRICE</th>

                <?php
                $conn = mysqli_connect(hostname: "localhost", username: "root", password: "", database: "computerservices");
                $res = mysqli_query(mysql: $conn, query: "SELECT * FROM available_pc");

                while ($row = mysqli_fetch_array(result: $res)) {
                    echo "<tr>";
                    echo "<td ><img src=AvailablePCs\\" . $row["image"] . "></td>";
                    echo "<td>";
                    $sentences = explode(separator: "\n", string: $row["specs"]);

                    foreach ($sentences as $sentence) {
                        $sentence = trim(string: $sentence);
                        echo "<li>" . $sentence . "</li>";
                    }
                    echo "</td>";
                    echo "<td> <p>$" . $row["price"] . "</p><button class=btn>Add to cart</button></td>";
                    echo "</tr>";
                }
                ?>
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