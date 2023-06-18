<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include 'components/add_cart.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>menu</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style2.css">

</head>
<body>
   
<!-- header section starts  -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->


<!-- menu section starts  -->
<div class="second"><ul>
    <h1>Categories</h1> <br>
    <li> <a href="menu.php" class="button14">Back To Main Menu</a></li>
        <li> <a href="category.php?category=coffee series" class="button14">COFFEE SERIES</a></li>
        <li> <a href="category.php?category=yogurt"  class="button14">YOGURT SERIES</a></li>
        <li> <a href="category.php?category=choco" class="button14">CHOCO SERIES</a></li>
        <li><a href="category.php?category=milktea" class="button14">MILKTEA SERIES</a></li>
        <li><a href="category.php?category=mango" class="button14">MANGO SERIES</a></li>
      </ul>
    </div>


<!-- menu section ends -->






 -->













<div class="loader">
   <img src="images/loading.gif" alt="">
</div>



<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->








<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>