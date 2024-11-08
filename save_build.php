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
    $cpuBrand = $_POST['cpu_brand'] ?? null;
    $cpuCategory = $_POST['cpu_category'] ?? null;
    $cpuModel = $_POST['cpu_model'] ?? null;

    $gpuBrand = $_POST['gpu_brand'] ?? null;
    $gpuCategory = $_POST['gpu_category'] ?? null;
    $gpuModel = $_POST['gpu_model'] ?? null;

    $ramBrand = $_POST['ram_brand'] ?? null;
    $ramCategory = $_POST['ram_category'] ?? null;
    $ramModel = $_POST['ram_model'] ?? null;

    $primaryStorageBrand = $_POST['primary_storage_brand'] ?? null;
    $primaryStorageCategory = $_POST['primary_storage_category'] ?? null;
    $primaryStorageModel = $_POST['primary_storage_model'] ?? null;

    $secondaryStorageBrand = $_POST['secondary_storage_brand'] ?? null;
    $secondaryStorageCategory = $_POST['secondary_storage_category'] ?? null;
    $secondaryStorageModel = $_POST['secondary_storage_model'] ?? null;

    // Calculate the total price (modify this if prices are fetched from database or calculated differently)
    $totalPrice = 1000.00; // Placeholder value for total price

    // Create build summary with <br> tags
    $buildSummary = "CPU: $cpuBrand $cpuCategory $cpuModel<br>" .
                    "GPU: $gpuBrand $gpuCategory $gpuModel<br>" .
                    "RAM: $ramBrand $ramCategory $ramModel<br>" .
                    "Primary Storage: $primaryStorageBrand $primaryStorageCategory $primaryStorageModel<br>" .
                    "Secondary Storage: $secondaryStorageBrand $secondaryStorageCategory $secondaryStorageModel";

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
                                  $cpuBrand, $cpuCategory, $cpuModel, 
                                  $gpuBrand, $gpuCategory, $gpuModel,
                                  $ramBrand, $ramCategory, $ramModel, 
                                  $primaryStorageBrand, $primaryStorageCategory, $primaryStorageModel, 
                                  $secondaryStorageBrand, $secondaryStorageCategory, $secondaryStorageModel, 
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
        $sqlOrder = "INSERT INTO orders (user_id, build_summary, total_price, status) VALUES (?, ?, ?, 'pending')";
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

    // Close the connection
    $conn->close();
}
?>
