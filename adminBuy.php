<?php
session_start();
if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true || $_SESSION['role'] !== 1) {
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/buy.css" />
    <link rel="icon" href="pictures/loginlogo.png">
    <script src="https://kit.fontawesome.com/9d214354b3.js" crossorigin="anonymous"></script>

    <title>CT ZONE</title>
</head>

<body>
    <header>
        <nav>
            <div class="logo">
                <a href="admin.php"><i class="fas fa-microchip"></i></a>
                <a href="admin.php">CT ZONE</a>
            </div>
            <div class="nav-links">
                <ul>
                    <li><a href="admin.php">Home</a></li>
                    <li><a href="admin.php#buy-Build">Buy </a></li>
                    <li><a href="admin.php#contact">Repair</a></li>
                    <?php session_start();
                    if ($_SESSION['is_logged_in']) {
                        echo '<li><a href="logout.php">Logout</a></li>';
                    } else {
                        echo '<li><a href="login.php">Login</a></li>';
                    } ?>
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

            <table width="50%">
                <th>IMAGE</th>
                <th>SPECS</th>
                <th>PRICE</th>
                <th>EDIT</th>
                <th>DELETE</th>
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
                    echo "<td> <p style='color: #800'>$" . $row["price"] . "</p></td>";
                    echo "<td><button id='dlt'><a href='pcEdit.php?id=" . $row["id"] . "'><i class='fa-regular fa-pen-to-square fa-2xl'></i></a></button></td>";
                    echo "<td><button id='dlt'><a href='delete.php?id=" . $row["id"] . "&cat_id=1'><i class='fa-regular fa-trash-can fa-2xl'></i></a></button></td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </section>
        <h2 style=" text-align: center;margin: 40px; color:red">Upload PC</h2>
        <form method="POST" enctype="multipart/form-data" class="upload-form" action="upload.php">
            <input type="hidden" name="category" value="1">
            <label>Choose an image</label><input name="image" type="file">
            <label for="">Specs</label><textarea name="description" rows="6"></textarea>
            <label for="">Price</label><input name="price" type="text" style="width:70px; padding:5px 10px">
            <button type="submit" name="upload" class="btn">UPLOAD</button>
        </form>
    </main>
    <footer>
        <p>&copy; 2024 CT ZONE Repair & Buy. All rights reserved.</p>
    </footer>
</body>
</html>