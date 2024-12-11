<?php

require_once 'connection.php';

if (
    $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit'])
) {


    $id = $_POST['id'];
    $name = $_POST['name'] || ' ';
    $description = $_POST['description'];
    $stock_quantity = $_POST['stock_quantity'] || 0;
    $price = $_POST['price'];
    $category_id = $_POST['category'] || 1;
    $fileName = $_POST['old_image'];

    if ($_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        $fileName = basename($_FILES['image']['name']);
        $fileName = $conn->real_escape_string($fileName);
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $uploadFilePath = $uploadDir . $fileName;

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
    }

    move_uploaded_file($fileTmpPath, $uploadFilePath);

    if ($_POST['cat_id'] != 1) {
        $stmt = $conn->prepare("UPDATE `products` SET `name`=?, `category_id`=?, `description`='', `price`=?, `stock_quantity`=?, `image`=? WHERE id=?");
        $stmt->bind_param("siiisi", $name, $category_id, $price, $stock_quantity, $fileName, $id);
    } else {
        $stmt = $conn->prepare("UPDATE `products` SET  `description`=?, `price`=?, `image`=? WHERE id=?");
        $stmt->bind_param("sisi", $description, $price, $fileName, $id);
    }

    if ($stmt->execute()) {
        if ($_POST['cat_id'] != 1) {
            header('Location: adminBuild.php');
        } else {
            header('Location: adminBuy.php');
        }
        exit();
    } else {
        echo "Error updating record: " . $stmt->error;
        exit();
    }
}
