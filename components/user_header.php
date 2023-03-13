<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">

   <section class="flex">

   <a href="../index.php" class="logo"><img src="images/omg-logo.png" image style="    position: absolute;
    width: 117px;
    height: 115px;
    top: 0px;
    left:-1px;"></a>

      <nav class="navbar">
         <a href="index.php">HOME</a>
         <a href="menu.php">MENU</a>

         <a href="blog.php">BLOG</a>
         <a href="franchise.php">FRANCHISE</a>
         <a href="career.php">CAREER</a>



         <a href="location.php">LOCATION</a>
         <a href="contact.php">CONTACT US</a>
      </nav>

      <div class="icons">
         <?php
            $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $count_cart_items->execute([$user_id]);
            $total_cart_items = $count_cart_items->rowCount();
         ?>
         <a href="search.php"><i class="fas fa-search"></i></a>
         <a href="https://www.facebook.com/omgmainbranch/"><i class="fa-brands fa-facebook-f" id="facebook"></i></a>
         <a href="cart.php"><i class="fas fa-shopping-cart"></i><span>(<?= $total_cart_items; ?>)</span></a>
         <div id="user-btn" class="fas fa-user"></div>
         <div id="menu-btn" class="fas fa-bars"></div>
      </div>

      <div class="profile">
         <?php
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$user_id]);
            if($select_profile->rowCount() > 0){
               $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <p class="name"><?= $fetch_profile['name']; ?></p>
         <div class="flex">
            <a href="profile.php" class="btn">profile</a>
            <a href="components/user_logout.php" onclick="return confirm('logout from this website?');" class="delete-btn">logout</a>
         </div>
         <p class="account">
            <a href="login.php">login</a> or
            <a href="register.php">sign up</a>
         </p> 
         <?php
            }else{
         ?>
            <a href="profile.php" class="name">PROFILE</a>
        <a href="#" class="name">ORDERS</a>
        <a href="login.php" class="btn">LOGIN</a></div>         <?php
          }
         ?>
      </div>

   </section>

</header>

