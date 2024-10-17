<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $number = $_POST['number'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Simple validation
    if ($password !== $confirm_password) {
        echo "Password mismatch!";
        exit;
    }

    // Generate a 6-digit OTP
    $otp = rand(100000, 999999);
    $_SESSION['otp'] = $otp;
    $_SESSION['user_data'] = [
        'name' => $name,
        'number' => $number,
        'email' => $email,
        'password' => password_hash($password, PASSWORD_DEFAULT) // Securely hash the password
    ];

    // Send OTP to mobile number (use an API service like Twilio)
    // Assuming the SMS sending function is sendSMS($number, $message)
    $message = "Your OTP is: " . $otp;

    // Send the OTP
    // Uncomment the line below if you have an SMS API to integrate
    // if (sendSMS($number, $message)) {
    //     echo "otp_sent";
    // } else {
    //     echo "Error sending OTP";
    // }

    // For now, simulate that OTP has been sent
    echo "otp_sent";
}
