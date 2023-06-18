<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include 'components/add_cart.php';
$select_categories = $conn->prepare("SELECT * FROM `omg_categories`");
$select_categories->execute();
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
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

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
    <div class="flex-container">
    <?php
    // Fetch the results using a while loop
    while ($row = $select_categories->fetch(PDO::FETCH_ASSOC)) {
        $category_name = $row['category_name'];
        $category_image = $row['category_img'];
        $category_id = $row['category_id'];
        echo '<div><img src="images/category/sample.jpg" height="100px" width="100px" onclick="selectCategory('.$category_id.')"/><br>'.$category_name.'</div>';
    }
    ?>
    </div>
    </div>
<div>
</div>

<div class="loader">
   <img src="images/loading.gif" alt="">
</div>
<!-- footer section starts  -->
<!-- <?php include 'components/footer.php'; ?> -->
<!-- footer section ends -->
<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>
<script>
function selectCategory(id) {
         console.log(id);
         $.ajax({
            type: "POST",
            url: "product_list.php",
            data: {"id": id},
            success: function(result){
               console.log(result);
         }
      });	
   }
</script>