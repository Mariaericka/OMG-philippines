<?php
include 'components/connect.php';

session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'vendor/autoload.php';

function generate_unique_order_id($user_id)
{
    $timestamp = time();
    $order_id = $user_id . '-' . $timestamp;
    return $order_id;
}
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $order_id = generate_unique_order_id($user_id);
    $total_amount = 0; // Assume $total_amount is obtained from your cart logic


    if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $number = $_POST['number'];
        $number = filter_var($number, FILTER_SANITIZE_STRING);
        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_STRING);
        $method = $_POST['method'];
        $method = filter_var($method, FILTER_SANITIZE_STRING);
        $address = $_POST['address'];
        $address = filter_var($address, FILTER_SANITIZE_STRING);
        $total_products = $_POST['total_products'];
        $total_price = $_POST['total_price'];
    
        $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
        $check_cart->execute([$user_id]);


        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.xendit.co');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        
        $data = [
            'reference_id' => $order_id,
            'currency' => 'PHP',
            'amount' => $total_amount,
            'checkout_method' => 'ONE_TIME_PAYMENT',
            'channel_code' => 'GCASH',
            'redirect_success' => 'http://localhost/OMG-philippines/orders.php',
            'redirect_failure' => 'http://localhost/OMG-philippines'
        ];
        
        $headers = [
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode('xnd_development_BAdhFSIoIl9We02NcrWohsRlYHwi86dKfN2Y3I5UL7iOkbkZJ1RI6mJC5Ja4 ' . ':')
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        
        curl_close($ch);
        
        $response_data = json_decode($result, true);
        if (isset($response_data['status']) && $response_data['status'] === 'PENDING') {
            header('Location: ' . $response_data['actions']['desktop_web_checkout_url']);
            exit();
        } else {
            // Handle the error
            echo 'Payment could not be initialized. Please try again.';
        }
        

        if ($check_cart->rowCount() > 0) {
            if ($address == '') {
                $message[] = 'please add your address!';
            } else {
                $cart_items = array();
                while ($fetch_cart = $check_cart->fetch(PDO::FETCH_ASSOC)) {
                    $size = $fetch_cart['size'];
                    $select_product_price = $conn->prepare("SELECT price, priceR FROM products WHERE id = ?");
                    $select_product_price->execute([$fetch_cart['pid']]);
                    $product_price = $select_product_price->fetch(PDO::FETCH_ASSOC);
                    $price = $size === 'large' ? $product_price['priceR'] : $product_price['price'];
                    $sub_total = $price * $fetch_cart['quantity'];
    
                    // Consider add-ons in the total price calculation
                    $select_addons = $conn->prepare("SELECT addon_name, addon_price FROM cart_addons WHERE cart_id = ?");
                    $select_addons->execute([$fetch_cart['id']]);
                    $addons = $select_addons->fetchAll(PDO::FETCH_ASSOC);
    
                    $sub_total += array_sum(array_column($addons, 'addon_price'));
    
                    $total_price += $sub_total;
                    $cart_items[] = array(
                        'name' => $fetch_cart['name'],
                        'price' => $price,
                        'quantity' => $fetch_cart['quantity'],
                        'addons' => $addons
                    );
                }
                $total_products = implode(' - ', array_map(function ($item) {
                    return $item['name'] . ' (' . $item['price'] . ' x ' . $item['quantity'] . ')';
                }, $cart_items));
    
                $order_id = generate_unique_order_id($user_id);
    
    
                    $order_placed = true;
                
    
                if ($order_placed) {
                     // Convert cart items with addons to JSON format
        $cart_addons_json = json_encode($cart_items, JSON_UNESCAPED_UNICODE);
        $insert_order = $conn->prepare("INSERT INTO `orders` (order_id, user_id, name, number, email, method, address, total_products, total_price, cart_addons) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $insert_order->execute([$order_id, $user_id, $name, $number, $email, $method, $address, $total_products, $total_price, $cart_addons_json]);
                    // Delete cart addons first
                    $delete_cart_addons = $conn->prepare("DELETE FROM `cart_addons` WHERE cart_id IN (SELECT id FROM `cart` WHERE user_id = ?)");
                    $delete_cart_addons->execute([$user_id]);
    
                    // Delete cart items
                    $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
                    $delete_cart->execute([$user_id]);
    
                    $message[] = 'Order placed successfully!';
                }
            }
        } else {
            $message[] = 'Your cart is empty';
        }
    }

} else {
    $user_id = '';
    header('location:index.php');
}




?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Checkout</title>
   <link rel="icon" href="images/omg-logo.png">

   <!-- font awesome cdn link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link -->
   <link rel="stylesheet" href="css/style2.css">
