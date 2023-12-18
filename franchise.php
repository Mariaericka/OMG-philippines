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
   <div class="franchise-sticky">
      <div class="stick">
         <div class="sticky">
            <h1 class="sticky-1"> Provides the ultimate bevarage experience</h1>
         </div>
         
         <div class="sticky">
            <h1 class="sticky-2">Accessible excellence for your indulgence.</h1>   
         </div>
            
         <div class="sticky">
            <h1 class="sticky-3"> Offering top-quality ingredients at an affordable price</h1>
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
                  <h4>First name</h4>
                  <h4>Last name</h4>
                  <h4>Contact number</h4>
                  <h4>Email address</h4>
                  <h4>Target location</h4>
               </div>

               <div class="fill-out-box">
                  <div class="first-name">
                     <label for="first-name">
                        <input type="text" name="first-name" id="first-name" placeholder=" Enter your first name" required="required">
                     </label>
                  </div>

                  <div class="last-name">
                     <label for="last-name">
                        <input type="text" name="last-name" id="last-name" placeholder=" Enter your last name" required>
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
            
            <div class="franchise-form-btn">
               <button class="submit">Submit</button>
            </div>
         </div>
      </form>
   </div>
</div>




<script src="js/script.js"></script>
<?php include 'components/footer.php'; ?>
</body>
</html>