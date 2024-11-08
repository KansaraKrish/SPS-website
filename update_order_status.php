<?php
// update_order_status.php

// Database connection
require 'db.php';

// Get input data from AJAX request
$data = json_decode(file_get_contents("php://input"), true);
$order_id = $data['order_id'];
$status = $data['status'];
$new_price = $data['new_price'];

// Sanitize inputs
$order_id = intval($order_id);
$status = htmlspecialchars($status, ENT_QUOTES, 'UTF-8');
$new_price = floatval($new_price);

$response = ['success' => false];

// Update the status and price in the orders table
$query = "UPDATE orders SET status = ?, total_price = ? WHERE order_id = ?";
$stmt1 = $conn->prepare($query);

if ($stmt1) {
    $stmt1->bind_param("sdi", $status, $new_price, $order_id);
    $stmt1->execute();

    if ($stmt1->affected_rows > 0) {
        // Update the price in the user_hardware table
        $updateHardwareQuery = "UPDATE user_hardware SET price = ? WHERE id = ?";
        $stmt2 = $conn->prepare($updateHardwareQuery);

        if ($stmt2) {
            $stmt2->bind_param("di", $new_price, $order_id);
            $stmt2->execute();

            if ($stmt2->affected_rows > 0) {
                $response['success'] = true;
            } else {
                $response['error'] = "Failed to update price in user_hardware table.";
            }

            $stmt2->close();
        } else {
            $response['error'] = "Error preparing query for user_hardware: " . $conn->error;
        }
    } else {
        $response['error'] = "Failed to update orders table.";
    }

    $stmt1->close();
} else {
    $response['error'] = "Error preparing query for orders: " . $conn->error;
}

echo json_encode($response);

$conn->close();
?>
