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
   <title>OMGPH BEVERAGE</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/styles.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="products">

   <h3> Beverages</h3>

   <div class="box-container">

      <?php
         $category = $_GET['category'];
         $select_products = $conn->prepare("SELECT * FROM `products` WHERE category = ?");
         $select_products->execute([$category]);
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
         <a href="category.php?category=<?= $fetch_products['category']; ?>" class="cat"><?= $fetch_products['category']; ?></a>
         <h4><?= $fetch_products['name']; ?></h4>
         
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

















<?php include 'components/footer.php'; ?>


<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>


</body>
</html>