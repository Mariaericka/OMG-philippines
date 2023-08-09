<?php
include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:index.php');
};

if(isset($_POST['delete'])){
   $cart_id = $_POST['cart_id'];
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
   $delete_cart_item->execute([$cart_id]);
   $message[] = 'cart item deleted!';
}

if(isset($_POST['delete_all'])){
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
   $delete_cart_item->execute([$user_id]);
   $message[] = 'deleted all from cart!';
}

if(isset($_POST['update_qty'])){
   $cart_id = $_POST['cart_id'];
   $qty = $_POST['qty'];
   $qty = filter_var($qty, FILTER_SANITIZE_STRING);
   $update_qty = $conn->prepare("UPDATE `cart` SET quantity = ? WHERE id = ?");
   $update_qty->execute([$qty, $cart_id]);
   $message[] = 'cart quantity updated';
}

$grand_total = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>OMGPH CART</title>
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
   <h3>Your Cart</h3>
</div>

<!-- shopping cart section starts  -->
<section class="products">
   <div class="box-container">

      <?php
      // Fetch and display add-ons for each cart item
      $select_cart = $conn->prepare("SELECT c.*, p.priceR, pa.addon_id, a.name AS addon_name, a.price AS addon_price FROM `cart` c INNER JOIN `products` p ON c.pid = p.id LEFT JOIN `product_addons` pa ON c.pid = pa.product_id LEFT JOIN `addons` a ON pa.addon_id = a.id WHERE c.user_id = ?");
      $select_cart->execute([$user_id]);

      if ($select_cart->rowCount() > 0) {
         while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
            $size = $fetch_cart['size'];
            $select_product_price = $conn->prepare("SELECT price, priceR FROM products WHERE id = ?");
            $select_product_price->execute([$fetch_cart['pid']]);
            $product_price = $select_product_price->fetch(PDO::FETCH_ASSOC);
            $price = $size === 'large' ? $product_price['priceR'] : $product_price['price'];
            $sub_total = $price * $fetch_cart['quantity'];
            $grand_total += $sub_total;
      ?>

      <form action="" method="post" class="box">
         <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
         <button type="submit" class="fas fa-times" name="delete" onclick="return confirm('Delete this item?');"></button>
         <img src="images/<?= $fetch_cart['image']; ?>" alt="">
         <div class="name"><?= $fetch_cart['name']; ?></div>
         <div class="flex">
            <div class="price"><span>₱</span><?= $price; ?></div>
            <input type="number" name="qty" class="qty" min="1" max="99" value="<?= $fetch_cart['quantity']; ?>" maxlength="2">
            <button type="submit" class="fas fa-edit" name="update_qty"></button>
         </div>
         
         <div class="sub-total">Sub total: <span>₱<?= $sub_total; ?>/-</span></div>

       
      </form>

      <?php
         }
      } else {
         echo '<p class="empty">Your cart is empty</p>';
      }
      ?>
   </div>

   <div class="cart-total">
      <p>Cart Total: <span>₱<?= $grand_total; ?></span></p>
      <a href="checkout.php" class="btn <?= ($grand_total > 1) ? '' : 'disabled'; ?>">Proceed to Checkout</a>
   </div>

   <div class="more-btn">
      <form action="" method="post">
         <button type="submit" class="delete-btn <?= ($grand_total > 1) ? '' : 'disabled'; ?>" name="delete_all" onclick="return confirm('Delete all from cart?');">Delete All</button>
      </form>
      <a href="menu.php" class="btn">Continue Shopping</a>
   </div>
</section>

<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->

<!-- custom js file link  -->
<script src="js/script.js"></script>
<script src="js/modal.js"></script>

</body>
</html>
