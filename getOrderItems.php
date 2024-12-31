<?php
session_start();
require_once 'connection.php';

$order_id = $_GET['order_id'];
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT oi.*, p.name, p.image, p.price 
                       FROM orders_items oi
                       JOIN products p ON oi.product_id = p.id
                       WHERE oi.order_id = ? AND EXISTS (
                           SELECT 1 FROM orders 
                           WHERE id = ? AND user_id = ?
                       )");
$stmt->bind_param("iii", $order_id, $order_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

$items = [];
while($row = $result->fetch_assoc()) {
    $items[] = $row;
}

echo json_encode(['items' => $items]);