<?php
session_start();
require_once 'connection.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $order_id = $data['orderId'];
    $user_id = $_SESSION['user_id'];

    // Use the same SELECT query from cart.php
    $stmt = "SELECT `cart`.*, `products`.`name`, `products`.`price` FROM `cart` 
             JOIN `products` ON `cart`.`product_id` = `products`.`id` 
             WHERE `user_id` = $user_id";

    $result = $conn->query($stmt);

    if ($result) {
        $success = true;

        // Prepare the insert statement for order items
        $insert_stmt = $conn->prepare("INSERT INTO `orders_items`( `order_id`, `product_id`, `quantity`, `price`)
                                             VALUES (?,?,?,?)");

        while ($row = $result->fetch_assoc()) {
            $product_id = $row['product_id'];
            $quantity = $row['quantity'];
            $price = $row['price'];

            $insert_stmt->bind_param('iiid', $order_id, $product_id, $quantity, $price);

            if (!$insert_stmt->execute()) {
                $success = false;
                break;
            }
        }

        if ($success) {
            // Clear the cart after successful order
            $delete_stmt = $conn->prepare("DELETE FROM `cart` WHERE `user_id` = ?");
            $delete_stmt->bind_param('i', $user_id);
            $delete_stmt->execute();

            echo json_encode([
                'success' => true,
                'message' => 'Order items saved successfully'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Failed to save order items'
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to fetch cart items'
        ]);
    }
}
