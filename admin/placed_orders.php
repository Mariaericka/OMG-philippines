<?php
include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:admin_login.php');
}

if (isset($_POST['update_payment'])) {

   $order_id = $_POST['order_id'];
   $payment_status = $_POST['payment_status'];
   $update_status = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
   $update_status->execute([$payment_status, $order_id]);
   $message[] = 'Payment status updated!';

}

if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];
   $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
   $delete_order->execute([$delete_id]);
   header('location:placed_orders.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Placed Orders</title>
   <link rel="icon"  href="images/omg-logo.png">

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php' ?>

<!-- Placed orders section starts  -->

<section class="main-content">
<div class="wrapper">

   <h1 class="heading">Placed Orders</h1>

   <table class="tbl-full">
   <tr>
                    <th class="headers">User ID</th>
                    <th class="headers">Placed On</th>
                    <th class="headers">Order ID</th>

                    <th class="headers">Name</th>
                    <th class="headers">Email</th>
                    <th class="headers">Number</th>
                    <th class="headers">Address</th>
                    <!--<th class="headers">Add ons</th>-->

                    <th class="headers">Total price</th>
                    <th class="headers">Payment Method</th>
                    <th class="headers">Payment Status</th>
                    <th class="headers">Cancellation Reason</th>
                    <th class="headers last" colspan="3">Actions</th>

                </tr>
   <?php
      $select_orders = $conn->prepare("SELECT * FROM `orders`");
      $select_orders->execute();
      if($select_orders->rowCount() > 0){
         while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
            $order_id = $fetch_orders['id'];
              // Calculate the total price for the order, including add-ons
        $total_price = $fetch_orders['total_price'];
        $select_cart_items = $conn->prepare("SELECT addon_price FROM cart_addons WHERE cart_id IN (SELECT id FROM cart WHERE user_id = ?)");
        $select_cart_items->execute([$fetch_orders['user_id']]);
        $cart_addons = $select_cart_items->fetchAll(PDO::FETCH_ASSOC);

        // Add the prices of add-ons to the total price
        foreach ($cart_addons as $addon) {
            $total_price += $addon['addon_price'];
        }
   ?>
                        <tr class="table-content">
                        <td>  <?= $fetch_orders['user_id']; ?> </td>
                        <td> <?= $fetch_orders['placed_on']; ?> </td>
                        <td> <?= $fetch_orders['order_id']; ?> </td>

                        <td><?= $fetch_orders['name']; ?> </td>
                        <td><?= $fetch_orders['email']; ?> </td>
                        <td><?= $fetch_orders['number']; ?> </td>
                        <td><?= $fetch_orders['address']; ?> </td>
   <?php
         // Retrieve add-ons for the current order
         $select_order_addons = $conn->prepare("SELECT * FROM `cart_addons` WHERE cart_id = ?");
         $select_order_addons->execute([$order_id]);
         ?>

         <?php if ($select_order_addons->rowCount() > 0) { ?>
         
            <?php
               while ($fetch_order_addons = $select_order_addons->fetch(PDO::FETCH_ASSOC)) {
                  echo $fetch_order_addons['addon_name'] . ' (+₱' . $fetch_order_addons['addon_price'] . ') ';
               }
            ?>
      
         <?php } ?>
         <td><?= number_format($total_price, 2); ?> </td>
         <td><?= $fetch_orders['method']; ?> </td>
         <td>
                    <span style="color: <?= ($fetch_orders['payment_status'] == 'pending') ? 'red' : 'green'; ?>">
                        <?= $fetch_orders['payment_status']; ?>
                    </span>
                </td>
                <td><?= $fetch_orders['cancel_reason']; ?></td>
                <td>
                    <form action="" method="POST">
                        <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
                        <select name="payment_status" class="drop-down">
                            <option value="" selected disabled><?= $fetch_orders['payment_status']; ?></option>
                            <option value="pending">pending</option>
                            <option value="completed">completed</option>
                            <option value="to be delivered">to be delivered</option>
                        </select>
                </td>
                <td>
                    <input type="submit" value="Update" class="btn" name="update_payment">
                    </form>
                </td>
                <td>
                    <a href="placed_orders.php?delete=<?= $fetch_orders['id']; ?>"
                        onclick="return confirm('Delete this order?');">
                        <img src="../images/icons/delete.png" class="manage-drink-icons-delete" alt="Delete Order">
                    </a>
                </td>
            </tr>
      </form>
   </div>
   <?php
                    }
                } else {
                    echo '<tr><td colspan="5" class="empty">You have no order</td></tr>';
                }
                ?>
        </table>
        </div>
    </div>
</section>
<!-- Placed orders section ends -->

<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>
