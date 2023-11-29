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
  

<!--------------------- Franchising 1 ------------------>

<div class="video">
    <video src="images/OMG-video.mp4" autoplay muted loop></video>
</div>


<div class="franchise-grid">
    <h3 id="follow">With 1.3 million followers in the food indistry</h3>
    <h3 id="franchise1">Franchise are multi-awarded in the field of customer service and training</h3>
    <h3 id="food-panda">Food panda integrated</h3>
    <h3 id="sales">Proven sales record</h3>
    <h3 id="products">Products are very affordable yet the ingredients are of the highest quality</h3>
    <h3 id="fastest">Fastest growing and trending franchise</h3>
    <h3 id="legit">Legit and promoted but the VIPs</h3>
    <h3 id="tofil">The Outstanding Filipino 2019 Recognized</h3>
</div>


        
<section class="franchise-packages" id="franchise2">

    <div class="container">

        <div class="content1">
        <h2>FRANCHISE PACKAGES</h2>

            <h3 style="
    text-align: inherit">It's a 5 in 1 franchise!</h3>
            <p>Why settle for just one drink when you can have five of it</p>
       
        </div>

</section>


<script src="js/script.js"></script>
<?php include 'components/footer.php'; ?>
</body>
</html>