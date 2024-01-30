<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:index.php');
};

if(isset($_POST['submit'])){

   $address = $_POST['number'] .' '.$_POST['street'].', '.$_POST['brgy'].', '.$_POST['city'] .', '. $_POST['province'] .', '. $_POST['region'] .', '. $_POST['country'] .' , '. $_POST['postal'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);

   $update_address = $conn->prepare("UPDATE `users` set address = ? WHERE id = ?");
   $update_address->execute([$address, $user_id]);

   $message[] = 'Address saved!';

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Update Address</title>
   <link rel="icon"  href="images/omg-logo.png">

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style2.css">

</head>
<body>
   
<?php include 'components/user_header.php' ?>

<section class="form-container">

   <form action="" method="post">
      <h3>your address</h3>
      <input type="text" class="box" placeholder="Unit no/house no./building no." required maxlength="50" name="number">
      <input type="text" class="box" placeholder="Street name" required maxlength="50" name="street">
      <input type="text" class="box" placeholder="Barangay" required maxlength="50" name="brgy">
      <input type="text" class="box" placeholder="Province" required maxlength="50" name="province">
      <input type="text" class="box" placeholder="City" required maxlength="50" name="city">
      <input type="text" class="box" placeholder="Region" required maxlength="50" name="region">
      <input type="number" class="box" placeholder="Postal code" required max="999999" min="0" maxlength="6" name="postal">
      <input type="text" class="box" placeholder="Country" required maxlength="50" name="country">
      <input type="submit" value="Save address" name="submit" class="btn">
   </form>

</section>










<?php include 'components/footer.php' ?>







<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>