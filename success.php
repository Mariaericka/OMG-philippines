<meta http-equiv="refresh" content="5;url=orders.php">

<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

include 'components/connect.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header('location:index.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch cart details for the user
$select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
$select_cart->execute([$user_id]);

if ($select_cart->rowCount() == 0) {
    echo "No cart items found for the user!";
    exit();
}

// Fetch user details for the order
$select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
$select_user->execute([$user_id]);

$user_details = $select_user->fetch(PDO::FETCH_ASSOC);
$name = $user_details['name'];
$number = $user_details['number'];
$email = $user_details['email'];
$address = $user_details['address'];

// Assuming that if they're on this page, the payment method was GCash
$method = "gcash";

// Generating order ID
function generate_unique_order_id($user_id) {
    $timestamp = time();
    return $user_id . '-' . $timestamp;
}
$order_id = generate_unique_order_id($user_id);

// Process cart items and calculate total price
$total_price = 0;
$cart_items = [];

while ($row = $select_cart->fetch(PDO::FETCH_ASSOC)) {
    // Process each cart item and update total_price
    $total_price += $row['price'] * $row['quantity'];
    $cart_items[] = $row;
}

$total_products = count($cart_items);

// Simulated GCash payment verification
$is_payment_successful = true;  // Placeholder

if ($is_payment_successful) {
    // Convert cart items with addons to JSON format
    $cart_addons_json = json_encode($cart_items, JSON_UNESCAPED_UNICODE);

    // Insert order details
    $insert_order = $conn->prepare("INSERT INTO `orders` (order_id, user_id, name, number, email, method, address, total_products, total_price, cart_addons) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $insert_order->execute([$order_id, $user_id, $name, $number, $email, $method, $address, $total_products, $total_price, $cart_addons_json]);
    
    // Clear cart
    $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
    $delete_cart->execute([$user_id]);

    // echo "Order placed successfully and cart cleared!";
    $email_subject = "Receipt for Your Order at OMG Philippines";
    $email_body = "<h2>Order Confirmation</h2>";
    $email_body = "<p>Thank you for placing your order with us. Your order details are as follows: </p>";


    $email_body .= "<p><strong>Order ID:</strong> " . $order_id . "</p>";
    $email_body .= "<p><strong>Name:</strong> " . $name . "</p>";
    foreach ($cart_items as $item) {
      $email_body .= "<p>Product: " . $item['name'] . " - ₱" . $item['price'] . " x " . $item['quantity'] . "</p>";
      
      if (isset($item['addons']) && is_array($item['addons'])) {
          foreach ($item['addons'] as $addon) {
              $email_body .= "<p>Addon: " . $addon['addon_name'] . " - ₱" . $addon['addon_price'] . "</p>";
          }
      }
  }
  $email_body .= "<p><strong>Payment Method:</strong> " . $method . "</p>";

    $email_body .= "<p><strong>Total Products:</strong> " . $total_products . "</p>";
    $email_body .= "<p><strong>Total Price:</strong> ₱" . $total_price . "</p>";

    $email_body .= "<p>Thank you for ordering! </p>";
 // Send the email using PHPMailer
 $mail = new PHPMailer(true);
  
 $mail->isSMTP();
 $mail->Host = 'smtp.gmail.com';
 $mail->SMTPAuth = true;
 $mail->Username = 'omgphilippines123@gmail.com';
 $mail->Password = 'qcdjmrfckncojvsy';
 $mail->SMTPSecure = 'ssl';
 $mail->Port = 465;

 $mail->setFrom('omgphilippines123@gmail.com', 'OMG Philippines');
 $mail->addAddress($email);
 $mail->isHTML(true);
 $mail->Subject = $email_subject;
 $mail->Body = $email_body;

 try {
     $mail->send();
 } catch (Exception $e) {
     $message[] = "Receipt email could not be sent. Mailer Error: {$mail->ErrorInfo}";
   }

} else {
    // echo "Payment verification failed!";
}

?>
<html>
  <head>
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,400i,700,900&display=swap" rel="stylesheet">
  </head>
    <style>
      body {
        text-align: center;
        padding: 40px 0;
        background: #EBF0F5;
      }
        h1 {
          color: #88B04B;
          font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
          font-weight: 900;
          font-size: 40px;
          margin-bottom: 10px;
        }
        p {
          color: #404F5E;
          font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
          font-size:20px;
          margin: 0;
        }
      i {
        color: #9ABC66;
        font-size: 100px;
        line-height: 200px;
        margin-left:-15px;
      }
      .card {
        background: white;
        padding: 60px;
        border-radius: 4px;
        box-shadow: 0 2px 3px #C8D0D8;
        display: inline-block;
        margin: 0 auto;
      }
    </style>
    <body>
      <div class="card">
      <div style="border-radius:200px; height:200px; width:200px; background: #F8FAF5; margin:0 auto;">
        <i class="checkmark">✓</i>
      </div>
        <h1>Success</h1> 
        <p>We received your purchase request;<br/> 
  Thank you for your order !<br/>
   Your order receipt will be emailed to you.</p>

      </div>
    </body>
</html>