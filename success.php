<?php
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

    echo "Order placed successfully and cart cleared!";
} else {
    echo "Payment verification failed!";
}

?>
