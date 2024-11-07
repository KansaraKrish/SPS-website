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
            // Example code to fetch orders from the database
            // Assume user is logged in and username is stored in session
            if (isset($_SESSION['user_name'])) {
                $user_name = $_SESSION['user_name'];
                // Fetch orders based on username from your database
                // Example: $orders = fetchOrdersByUser($user_name);

                if (empty($orders)): // No orders found
                    echo '<p>My Orders is empty. <a href="product.php">Go to Customize</a></p>';
                else: // Orders are available
                    // Loop through orders and display each
                    foreach ($orders as $order) {
                        echo '
                        <div class="order">
                            <h2>Order #'.$order['id'].'</h2>
                            <p>CPU: '.$order['cpu'].'<br>
                            GPU: '.$order['gpu'].'<br>
                            RAM: '.$order['ram'].'<br>
                            Storage: '.$order['storage'].'<br>
                            Total Price: $'.$order['price'].'</p>
                            <img src="images/'.$order['image'].'" alt="Order Image" style="max-width: 300px; margin-top: 20px;">
                        </div>';
                    }
                endif;
            }
        ?>

    </section>

    <footer>
        <p>&copy; 2024 Custom Desktop Builder. All rights reserved.</p>
    </footer>

</body>
</html>
