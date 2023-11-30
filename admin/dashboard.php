<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>OMGPH | ADMIN PAGE</title>
   <link rel="icon"  href="images/omg-logo.png">

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php' ?>

<!-- admin dashboard section starts  -->

<div class="main-content">
<div class="wrapper">
   <h1 class="heading">dashboard</h1>
   <div class="col-4 text-center">
   <?php
$total_pendings = 0;
$select_pendings = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
$select_pendings->execute(['pending']);

while ($fetch_pendings = $select_pendings->fetch(PDO::FETCH_ASSOC)) {
    // Parse the JSON string representing the order items and addons
    $order_items = json_decode($fetch_pendings['cart_addons'], true);

    // Calculate the total price for order items
    $order_total = 0;
    foreach ($order_items as $item) {
        $item_price = isset($item['price']) ? $item['price'] : 0;
        $item_quantity = isset($item['quantity']) ? $item['quantity'] : 1;
        $order_total += $item_price * $item_quantity;
        
        // Calculate the total price for addons (if any)
        if (isset($item['addons']) && is_array($item['addons'])) {
            foreach ($item['addons'] as $addon) {
                $addon_price = isset($addon['addon_price']) ? $addon['addon_price'] : 0;
                $addon_quantity = isset($addon['quantity']) ? $addon['quantity'] : 1;
                $order_total += $addon_price * $addon_quantity;
            }
        }
    }

    // Add the order total to the overall total_pendings
    $total_pendings += $order_total;
}
?>

<h3><span>₱</span><?= $total_pendings; ?><span></span></h3>


      <div class="dashboardicons"><img src="../images/icons/pending.png"><p>total pendings</p></div>
      <a href="placed_orders.php" class="btn">see orders</a>
   </div>

   <div class="col-4 text-center">
      <?php
         $total_completes = 0;
         $select_completes = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
         $select_completes->execute(['completed']);
         while($fetch_completes = $select_completes->fetch(PDO::FETCH_ASSOC)){
            $total_completes += $fetch_completes['total_price'];
         }
      ?>
      <h3><span>₱</span></span><?=$total_completes; ?><span></span></h3>
      <div class="dashboardicons"><img src="../images/icons/completed.png"><p>total completes</p></div>
      <a href="placed_orders.php" class="btn">see orders</a>
   </div>

   <div class="col-4 text-center">
      <?php
         $select_orders = $conn->prepare("SELECT * FROM `orders`");
         $select_orders->execute();
         $numbers_of_orders = $select_orders->rowCount();
      ?>
      <h3><?= $numbers_of_orders; ?></h3>
      <div class="dashboardicons"><img src="../images/icons/total_order.png"><p>total orders</p></div>
      <a href="placed_orders.php" class="btn">see orders</a>
   </div>

   <div class="col-4 text-center">
      <?php
         $select_products = $conn->prepare("SELECT * FROM `products`");
         $select_products->execute();
         $numbers_of_products = $select_products->rowCount();
      ?>
      <h3><?= $numbers_of_products; ?></h3>
      <div class="dashboardicons"><img src="../images/icons/beverage.png"><p>beverages added</p></div>
      <a href="products.php" class="btn">see products</a>
   </div>
   <div class="col-4 text-center">
      <?php
         $select_messages = $conn->prepare("SELECT * FROM `messages`");
         $select_messages->execute();
         $numbers_of_messages = $select_messages->rowCount();
      ?>
      <h3><?= $numbers_of_messages; ?></h3>
      <div class="dashboardicons"><img src="../images/icons/messages.png"><p>new messages</p></div>
      <a href="messages.php" class="btn">see messages</a>
   </div>

   
      </div>
      </div>
<script src="../js/admin_script.js"></script>

</body>
</html>