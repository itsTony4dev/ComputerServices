<?php
require_once 'connection.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $cart_id = $data['cart_id'];
    $action = $data['action'];

    if (!isset($cart_id) || !isset($action)) {
        echo json_encode(['success' => false, 'message' => 'Invalid data']);
        exit;
    }

    $quantityUpdate = $action === 'increase' ? 'quantity = quantity + 1' : 'quantity = quantity - 1';
    $stmt = $conn->prepare("UPDATE `cart` SET $quantityUpdate WHERE `id` = ? AND `quantity` > 0");
    $stmt->bind_param('i', $cart_id);



    if ($stmt->execute()) {
        $result = $conn->query("SELECT `quantity` FROM `cart` WHERE `id` = $cart_id");
        $row = $result->fetch_assoc();
        echo json_encode(['success' => true, 'new_quantity' => $row['quantity']]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update quantity']);
    }
    $stmt->close();
}
    