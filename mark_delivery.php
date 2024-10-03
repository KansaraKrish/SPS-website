<?php
include 'db.php';

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    $sql = "UPDATE orders SET status='delivered' WHERE order_id='$order_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Order marked as delivered!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
