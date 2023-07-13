<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? OR number = ?");
   $select_user->execute([$email, $number]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   if($select_user->rowCount() > 0){
      $message[] = 'email or number already exists!';
   }else{
      if($pass != $cpass){
         $message[] = 'confirm password not matched!';
      }else{
         $insert_user = $conn->prepare("INSERT INTO `users`(name, email, number, password) VALUES(?,?,?,?)");
         $insert_user->execute([$name, $email, $number, $cpass]);
         $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
         $select_user->execute([$email, $pass]);
         $row = $select_user->fetch(PDO::FETCH_ASSOC);
         if($select_user->rowCount() > 0){
            $_SESSION['user_id'] = $row['id'];
            header('location:index.php');
         }
      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>OMGPH SIGN UP</title>
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


<div class="container1">

<div class="frame">
<div class="nav1">
<li class="signin-active"><a class="btn1">Sign up</a></li>

<form action="" method="POST" class="form-signin">
<label for="fullname">Fullname</label>           
 <input type="text" class="form-styling" name="name"  maxlength="50"placeholder="Enter Full name" required="required" style="background-color: white;background-image: none; color: black;">
 <label for="email">Email</label>           
 <input type="text" class="form-styling" name="email"maxlength="30" placeholder="Enter e-mail" required="required" style="background-color: white;background-image: none; color: black;">
 <label for="number">Number</label>           
 <input type="text" class="form-styling" name="number" maxlength="12"placeholder="Enter number" required="required" style="background-color: white;background-image: none; color: black;">


   <label for="Password">Password</label>  
   <input type="password"  class="form-styling" name="pass"maxlength="8" placeholder="Enter Password" required="required" style="background-color: white;background-image: none; color: black;">
   <label for="Password">Confirm Your Password</label>  
   <input type="cpassword"  class="form-styling" name="cpass"maxlength="8" placeholder="Confirm Password" required="required" style="background-color: white;background-image: none; color: black;">
     
   <input type="submit" name="submit" value="Sign-up" class="btn" >
 
   </form>
   <!-- Login Form Ends HEre -->

</div>
     </div>





</div>









<?php include 'components/footer.php'; ?>







<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>