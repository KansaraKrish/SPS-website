<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entered_otp = $_POST['otp'];

    if (isset($_SESSION['otp']) && $entered_otp == $_SESSION['otp']) {
        // If OTP is correct, insert the data into the database
        $user_data = $_SESSION['user_data'];

        // DB connection
        $conn = new mysqli('localhost', 'root', '', 'your_database');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $name = $user_data['name'];
        $number = $user_data['number'];
        $email = $user_data['email'];
        $password = $user_data['password'];

        // Insert user details into the database
        $sql = "INSERT INTO users (name, number, email, password) VALUES ('$name', '$number', '$email', '$password')";

        if ($conn->query($sql) === TRUE) {
            echo "Registration successful!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
        session_unset();
        session_destroy();
    } else {
        echo "Incorrect OTP!";
    }
}
