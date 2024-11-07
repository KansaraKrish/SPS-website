<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customize Your Build</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="js/scripts.js" defer></script>
</head>
<body>
    <header>
        <h2>Customize Your Desktop</h2>
        <nav class="navbar">
            <ul>
                <li><a href="index.php">Home</a></li>
                <!-- <li><a href="login.php">Login</a></li> -->
            </ul>

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
    <main>
        <section class="customization">
            <div class="options">
                <h2>Choose Your Components</h2>
                <form id="custom-build-form" action="save_build.php" method="POST">
                    
                    <!-- CPU Selection (Same as previous example) -->
                    <label for="cpu-brand">CPU Brand:</label>
                    <select id="cpu-brand" name="cpu_brand" onchange="loadCategories('cpu')">
                        <option value="" disabled selected>Select a Brand</option>
                        <?php
                        session_start();
                        require 'db.php';
                        $sql = "SELECT * FROM cpu_brands";
                        $result = $conn->query($sql);
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='{$row['brand_id']}'>{$row['brand_name']}</option>";
                        }
                        ?>
                    </select>

                    <label for="cpu-category">CPU Category:</label>
                    <select id="cpu-category" name="cpu_category" onchange="loadModels('cpu')" disabled>
                        <option value="" disabled selected>Select a Category</option>
                    </select>

                    <label for="cpu-model">CPU Model:</label>
                    <select id="cpu-model" name="cpu_model" onchange="updateBuildPreview()" disabled>
                        <option value="" disabled selected>Select a Model</option>
                    </select>

                    <!-- GPU Selection -->
                    <label for="gpu-brand">GPU Brand:</label>
                    <select id="gpu-brand" name="gpu_brand" onchange="loadCategories('gpu'); updateBuildPreview()">
                        <option value="" disabled selected>Select a Brand</option>
                        <?php
                        $sql = "SELECT * FROM gpu_brands";
                        $result = $conn->query($sql);
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='{$row['brand_id']}'>{$row['brand_name']}</option>";
                        }
                        ?>
                    </select>

                    <label for="gpu-category">GPU Category:</label>
                    <select id="gpu-category" name="gpu_category" onchange="loadModels('gpu'); updateBuildPreview()" disabled>
                        <option value="" disabled selected>Select a Category</option>
                    </select>

                    <label for="gpu-model">GPU Model:</label>
                    <select id="gpu-model" name="gpu_model" disabled>
                        <option value="" disabled selected>Select a Model</option>
                    </select>

                    <!-- RAM Selection -->
                    <label for="ram-brand">RAM Brand:</label>
                    <select id="ram-brand" name="ram_brand" onchange="loadCategories('ram'); updateBuildPreview()">
                        <option value="" disabled selected>Select a Brand</option>
                        <?php
                        $sql = "SELECT * FROM ram_brands";
                        $result = $conn->query($sql);
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='{$row['brand_id']}'>{$row['brand_name']}</option>";
                        }
                        ?>
                    </select>

                    <label for="ram-category">RAM Category:</label>
                    <select id="ram-category" name="ram_category" onchange="loadModels('ram'); updateBuildPreview()" disabled>
                        <option value="" disabled selected>Select a Category</option>
                    </select>

                    <label for="ram-model">RAM Model:</label>
                    <select id="ram-model" name="ram_model" disabled>
                        <option value="" disabled selected>Select a Model</option>
                    </select>

                    <!-- Primary Storage Selection -->
                    <h3>Primary Storage (e.g., for OS)</h3>
                    <label for="primary-storage-brand">Storage Brand:</label>
                    <select id="primary-storage-brand" name="primary_storage_brand" onchange="loadCategories('primary-storage'); updateBuildPreview()">
                        <option value="" disabled selected>Select a Brand</option>
                        <?php
                        $sql = "SELECT * FROM storage_brands";
                        $result = $conn->query($sql);
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='{$row['brand_id']}'>{$row['brand_name']}</option>";
                        }
                        ?>
                    </select>

                    <label for="primary-storage-category">Storage Type:</label>
                    <select id="primary-storage-category" name="primary_storage_category" onchange="loadModels('primary-storage'); updateBuildPreview()" disabled>
                        <option value="" disabled selected>Select a Type</option>
                    </select>

                    <label for="primary-storage-model">Storage Model:</label>
                    <select id="primary-storage-model" name="primary_storage_model" disabled>
                        <option value="" disabled selected>Select a Model</option>
                    </select>

                    <!-- Secondary Storage Selection -->
                    <h3>Secondary Storage (e.g., for extra storage)</h3>
                    <label for="secondary-storage-brand">Storage Brand:</label>
                    <select id="secondary-storage-brand" name="secondary_storage_brand" onchange="loadCategories('secondary-storage'); updateBuildPreview()">
                        <option value="" disabled selected>Select a Brand</option>
                        <?php
                        $sql = "SELECT * FROM storage_brands";
                        $result = $conn->query($sql);
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='{$row['brand_id']}'>{$row['brand_name']}</option>";
                        }
                        ?>
                    </select>

                    <label for="secondary-storage-category">Storage Type:</label>
                    <select id="secondary-storage-category" name="secondary_storage_category" onchange="loadModels('secondary-storage'); updateBuildPreview()" disabled>
                        <option value="" disabled selected>Select a Type</option>
                    </select>

                    <label for="secondary-storage-model">Storage Model:</label>
                    <select id="secondary-storage-model" name="secondary_storage_model" disabled>
                        <option value="" disabled selected>Select a Model</option>
                    </select>
                    <button type="submit">Save Build</button>
                </form>
            </div>
            <!-- Build Preview Section -->
            <div class="live-preview">
                <h2>Your Build Preview</h2>
                <div id="build-preview">
                    <p id="cpu-summary"></p>
                    <p id="gpu-summary"></p>
                    <p id="ram-summary"></p>
                    <p id="primary-storage-summary"></p>
                    <p id="secondary-storage-summary"></p>
                </div>
                <img id="build-image" src="images/default-build.jpeg" alt="Custom Build Preview" height="250" width="350">
            </div>

        </section>
