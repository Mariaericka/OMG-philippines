<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};


if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $delete_product_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
   $delete_product_image->execute([$delete_id]);
   $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
   unlink('../uploaded_img/'.$fetch_delete_image['image']);
   $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
   $delete_product->execute([$delete_id]);
   $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
   $delete_cart->execute([$delete_id]);
   header('location:products.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>OMGPH | ADMIN PAGE</title>
   <link rel="icon"  href="images/omg-logo.png">

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>
<?php include '../components/admin_header.php' ?>

<section>
   <div class="main-content">
   <div class="wrapper">
   <h1 class="heading">Manage Beverages</h1>
   <div class="col-4 btn-primary"><a href="products.php">ADD DRINK</a></div>
   <table class="tbl-full">
   <tr>
      <th class="headers">NAME</th>
      <th class="headers">REG PRICE </th>

      <th class="headers">CATEGORY</th>
      <th class="headers">IMAGE</th>
      <th class="headers last" ></th>
   </tr>
   <?php
      $show_products = $conn->prepare("SELECT * FROM `products`");
      $show_products->execute();
      if($show_products->rowCount() > 0){
         while($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)){  
   ?>  
     <tr class="table-content">
     <th><?= $fetch_products['name']; ?></th>
     <th><span>₱</span><?= $fetch_products['price']; ?></th>

        
     <th> <?= $fetch_products['category']; ?></th>
     <th><img src="../images/<?= $fetch_products['image']; ?>" alt="" width="100px"></th>
     <th>
         <a href="update_product.php?update=<?= $fetch_products['id']; ?>"><img src="../images/icons/update.png"/ class="manage-drink-icons-update"/></a>
         <a href="products.php?delete=<?= $fetch_products['id']; ?>" onclick="return confirm('delete this drink?');"><img src="../images/icons/delete.png"/ class="manage-drink-icons-delete"/></a>
     </th>
         </tr>
        </div>
   <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
   ?>
</table>
   </div>
    </div>

    </section>
<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>