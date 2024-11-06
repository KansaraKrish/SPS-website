<?php
$category_id = intval($_GET['category_id']);
$component = $_GET['component'];
$table = '';
session_start();
require 'db.php';

switch ($component) {
    case 'cpu':
        $table = 'cpu_models';
        break;
    case 'gpu':
        $table = 'gpu_models';
        break;
    case 'ram':
        $table = 'ram_models';
        break;
    case 'primary-storage':
    case 'secondary-storage':
        $table = 'storage_models';
        break;
}

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT model_id, model_name FROM $table WHERE category_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $category_id);
$stmt->execute();
$result = $stmt->get_result();

$models = [];
while ($row = $result->fetch_assoc()) {
    $models[] = $row;
}

$stmt->close();
$conn->close();

echo json_encode($models);
?>
