<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:index.php');
};?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Order Receipt</title>
   <link rel="icon"  href="images/omg-logo.png">

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style2.css">

   <!-- custom inline CSS for receipt layout -->
  
</head>
<body>
   
<!-- header section starts  -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->

<div class="heading">
   <h3>Order Summary</h3>
   <p><a href="index.php">Home</a> <span> / checkout</span></p>
</div>

<section class="checkout">

<div class="receipt">
   <h2>Order Receipt</h2>
   <p>Order ID: <?php echo $order_id; ?></p>
   <p>Date: <?php echo date("Y-m-d H:i:s"); ?></p>
   <p>Name: <?php echo $name; ?></p>
   <p>Email: <?php echo $email; ?></p>
   <p>Delivery Address: <?php echo $address; ?></p>
   <p>Payment Method: <?php echo $method; ?></p>
   <hr>
   <h3>Order Details</h3>
   <?php
      // Loop through the cart items to display order details
      while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
         $size = $fetch_cart['size'];
         $select_product_price = $conn->prepare("SELECT price, priceR FROM products WHERE id = ?");
         $select_product_price->execute([$fetch_cart['pid']]);
         $product_price = $select_product_price->fetch(PDO::FETCH_ASSOC);
         $price = $size === 'large' ? $product_price['priceR'] : $product_price['price'];
   ?>
   <p><span class="name"><?= $fetch_cart['name']; ?></span><span class="price">₱<?= $price; ?> x <?= $fetch_cart['quantity']; ?></span></p>
   <?php
      }
   ?>
   <hr>
   <p class="total">Total Price: ₱<?php echo $grand_total; ?>/-</p>
   <p class="message">Thank you for placing your order. It will be delivered to the provided address soon!</p>
</div>
   
</section>

<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->

<script src="js/modal.js"></script>
<script src="js/script.js"></script>

</body>
</html>
