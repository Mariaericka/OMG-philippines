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
   <link rel="stylesheet" href="css/style2.css">
   <link rel="stylesheet" href="css/modal.css">
</head>
<body>
   
<?php include 'components/user_header.php'; ?>
<div class="second"><ul>
    <br> <h1>Categories</h1>
    <li> <a href="menu.php" class="button14"><i class="fa fa-long-arrow-left" style=""></i> Go Back</a></li>

        <li> <a href="category.php?category=coffee series" class="button14">COFFEE SERIES<i class="fa fa-chevron-right" aria-hidden="true"></i></a></li>
        <li> <a href="category.php?category=yogurt"  class="button14">YOGURT SERIES<i class="fa fa-chevron-right" aria-hidden="true"></i></a></li>
        <li> <a href="category.php?category=choco" class="button14">CHOCO SERIES<i class="fa fa-chevron-right" aria-hidden="true"></i></a></li>
        <li><a href="category.php?category=milktea" class="button14">MILKTEA SERIES<i class="fa fa-chevron-right" aria-hidden="true"></i></a></li>
        <li><a href="category.php?category=mango" class="button14">MANGO SERIES<i class="fa fa-chevron-right" aria-hidden="true"></i></a></li>
      </ul>
    </div>
    <section>
    <div class="container2" style="box-sizing: border-box;

border: 2px solid #000000;

height: 800px;
margin-left: 25%;">




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

         <img src="images/<?= $fetch_products['image']; ?>" alt="" class="img1" onclick="openModal()"></div>
         <h4 style="font-size: initial;"><?= $fetch_products['name']; ?></h4>
         
            <div class="cat"><span>₱</span><?= $fetch_products['price']; ?></div>
           <!-- Qty <input type="number" name="qty" class="qty" min="1" max="99" value="1" maxlength="2"> -->
            <p class="omg-detail">
                            <div class="omg-menu-desc">
                            <?= $fetch_products['description']; ?>
                                    </p></div>
                 
        <!-- <button type="submit" name="add_to_cart" class="btn">ADD TO CART</button> -->

         
      </form>
      <?php
            }
         }else{
            echo '<p class="empty">No drinks added yet!</p>';
         }
      ?>

   </div>
   </div>
</section>


    



     






<!-- The Modal -->
<div id="costumizeOrderModal" class="backdrop">

  <!-- Modal content -->
  <div class="modal">
      <div class="modal-header">
         <span class="close" onclick="closeModal()">&times;</span>
      </div>
      <div class="modal-body">
         <table>
            <tr>
               <td>
                  <span class="modal-label">Size:</span>
               </td>
               <td>
                  <select class="input" id="size-dropdown">
                     <option value="small" selected>Small</option>
                     <option value="medium">Medium</option>
                     <option value="large">Large</option>
                  </select>
               </td>
               <tr>
               <td>
                  <span class="modal-label">Quantity:</span>
               </td>
               <td>
                  <input class="input" type="number"/>
               </td>
            </tr>
         </table>
      </div>
      <div class="modal-footer">
         <button class="btn confirm-btn">ADD TO CART</button>
         <button class="btn close-btn">CANCEL</button>
      </div>
  </div>


</div>



<?php include 'components/footer.php'; ?>


<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>
<script src="js/modal.js"></script>
</body>
</html>