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
<link rel="icon"  href="images/omg-logo.png">
   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style2.css">
   


</head>
<body>
<?php include 'components/user_header.php'; ?>


        <img class="background-image" src="images\category\background.png" >

        <div class="Tagline">
         <h3> Creamy goodness in a cup. Taste that would definitely make you go OMG!</h3>
        </div>

        
<section class="franchise" id="franchise">

    <div class="container">
      <h1 class="five">5</h1>
      <h1 class="branch">BRANCHES</h1>
      <h1 class="nationwide">NATIONWIDE!</h1>
        <div class="content1">
            <a href="franchise.php" class="button11">Franchise Now!</a>
         </div>
         <div class="laguna-map">
            <img src="images\category\laguna.png" alt="laguna-map">
         </div>
    </div>


</section>


<section class="hero flex" style="margin: 0px;">
   
<a href="menu.php"><div class="babyruth">
</div></a>
<a href="franchise.php"> <div class="event"></div></a>
<a href="menu.php">  <div class="series"></div> </a>
   
</section>


<section class="hero">


</section>


<section>
   <div class="swiper-pagination"></div>

</div>



<section class="hero">

   <div class="swiper hero-slider">

      <div class="swiper-wrapper">

         <div class="swiper-slide slide">
            <div class="content">
               <span>Yogurt Series</span>
               <h3>Creamy Fruity Melon</h3>
               <a href="menu.php" class="btn">Order Now</a>
            </div>
            <div class="image">
               <img src="images/creamy fruit melon1.png" alt="">
            </div>
         </div>


         <div class="swiper-slide slide">
            <div class="content">
               <span>Choco Series</span>
               <h3>Choco Kisses</h3>
               <a href="menu.php" class="btn">Order Now</a>
            </div>
            <div class="image">
               <img src="images/kisses choco1.png" alt="">
            </div>
         </div>
         <div class="swiper-slide slide">
            <div class="content">
               <span>Choco Series</span>
               <h3>Twix Choco</h3>
               <a href="menu.php" class="btn">Order Now</a>
            </div>
            <div class="image">
               <img src="images/twix choco.png" alt="">
            </div>
         </div>
      </div>

      <div class="swiper-pagination"></div>

   </div>

</section>


</section>









 <div class="loader">
   <img src="images/loading.gif" alt="">
</div> 




<div></div>
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