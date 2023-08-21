<?php
include 'components/connect.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header('location:index.php');
    exit();
}

$order_id = $_GET['order_id'];

// Fetch order details
$select_order = $conn->prepare("SELECT * FROM `orders` WHERE order_id = ?");
$select_order->execute([$order_id]);

if ($select_order->rowCount() > 0) {
    $order = $select_order->fetch(PDO::FETCH_ASSOC);

    // Extract relevant information from the $order array
    $customerName = $order['name'];
    $orderDate = $order['placed_on'];
    $totalPrice = $order['total_price'];
    $orderProducts = json_decode($order['total_products'], true);
} else {
    echo 'Order not found.';
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Placed Order Details</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- Header section -->
<?php include 'components/header.php'; ?>

<!-- Order details section -->
<div class="container">
    <h2>Order Details</h2>
    <p><strong>Customer Name:</strong> <?= $customerName; ?></p>
    <p><strong>Order Date:</strong> <?= $orderDate; ?></p>
</div>

<!-- Ordered products section -->
<div class="container">
    <h3>Ordered Products</h3>
    <?php foreach ($orderProducts as $product) : ?>
        <div class="product">
            <p><strong>Product Name:</strong> <?= $product['name']; ?></p>
            <p><strong>Quantity:</strong> <?= $product['quantity']; ?></p>
            <!-- Fetch and display add-ons for this product -->
            <?php
            $select_addons = $conn->prepare("SELECT addon_name, addon_price FROM `cart_addons` WHERE cart_id = ?");
            $select_addons->execute([$product['cart_id']]);

            if ($select_addons->rowCount() > 0) {
                echo '<p><strong>Add-ons:</strong></p>';
                echo '<ul>';
                while ($addon = $select_addons->fetch(PDO::FETCH_ASSOC)) {
                    echo '<li>' . $addon['addon_name'] . ' (+₱' . $addon['addon_price'] . ')</li>';
                }
                echo '</ul>';
            }
            ?>
        </div>
    <?php endforeach; ?>
</div>

<!-- Total price section -->
<div class="container">
    <h3>Total Price:</h3>
    <p>₱<?= $totalPrice; ?></p>
</div>

<!-- Footer section -->
<?php include 'components/footer.php'; ?>

</body>
</html>
