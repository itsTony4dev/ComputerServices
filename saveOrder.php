<?php
session_start();
require_once 'connection.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (!isset($data['total_price']) && $data['total_price'] === 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid data'
        ]);
        exit;
    }

    $total_price = $data['total_price'];

    if (!isset($_SESSION['user_id'])) {
        echo json_encode([
            'success' => false,
            'message' => 'User not logged in'
        ]);
        exit;
    }

    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO `orders`(`user_id`, `total_price`, `created_at`) VALUES (?, ?, NOW())");
    $stmt->bind_param('id', $user_id, $total_price);
    if ($stmt->execute()) {
        $order_id = $conn->insert_id;
        echo json_encode([
            'success' => true,
            'message' => 'Order saved successfully',
            'order_id' => $order_id
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to save order'
        ]);
    }
    $stmt->close();
}
