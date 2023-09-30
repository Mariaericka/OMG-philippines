<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>OMG Philippines | Blog</title>
   <link rel="icon"  href="images/omg-logo.png">

  <!-- font awesome cdn link  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">


   <!-- Own Carousel -->
   <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">


  
   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style2.css">
   <link rel="stylesheet" href="css/blog.css">



</head>
<body>

<?php include 'components/user_header.php'; ?>


<!-- BLOG NEW start-->
<section class="site-title">
<div class="header1">
    <h1>OMG</h1>
    <h2>is the best choice!</h2>
    <p>Overload goodness in cup</p>
</div>

<div class="OMG-main">
    <img src="./images/OMG.jpg" alt="OMG-main">
</div>

</section>
<!--<div class="owl-carousel owl-theme ">

<div class="Price-rollback">
   <img src="./images/Price rollback sale.jpg" alt="Price rollback sale">
   <h2 class="From">From 69 pesos</h2>
   <h2 class="Now">Now 45 pesos</h2>
</div>

<div class="Buy-1-take-1">
   <img src="./images/Buy 1 take 1.jpg" alt="Buy 1 take 1">
   <h2 class="Enjoy">Enjoy two drinks</h2>
   <h2 class="Only">for only 88 pesos</h2>
</div>

<div class="Fruity-yogurt">
   <img src="./images/Fruity yogurt.jpg" alt="Fruity yogurt">
   <h2 class="Get">Get only from</h2>
   <h2 class="April">April 4-9</h2>
</div>

</div>-->




<!------------------- Blog Carousel ------------------->


<section>
      
          
                <div class="owl-carousel owl-theme blog-post">
                    <div class="blog-content">
                    <img src="./images/Price rollback sale.jpg" alt="Price rollback sale">
                        <div class="blog-title">
                            <h3>Buy one take one milk shake for only 88 pesos!</h3>
                            <button class="btn btn-blog">Milkshakes</button>
                        </div>
                    </div>
                    <div class="blog-content">
                    <img src="./images/Buy 1 take 1.jpg" alt="Buy 1 take 1">
                        <div class="blog-title">
                            <h3>Price rollback sale from P69 to P45!</h3>
                            <button class="btn btn-blog">Coffees</button>
                        </div>
                    </div>
                    <div class="blog-content">
                    <img src="./images/Fruity yogurt.jpg" alt="Fruity yogurt">
                        <div class="blog-title">
                            <h3>Yogurt for only P88!</h3>
                            <button class="btn btn-blog">Yogurts</button>
                        </div>
                    </div>
                </div>
                <div class="owl-navigation">
                    <span class="owl-nav-prev"><i class="fa-solid fa-circle-chevron-left"></i></span>
                    <span class="owl-nav-next"><i class="fa-solid fa-circle-chevron-right"></i></span>
                </div>
  
   
    </section>
    
<section>
      
          
      <div class="owl-carousel owl-theme blog-post">
          <div class="blog-content1">
          <img src="./images/picture 1.jpg" alt="Coming soon">
                        <div class="blog-title">
                  <h3>Coming Soon</h3>
              </div>
          </div>
          <div class="blog-content1">
          <img src="./images/picture 2.jpg" alt="Opening soon">
              <div class="blog-title">
                  <h3>Opening Soon</h3>
              </div>
          </div>
          <div class="blog-content1">
          <img src="./images/picture 3.jpg" alt="Customers">
              <div class="blog-title">
                  <h3>Customers!</h3>
              </div>
          </div>
          <div class="blog-content1">
          <img src="./images/picture 4.jpg" alt="New branch">
                        <div class="blog-title">
                  <h3>New Branch</h3>
              </div>
          </div>
      </div>
    


</section>



    <!---------x---------- Blog Carousel----------x--------->
    <!-- <section class="site-title1">
<div class="Coming-soon">
      <img src="./images/picture 1.jpg" alt="Coming soon">
      <p class="Likes">Likes<br>Comments</p>

   <div class="Coming-soon-icons">
      <img src="./images/icons/heart.png" id="Heart-icon" alt="Heart-icon">
      <img src="./images/icons/comment.png" id="Comment-icon" alt="Comment-icon">

   </div>

</div>

<div class="Opening-soon">
   <img src="./images/picture 2.jpg" alt="Opening soon">
   <p class="Likes">Likes<br>Comments</p>
</div>

<div class="Customers">
   <img src="./images/picture 3.jpg" alt="Customers">
   <p class="Likes">Likes<br>Comments</p>
</div>

<div class="New-branch">
   <img src="./images/picture 4.jpg" alt="New branch">
   <p class="Likes">Likes<br>Comments</p>
</div>-->
</section>

<?php include 'components/footer.php'; ?>

<!-- BLOG NEW end-->
  <!-- Jquery Library file -->
  <script src="JS/Jquery3.6.0.min.js"></script>

<!-- Owl Carousel -->
<script src="JS/owl.carousel.min.js"></script>
<script src="JS/script2.js"></script>

<script src="js/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>


</body>
</html>


