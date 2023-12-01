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
   <title>OMG Philippines | Franchise</title>   
   <link rel="icon"  href="images/omg-logo.png">

  <!-- font awesome cdn link  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Own Carousel -->
 <link rel="stylesheet" href="css/owl.carousel.min.css">


  
   <!-- custom css file link  -->
   <link rel="stylesheet" href="./css/style2.css">
  <!-- <link rel="stylesheet" href="css/bootstrap.css">-->


</head>
<body>

<?php include 'components/user_header.php'; ?>
  


<div class="video">
    <video src="images/OMG-video.mp4" autoplay muted loop></video>
</div>


<div class="franchise-grid">
    <div class="followers">
        <img src="images\icons\followers.png" alt="followers-image">
        <h4>With 1.3 million followers in the food indistry</h4>
    </div>

    <div class="trophy">
        <img src="images\icons\Award.png" alt="Award-image">
        <h4>Franchise are multi-awarded in the field of customer service and training</h4>
    </div>

    <div class="motorbike">
        <img src="images\icons\motorbike.png" alt="motorbike-image">
        <h4>Food panda integrated</h4>
    </div>

    <div class="thumbs-up">
        <img src="images\icons\thumb-up.png" alt="thumbs-up-image">
        <h4>Products are very affordable yet the ingredients are of the highest quality</h4>
    </div>

    <div class="growing">
        <img src="images\icons\growing.png" alt="growing-image">
        <h4>Fastest growing and trending franchise</h4>
    </div>

    <div class="legit">
        <img src="images\icons\legit.png" alt="legit-image">
        <h4>Legit and promoted but the VIPs</h4>
    </div>

    <div class="outstanding">
        <img src="images\icons\outsanding.png" alt="oustanding-image">
        <h4>The Outstanding Filipino 2019 Recognized</h4>
    </div>


</div>






            <!-- <p>Why settle for just one drink when you can have five of it</p> -->

<script src="js/script.js"></script>
<?php include 'components/footer.php'; ?>
</body>
</html>