<?php
// Database configuration
require 'db.php';


// Retrieve form data
$name = $_POST['name'];
$number = $_POST['number'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// Validate if passwords match
if ($password !== $confirm_password) {
    echo "Passwords do not match!";
    exit;
}

// Hash the password
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

// Insert data into the database
$sql = "INSERT INTO users(email, password, phone, name) VALUES ('$email', '$hashed_password', '$number', '$name')";

if ($conn->query($sql) === TRUE) {
    echo "Registration successful!";
} else {    
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close connection
$conn->close();
?>
