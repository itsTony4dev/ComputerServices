<?php
session_start();
require_once 'connection.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    

    if (
        !isset($data['fullName']) || !isset($data['address']) || 
        !isset($data['city']) || !isset($data['state']) || 
        !isset($data['phone']) || !isset($data['email']) ||
        empty($data['fullName']) || empty($data['address']) || 
        empty($data['city']) || empty($data['state']) || 
        empty($data['phone']) || empty($data['email'])
    ) {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid data'
        ]);
        exit;
    }

    if (!isset($_SESSION['user_id'])) {
        echo json_encode([
            'success' => false,
            'message' => 'User not logged in'
        ]);
        exit;
    }

    $full_name = $data['fullName'];
    $address = $data['address'];
    $city = $data['city'];
    $state = $data['state'];
    $phone = $data['phone'];
    $email = $data['email'];
    $payment_method = $data['paymentMethod'];
    $order_id = $data['orderId'];

    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO `customer_details` 
        (`email`, `phone`, `full_name`, `address`, `city`, `state`, `payment_method`, `order_id`) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        
    $stmt->bind_param('sssssssi', $email, $phone, $full_name, $address, $city, $state, $payment_method, $order_id);
    
    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'message' => 'Customer details saved successfully'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to save customer details'
        ]);
    }
    $stmt->close();
}
?>