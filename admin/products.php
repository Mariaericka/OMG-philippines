<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['add_product'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   
   $desc = $_POST['description'];
   $desc = filter_var($desc, FILTER_SANITIZE_STRING);
   $price = $_POST['price'];
   $price = filter_var($price, FILTER_SANITIZE_STRING);
   $priceR = $_POST['priceR'];
   $priceR = filter_var($priceR, FILTER_SANITIZE_STRING);
  
   $category = $_POST['category'];
   $category = filter_var($category, FILTER_SANITIZE_STRING);

   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = '../uploaded_img/'.$image;

   $select_products = $conn->prepare("SELECT * FROM `products` WHERE name = ?");
   $select_products->execute([$name]);

   if($select_products->rowCount() > 0){
      $message[] = 'drink name already exists!';
   }else{
      if($image_size > 2000000){
         $message[] = 'image size is too large';
      }else{
         move_uploaded_file($image_tmp_name, $image_folder);

         $insert_product = $conn->prepare("INSERT INTO `products`(name,description, category, price,priceR, image) VALUES(?,?,?,?,?,?)");
         $insert_product->execute([$name,$desc, $category, $price,$priceR, $image]);

         $message[] = 'new drink added!';
      }

   }

}

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

<!-- add products section starts  -->

<section class="add-products">

   <form action="" method="POST" enctype="multipart/form-data">
      <h3>add product</h3>
      <input type="text" required placeholder="enter drink name" name="name" maxlength="100" class="box">
      <input type="number" min="0" max="9999999999" required placeholder=" regular drink price " name="price" onkeypress="if(this.value.length == 10) return false;" class="box">
      <input type="number" min="0" max="9999999999" required placeholder=" large drink price " name="priceR" onkeypress="if(this.value.length == 10) return false;" class="box">

      <input type="text" min="0" max="9999999999" required placeholder="description" name="description" onkeypress="if(this.value.length == 50) return false;" class="box">
      <select name="category" class="box" required>
         <option value="" disabled selected>select category --</option>
         <option value="coffee series">Coffee series</option>
         <option value="yogurt">Yogurt series</option>
         <option value="choco">Choco series</option>
         <option value="milktea">Milktea series</option>
         <option value="mango">Mango series</option>
         <option value="cheese">Cheesecake series</option>
         <option value="ventea">Ventea</option>
         <option value="promo">Promo series</option>


      </select>
      <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png, image/webp" required>
      <input type="submit" value="add drink" name="add_product" class="btn">
      <a href="manage-drink.php" class="btn">Go back</a>

   </form>

</section>

<!-- add products section ends -->

<!-- show products section starts  -->


<!-- show products section ends -->










<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>