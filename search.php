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
   <title>OMG Philippines</title>
   <link rel="icon"  href="images/omg-logo.png">
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style2.css">
   <link rel="stylesheet" href="css/modal.css">


</head>
<body>
   
<!-- header section starts  -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->

<!-- search form section starts  -->

<section class="search-form">
   <form method="post" action="">
      <input type="text" name="search_box" placeholder="search here..." class="box">
      <button type="submit" name="search_btn" class="fas fa-search"></button>
   </form>
</section>

<!-- search form section ends -->


<section class="products" style="min-height: 100vh; padding-top:0;">

<div class="box-container">

      <?php
         if(isset($_POST['search_box']) OR isset($_POST['search_btn'])){
         $search_box = $_POST['search_box'];
         $select_products = $conn->prepare("SELECT * FROM `products` WHERE name LIKE '%{$search_box}%'");
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

         <img src="images/<?= $fetch_products['image']; ?>" alt="" class="img1" onclick="openModal()"></div>
         <div class="cat"><?= $fetch_products['name']; ?></div>
         <h4 style="font-size: initial; background-color: #FFD93D;"> Starts at <span>₱</span><?= $fetch_products['price']; ?>.00</h4>
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
            echo '<p class="empty">No results found</p>';
         }
      }
      ?>

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
                     <option value="small" selected>Regular</option>
                     <option value="large">Large</option>
                  </select>
               </td>
               <tr>
               <td>
                  <span class="modal-label">Quantity:</span>
               </td>
               <td>
           <input type="number" name="qty" class="qty" min="1" max="99" value="1" maxlength="2">
           </td>
            </tr>
         </table>
      </div>
      <div class="modal-footer">
         <button class="btn confirm-btn" name="add_to_cart">ADD TO CART</button>
         <button class="btn close-btn" onclick="closeModal()">CANCEL</button>
      </div>
  </div>


</div>






<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->







<!-- custom js file link  -->
<script src="js/script.js"></script>
<script src="js/modal.js"></script>

</body>
</html>