<?php
session_start();
require_once 'connection.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['component_id'])) {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid data'
        ]);
        exit();
    }

    if (!isset($_SESSION['user_id'])) {
        echo json_encode([
            'success' => false,
            'message' => 'User not logged in'
        ]);
        exit();
    }

    $component_id = $data['component_id'];
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("SELECT * FROM `cart` WHERE `user_id` = ? AND `product_id` = ?");
    $stmt->bind_param('ii', $user_id, $component_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        $stmt = $conn->prepare("UPDATE `cart` SET `quantity` = `quantity` + 1 WHERE `user_id` = ? AND `product_id` = ?");
        $stmt->bind_param('ii', $user_id, $component_id);
        if ($stmt->execute()) {
            echo json_encode([
                'success' => true,
                'message' => 'Quantity updated'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Failed to update quantity'
            ]);
        }
    } else {

        $stmt = $conn->prepare("INSERT INTO `cart`(`user_id`, `product_id`, `quantity`, `added_at`) VALUES (?, ?, 1, NOW())");
        $stmt->bind_param('ii', $user_id, $component_id);
        if ($stmt->execute()) {
            echo json_encode([
                'success' => true,
                'message' => 'Item added to cart'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Failed to add item to cart'
            ]);
        }
    }
    $stmt->close();
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method'
    ]);
}

