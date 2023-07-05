<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};


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
<body>
<?php include '../components/admin_header.php' ?>

<section>
   <div class="main-content">
   <div class="wrapper">
   <h1><center>Manage Applicants</center></h1>


   <?php
      $show_products = $conn->prepare("SELECT * FROM `applicants`");
      $show_products->execute();
      if($show_products->rowCount() > 0){
         while($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)){  
   ?>   <br><br><br>

   <table class="tbl-full">
   <tr>
                       
                        <th >first name</th>
                        <th>last name </th>
                        <th >email</th>
                        <th >phone</th>
                        <th >position</th>
                        <th >start date</th>
                        <th >file</th>

                    </tr>
     <tr>
     <th><?= $fetch_products['firstname']; ?></th>
     <th><?= $fetch_products['lastname']; ?></th>
        
     <th> <?= $fetch_products['email']; ?></td>
     <th> <?= $fetch_products['phone']; ?></td>
     <th> <?= $fetch_products['position']; ?></td>
     <th> <?= $fetch_products['startdate']; ?></td>


     <th><?= $fetch_products['img'];?></th>
   
      
      
         
         </tr>
        </div>
      
         </table>
   <?php
         }
      }else{
         echo '<p class="empty">no applicants yet!</p>';
      }
   ?>

   </div>
    </div>

    </section>
<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>