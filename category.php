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
   <link rel="icon"  href="images/omg-logo.png">

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
        <li><a href="category.php?category=promo" class="button14">PROMO<i class="fa fa-chevron-right" aria-hidden="true"></i></a></li>
  
    </ul>
    </div>
 
    <section>
 
    <div class="container2" style="box-sizing: border-box; height:900px;

margin-left: 25%;">
   



<section class="products">

  

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
         <input type="hidden" name="size" value="<?= $fetch_products['size']; ?>">

         <input type="hidden" name="priceR" value="<?= $fetch_products['description']; ?>">


         <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">
         <div class="omg-menu-img">
         <img src="images/<?= $fetch_products['image']; ?>" alt="" class="img1" onclick="openModal(<?= $fetch_products['id']; ?>)">

        </div>
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
            echo '<p class="empty">No drinks added yet!</p>';
         }
      ?>

   </div>
   </div>
 

</section>



     
<!-- The Modal -->

<?php


$category = $_GET['category'];
$select_products = $conn->prepare("SELECT * FROM `products` WHERE category = ?");
$select_products->execute([$category]);
if ($select_products->rowCount() > 0) {
    while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
        ?>


          
        <div id="costumizeOrderModal<?= $fetch_products['id']; ?>" class="backdrop">
            <!-- Modal content -->
            <div class="modal">
                <div class="modal-header">
                    <span class="close" onclick="closeModal(<?= $fetch_products['id']; ?>)">&times;</span>
                </div>
                <div class="modal-body">
                    <table>
                        <tr>
                            <td>
                                <span class="modal-label">Price:</span>
                            </td>
                            <td>
                                
                            <select class="input" id="size-dropdown<?= $fetch_products['id']; ?>" name="size[]"onchange="updateSize(<?= $fetch_products['id']; ?>)">
    <option value="regular" data-price="<?= $fetch_products['price']; ?>" selected> ₱<?= $fetch_products['price']; ?>.00</option>
<!-- <option value="large" data-price="<?= $fetch_products['priceR']; ?>">Large ₱<?= $fetch_products['priceR']; ?>.00</option> -->
</select>




                            </td>
                        </tr>
                        <tr> 
                            <td>
                                <span class="modal-label">Quantity:</span>
                            </td>
                            <form action="" method="post" class="box">

                            <td>
                            <input type="number" name="qty[]" class="qty" min="1" max="99" value="1" maxlength="2">
                            </td>
                        </tr>



                        
                    </table>
                </div>

  <!-- Add-ons section -->
  <div class="modal-body" style="flex-direction: column;">

                   
<tr>
  <td>
  <span class="modal-label">Add-ons:</span>
 
    <?php
    // Fetch the addons for the current product from the database
    $select_addons = $conn->prepare("SELECT * FROM `addons`");
    $select_addons->execute();
    $addons = $select_addons->fetchAll(PDO::FETCH_ASSOC);
    foreach ($addons as $addon) {
        ?>
      
      
        
        <label>
    <input type="checkbox" name="add_ons[<?= $addon['id']; ?>][<?= $addon['name']; ?>][<?= $addon['price']; ?>]"
           value="<?= $addon['name']; ?>">
    <?= $addon['name']; ?> (+₱<?= $addon['price']; ?>)
</label>
<input type="hidden" name="add_ons[<?= $fetch_products['id']; ?>][<?= $addon['id']; ?>][price]" value="<?= $addon['price']; ?>">

    <?php } ?>
    </td>
    </tr>
</div>
   
    

                <div class="modal-footer">

                        <input type="hidden" name="pid[]" value="<?= $fetch_products['id']; ?>">


                        <input type="hidden" name="name[]" value="<?= $fetch_products['name']; ?>">
                        <input type="hidden" name="price[]" value="<?= $fetch_products['price']; ?>">
                        <input type="hidden" name="size[]" id="size<?= $fetch_products['id']; ?>" value="regular">
                        <input type="hidden" name="priceR[]" value="<?= $fetch_products['description']; ?>">
                        <input type="hidden" name="image[]" value="<?= $fetch_products['image']; ?>">
                        <button class="btn confirm-btn" name="add_to_cart" onclick="submitForm(<?= $fetch_products['id']; ?>)">ADD TO CART</button>
                   
                    </form>
                    <button class="btn close-btn" onclick="closeModal(<?= $fetch_products['id']; ?>)">CANCEL</button>

                </div>
            </div>

        </div>

        <?php
    }
} else {
   
}
?>
      



</form>




<?php include 'components/footer.php'; ?>

<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>
<script src="js/modal.js"></script>
</body>
</html> 