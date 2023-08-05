<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_admin = $conn->prepare("DELETE FROM `admin` WHERE id = ?");
   $delete_admin->execute([$delete_id]);
   header('location:admin_accounts.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admins accounts</title>
   <link rel="icon"  href="images/omg-logo.png">

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php' ?>

<!-- admins accounts section starts  -->

<section class="accounts">

<div class="main-content">
   <div class="wrapper">
   <h1 class="heading">Manage Admin</h1>
  <div class="col-4 btn-primary"> <a href="register_admin.php" >ADD ADMIN</a> </div>




 
   
      <table class="tbl-full">
   <tr>
                       
          <th class="headers" >ID</th>
          <th class="headers" >FULLNAME</th>
         <th class="headers">USERNAME</th>
         <th class="headers last" ></th>          
         </tr>

         <?php
      $select_account = $conn->prepare("SELECT * FROM `admin`");
      $select_account->execute();
      if($select_account->rowCount() > 0){
         while($fetch_accounts = $select_account->fetch(PDO::FETCH_ASSOC)){  
   ?>
 <tr class="table-content">
<th> <?= $fetch_accounts['id']; ?></th>
<th> <?= $fetch_accounts['fullname']; ?></th>

<th><?= $fetch_accounts['name']; ?></th>
    
<th> <a href="admin_accounts.php?delete=<?= $fetch_accounts['id']; ?>" class="btn-danger" onclick="return confirm('delete this account?');"><img src="../images/icons/delete.png" class="manage-drink-icons-delete"/></a>
         <?php
            if($fetch_accounts['id'] == $admin_id){
               echo '<a href="update_profile.php" class="btn-secondary"><img src="../images/icons/update.png"/ class="manage-drink-icons-update"/></a>';
            }
         ?>
      </th>
    </tr>
        </div>
      
        
   <?php
      }
   }else{
      echo '<p class="empty">no accounts available</p>';
   }
   ?>
   </table>
  </div>
    </div>

    </section>

<!-- admins accounts section ends -->




















<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>