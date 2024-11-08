<?php
session_start();
require 'db.php'; // Include your database connection

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ensure the user is logged in
    if (!isset($_SESSION['user_name'])) {
        echo "You must be logged in to save your build.";
        exit;
    }
    
    // Get the username from the session
    $userName = $_SESSION['user_name'];

    // Get the selected component values from the form
    $cpuBrandId = $_POST['cpu_brand'] ?? null;
    $cpuCategoryId = $_POST['cpu_category'] ?? null;
    $cpuModelId = $_POST['cpu_model'] ?? null;

    $gpuBrandId = $_POST['gpu_brand'] ?? null;
    $gpuCategoryId = $_POST['gpu_category'] ?? null;
    $gpuModelId = $_POST['gpu_model'] ?? null;

    $ramBrandId = $_POST['ram_brand'] ?? null;
    $ramCategoryId = $_POST['ram_category'] ?? null;
    $ramModelId = $_POST['ram_model'] ?? null;

    $primaryStorageBrandId = $_POST['primary_storage_brand'] ?? null;
    $primaryStorageCategoryId = $_POST['primary_storage_category'] ?? null;
    $primaryStorageModelId = $_POST['primary_storage_model'] ?? null;

    $secondaryStorageBrandId = $_POST['secondary_storage_brand'] ?? null;
    $secondaryStorageCategoryId = $_POST['secondary_storage_category'] ?? null;
    $secondaryStorageModelId = $_POST['secondary_storage_model'] ?? null;

    // Calculate the total price (modify this if prices are fetched from database or calculated differently)
    $totalPrice = 0; // Placeholder value for total price

    // Function to retrieve component name based on IDs
    function getComponentName($conn, $table, $brandId, $categoryId, $modelId) {
        $sql = "SELECT CONCAT(b.brand_name, ' ', c.category_name, ' ', m.model_name) AS full_name 
                FROM {$table}_brands b
                JOIN {$table}_categories c ON c.category_id = ?
                JOIN {$table}_models m ON m.model_id = ?
                WHERE b.brand_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $categoryId, $modelId, $brandId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['full_name'] ?? "Unknown";
    }

    // Fetch actual component names
    $cpuDetails = getComponentName($conn, 'cpu', $cpuBrandId, $cpuCategoryId, $cpuModelId);
    $gpuDetails = getComponentName($conn, 'gpu', $gpuBrandId, $gpuCategoryId, $gpuModelId);
    $ramDetails = getComponentName($conn, 'ram', $ramBrandId, $ramCategoryId, $ramModelId);
    $primaryStorageDetails = getComponentName($conn, 'storage', $primaryStorageBrandId, $primaryStorageCategoryId, $primaryStorageModelId);
    $secondaryStorageDetails = getComponentName($conn, 'storage', $secondaryStorageBrandId, $secondaryStorageCategoryId, $secondaryStorageModelId);

    // Create build summary with actual names
    $buildSummary = "CPU: $cpuDetails ," .
                    "GPU: $gpuDetails ," .
                    "RAM: $ramDetails ," .
                    "Primary Storage: $primaryStorageDetails ," .
                    "Secondary Storage: $secondaryStorageDetails";

    // Begin transaction
    $conn->begin_transaction();

    try {
        // Step 1: Insert into user_hardware table
        $sqlHardware = "INSERT INTO user_hardware (cpu_brand, cpu_category, cpu_model, gpu_brand, gpu_category, gpu_model, 
                        ram_brand, ram_category, ram_model, primary_storage_brand, primary_storage_category, primary_storage_model, 
                        secondary_storage_brand, secondary_storage_category, secondary_storage_model, user_name) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmtHardware = $conn->prepare($sqlHardware);
        $stmtHardware->bind_param("ssssssssssssssss", 
                                  $cpuBrandId, $cpuCategoryId, $cpuModelId, 
                                  $gpuBrandId, $gpuCategoryId, $gpuModelId,
                                  $ramBrandId, $ramCategoryId, $ramModelId, 
                                  $primaryStorageBrandId, $primaryStorageCategoryId, $primaryStorageModelId, 
                                  $secondaryStorageBrandId, $secondaryStorageCategoryId, $secondaryStorageModelId, 
                                  $userName);
        
        if (!$stmtHardware->execute()) {
            throw new Exception("Error saving build to user_hardware: " . $stmtHardware->error);
        }

        // Step 2: Fetch the user_id for the current user
        $stmtUser = $conn->prepare("SELECT id FROM users WHERE name = ?");
        $stmtUser->bind_param("s", $userName);
        $stmtUser->execute();
        $resultUser = $stmtUser->get_result();
        $user = $resultUser->fetch_assoc();
        $userId = $user['id'];
        
        if (!$userId) {
            throw new Exception("User ID not found for user_name: $userName");
        }

        // Step 3: Insert into orders table
        $sqlOrder = "INSERT INTO orders (user_id, build_summary, total_price, status) VALUES (?, ?, ?, 'pending for aproval')";
        $stmtOrder = $conn->prepare($sqlOrder);
        $stmtOrder->bind_param("isd", $userId, $buildSummary, $totalPrice);

        if (!$stmtOrder->execute()) {
            throw new Exception("Error saving order to orders: " . $stmtOrder->error);
        }

        // Commit transaction if both inserts are successful
        $conn->commit();
        echo "Your build has been saved successfully in both user_hardware and orders tables!";

        // Close statements
        $stmtHardware->close();
        $stmtUser->close();
        $stmtOrder->close();
        
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        echo $e->getMessage();
    }
    header("Location: index.php");
    // Close the connection
    $conn->close();
}
?>
