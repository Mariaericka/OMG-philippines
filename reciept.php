<?php

include 'components/connect.php';


// Retrieve the order ID from the URL query parameter
if (isset($_GET['order_id'])) {
   $order_id = $_GET['order_id'];

   // Fetch the order details from the database using the order ID
   $fetch_order = $conn->prepare("SELECT * FROM `orders` WHERE order_id = ?");
   $fetch_order->execute([$order_id]);

   if ($fetch_order->rowCount() > 0) {
       $order_data = $fetch_order->fetch(PDO::FETCH_ASSOC);
       // Extract the order details
       $name = $order_data['name'];
       $total_products = $order_data['total_products'];
       $method = $order_data ['method'];
       $total_price = $order_data['total_price'];
;?>


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
   <p><strong>Order ID:</strong> <?= $order_id; ?></p>
   <p><strong>Name:</strong> <?= $name; ?></p>
   <p><strong>Total Products:</strong> <?= $total_products; ?></p>
   <p><strong>Total Price:</strong> ₱<?= $total_price+= $sub_total; ?></p>
   <p><strong>Payment Method</strong> <?= $method; ?></p>

   <h3>Order Details</h3>
 
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
<?php
    } else {
        // Handle the case when the order ID is not found in the database
        echo "Order not found.";
    }
} else {
    // Handle the case when the order ID is not provided in the URL
    echo "Order ID not provided.";
}
?>