<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    die("You need to log in to place an order.");
}

$user_id = $_SESSION['user_id'];
$build_summary = $_POST['build_summary'];
$total_price = $_POST['total_price'];

$sql = "INSERT INTO orders (user_id, build_summary, total_price) VALUES ('$user_id', '$build_summary', '$total_price')";
if ($conn->query($sql) === TRUE) {
    echo "Order placed successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>
