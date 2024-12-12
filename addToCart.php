<?php
session_start();
require_once 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addToCart'])) {
    $component_id = $_POST['component_id'];
    $user_id = $_SESSION['user_id'];

    $stmt = "INSERT INTO `cart`(`user_id`, `product_id`, `quantity`, `added_at`) VALUES (?,?,'1',NOW())";
    $stmt = $conn->prepare($stmt);
    $stmt->bind_param('ii', $user_id, $component_id);
    if ($stmt->execute()) {
        header("location: " . $_GET['page'] . ".php");
    } else {
        echo "Error: " . $stmt->error;
    }
}
