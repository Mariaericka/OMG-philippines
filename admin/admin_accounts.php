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
   <h1><center>Manage Admin</center></h1>
   <a href="register_admin.php" class="btn-primary">ADD ADMIN</a>   <br><br><br>




   <?php
      $select_account = $conn->prepare("SELECT * FROM `admin`");
      $select_account->execute();
      if($select_account->rowCount() > 0){
         while($fetch_accounts = $select_account->fetch(PDO::FETCH_ASSOC)){  
   ?>
   <br><br><br>
      <table class="tbl-full">
   <tr>
                       
                        <th >ID</th>
                        <th style="display: flex;" >FULLNAME</th>

                        <th>USERNAME</th>
                    
                    </tr>
<tr>
<td> <?= $fetch_accounts['id']; ?></td>
<td> <?= $fetch_accounts['fullname']; ?></td>

<td><?= $fetch_accounts['name']; ?></td>
    
<td> <a href="admin_accounts.php?delete=<?= $fetch_accounts['id']; ?>" class="btn-danger" onclick="return confirm('delete this account?');">delete</a>
         <?php
            if($fetch_accounts['id'] == $admin_id){
               echo '<a href="update_profile.php" class="btn-secondary">update</a>';
            }
         ?>
      </td>
    </tr>
        </div>
      
         </table>
   <?php
      }
   }else{
      echo '<p class="empty">no accounts available</p>';
   }
   ?>
  </div>
    </div>

    </section>

<!-- admins accounts section ends -->




















<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>