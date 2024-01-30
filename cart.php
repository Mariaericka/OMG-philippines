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
   // Delete associated cart add-ons first
   $delete_cart_addons = $conn->prepare("DELETE FROM `cart_addons` WHERE cart_id = ?");
   $delete_cart_addons->execute([$cart_id]);


   // Now delete the cart item
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
   $delete_cart_item->execute([$cart_id]);


   $message[] = 'Cart item deleted!';
}


if(isset($_POST['delete_all'])){
   // Delete cart add-ons first
   $delete_cart_addons = $conn->prepare("DELETE ca FROM `cart_addons` ca INNER JOIN `cart` c ON ca.cart_id = c.id WHERE c.user_id = ?");
   $delete_cart_addons->execute([$user_id]);


   // Now delete all cart items
   $delete_cart_items = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
   $delete_cart_items->execute([$user_id]);
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






<!-- shopping cart section starts -->
<section class="products">
   <div class="center-heading">
      <div class="sticky-heading">
         
      <h3>Your Cart</h3>
       
   
        
      </div>


   </div>


   
   <div class="box-container">
      <?php
      // Fetch and display cart items
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
      ?>


      <form action="" method="post" class="box">
         <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
         <input type="hidden" name="quantity[]" id="input_quantity_<?= $fetch_cart['id']; ?>" value="<?= $fetch_cart['quantity']; ?>">


         <button type="submit" class="fa-solid fa-trash-can fa-xl" style="background-color: #FFD93D;" name="delete" onclick="return confirm('Delete this item?');"></button>
         <div class="name"><?= $fetch_cart['name']; ?></div>
         <div class="flex">
         <div class="price"><span>₱</span><?= $price; ?></div>
            <span class="minus" onclick="updateQuantity('<?= $fetch_cart['id']; ?>', 'subtract', <?= $price; ?>)">-</span>
            <span class="num" id="quantity_<?= $fetch_cart['id']; ?>"><?= $fetch_cart['quantity']; ?></span>
            <span class="plus" onclick="updateQuantity('<?= $fetch_cart['id']; ?>', 'add', <?= $price; ?>)">+</span>
          

         </div>


<!-- <input type="number" name="qty" class="qty" min="1" max="99" value="<?= $fetch_cart['quantity']; ?>" maxlength="2"> -->


         <?php
         // Display the selected add-ons
         $select_addons = $conn->prepare("SELECT ca.addon_id, a.name AS addon_name, a.price AS addon_price FROM `cart_addons` ca INNER JOIN `addons` a ON ca.addon_id = a.id WHERE ca.cart_id = ?");
         $select_addons->execute([$fetch_cart['id']]);
         
         if ($select_addons->rowCount() > 0) {
            echo '<div class="addons">';
            echo '<p>Selected Add-ons:</p>';
           
            while ($addon = $select_addons->fetch(PDO::FETCH_ASSOC)) {
               echo '<p>' . $addon['addon_name'] . ' (+₱' . $addon['addon_price'] . ')</p>';
               $sub_total += $addon['addon_price']; // Calculate total add-ons price
            }
           
            echo '</div>';
         }
         ?>    
         <div class="sub-total">Sub total: <span id="subTotal_<?= $fetch_cart['id']; ?>">₱<?= $sub_total; ?></span></div>

      </form>
     
      <?php
            $grand_total += $sub_total;
         }
      } else {
         echo '<p class="empty">Your cart is empty</p>';
      }
      ?>
   </div>
   <div class="sticky-heading">
   
  <p>Cart Total:<span id="cartTotal">₱<?= $grand_total; ?></span></p>  
   

<!-- Timer display -->
<div id="timer" style="font-size: 18px; color: #FF0000;text-align: center;"></div>
<div id="timerMessage" style="font-size: 16px; color: #666;text-align: center;"></div>



   <div class="more-btn">
      <form action="" method="post">
         <button type="submit" class="delete-btn <?= ($grand_total > 1) ? '' : 'disabled'; ?>" name="delete_all" onclick="return confirm('Delete all from cart?');">Delete All</button>
      </form>
      <a href="menu.php" class="continue-btn">Continue Shopping</a>
            <a href="checkout.php" class="checkout-btn" <?= ($grand_total > 0) ? '' : 'disabled'; ?>">Proceed to Checkout</a>
      </div>
   </div> 



 



</section>


<!-- footer section starts -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->


<!-- custom js file link -->
<script src="js\script.js"></script>
<script src="js/modal.js"></script>
<!-- Add this before your cart.js script tag -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


<script src="js/cart.js"></script>
<script>
  // Set the timer duration in seconds
  const timerDuration = 300; // 5 minutes in this example
  let remainingTime = timerDuration;
// Display initial timer message
document.getElementById('timerMessage').innerHTML = 'Your cart will be cleared in 5 minutes.';
  // Update the timer every second
  const timerInterval = setInterval(updateTimer, 1000);

  function updateTimer() {
    // Display the remaining time
    document.getElementById('timer').innerHTML = `Time remaining: ${formatTime(remainingTime)}`;

    // If time runs out, remove cart items and stop the timer
    if (remainingTime <= 0) {
      clearCart();
      clearInterval(timerInterval);
      // Reload the page after clearing the cart
      location.reload();
    }

    remainingTime--;
  }

  function formatTime(seconds) {
    const minutes = Math.floor(seconds / 60);
    const remainingSeconds = seconds % 60;
    return `${minutes}:${remainingSeconds < 10 ? '0' : ''}${remainingSeconds}`;
  }

  function clearCart() {
    // Use AJAX to call the PHP script that deletes cart items
    $.ajax({
      url: 'clear_cart.php', // Replace with the actual URL of your PHP script
      type: 'POST',
      data: { clear_cart: true }, // Additional data if needed
      success: function (response) {
        console.log(response); // Log the response for debugging
        // You can update the UI or redirect the user as needed
      },
      error: function (error) {
        console.error(error); // Log any errors for debugging
      }
    });
  }
</script>

</body>
</html>