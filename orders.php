<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:index.php');
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Orders</title>
   <link rel="icon"  href="images/omg-logo.png">

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style2.css">

</head>
<body>
   
<!-- header section starts  -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->

<div class="heading">
   <h3>Orders</h3>
</div>

<section class="orders">

   <h1 class="title">your orders</h1>

   <div class="box-container">

   <?php
      if($user_id == ''){
         echo '<p class="empty">please login to see your orders</p>';
      }else{
         $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");
         $select_orders->execute([$user_id]);
         if($select_orders->rowCount() > 0){
            while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
      // Retrieve the order details from the `orders` table
      $order_id = $fetch_orders['id'];
      $order_total_products = $fetch_orders['total_products'];

      // Calculate the total price for the current order
      $order_total_price = 0;
      $order_products = explode(' - ', $order_total_products); // Convert total products string to an array
      foreach ($order_products as $product) {
         // Split the product string to get the price and quantity
         $product_parts = explode(' (', $product);
         if (count($product_parts) === 2) {
            list($product_name, $product_price_quantity) = $product_parts;
            list($product_price, $product_quantity) = explode(' x ', $product_price_quantity);

            // Calculate and accumulate the total price for the current order
            $order_total_price += intval($product_price) * intval($product_quantity);
         }
      }

   ?>
   <div class="box">
      <p>placed on : <span><?= $fetch_orders['placed_on']; ?></span></p>
   

      <p>your orders : <span><?= $fetch_orders['total_products']; ?></span></p>
      <p>total price : <span>₱<?= number_format($order_total_price, 2); ?>/-</span></p>
      <p> payment status : <span style="color:<?php if($fetch_orders['payment_status'] == 'pending'){ echo 'red'; }else{ echo 'green'; }; ?>"><?= $fetch_orders['payment_status']; ?></span> </p>
<br>
      <p>name : <span><?= $fetch_orders['name']; ?></span></p>
      <p>email : <span><?= $fetch_orders['email']; ?></span></p>
      <p>number : <span><?= $fetch_orders['number']; ?></span></p>
<br>      
      <p>payment method : <span><?= $fetch_orders['method']; ?></span></p>
      <p>address : <span><?= $fetch_orders['address']; ?></span></p>

      <?php if ($fetch_orders['status'] == 'Cancelled'): ?>
                     <p>Status: <span style="color: red;">Cancelled</span></p>
                     <p>Reason for Cancellation: <?= $fetch_orders['cancel_reason']; ?></p>
                  <?php else: ?>
                     <a href="cancel_order.php?order_id=<?= $fetch_orders['id']; ?>" class="btn">Cancel Order</a>
                  <?php endif; ?>
         _______________________________________________________________________________
   </div>
   <?php
      }
      }else{
         echo '<p class="empty">no orders placed yet!</p>';
      }
      }
   ?>

   </div>

</section>










<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->






<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>