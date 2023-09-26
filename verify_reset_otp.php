<!-- verify_reset_otp.php -->

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Alex+Brush">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Allura">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="stylesheet" href="css/Login-Form-Clean.css">
    <link rel="stylesheet" href="css/Navigation-with-Button.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
   <title>Verify OTP</title>
</head>
<body style="background:  white;padding:10% 39%;">
<div class="centered-div1" style="box-shadow: 1px 2px 9px 0px #00000;border-radius: 20px;background: rgba(111,66,193,0.33);color: var(--bs-dark); padding:20px;width:350px;">

   <form action="process_reset_otp.php" method="post">
       <input type="hidden" name="email" value="<?php echo $_GET['email']; ?>">
       <input type="text" name="otp" placeholder="Enter OTP" required>
       <button type="submit" class="btn d-block w-100" style="border-radius: 20px;background: orange;margin:10px 0px;" value="Submit">Verify
</button>
   </form>
</div>
</body>
</html>
