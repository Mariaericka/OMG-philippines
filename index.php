<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include 'components/add_cart.php';
 if(isset($_POST['send'])){

   $subject = $_POST['subject'];
   $subject = filter_var($subject, FILTER_SANITIZE_STRING);
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $msg = $_POST['msg'];
   $msg = filter_var($msg, FILTER_SANITIZE_STRING);
   
   $select_message = $conn->prepare("SELECT * FROM `messages` WHERE subject = ?  AND name = ? AND email = ? AND number = ? AND message = ?");
   $select_message->execute([$subject, $name, $email, $number, $msg]);
   
   if($select_message->rowCount() > 0){
      $message[] = 'already sent message!';
   }else{
   
      $insert_message = $conn->prepare("INSERT INTO `messages`(user_id, subject, name, email, number, message) VALUES(?,?,?,?,?,?)");
      $insert_message->execute([$user_id,$subject, $name, $email, $number, $msg]);
   
      $message[] = 'sent message successfully!';
   
   }
   
}   
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>OMG Philippines</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/stylez.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>
<section class="hero">

        <h3>Creamy goodness in a cup</h3>
        <p>Taste that would definitely make you go OMG!</p>
        <video src="images/background_3.mp4" autoplay muted loop height="100%" width="100%"></video>

</section>
<section class="franchise" id="franchise">

    <div class="container">

        <div class="content1">
            <h1>OPEN FOR FRANCHISE NATIONWIDE!</h1>
            <h1>5 in 1 FRANCHISE</h1>
            <p>With initial stocks and initial equipments, food panda application, creation of page, extensive training and initial marketing included</p>
            <a href="#" class="btn">Franchise now!</a>
          
        </div>
     
    </div>

</section>




            <section class="hero">

<div class="swiper hero-slider">

   <div class="swiper-wrapper">

      <div class="swiper-slide slide">
      
         <div class="image">
         
    <img src="images/cheescakeseries.jpg" alt="" style=" width: 100%;
    height: 30%;">
         </div>
      </div>



      <div class="swiper-slide slide">
        
         <div class="image">
         <img src= "images/babyruth.jpg" alt=""style=" width: 100%;
    height: 30%;">
         </div>
      </div>
   </div>

   <div class="swiper-pagination"></div>

</div>

</section>

<section class="hero">

   <div class="swiper hero-slider">

      <div class="swiper-wrapper">

         <div class="swiper-slide slide">
            <div class="content">
               <span>Yogurt Series</span>
               <h3>Creamy Fruity Melon</h3>
               <a href="menu.html" class="btn">Order Now</a>
            </div>
            <div class="image">
               <img src="images/creamy fruit melon1.png" alt="">
            </div>
         </div>


         <div class="swiper-slide slide">
            <div class="content">
               <span>Choco Series</span>
               <h3>Choco Kisses</h3>
               <a href="menu.html" class="btn">Order Now</a>
            </div>
            <div class="image">
               <img src="images/kisses choco1.png" alt="">
            </div>
         </div>
         <div class="swiper-slide slide">
            <div class="content">
               <span>Choco Series</span>
               <h3>Twix Choco</h3>
               <a href="menu.html" class="btn">Order Now</a>
            </div>
            <div class="image">
               <img src="images/twix choco.png" alt="">
            </div>
         </div>
      </div>

      <div class="swiper-pagination"></div>

   </div>

</section>

<section class="hero">

<!-- Contact us starts here -->

<form action="" method="post" enctype="multipart/form-data">

    <div class="container">
        <div class="contact-parent">
        <div class="contact-child child1">
            <p>
                <i class="fas fa-map-marker-alt"></i> Main Branch Address <br />
                <span> JP Rizal St. Brgy I- Poblacion, Alaminos
                <br />
                Laguna (Plaza, Near Munisipyo Of Alaminos)
                </span>
            </p>
            <p>
                <i class="fas fa-phone-alt"></i> Contact us <br />
                <span> 09171675592</span>
            </p>
            <p>
                <i class=" far fa-envelope"></i> Email <br />
                <span>omgfranchising@gmail.com</span>
            </p>
        </div>
        <div class="contact-child child2">
            <div class="inside-contact">
                <h2>Contact Us</h2>
                <h3>
                    <span id="confirm">
                </h3>
                <p>Name *</p>
                <input id="txt_name" type="text" Required="required" name="name">
                <p>Email *</p>
                <input id="txt_email" type="text" Required="required" name="email">
                <p>Phone *</p>
                <input id="txt_phone" type="text" Required="required" name="number">
                <p>Subject *</p>
                <input id="txt_subject" type="text" Required="required" name="subject">
                <p>Message *</p>
                <textarea id="txt_message" rows="4" cols="20" Required="required" name="msg" ></textarea>
                <input type="submit" id="btn_send" value="send" name="send">
            </div>
        </div>
        </div>
    </div>   
</form>

</section>





















<?php include 'components/footer.php'; ?>


<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>

<script>

var swiper = new Swiper(".hero-slider", {
   loop:true,
   grabCursor: true,
   effect: "flip",
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
});

</script>

</body>
</html>