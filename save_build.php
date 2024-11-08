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
    $userName = $_SESSION['user_name']; // Assuming the user's name is stored in the session

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

    // Prepare the SQL query to insert the selected components into the database
    $sql = "INSERT INTO user_hardware (cpu_brand, cpu_category, cpu_model, gpu_brand, gpu_category, gpu_model, 
            ram_brand, ram_category, ram_model, primary_storage_brand, primary_storage_category, primary_storage_model, 
            secondary_storage_brand, secondary_storage_category, secondary_storage_model, user_name) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare the statement
    if ($stmt = $conn->prepare($sql))   {
        // Bind the parameters to the prepared statement
        $stmt->bind_param("ssssssssssssssss", $cpuBrand, $cpuCategory, $cpuModel, $gpuBrand, $gpuCategory, $gpuModel,
                          $ramBrand, $ramCategory, $ramModel, $primaryStorageBrand, $primaryStorageCategory, $primaryStorageModel,
                          $secondaryStorageBrand, $secondaryStorageCategory, $secondaryStorageModel, $userName);
        
        // Execute the query
        if ($stmt->execute()) {
            header("Location: index.php");        
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