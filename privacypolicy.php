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
   <title>OMG Philippines | Privacy Policy</title>
   <link rel="icon"  href="images/omg-logo.png">

  <!-- font awesome cdn link  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Own Carousel -->
 <link rel="stylesheet" href="css/owl.carousel.min.css">


  
   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style2.css">


</head>
<body><?php include 'components/user_header.php'; ?>


<section>
<div class="container"><br><br>

<h1>Privacy Policy</h1>

<p>Last updated: August 2023 </p>

<h1>Welcome to OMG Milkshake Milktea and Coffee ("we", "our", or "us"). We are committed to protecting your privacy and providing you with a safe online experience. This Privacy Policy governs the manner in which we collect, use, maintain, and disclose information collected from users ("you" or "your") of the OMG Milkshake Milktea and Coffee website.</h1>

<h2>1. Information We Collect:</h2>
<p>We may collect personal identification information from you in a variety of ways, including, but not limited to, when you visit our website, register on the website, place an order, subscribe to the newsletter, and in connection with other activities, services, features, or resources we make available on our website. You may be asked for your name, email address, phone number, and delivery address, among other information.</p>

<h2>2. How We Use the Information:</h2>
<p>The information we collect from you may be used in one or more of the following ways:</p>

<p> • To personalize your experience on our website and respond to your individual needs.</p>
<p> • To process transactions and deliver the purchased products to the specified delivery address.</p>
<p> • To send periodic emails, including order updates, promotions, and company news. You may opt-out of receiving marketing emails by following the unsubscribe instructions provided in the email.</p>

<h2>3. Protection of Information:</h2>
<p>We adopt appropriate data collection, storage, and processing practices, as well as security measures, to protect against unauthorized access, alteration, disclosure, or destruction of your personal information, username, password, transaction information, and data stored on our website.</p>

<h2>4. Information Sharing:</h2>
<p>We do not sell, trade, or rent your personal identification information to others. We may share generic aggregated demographic information not linked to any personal identification information regarding visitors and users with our business partners, trusted affiliates, and advertisers.</p>

<h2>5. Cookies and Similar Technologies:</h2>
<p>Our website may use "cookies" to enhance user experience. Cookies are small text files that are placed on your device when you access and use our website. You may choose to set your web browser to refuse cookies or to alert you when cookies are being sent. However, if you do so, some parts of our website may not function properly.</p>

<h2>6. Location Limit for Delivery:</h2>
<p>Please note that our delivery service is limited to the Laguna area only. If you are located far away from our delivery zone, we encourage you to visit our stores or other OMG Milkshake Milktea and Coffee franchise branches for your milktea needs.</p>

<h2>7. Mode of Payment:</h2>
<p>We offer two modes of payment: "In-Store Pick Up" and "GCash." For "In-Store Pick Up," you can make your payment when you pick up your order at our physical store. For "GCash," you can conveniently pay through the GCash platform during the checkout process.<p>

<h2>8. Changes to this Privacy Policy:</h2>
<p>We may update this Privacy Policy at any time. When we do, we will revise the "last updated" date at the top of this page. We encourage you to review this Privacy Policy periodically to stay informed about how we are protecting the personal information we collect.</p>

<h2>9. Contact Us:</h2>
If you have any questions about this Privacy Policy or the practices of our website, </p>
<p>please contact us at 0917 167 5592.</p>

<p>Thank you for visiting OMG Milkshake Milktea and Coffee. Enjoy your milktea experience!</p>

<p>OMG MILKSHAKE,MILKTEA AND COFFEE</p>
<p>Rizal St, Alaminos</p>
<p>Laguna Philippines</p>
<p>0917 167 5592</p>
<p>Email: omgfranchising@gmail.com</p>

</div>
</section>




<?php include 'components/footer.php'; ?>

    <script src="js/script.js"></script>
    



    </body>
</html>