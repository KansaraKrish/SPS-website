<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <link rel="stylesheet" href="css/my_orders.css">
    <script src="js/scripts.js"></script>
</head>
<body>
    <header>
        <nav class="navbar">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="product.php">Customize</a></li>
            </ul>
            <div class="login-area" style="position: absolute; right: 20px; top: 30px; font-size: 18px;">
                <?php
                session_start();
                if (isset($_SESSION['user_name'])): ?>
                    <span>Welcome, <?= htmlspecialchars($_SESSION['user_name']) ?></span>
                <?php else: ?>
                    <a href="login.php" class="login-btn" style="background-color: #008080; color: white; padding: 10px 15px; border-radius: 5px; text-decoration: none; transition: background-color 0.3s ease;">Login</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>

    <section class="orders-section">
        <h1>My Orders</h1>
        <?php
        require 'db.php';

        if (isset($_SESSION['user_name'])) {
            $user_name = $_SESSION['user_name'];

            // Updated SQL query with proper column aliasing
            $sql = "SELECT 
                        uh.id AS order_id,
                        CONCAT(cb.brand_name, ' ', cc.category_name, ' ', cm.model_name) AS cpu_details,
                        CONCAT(gb.brand_name, ' ', gc.category_name, ' ', gm.model_name) AS gpu_details,
                        CONCAT(rb.brand_name, ' ', rc.category_name, ' ', rm.model_name) AS ram_details,
                        CONCAT(psb.brand_name, ' ', psc.category_name, ' ', psm.model_name) AS primary_storage,
                        CONCAT(ssb.brand_name, ' ', ssc.category_name, ' ', ssm.model_name) AS secondary_storage,
                        uh.price AS build_price,
                        o.status AS order_status,
                        cb.brand_name AS cpu_brand,
                        gb.brand_name AS gpu_brand
                    FROM 
                        user_hardware uh
                    JOIN 
                        users u ON u.name = uh.user_name
                    LEFT JOIN 
                        cpu_brands cb ON cb.brand_id = uh.cpu_brand
                    LEFT JOIN 
                        cpu_categories cc ON cc.category_id = uh.cpu_category
                    LEFT JOIN 
                        cpu_models cm ON cm.model_id = uh.cpu_model
                    LEFT JOIN 
                        gpu_brands gb ON gb.brand_id = uh.gpu_brand
                    LEFT JOIN 
                        gpu_categories gc ON gc.category_id = uh.gpu_category
                    LEFT JOIN 
                        gpu_models gm ON gm.model_id = uh.gpu_model
                    LEFT JOIN 
                        ram_brands rb ON rb.brand_id = uh.ram_brand
                    LEFT JOIN 
                        ram_categories rc ON rc.category_id = uh.ram_category
                    LEFT JOIN 
                        ram_models rm ON rm.model_id = uh.ram_model
                    LEFT JOIN 
                        storage_brands psb ON psb.brand_id = uh.primary_storage_brand
                    LEFT JOIN 
                        storage_categories psc ON psc.category_id = uh.primary_storage_category
                    LEFT JOIN 
                        storage_models psm ON psm.model_id = uh.primary_storage_model
                    LEFT JOIN 
                        storage_brands ssb ON ssb.brand_id = uh.secondary_storage_brand
                    LEFT JOIN 
                        storage_categories ssc ON ssc.category_id = uh.secondary_storage_category
                    LEFT JOIN 
                        storage_models ssm ON ssm.model_id = uh.secondary_storage_model
                    LEFT JOIN 
                        orders o ON o.user_id = u.id AND o.order_id = uh.id
                    WHERE 
                        u.name = ?";

            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("s", $user_name);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while ($order = $result->fetch_assoc()) {
                        $image_name = 'default-build.jpeg';
                        // Set the image name based on CPU and GPU brand
                        if ($order['cpu_brand'] === 'AMD') {
                            $image_name = 'amd.jpg'; // Path for AMD image
                        } else if ($order['cpu_brand'] === 'Intel') {
                            $image_name = 'intel.jpg'; // Path for Intel image
                        } else if ($order['gpu_brand'] === 'NVIDIA') {
                            $image_name = 'nvidia.jpg'; // Path for NVIDIA GPU image (if needed)
                        }

                        echo '
                        <div class="order-card">
                            <div class="order-info">
                                <h2>Order #' . htmlspecialchars($order['order_id']) . '</h2>
                                <p><strong>CPU:</strong> ' . htmlspecialchars($order['cpu_details']) . '</p>
                                <p><strong>GPU:</strong> ' . htmlspecialchars($order['gpu_details']) . '</p>
                                <p><strong>RAM:</strong> ' . htmlspecialchars($order['ram_details']) . '</p>
                                <p><strong>Primary Storage:</strong> ' . htmlspecialchars($order['primary_storage']) . '</p>
                                <p><strong>Secondary Storage:</strong> ' . htmlspecialchars($order['secondary_storage']) . '</p>
                                <p><strong>Total Price:</strong> $' . htmlspecialchars($order['build_price']) . '</p>
                                <p><strong>Status:</strong> ' . htmlspecialchars($order['order_status']) . '</p>
                            </div>
                            <div class="order-image">
                                <img src="images/' . htmlspecialchars($image_name) . '" alt="Order Image" style="max-width: 300px; margin-top: 20px;">
                            </div>
                        </div>';
                    }
                } else {
                    echo '<p>My Orders is empty. <a href="product.php">Go to Customize</a></p>';
                }

                $stmt->close();
            } else {
                echo "Error fetching orders: " . $conn->error;
            }

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
