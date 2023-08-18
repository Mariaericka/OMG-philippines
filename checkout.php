<?php
include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
    header('location:index.php');
}

function generate_unique_order_id($user_id)
{
    $timestamp = time();
    $order_id = $user_id . '-' . $timestamp;
    return $order_id;
}

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

            $order_placed = false;

            if ($method === 'gcash' && !isset($_FILES['payment_screenshot'])) {
                $message[] = 'Please upload the payment screenshot for GCash payment.';
            } else {
                $order_placed = true;
            }

            if ($order_placed) {
                $insert_order = $conn->prepare("INSERT INTO `orders` (order_id, user_id, name, number, email, method, address, total_products, total_price) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $insert_order->execute([$order_id, $user_id, $name, $number, $email, $method, $address, $total_products, $total_price]);

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
    <?php if (isset($_POST['submit']) && $_POST['method'] === 'gcash'): ?>
        <div class="gcash-qr-code">
            <!-- Add your GCash QR code image or HTML here -->
            <img src="images\gcash qr code.jpg" alt="GCash QR Code" style="width: 242px;">
        </div>
        <label for="payment_screenshot">Upload Payment Screenshot:</label>
        <input type="file" name="payment_screenshot" accept="image/*" required>
    <?php endif; ?>
    <input type="submit" value="Place Order" class="btn <?php if($fetch_profile['address'] == '' || (isset($_POST['method']) && $_POST['method'] === 'gcash')) { echo 'disabled'; } ?>" style="width: 100%; background: var(--red); color: var(--white);" name="submit">
   </form>
</section>

<!-- footer section starts -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->

<!-- custom js file link -->
<script src="js/modal.js"></script>
<script src="js/script.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const paymentMethodSelect = document.getElementById("payment-method");
    const gcashQrCode = document.querySelector(".gcash-qr-code");
    const paymentScreenshotInput = document.querySelector("[name='payment_screenshot']");

    paymentMethodSelect.addEventListener("change", function() {
        if (this.value === "gcash") {
            gcashQrCode.style.display = "block";
            paymentScreenshotInput.required = true;
        } else {
            gcashQrCode.style.display = "none";
            paymentScreenshotInput.required = false;
        }
    });
});
</script>

</body>
</html>
