<?php
session_start();
include 'components/connect.php';

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
   header('location:index.php');
}

if (isset($_GET['order_id'])) {
   $order_id = $_GET['order_id'];
}

if (isset($_POST['submit'])) {
   $cancel_reason = $_POST['cancel_reason'];
   // Update the order status to "Cancelled" and set the cancellation reason in the database
   $update_order = $conn->prepare("UPDATE `orders` SET status = 'Cancelled', cancel_reason = ? WHERE id = ? AND user_id = ?");
   $update_order->execute([$cancel_reason, $order_id, $user_id]);
   header('location:orders.php'); // Redirect back to the orders page after cancellation
}
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
<br><br>
<br><br>

<section>
   <div class="box container">
    <div class="box">
      <h2>Cancel Order</h2>
      <form action="" method="post">
         <textarea name="cancel_reason" placeholder="Reason for cancellation" required></textarea>
         <input type="submit" name="submit" value="Submit" class="btn">
      </form>
   </div>
</div>
</section>
<br><br>
<br><br><br><br>




<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->



<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>


</html>