</head>
<body>

<!-- header section starts -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->

<div class="heading">
   <h3>Order Summary</h3>
   <p><a href="index.php">Home</a> <span>/ checkout</span></p>
</div>

<section class="checkout">
   <form action="" method="post" enctype="multipart/form-data">
      <div class="cart-items">
         <h3>Cart Items</h3>
         <?php
            $total_price = 0;

            $select_cart = $conn->prepare("SELECT c.*, p.priceR FROM `cart` c INNER JOIN `products` p ON c.pid = p.id WHERE c.user_id = ?");
            $select_cart->execute([$user_id]);

            if ($select_cart->rowCount() > 0) {
               while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                  $size = $fetch_cart['size'];
                  $select_product_price = $conn->prepare("SELECT price, priceR FROM products WHERE id = ?");
                  $select_product_price->execute([$fetch_cart['pid']]);
                  $product_price = $select_product_price->fetch(PDO::FETCH_ASSOC);
                  $price = $size === 'large' ? $product_price['priceR'] : $product_price['price'];
                  $sub_total = $price * $fetch_cart['quantity'];

                  // Consider add-ons in the total price calculation
                  $select_addons = $conn->prepare("SELECT addon_name, addon_price FROM cart_addons WHERE cart_id = ?");
                  $select_addons->execute([$fetch_cart['id']]);
                  $addons = $select_addons->fetchAll(PDO::FETCH_ASSOC);

                  $sub_total += array_sum(array_column($addons, 'addon_price'));
                  $total_price += $sub_total;
         ?>
                  <p><span class="name"><?= $fetch_cart['name']; ?></span><span class="price">₱<?= $price; ?> x <?= $fetch_cart['quantity']; ?></span></p>
                  <?php if (!empty($addons)): ?>
                  <div class="addons-list">
                     <ul style="display: flex; flex-direction: column;">
                        <?php foreach ($addons as $addon): ?>
                           <li class="addons"><?= $addon['addon_name']; ?> (+₱<?= $addon['addon_price']; ?>)</li>
                        <?php endforeach; ?>
                     </ul>
                  </div>
                  <?php endif; ?>
         <?php
               }
            } else {
               echo '<p class="empty">Your cart is empty!</p>';
            }
         ?>
         <p class="grand-total"><span class="name">Grand Total:</span><span class="price">₱<?= $total_price; ?></span></p>
      </div>

      <a href="cart.php" class="btn">View Cart</a>

      <input type="hidden" name="total_products" value="<?= $total_products; ?>">
      <input type="hidden" name="total_price" value="<?= $total_price; ?>">
      <input type="hidden" name="name" value="<?= $fetch_profile['name'] ?>">
      <input type="hidden" name="number" value="<?= $fetch_profile['number'] ?>">
      <input type="hidden" name="email" value="<?= $fetch_profile['email'] ?>">
      <input type="hidden" name="address" value="<?= $fetch_profile['address'] ?>">

      <div class="user-info">
         <h3>Your Info</h3>
         <p><i class="fas fa-user"></i><span><?= $fetch_profile['name'] ?></span></p>
         <p><i class="fas fa-phone"></i><span><?= $fetch_profile['number'] ?></span></p>
         <p><i class="fas fa-envelope"></i><span><?= $fetch_profile['email'] ?></span></p>
         <a href="update_profile.php" class="btn">Update Info</a>
         <h3>Delivery Address</h3>
         <p><i class="fas fa-map-marker-alt"></i><span><?php if($fetch_profile['address'] == ''){echo 'Please enter your address';}else{echo $fetch_profile['address'];} ?></span></p>
         <a href="update_address.php" class="btn">Update Address</a>
         <div class="delivery-info">
            <h3>Delivery Information</h3>
            <p><strong>Note:</strong> Delivery is available within the Laguna area only. If you are outside the delivery range, please choose "In-store Pick-up" or "GCash" as your payment method and visit our stores or other franchise branches.</p>
         </div>
         <select name="method" class="box" id="payment-method" required>
        <option value="" disabled selected>Select Payment Method</option>
        <option value="gcash">GCash</option>
        <option value="instore">In-store Pickup</option>
    </select>
    
    <input type="submit" value="Place Order" class="btn <?php if($fetch_profile['address'] == '' || (isset($_POST['method']) && $_POST['method'] === 'gcash')) { echo 'disabled'; } ?>" style="width: 100%; background: var(--red); color: var(--white);" name="submit">
   </form>
</section>

<!-- footer section starts -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->

<!-- custom js file link -->
<script src="js/modal.js"></script>
<script src="js/script.js"></script>


</body>
</html>
  