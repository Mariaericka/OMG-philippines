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
        <li> <a href="category.php?category=coffee series" class="button14">COFFEE SERIES</a></li>
        <li> <a href="category.php?category=yogurt"  class="button14">YOGURT SERIES</a></li>
        <li> <a href="category.php?category=choco" class="button14">CHOCO SERIES</a></li>
        <li><a href="category.php?category=milktea" class="button14">MILKTEA SERIES</a></li>
        <li><a href="category.php?category=mango" class="button14">MANGO SERIES</a></li>
      </ul>
    </div>
    <section>
    <div class="container2" style="box-sizing: border-box;
background: #FFBE00;
border: 5px solid #000000;
border-radius: 50px;
height: 1000px;
margin-left: 25%;">
       
       <div class="omg-menu">     
        <div class="omg-menu-box1">
        <div class="omg-menu-img"> <img src="images/caramel macchiato1.png" img class="img1"></div>
       <h2 class="omg-menu-desc">Caramel Macchiato </h2> </div>
       <div class="omg-menu-box1">
           <div class="omg-menu-img"> <img src="images/cappucino2.png" img class="img1"></a></div>
            <h2 class="omg-menu-desc">Cappucino </h2></div>

            <div class="omg-menu-box1">
           <div class="omg-menu-img"> <img src="images/mocha3.png" img class="img1"></a></div>
            <h2 class="omg-menu-desc">Mocha</h2></div>

            <div class="omg-menu-box1">
            <div class="omg-menu-img"> <img src="images/coffee crumble4.png" img class="img1"></a></div>
             <h2 class="omg-menu-desc">Coffee Crumble</h2></div>

             <div class="omg-menu-box1">
        <div class="omg-menu-img"> <img src="images/bluebery yogurt1.png" img class="img1"></a></div>
         <h2 class="omg-menu-desc">Blueberry Yogurt </h2></div>

         <div class="omg-menu-box1">
        <div class="omg-menu-img"> <img src="images/strawberry yogurt2.png" img class="img1"></a></div>
         <h2 class="omg-menu-desc">Strawberry Yogurt </h2> </div>
          <div class="omg-menu-box1">
        <div class="omg-menu-img"> <img src="images/mango fruit yogurt3.png" img class="img1"></a></div>
         <h2 class="omg-menu-desc">Mango Fruit Yogurt</h2></div>

            </div>


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

         <img src="images/<?= $fetch_products['image']; ?>" alt="" class="img1"></div>
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