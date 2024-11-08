<?php
// admin_orders.php

// Database connection settings
require 'db.php';

// Fetch all orders and related user info
$query = "
    SELECT orders.order_id, users.name AS user_name, users.email, orders.build_summary, 
           orders.total_price, orders.status
    FROM orders
    JOIN users ON orders.user_id = users.id
    ORDER BY orders.order_id DESC
";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
$orders = $result->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Orders Panel</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        table, th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
        .status-pending { color: orange; }
        .status-confirmed { color: green; }
        .status-delivered { color: blue; }
    </style>
</head>
<body>

<h1>All Orders</h1>

<table>
    <thead>
        <tr>
            <th>Order ID</th>
            <th>User Name</th>
            <th>Email</th>
            <th>Build Summary</th>
            <th>Total Price ($)</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($orders as $order): ?>
    <tr>
        <td><?php echo htmlspecialchars($order['order_id']); ?></td>
        <td><?php echo htmlspecialchars($order['user_name']); ?></td>
        <td><?php echo htmlspecialchars($order['email']); ?></td>
        <td><?php echo htmlspecialchars($order['build_summary']); ?></td>
        <td><?php echo htmlspecialchars($order['total_price']); ?></td>
        <td>
            <select class="status-dropdown" data-order-id="<?php echo $order['order_id']; ?>">
                <option value="approve" <?php echo $order['status'] === 'approve' ? 'selected' : ''; ?>>Approve</option>
                <option value="under_process" <?php echo $order['status'] === 'under_process' ? 'selected' : ''; ?>>Under Process</option>
                <option value="ready_to_deliver" <?php echo $order['status'] === 'ready_to_deliver' ? 'selected' : ''; ?>>Ready to Deliver</option>
            </select>
            <button class="update-btn" data-order-id="<?php echo $order['order_id']; ?>">Update</button>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<script>
document.querySelectorAll('.update-btn').forEach(button => {
    button.addEventListener('click', () => {
        const orderId = button.getAttribute('data-order-id');
        const status = document.querySelector(`.status-dropdown[data-order-id='${orderId}']`).value;

        fetch('update_order_status.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ order_id: orderId, status: status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Order status updated successfully.');
            } else {
                alert('Error updating order status: ' + (data.error || 'Unknown error.'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error updating order status.');
        });
    });
});
</script>

</body>
</html>
