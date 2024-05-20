<?php 
include "restricted/config.php";
$phoneNumber = '+1234567890'; // Recipient's phone number
$otp = 123456; // Generate your OTP using your preferred method

$message = $twilio->messages->create(
    $phoneNumber,
    [
        'from' => 'YOUR_TWILIO_PHONE_NUMBER',
        'body' => 'Your OTP is: ' . $otp
    ]
);
?>