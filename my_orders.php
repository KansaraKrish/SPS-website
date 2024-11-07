<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="js/scripts.js"></script>
</head>
<body>
    <header>
        <nav class="navbar">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="product.php">Customize</a></li>
            </ul>

            <!-- Login Button or Username Placeholder -->
            <div class="login-area" style="position: absolute; right: 20px; top: 30px; font-size: 18px;">
                <?php
                session_start();
                if (isset($_SESSION['user_name'])): ?>
                    <span>Welcome, <?= $_SESSION['user_name'] ?></span>
                <?php else: ?>
                    <a href="login.php" class="login-btn" style="background-color: #008080; color: white; padding: 10px 15px; border-radius: 5px; text-decoration: none; transition: background-color 0.3s ease;">Login</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>

    <section>
        <h1>My Orders</h1>

        <?php
            // Include database connection
            require 'db.php'; // Ensure this points to your actual database connection file

            // Check if the user is logged in
            if (isset($_SESSION['user_name'])) {
                $user_name = $_SESSION['user_name'];

                // Fetch orders from the database where user_name matches the session user
                $sql = "SELECT * FROM user_hardware WHERE user_name = ?";
                if ($stmt = $conn->prepare($sql)) {
                    // Bind the username parameter to the query
                    $stmt->bind_param("s", $user_name);
                    
                    // Execute the query
                    $stmt->execute();
                    
                    // Get the result
                    $result = $stmt->get_result();
                    
                    // Check if any orders were found
                    if ($result->num_rows > 0) {
                        // Loop through the orders and display them
                        while ($order = $result->fetch_assoc()) {
                            echo '
                            <div class="order">
                                <h2>Order #' . $order['id'] . '</h2>
                                <p>CPU: ' . $order['cpu_brand'] . ' ' . $order['cpu_category'] . ' ' . $order['cpu_model'] . '<br>
                                GPU: ' . $order['gpu_brand'] . ' ' . $order['gpu_category'] . ' ' . $order['gpu_model'] . '<br>
                                RAM: ' . $order['ram_brand'] . ' ' . $order['ram_category'] . ' ' . $order['ram_model'] . '<br>
                                Storage: ' . $order['primary_storage_brand'] . ' ' . $order['primary_storage_category'] . ' ' . $order['primary_storage_model'] . ' / ' . $order['secondary_storage_brand'] . ' ' . $order['secondary_storage_category'] . ' ' . $order['secondary_storage_model'] . '<br>
                                Total Price: $' . $order['price'] . '</p>
                                <img src="images/' . $order['image'] . '" alt="Order Image" style="max-width: 300px; margin-top: 20px;">
                            </div>';
                        }
                    } else {
                        // If no orders found
                        echo '<p>My Orders is empty. <a href="product.php">Go to Customize</a></p>';
                    }

                    // Close the statement
                    $stmt->close();
                } else {
                    echo "Error fetching orders: " . $conn->error;
                }

                // Close the connection
                $conn->close();
            } else {
                echo '<p>Please log in to view your orders.</p>';
            }
        ?>

    </section>

    <footer>
        <p>&copy; 2024 Custom Desktop Builder. All rights reserved.</p>
    </footer>

</body>
</html>
