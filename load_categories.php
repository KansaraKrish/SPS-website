<?php
$brand_id = intval($_GET['brand_id']);
$component = $_GET['component'];
$table = '';
session_start();
require 'db.php';

// Determine the appropriate category table based on the component type
switch ($component) {
    case 'cpu':
        $table = 'cpu_categories';
        break;
    case 'gpu':
        $table = 'gpu_categories';
        break;
    case 'ram':
        $table = 'ram_categories';
        break;
    case 'primary-storage':
    case 'secondary-storage':
        $table = 'storage_categories';
        break;
}

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch categories based on the selected brand
$sql = "SELECT category_id, category_name FROM $table WHERE brand_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $brand_id);
$stmt->execute();
$result = $stmt->get_result();

$categories = [];
while ($row = $result->fetch_assoc()) {
    $categories[] = $row;
}

$stmt->close();
$conn->close();

// Return categories in JSON format
echo json_encode($categories);
?>
