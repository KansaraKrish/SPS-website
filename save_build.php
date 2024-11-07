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
    
    // Assuming the user's ID is stored in the session
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
    $primaryStorageType = $_POST['primary_storage_type'] ?? null; // Changed from 'category' to 'type'
    $primaryStorageModel = $_POST['primary_storage_model'] ?? null;

    $secondaryStorageBrand = $_POST['secondary_storage_brand'] ?? null;
    $secondaryStorageType = $_POST['secondary_storage_type'] ?? null; // Changed from 'category' to 'type'
    $secondaryStorageModel = $_POST['secondary_storage_model'] ?? null;

    // Prepare the SQL query to insert the selected components into the database
    $sql = "INSERT INTO user_hardware (user_name, cpu_brand, cpu_category, cpu_model, gpu_brand, gpu_category, gpu_model, 
            ram_brand, ram_category, ram_model, storage_brand_1, storage_type_1, storage_model_1, 
            storage_brand_2, storage_type_2, storage_model_2) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare the statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind the parameters to the prepared statement
        $stmt->bind_param($_SESSION['user_name'], $cpuBrand, $cpuCategory, $cpuModel, 
                          $gpuBrand, $gpuCategory, $gpuModel, $ramBrand, $ramCategory, $ramModel, 
                          $primaryStorageBrand, $primaryStorageType, $primaryStorageModel,
                          $secondaryStorageBrand, $secondaryStorageType, $secondaryStorageModel, $userId);
        
        // Execute the query
        if ($stmt->execute()) {
            echo "Your build has been saved successfully!";
        } else {
            echo "Error saving build: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error preparing the query: " . $conn->error;
    }

    // Close the connection
    $conn->close();
}
?>