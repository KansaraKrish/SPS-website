<?php
include 'db.php';

$sql = "SELECT * FROM orders";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    echo "Order ID: " . $row['order_id'] . " - Status: " . $row['status'];
    echo "<a href='mark_delivery.php?order_id=" . $row['order_id'] . "'>Mark as Delivered</a><br>";
}
?>
