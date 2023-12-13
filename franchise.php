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
  
<div class="franchise">

   
   <div class="franchise-box-1">
      <h1 class="main-box-1">OMG-Main</h1>
      <p class="alaminos">Alaminos Laguna</p>
            
   </div>

   <div class="franchise-slider">
      <div class="slide">
         <div class="slider">
            <h1 class="slider-1"> Provides the ultimate bevarage experience</h1>
         </div>
         
         <div class="slider">
            <h1 class="slider-2">Accessible excellence for your indulgence.</h1>   
         </div>
            
         <div class="slider">
            <h1 class="slider-3"> Offering top-quality ingredients at an affordable price</h1>
         </div>
      </div>



      <form action="thank" method="GET">
         <div class="franchise-form">
            <div class="greet">
               <h5> We appreciate your enthusiasm! Kindly provide the necessary details below 
               for franchise. We will reach out to you promptly.</h5>
            </div>

            <div class="field">
               <div class="fill-out">
                  <h4>Name</h4>
                  <h4>Contact number</h4>
                  <h4>Email Address</h4>
                  <h4>Target Location</h4>
               </div>

               <div class="fill-out-box">
                  <div class="name">

                     <label for="name">
                        <input type="text" name="name" id="name" placeholder=" Enter your name" required>
                     </label>
                  </div>

                  <div class="contact-number">
                     <label>
                        <input type="number" name="number" id="number" placeholder=" Enter your phone number" max="11" required>
                     </label>
                  </div>

                  <div class="email-address">
                  <label>
                        <input type="email" name="email" id="email" placeholder=" Enter your email address" required>
                     </label>
                  </div>

                  <div class="target-space-location">

                     
                     <label>
                        <input type="text" name="location" id="location" placeholder=" Enter your target location" required>
                     </label>
                  </div>
               </div>
            </div>
            <button type="reset">Reset</button>
            <button type="submit" >Submit</button>
         </div>
      </form>
   </div>




   


   <!-- <div class="franchise-Offers">

   <div class="franchise2">
      <div class="franchise-grid">
         <div class="main-box-2">
               <h1 class="OMG-Main-2">OMG-Main</h1>
               <p class="Alaminos-Laguna-2">Alaminos Laguna</p>
         </div>


         <div class="series">
            <div class="Choco">
               <h3 class="series-1">Creamy Choco Series</h3>
               <p class="mini-description">Creamy Chocolate drink</p>
            </div>

            <div class="Milktea">
               <h3 class="series-2">Milktea Series</h3>
               <p>100% tea-based drinks</p>
            </div>

            <div class="Yogurt">
               <h3 class="series-3">Fruit Yogurt Series</h3>
               <p>Yakult inspired drink</p>
            </div>

            <div class="Coffee"></div>
            <h3 class="series-3">Creamy Coffe Series</h3>
            <p>Creamy coffee drink</p>
         </div>
      




            
      </div>
   </div> -->

</div>




<script src="js/script.js"></script>
<?php include 'components/footer.php'; ?>
</body>
</html>