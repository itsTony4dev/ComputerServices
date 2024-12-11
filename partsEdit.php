<!DOCTYPE html>
<html lang="en">

<?php
require_once "connection.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT products.*, category.name as cat_name 
            FROM products 
            JOIN category ON products.category_id = category.id 
            WHERE products.id = ?";
    $stmt = $conn->prepare(query: $sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/build.css">
    <title>Edit product</title>
</head>

<body style="background-image: url('pictures/home.webp'); ">
    <div class="overlay" ></div>
    <div class="container" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 100%; z-index: 100;">
        <h2 style=" text-align: center;margin: 40px; color:red; font-size:30px; font-weight: 900">Edit Part</h2>
        <form action="update.php" class="upload-form" method="POST" enctype="multipart/form-data">

            <input type="hidden" name="id" value="<?= $product['id'] ?>">
            <label for="image">Edit image</label>
            <input type="file" id="image" name="image">
            <input type="hidden" name="old_image" value="<?= $product['image'] ?>">

            <label for="name">Name</label>
            <input type="text" id="name" rows="4" value="<?= $product['name'] ?>" name="name" required></input>

            <label for="category">Category</label>
            <select name="category" id="category">
                <option value="<?= $product['category_id'] ?>"><?= $product['cat_name'] ?></option>
                <?php
                $sql = "SELECT * FROM category WHERE id != $product[category_id]";
                $result = $conn->query(query: $sql);
                while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                }
                ?>
            </select>

            <label for="stock_quantity">Quantity</label>
            <input type="number" id="stock_quantity" value="<?= $product['stock_quantity'] ?>" name="stock_quantity" required>

            <label for="price">Price</label>
            <input type="number" id="price" value="<?= $product['price'] ?>" name="price" required>

            <button type="submit" name="edit" class="btn">EDIT</button>
            <button class="btn" style=" background-color:#333">
                <a href="adminBuild.php" style="text-decoration: none; color: white; width: 100%; height: 100%; display: block;">Back</a>
            </button>

        </form>
    </div>

</body>
<style>
    .upload-form button a:last-child:hover {
        background-color: #333;
    }

    .overlay {
        background-color: white;
        z-index: 1;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0.85;
    }
</style>

</html>