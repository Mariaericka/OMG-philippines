<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_message = $conn->prepare("DELETE FROM `messages` WHERE id = ?");
   $delete_message->execute([$delete_id]);
   header('location:messages.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Messages</title>
   <link rel="icon"  href="images/omg-logo.png">

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php' ?>

<!-- messages section starts  -->

<section>
<div class="main-content">
   <div class="wrapper">
   <h1 class="heading">messages</h1>
   <table class="tbl-full">
   <tr>
      <th class="headers">NAME</th>
      <th class="headers">NUMBER</th>

      <th class="headers">EMAIL</th>
      <th class="headers">MESSAGE</th>
      <th class="headers last" ></th>
   </tr>
   <?php
      $select_messages = $conn->prepare("SELECT * FROM `messages`");
      $select_messages->execute();
      if($select_messages->rowCount() > 0){
         while($fetch_messages = $select_messages->fetch(PDO::FETCH_ASSOC)){
   ?>
     <tr class="table-content">
      <th> <?= $fetch_messages['name']; ?><th>
      <th> <?= $fetch_messages['number']; ?><th>
      <th><?= $fetch_messages['email']; ?><th>
      <th> <?= $fetch_messages['message']; ?><th>
      <th> <a href="messages.php?delete=<?= $fetch_messages['id']; ?>" onclick="return confirm('delete this message?');"><img src="../images/icons/delete.png"/ class="manage-drink-icons-delete"/></a>
         </th>
         </tr>
        </div>
   <?php
         }
      }else{
         echo '<p class="empty">you have no messages</p>';
      }
   ?>
</table>
   </div>
    </div>

    </section>
<!-- messages section ends -->









<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>