<?php
include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
}

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
<div class="second">
   <ul>
      <br>
      <h1>Categories</h1>
      <li><a href="menu.php" class="button14"><i class="fa fa-long-arrow-left" style=""></i> Go Back</a></li>
      <li><a href="category.php?category=coffee series" class="button14">COFFEE SERIES<i class="fa fa-chevron-right" aria-hidden="true"></i></a></li>
      <li><a href="category.php?category=yogurt" class="button14">YOGURT SERIES<i class="fa fa-chevron-right" aria-hidden="true"></i></a></li>
      <li><a href="category.php?category=choco" class="button14">CHOCO SERIES<i class="fa fa-chevron-right" aria-hidden="true"></i></a></li>
      <li><a href="category.php?category=milktea" class="button14">MILKTEA SERIES<i class="fa fa-chevron-right" aria-hidden="true"></i></a></li>
      <li><a href="category.php?category=mango" class="button14">MANGO SERIES<i class="fa fa-chevron-right" aria-hidden="true"></i></a></li>
   </ul>
</div>

<section>
   <div class="container2" style="box-sizing: border-box; height: 800px; margin-left: 25%;">
      <section class="products">
         <div class="box-container">
            <?php
            $category = $_GET['category'];
            $select_products = $conn->prepare("SELECT * FROM `products` WHERE category = ?");
            $select_products->execute([$category]);
            if ($select_products->rowCount() > 0) {
               while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
            ?>
                  <div class="box">
                     <div class="omg-menu-img">
                        <img src="images/<?= $fetch_products['image']; ?>" alt="" class="img1" onclick="openModal('<?= $fetch_products['id']; ?>', '<?= $fetch_products['name']; ?>', '<?= $fetch_products['price']; ?>', '<?= $fetch_products['priceR']; ?>', '<?= $fetch_products['image']; ?>')">
                     </div>
                     <div class="cat"><?= $fetch_products['name']; ?></div>
                     <h4 style="font-size: initial; background-color: #FFD93D;"> Starts at <span>₱</span><?= $fetch_products['price']; ?>.00</h4>
                     <h4 style="font-size: initial; background-color: #FFD93D;"> Starts at <span>₱</span><?= $fetch_products['priceR']; ?>.00</h4>
                     <div class="omg-menu-desc">
                        <?= $fetch_products['description']; ?>
                     </div>
                  </div>
                  <div id="costumizeOrderModal<?= $fetch_products['id']; ?>" class="backdrop">
                     <div class="modal">
                        <div class="modal-header">
                           <span class="close" onclick="closeModal(<?= $fetch_products['id']; ?>)">&times;</span>
                        </div>
                        <div class="modal-body">
                           <table>
                              <tr>
                                 <td>
                                    <span class="modal-label">Size:</span>
                                 </td>
                                 <td>
                                    <select class="input" id="size-dropdown<?= $fetch_products['id']; ?>">
                                       <option value="small" selected>Regular <span>₱</span><span id="modal-regular-price<?= $fetch_products['id']; ?>"></span><?= $fetch_products['price']; ?>.00</option>
                                       <option value="large">Large <span>₱</span><span id="modal-large-price<?= $fetch_products['id']; ?>"></span><?= $fetch_products['priceR']; ?>.00</option>
                                    </select>
                                 </td>
                              </tr>
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
                           <button class="btn confirm-btn" onclick="addToCart(<?= $fetch_products['id']; ?>)">ADD TO CART</button>
                           <button class="btn close-btn" onclick="closeModal(<?= $fetch_products['id']; ?>)">CANCEL</button>
                        </div>
                     </div>
                  </div>
            <?php
               }
            } else {
               echo '<p class="empty">No drinks added yet!</p>';
            }
            ?>
         </div>
      </section>
   </div>
</section>

<?php include 'components/footer.php'; ?>

<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
<script src="js/script.js"></script>
<script src="js/modal.js"></script>

</body>
</html>
