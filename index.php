<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Custom Desktop Builder</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="js/scripts.js"></script>
    <style>
        /* Homepage Banner Section */
.homepage-banner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background-color: #454545;
    /* padding: 60px 80px; */
    color: #ffffff;
    margin-top: 20px;
}
.banner-content {
    max-width: 50%;
}

.banner-content h1 {
    font-size: 3em;
    font-weight: bold;
    margin-bottom: 20px;
    color: white;
}

.banner-content p {
    font-size: 1.2em;
    margin-bottom: 30px;
    color: white;
    margin-left: 60px;
}

.customize-button {
    padding: 12px 25px;
    font-size: 1em;
    margin-left: 60px;
    font-weight: bold;
    background-color: #ff4b4b;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.customize-button:hover {
    background-color: #e63946;
}

.banner-image img {
    max-width: 500px;
    /* border-radius: 10px; */
    box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.2);
}

.logo {
    width: 120px;
    height: auto;
    margin-left: 35px;
}

.cart-icon {
    width: 30px;
    height: auto;
    margin-left: 1400px;
    cursor: pointer;
}

/* Container for all product cards */
.product-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 40px;
    padding: 20px;
}

/* Individual product card styling */
.product-card {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    max-width: 700px;
    display: flex;
    align-items: center;
    padding: 20px;
}

/* Styling for product details */
.product-details {
    flex: 1;
    padding-right: 20px;
}

.product-details h2 {
    font-size: 24px;
    color: #008080;
    margin-bottom: 10px;
}

.product-details p {
    font-size: 16px;
    color: #555;
    margin: 4px 0;
}

.btn {
    display: inline-block;
    background-color: #008080;
    color: #fff;
    padding: 10px 20px;
    border-radius: 5px;
    text-decoration: none;
    transition: background-color 0.3s ease;
    margin-top: 10px;
}

.btn:hover {
    background-color: #006666;
}

/* Styling for product images */
.product-image img {
    border-radius: 8px;
    max-width: 100%;
    height: auto;
}

    </style>
</head>
<body>
        <header>
            <nav class="navbar">

               <!-- Website Name as Text Logo -->
               <div class="logo">
               <a href="index.php"><img src="images/11.jpeg" alt="Build My Rig Logo" class="logo"></a>
            </div>
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="product.php">Customize</a></li>

                </ul>

                 <!-- Login Button or Username Placeholder -->
        <div class="login-area" style="position: absolute; right: 20px;top: 40px;font-size: 18px;">
            <?php
            session_start();
            if (isset($_SESSION['user_name'])): ?>
                <span>Welcome, <?= $_SESSION['user_name'] ?></span>
            <?php else: ?>
                <a href="login.php" class="login-btn" style="background-color: #008080; color: white;padding: 10px 15px; border-radius: 5px; text-decoration: none;
    transition: background-color 0.3s ease;">Login</a>
            <?php endif; ?>
        </div>

        <a href="my_orders.php"><img src="images/shopping-cart1.png" alt="Cart" class="cart-icon"></a>
            </nav>
        </header>  



        <main class="homepage-banner">
    <div class="banner-content">
        <h1>Build Your Custom Desktop</h1>
        <p>Create the ultimate PC setup tailored to your needs. Choose the components you want and see your dream build come to life.</p>
        <button class="customize-button">Customize Your PC</button>
    </div>
    <div class="banner-image">
        <img src="images/home pc.webp" alt="Custom Gaming PC">
    </div>
</main>

<!--     
        <section>
            <h1>Welcome To Our Website</h1>
            <h2>Build Your Custom Desktop</h2>
            <p>Choose from a range of components and build your dream machine.</p>
            
        </section> -->
        <!-- <table>
            <tr>
                <td>
                    CPU: Intel i9<br>
                    GPU: NVIDIA RTX 3080<br>
                    RAM: 16GB<br>
                    Storage: 2TB SSD<br>
                    <a href="product.php" class="btn">Add This</a>
                </td>
                <td>
                     <img style="margin-left: 800px; margin-top: 30px;"   src="images/intel.jpg" width="400px" height="300px"></img>
                </td>
            </tr>
        </table>
    <table>
        <tr>
            <td>
                CPU:AMD R9<br>
                GPU: NVIDIA RTX 3080<br>
                RAM: 16GB<br>
                Storage: 2TB SSD<br>
                <a href="product.html" class="btn">Add This</a> 
            </td>
            <td>
                <img style="margin-left: 800px; margin-top: 30px;"   src="images/amd.jpg" width="400px" height="300px"></img>
            </td>
        </tr>
    </table> -->


    <div class="product-container">
        <div class="product-card">
            <div class="product-details">
                <h2>Configuration 1</h2>
                <p>CPU: Intel i9</p>
                <p>GPU: NVIDIA RTX 3080</p>
                <p>RAM: 16GB</p>
                <p>Storage: 1TB SSD</p>
                <a href="product.php" class="btn">Add This</a>
            </div>
            <div class="product-image">
                <img src="images/intelfinal.webp" alt="Intel PC" width="400" height="300">
            </div>
        </div>

        <div class="product-card">
            <div class="product-details">
                <h2>Configuration 2</h2>
                <p>CPU: AMD R9</p>
                <p>GPU: NVIDIA RTX 3080</p>
                <p>RAM: 16GB</p>
                <p>Storage: 2TB SSD</p>
                <a href="product.php" class="btn">Add This</a>
            </div>
            <div class="product-image">
                <img src="images/amdfinal.jpeg" alt="AMD PC" width="400" height="300">
            </div>
        </div>
    </div>


    <div class="product-container">
        <div class="product-card">
            <div class="product-details">
                <h2>Configuration 3 </h2>
                <p>CPU: Intel i9</p>
                <p>GPU: NVIDIA RTX 3080</p>
                <p>RAM: 16GB</p>
                <p>Storage: 2TB SSD</p>
                <a href="product.php" class="btn">Add This</a>
            </div>
            <div class="product-image">
                <img src="images/intelnew.webp" alt="Intel PC" width="400" height="300">
            </div>
        </div>
    <div class="product-card">
            <div class="product-details">
                <h2>Configuration 4</h2>
                <p>CPU: AMD R9</p>
                <p>GPU: NVIDIA RTX 3080</p>
                <p>RAM: 16GB</p>
                <p>Storage: 2TB SSD</p>
                <a href="product.php" class="btn">Add This</a>
            </div>
            <div class="product-image">
                <img src="images/amd.jpg" alt="AMD PC" width="400" height="300">
            </div>
        </div>
    </div>



    <footer>
        <p>&copy; 2024 Custom Desktop Builder. All rights reserved.</p>
    </footer>    
</body>
</html>
