<?php
include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
} else {
   // Handle the case when user ID is not set (redirect or error handling)
   echo 'User ID not set.';
   exit(); // Stop further execution
}

if (isset($_POST['clear_cart'])) {
    // Delete cart add-ons first
    $delete_cart_addons = $conn->prepare("DELETE ca FROM `cart_addons` ca INNER JOIN `cart` c ON ca.cart_id = c.id WHERE c.user_id = ?");
    $delete_cart_addons->execute([$user_id]);

    // Now delete all cart items
    $delete_cart_items = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
    $delete_cart_items->execute([$user_id]);

    echo 'Cart items deleted successfully!';
    // You can include additional logic or echo messages as needed
}
?>
