<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_request = $conn->prepare("DELETE FROM `franchise_requests` WHERE id = ?");
   $delete_request->execute([$delete_id]);
   header('location:franchise_requests.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Franchise Requests</title>
   <link rel="icon"  href="images/omg-logo.png">

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php' ?>

<!-- franchise requests section starts  -->

<section>
    <div class="main-content">
        <div class="wrapper">
            <h1 class="heading">Franchise Requests</h1>
            <table class="tbl-full">
                <tr>
                    <th class="headers">First Name</th>
                    <th class="headers">Last Name</th>
                    <th class="headers">Contact Number</th>
                    <th class="headers">Email</th>
                    <th class="headers">Target Location</th>
                    <th class="headers last"></th>
                </tr>
                <?php
                $select_requests = $conn->prepare("SELECT * FROM `franchise_requests`");
                $select_requests->execute();
                if ($select_requests->rowCount() > 0) {
                    while ($fetch_request = $select_requests->fetch(PDO::FETCH_ASSOC)) {
                ?>
                        <tr class="table-content">
                            <td><?= $fetch_request['first_name']; ?></td>
                            <td><?= $fetch_request['last_name']; ?></td>
                            <td><?= $fetch_request['contact_number']; ?></td>
                            <td><?= $fetch_request['email']; ?></td>
                            <td><?= $fetch_request['target_location']; ?></td>
                            <td>
                                <a href="franchise_requests.php?delete=<?= $fetch_request['id']; ?>" onclick="return confirm('Delete this request?');">
                                    <img src="../images/icons/delete.png" class="manage-drink-icons-delete" alt="Delete Request" />
                                </a>
                            </td>
                        </tr>
                <?php
                    }
                } else {
                    echo '<tr><td colspan="6" class="empty">You have no franchise requests</td></tr>';
                }
                ?>
            </table>
        </div>
    </div>
</section>
<!-- franchise requests section ends -->

<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>
