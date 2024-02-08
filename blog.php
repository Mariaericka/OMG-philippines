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

<!-- Owl Carousel JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>


   <!-- Own Carousel -->
   <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">


   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style2.css">
   <link rel="stylesheet" href="css/blog.css">


</head>
<body>


<?php include 'components/user_header.php'; ?>


<div class="brief-history">
   
   <div class="history-animate">
      <h6 class="animation-1" id="about-OMG">
      During the pandemic, as online shopping soared, OMG emerged
      a year later, transforming quarantine cravings into a nationwide
      sensation. Starting from Alaminos, Laguna, We expanded to
      five branches, captivating a thirst-quenching niche in the tropical
      Philippines. Our journey, marked by trial and error, now stands
      as a testament to entrepreneurial resilience and taste bud triumphs.
      </h6>
   </div>


   <div class="history-animate">
   <img src="images\logo\logo.png" class="animation-1" id="blog-logo">
   </div>
</div>






<div class="blog">
   <div class="blog-box-1">
      <h5 class="blog-omg">OMG</h5>


      <div class="best">
         <h3 class="is">is the</h3>
         <h3 class="best-choice">best choice!</h3>
      </div>
   </div>


   <div class="blog-box-2">
      <div class="facebook-box-1">
         <iframe src="https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2Fomgmainbranch%2Fposts%2Fpfbid0QjiMeKGdb63UozWgbYxU6d1EN7XLcyy8etyMV3E2DkRMRi8PnsnQ7XwB2iPZ2B83l&show_text=true&width=500" width="500" height="580" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share" class="facebook-img"></iframe>
      </div>


      <div class="facebook-box-2">
      <iframe src="https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2Fomgmainbranch%2Fposts%2Fpfbid0W1DFdsZ87yoxyHn558gzZ92dnLkTJF7xNChk7oQ3jp9bdr2QHNfw4hkMrHzeKZrfl&show_text=true&width=500" width="500" height="250" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share" class="facebook-img"></iframe>
      </div>
         <script async defer crossorigin="anonymous"
        src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.2"></script>
   </div>
</div>


<div class="blog-box-3">
   <div class="blog-grid">
      <div class="growing">
         <img src="images\icons\growing.png" alt="growing-image">
         <h4>Fastest growing and trending franchise</h4>
      </div>


      <div class="legit">
         <img src="images\icons\legit.png" alt="legit-image">
         <h4>Legit and promoted but the VIPs</h4>
      </div>


      <div class="motorbike">
         <img src="images\icons\motorbike.png" alt="motorbike-image">
         <h4>Food panda <br> integrated</h4>
      </div>


      <div class="Halal">
         <img src="images\icons\halal.png" alt="halal-image">
         <h4 class="Halal">Halal <br> Certified</h4>
      </div>


      <div class="followers">
         <img src="images\icons\followers.png" alt="followers-image">
         <h4>With 1.3 million followers in the food indistry</h4>
      </div>


      <div class="trophy">
         <img src="images\icons\Award.png" alt="Award-image">
         <h4>Franchise are multi-awarded in the field of customer service and training</h4>
      </div>
           
      <div class="outstanding">
         <img src="images\icons\outsanding.png" alt="oustanding-image">
         <h4>The Outstanding Filipino 2019 Recognized</h4>
      </div>




      <div class="thumbs-up">
         <img src="images\icons\thumb-up.png" alt="thumbs-up-image">
         <h4>Products are very affordable yet the ingredients are of the highest quality</h4>
      </div>
   </div>
      </div>



    <!-- <div class="fb-posts-container">
          <a href="https://www.facebook.com/omgmainbranch/posts/pfbid0fMSVG7p9UdKsYHRoFktKmsUXLxViihd8T3p7CmVfsn5oKNhxgidcVRhhABscNS5Dl" target="_blank" class="caption">
            Tikman ang pinakamasarap na mas pinamura!
         </a>
         <img src="images\Blog-facebook.jpg" class="facebook-1">




        <iframe src="https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2Fomgmainbranch%2Fposts%2Fpfbid0QjiMeKGdb63UozWgbYxU6d1EN7XLcyy8etyMV3E2DkRMRi8PnsnQ7XwB2iPZ2B83l&show_text=true&width=500" width="500" height="580" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
        <iframe src="https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2Fomgmainbranch%2Fposts%2Fpfbid0Eiw9tXbAXCHb3kwF1895fxwyn4BJeS21eqq5j1jAAXs7dMtMP85oyCY7vNnAxz3Ul&show_text=true&width=500" width="500" height="580" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
        <iframe src="https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2Fomgmainbranch%2Fposts%2Fpfbid02W6rPnVcP5o7opcZUYja9St4DKM85zvBfAe5PmYqHS1PhAFWVc1gB9dzZd53BSueVl&show_text=true&width=500" width="500" height="580" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
        <iframe src="https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2Fomgmainbranch%2Fposts%2Fpfbid0CrNwwqk5t1dGq46LvVaAopuqJtkVfABbXnwvYea13o9kmNE1UUXLKLie5rrxZg5tl&show_text=true&width=500" width="500" height="580" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
           
        <script async defer crossorigin="anonymous"
        src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.2"></script>
    </div> -->








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

