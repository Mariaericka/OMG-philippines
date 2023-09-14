<?php
include 'components/connect.php';
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
    header('location:index.php');
}

// ...

// Place Order Button
if (isset($_POST['submit'])) {
    // ...
    
    $method = $_POST['method'];
    
    // Handle different payment methods
    if ($method === 'gcash' && !isset($_FILES['payment_screenshot'])) {
        $message[] = 'Please upload the payment screenshot for GCash payment.';
    }
    
    // ...

    if ($method === 'gcash') {
        // GCash API integration code
        require 'vendor/autoload.php';
        \Xendit\Xendit::setApiKey('your_api_key_here');

        $external_id = "test_" . time();
        $total_amount = /* Code to calculate total amount of cart goes here */;
        $redirect_url = "https://your-redirect-url.com";

        $params = [
            'external_id' => $external_id,
            'amount' => $total_amount,
            'redirect_url' => $redirect_url,
            'ewallet_type' => 'GCASH'
        ];

        try {
            $response = \Xendit\EWallets::create($params);
            if ($response['status'] === 'PENDING') {
                header('Location: ' . $response['actions']['desktop_web_checkout_url']);
                exit(); // Ensure no other code is executed after redirection
            }
        } catch (\Xendit\Exceptions\ApiException $e) {
            // Handle error
            echo "Error: " . $e->getMessage();
        }
    }
    
    // ...
}
?>

<!-- ... (rest of your HTML code) ... -->
