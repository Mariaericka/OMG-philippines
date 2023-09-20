<?php
include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
} else {
    header('location:index.php');
    exit;
}

function fetchOrders($conn, $user_id) {
    $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");
    $select_orders->execute([$user_id]);
    return $select_orders->fetchAll(PDO::FETCH_ASSOC);
}

function calculateTotalPrice($order_cart_items) {
    $total_price = 0;

    foreach ($order_cart_items as $item) {
        $product_price = $item['price'];
        $product_quantity = $item['quantity'];
        $total_price += $product_price * $product_quantity;

        if (isset($item['addons']) && is_array($item['addons'])) {
            foreach ($item['addons'] as $addon) {
                $total_price += $addon['addon_price'];
            }
        }
    }

    return $total_price;
}

$orders = fetchOrders($conn, $user_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
    <link rel="icon"  href="images/omg-logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="css/style2.css">
</head>
<body>
      
<?php include 'components/user_header.php'; ?>

<div class="heading">
    <h3>Orders</h3>
</div>

<section class="orders">
    <h1 class="title">your orders</h1>
    <div class="box-container">
    <?php
    if(empty($orders)) {
        echo '<p class="empty">no orders placed yet!</p>';
    } else {
        foreach ($orders as $order) {
            $order_cart_items = json_decode($order['cart_addons'], true);

            if (!is_array($order_cart_items)) {
                $order_cart_items = [];
            }

            $total_price = calculateTotalPrice($order_cart_items);
    ?>

    <div class="box">
        <p>placed on : <span><?= $order['placed_on']; ?></span></p>
        <?php foreach ($order_cart_items as $item): ?>
            <p><?= $item['name']; ?> : <span>₱<?= $item['price']; ?> x <?= $item['quantity']; ?></span></p>
            <?php if (isset($item['addons']) && is_array($item['addons'])): ?>
                <?php foreach ($item['addons'] as $addon): ?>
                    <p>Addon: <?= $addon['addon_name']; ?> : <span>₱<?= $addon['addon_price']; ?> x 1</span></p>
                <?php endforeach; ?>
            <?php endif; ?>
        <?php endforeach; ?>
        <p>total price : <span>₱<?= number_format($total_price, 2); ?>/-</span></p>
        <p>status : <span style="color:<?php if($order['payment_status'] == 'pending'){ echo 'red'; } else { echo 'green'; }; ?>"><?= $order['payment_status']; ?></span> </p>
        <br>
        <p>name : <span><?= $order['name']; ?></span></p>
        <p>email : <span><?= $order['email']; ?></span></p>
        <p>number : <span><?= $order['number']; ?></span></p>
        <br>
        <p>payment method : <span><?= $order['method']; ?></span></p>
        <p>address : <span><?= $order['address']; ?></span></p>

        <?php if ($order['status'] == 'Cancelled'): ?>
        <p>Status: <span style="color: red;">Cancelled</span></p>
        <p>Reason for Cancellation: <?= $order['cancel_reason']; ?></p>
        <?php else: ?>
        <a href="cancel_order.php?order_id=<?= $order['id']; ?>" class="btn">Cancel Order</a>
        <?php endif; ?>
        _______________________________________________________________________________
    </div>

    <?php
        } // end of foreach loop
    } // end of else statement
    ?>
    </div>
</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
