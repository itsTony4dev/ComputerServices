<?php

require_once 'connection.php';

if (
    $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['upload'])
) {
    $name = $_POST['name'] ?? ' ';
    $stock_quantity = $_POST['stock_quantity'] ?? 0;
    $price = $_POST['price'] ?? 0.0;
    $category_id = $_POST['category'] ?? 0;
    $description = $_POST['description'] ?? '';

    $uploadDir = 'uploads/';
    $fileName = basename($_FILES['image']['name']);
    $fileName = $conn->real_escape_string($fileName);
    $fileTmpPath = $_FILES['image']['tmp_name'];
    $uploadFilePath = $uploadDir . $fileName;

    if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        echo "File upload error.";
        exit();
    }

    if (!is_dir($uploadDir)) {
        if (!mkdir($uploadDir, 0755, true)) {
            echo "Failed to create upload directory.";
            exit();
        }
    }

    if (!move_uploaded_file($fileTmpPath, $uploadFilePath)) {
        echo "Failed to move uploaded file.";
        exit();
    }

    if ($category_id != 1) {
        $stmt = $conn->prepare("INSERT INTO `products` (`name`, `category_id`, `description`, `price`, `stock_quantity`, `image`) VALUES (?, ?, '', ?, ?, ?)");
        $stmt->bind_param("siiis", $name, $category_id, $price, $stock_quantity, $fileName);
    } else {
        $stmt = $conn->prepare("INSERT INTO `products` (`name`, `category_id`, `description`, `price`, `stock_quantity`, `image`) VALUES ('', 1, ?, ?, 0, ?)");
        $stmt->bind_param("sis", $description, $price, $fileName);
    }


    if ($stmt->execute()) {
        if ($category_id != 1) {
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
