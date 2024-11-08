<?php
// update_order_status.php

// Database connection
require 'db.php';

// Get input data from AJAX request
$data = json_decode(file_get_contents("php://input"), true);
$order_id = $data['order_id'];
$status = $data['status'];

// Sanitize input
$order_id = intval($order_id);
$status = htmlspecialchars($status, ENT_QUOTES, 'UTF-8');

// Update the status in the database
$query = "UPDATE orders SET status = ? WHERE order_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("si", $status, $order_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
