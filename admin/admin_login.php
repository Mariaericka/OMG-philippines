<?php

include '../components/connect.php';

session_start();

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE name = ? AND password = ?");
   $select_admin->execute([$name, $pass]);
   
   if($select_admin->rowCount() > 0){
      $fetch_admin_id = $select_admin->fetch(PDO::FETCH_ASSOC);
      $_SESSION['admin_id'] = $fetch_admin_id['id'];
      header('location:dashboard.php');
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
   <title>OMGPH | ADMIN PAGE</title>
   <link rel="icon"  href="images/omg-logo.png">
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<header style="background: white;"> 
    <a href="#" class="logo"><img src="../images/omg-logo.png" image style="object-fit: contain; width: 70px; background:white;" ></a>
    </header>
<body>

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

<!-- admin login form section starts  -->

<div class="login">
<h1>OMG PH LOG IN</h1><br><br>

   <form action="" method="POST" class="text-center">
      <h3>login now</h3>
      Username: <br><br>

      <input type="text" name="name" maxlength="20" required placeholder="enter your username"  style="background-color: white;background-image: none; color: black; oninput="this.value = this.value.replace(/\s/g, '')">
      <br><br>
      Password: <br><br>

      <input type="password" name="pass" maxlength="20" required placeholder="enter your password"  style="background-color: white;background-image: none; color: black;oninput="this.value = this.value.replace(/\s/g, '')">
     <br><br>
      <input type="submit" value="login now" name="submit" class="btn-primary"  style="background-image: none;padding: inherit;background-color: red;">
  <br><br>
   </form>
   <p>Powered By - <a href="https://www.facebook.com/">S.E.I</a></p>

</div>
<!-- admin login form section ends -->











</body>
</html>