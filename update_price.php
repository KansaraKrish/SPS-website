<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if order_id and new_price are set and valid
    if (isset($_POST['order_id'], $_POST['new_price']) && is_numeric($_POST['new_price'])) {
        $orderId = (int)$_POST['order_id'];
        $newPrice = (float)$_POST['new_price'];

        // Update the price in the orders table
        $updateOrderQuery = "UPDATE orders SET total_price = ? WHERE order_id = ?";
        $stmt1 = $conn->prepare($updateOrderQuery);
        
        if ($stmt1) {
            $stmt1->bind_param("di", $newPrice, $orderId);
            $stmt1->execute();

            // Check if the orders table was successfully updated
            if ($stmt1->affected_rows > 0) {
                // Update the price in the user_hardware table
                $updateHardwareQuery = "UPDATE user_hardware SET price = ? WHERE id = ?";
                $stmt2 = $conn->prepare($updateHardwareQuery);
                
                if ($stmt2) {
                    $stmt2->bind_param("di", $newPrice, $orderId);
                    $stmt2->execute();

                    // Check if the user_hardware table was successfully updated
                    if ($stmt2->affected_rows > 0) {
                        echo "Price updated successfully in both tables.";
                    } else {
                        echo "Failed to update price in user_hardware table.";
                    }

                    $stmt2->close();
                } else {
                    echo "Error preparing query for user_hardware: " . $conn->error;
                }
            } else {
                echo "Failed to update price in orders table.";
            }

            $stmt1->close();
        } else {
            echo "Error preparing query for orders: " . $conn->error;
        }
    } else {
        echo "Invalid order ID or price.";
    }
} else {
    echo "Invalid request method.";
}

$conn->close();
?>
