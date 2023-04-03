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
   <link rel="stylesheet" href="css/stylez.css">

</head>
<body>
   
<!-- header section starts  -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->

<div class="heading">
   <h3>OMG DRINKS</h3>
</div>

<!-- menu section starts  -->
<section class="category">

   <h3 >Categories</h3>

   <div class="box-container">

      <a href="category.php?category=coffee series" class="box">
         <img src="images/drinks/caramel macchiato1.png" alt="">
         <h3>Coffee Series</h3>
      </a>

      <a href="category.php?category=yogurt" class="box">
         <img src="images/strawberry yogurt2.png" alt="">
         <h3>Yogurt Series</h3>
      </a>

      <a href="category.php?category=choco" class="box">
         <img src="images/kisses choco1.png" alt="">
         <h3>Choco Series</h3>
      </a>

      <a href="category.php?category=milktea" class="box">
         <img src="images/okinawa milktea.png" alt="">
         <h3>Milktea Series</h3>
      </a>
      <a href="category.php?category=mango" class="box">
         <img src="images/mango fruit yogurt3.png" alt="">
         <h3>Mango Series</h3>
      </a>

   </div>

</section>


<section class="products">

   <h3>Latest Beverage</h3>

   <div class="box-container">

      <?php
         $select_products = $conn->prepare("SELECT * FROM `products`");
         $select_products->execute();
         if($select_products->rowCount() > 0){
            while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
      ?>
      <form action="" method="post" class="box">
         <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
         <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
         <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
         <input type="hidden" name="priceR" value="<?= $fetch_products['description']; ?>">


         <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">
         <div class="omg-menu-img">

         <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="" class="img1"></div>
         <div class="cat"><?= $fetch_products['name']; ?></div>
         <a href="category.php?category=<?= $fetch_products['category']; ?>" ><?= $fetch_products['category']; ?></a>

            <div class="cat"><span>₱</span><?= $fetch_products['price']; ?></div>
           Qty <input type="number" name="qty" class="qty" min="1" max="99" value="1" maxlength="2">
            <p class="omg-detail">
                            <div class="omg-menu-desc">
                            <?= $fetch_products['description']; ?>
                                    </p></div>
     <button type="submit" name="add_to_cart" class="btn">ADD TO CART</button>
    

         
      </form>
      <?php
            }
         }else{
            echo '<p class="empty">no drinks added yet!</p>';
         }
      ?>

   </div>

</section>


<!-- menu section ends -->
























<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->








<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>