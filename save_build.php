<?php
// Start the session
session_start();

// Include the database connection
require 'db.php'; // Ensure you have this connection in the same folder or modify the path as necessary

// Check if the user is logged in (optional)
if (!isset($_SESSION['user_name'])) {
    echo "You must be logged in to save your build.";
    exit();
}
// Capture the selected components from the form
$user_name = $_SESSION['user_name']; // You can also allow users to input their name if needed
$cpu_brand = $_POST['cpu_brand'];
$cpu_category = $_POST['cpu_category'];
$cpu_model = $_POST['cpu_model'];
$gpu_brand = $_POST['gpu_brand'];
$gpu_category = $_POST['gpu_category'];
$gpu_model = $_POST['gpu_model'];
$ram_brand = $_POST['ram_brand'];
$ram_category = $_POST['ram_category'];
$ram_model = $_POST['ram_model'];
$primary_storage_brand = $_POST['primary_storage_brand'];
$primary_storage_category = $_POST['primary_storage_category'];
$primary_storage_model = $_POST['primary_storage_model'];
$secondary_storage_brand = $_POST['secondary_storage_brand'];
$secondary_storage_category = $_POST['secondary_storage_category'];
$secondary_storage_model = $_POST['secondary_storage_model'];

// Prepare and execute the insert query
$sql = "INSERT INTO user_hardware (
    user_name, cpu_brand, cpu_category, cpu_model, 
    gpu_brand, gpu_category, gpu_model, 
    ram_brand, ram_category, ram_model, 
    primary_storage_brand, primary_storage_category, primary_storage_model, 
    secondary_storage_brand, secondary_storage_category, secondary_storage_model
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

// Prepare the statement
$stmt = $conn->prepare($sql);

// Bind parameters
$stmt->bind_param("sssssssssssssss", 
    $user_name, $cpu_brand, $cpu_category, $cpu_model, 
    $gpu_brand, $gpu_category, $gpu_model, 
    $ram_brand, $ram_category, $ram_model, 
    $primary_storage_brand, $primary_storage_category, $primary_storage_model, 
    $secondary_storage_brand, $secondary_storage_category, $secondary_storage_model);

// Execute the query
if ($stmt->execute()) {
    echo "Build saved successfully!";
} else {
    echo "Error saving the build: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
header("Location: confirmation.php");
exit();
?>
