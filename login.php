<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['submit'])){

   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $password = sha1($_POST['password']);
   $password = filter_var($password, FILTER_SANITIZE_STRING);

   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
   $select_user->execute([$email, $password]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   if($select_user->rowCount() > 0){
      $_SESSION['user_id'] = $row['id'];
      header('location:index.php');
   }else{
      $message[] = 'incorrect username or password!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>OMGPH LOGIN</title>
   <link rel="icon"  href="images/omg-logo.png">

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style2.css">

</head>
<body>
   
<!-- header section starts  -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->




     <!-- Login Form Starts HEre -->
     <div class="container1">

<div class="frame">
<div class="nav1">
<li class="signin-active"><a class="btn1">Sign in</a></li>

<form action="" method="POST" class="form-signin">
<label for="Email">Email</label>            
<input type="text" class="form-styling" name="email" placeholder="Enter Email" maxlength="30"required="required" style="background-color: white;background-image: none; color: black;">
<br><br>

   <label for="Password">Password</label>  
   <input type="password"  class="form-styling" name="password" placeholder="Enter Password" maxlength="8" required="required" style="background-color: white;background-image: none; color: black;"><br><br>
     
   <input type="submit" name="submit" value="Sign-in" class="btn" >
 
   </form>
   <!-- Login Form Ends HEre -->

  <center> <p>You don't have account? <a href="register.php">SIGN UP </a></p></center>
</div>
     </div>



     </div>






<?php include 'components/footer.php'; ?>




<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>




     
    
    