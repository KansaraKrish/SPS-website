<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Custom Desktop Builder</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="js/scripts.js"></script>
</head>
<body>
        <header>
            <nav class="navbar">
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="product.php">Customize</a></li>
                    <!-- Dropdown for Pc Studio -->
                    <li class="dropdown">
                        <a href="pcstudio.php">Our Pre-Builts</a>
                        <ul class="dropdown-content">
                            <li><a href="pcstudio.php">Gaming PCs</a></li>
                            <li><a href="workstation.php">Workstations</a></li>
                        </ul>
                    </li>
        
                    <!-- Dropdown for Pc Peripherals -->
                    <li class="dropdown">
                        <a href="pcper.php">Pc Peripherals</a>
                        <ul class="dropdown-content">
                            <li><a href="pcper.php">Monitors</a></li>
                            <li><a href="keyboards.php">Keyboards</a></li>
                            <li><a href="mice.php">Mice</a></li>
                        </ul>
                    </li>
        
                    <!-- <li><a href="login.php">Login</a></li> -->
                </ul>

                 <!-- Login Button or Username Placeholder -->
        <div class="login-area" style="position: absolute; right: 20px;top: 30px;font-size: 18px;">
            <?php
            session_start();
            if (isset($_SESSION['user_name'])): ?>
                <span>Welcome, <?= $_SESSION['user_name'] ?></span>
            <?php else: ?>
                <a href="login.php" class="login-btn" style="background-color: #008080; color: white;padding: 10px 15px; border-radius: 5px; text-decoration: none;
    transition: background-color 0.3s ease;">Login</a>
            <?php endif; ?>
        </div>
            </nav>
        </header>        
    
        <section>
            <h1>Welcome To Our Website</h1>
            <h2>Build Your Custom Desktop</h2>
            <p>Choose from a range of components and build your dream machine.</p>
            
        </section>
        <table>
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
    </table>
    <footer>
        <p>&copy; 2024 Custom Desktop Builder. All rights reserved.</p>
    </footer>    
</body>
</html>