</div>

    </main>
    <footer>
        <p>&copy; 2024 Custom Desktop Builder. All rights reserved.</p>
    </footer>
    <script src="js/scripts.js"></script>
    <script>
        // Function to dynamically load categories and models for each component type
        function loadCategories(componentType) {
            const brandId = document.getElementById(`${componentType}-brand`).value;
            fetch(`load_categories.php?brand_id=${brandId}&component=${componentType}`)
                .then(response => response.json())
                .then(data => {
                    const categorySelect = document.getElementById(`${componentType}-category`);
                    categorySelect.innerHTML = '<option value="" disabled selected>Select a Category</option>';
                    data.forEach(category => {
                        categorySelect.innerHTML += `<option value="${category.category_id}">${category.category_name}</option>`;
                    });
                    categorySelect.disabled = false;
                    document.getElementById(`${componentType}-model`).disabled = true;
                });
        }

        function loadModels(componentType) {
            const categoryId = document.getElementById(`${componentType}-category`).value;
            fetch(`load_models.php?category_id=${categoryId}&component=${componentType}`)
                .then(response => response.json())
                .then(data => {
                    const modelSelect = document.getElementById(`${componentType}-model`);
                    modelSelect.innerHTML = '<option value="" disabled selected>Select a Model</option>';
                    data.forEach(model => {
                        modelSelect.innerHTML += `<option value="${model.model_id}">${model.model_name}</option>`;
                    });
                    modelSelect.disabled = false;
                });
        }
        // Function to update the build preview dynamically
        function updateBuildPreview() {
        // Get selected component values (brand names and model names)
        const cpuBrand = document.getElementById("cpu-brand").options[document.getElementById("cpu-brand").selectedIndex]?.text;
        const gpuBrand = document.getElementById("gpu-brand").options[document.getElementById("gpu-brand").selectedIndex]?.text;
        
        // Get the selected models (these are the 'text' values for user-friendly display)
        const cpuModel = document.getElementById('cpu-model').options[document.getElementById('cpu-model').selectedIndex]?.text;
        const gpuModel = document.getElementById('gpu-model').options[document.getElementById('gpu-model').selectedIndex]?.text;
        const ramModel = document.getElementById('ram-model').options[document.getElementById('ram-model').selectedIndex]?.text;
        const primaryStorageModel = document.getElementById('primary-storage-model').options[document.getElementById('primary-storage-model').selectedIndex]?.text;
        const secondaryStorageModel = document.getElementById('secondary-storage-model').options[document.getElementById('secondary-storage-model').selectedIndex]?.text;

        // Update the preview summary
        document.getElementById('cpu-summary').innerHTML = cpuModel ? `<strong>CPU:</strong> ${cpuModel}` : '';
        document.getElementById('gpu-summary').innerHTML = gpuModel ? `<strong>GPU:</strong> ${gpuModel}` : '';
        document.getElementById('ram-summary').innerHTML = ramModel ? `<strong>RAM:</strong> ${ramModel}` : '';
        document.getElementById('primary-storage-summary').innerHTML = primaryStorageModel ? `<strong>Primary Storage:</strong> ${primaryStorageModel}` : '';
        document.getElementById('secondary-storage-summary').innerHTML = secondaryStorageModel ? `<strong>Secondary Storage:</strong> ${secondaryStorageModel}` : '';

        // Determine the image source based on the selected CPU and GPU brands (with fallback)
        let imageSrc = 'images/default-build.jpeg'; // Default image
        if (cpuBrand === 'AMD') {
            imageSrc = 'images/amd.jpg'; // Path for AMD image
        } else if (cpuBrand === 'Intel') {
            imageSrc = 'images/intel.jpg'; // Path for Intel image
        } else if (gpuBrand === 'NVIDIA') {
            imageSrc = 'images/nvidia.jpg'; // Path for NVIDIA GPU image (if needed)
        }
        // Update the image source in the preview
        document.getElementById("build-image").src = imageSrc;
    }
    </script>
</body>
</html>