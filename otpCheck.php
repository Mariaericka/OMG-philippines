<?php
include 'condb.php';
error_reporting(0);
session_start();

$email = $_SESSION['email'];

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if(isset($_POST['submit'])){

    $otp = mysqli_real_escape_string($conn, $_POST['code']);
    $select = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');

    if(mysqli_num_rows($select) > 0){
        while($row = mysqli_fetch_assoc($select)){
            $email = $row['email'];
            $post_time = $row['regAtime'];
            $otpCheck = $row['otp_code'];
            $curr_time = time();
			$real_time = $curr_time - $post_time;
			$real_min = $real_time / 60;
            $_SESSION['user_id'] = $row['id'];
        }
        if($otpCheck == $otp){
            if($real_min < 1 && $real_min < 2){
                $query = mysqli_query($conn, "UPDATE users SET isActivated = '1' WHERE otp_code = '$otp'") or die('query failed');
                echo "<script> success('Your account has been activated');
                    </script>";
                header("Location: index.php");
            }
            else if ($real_min >= 2){
                echo "<script> alert('OTP Code has expired!');</script>";
    
                echo "
                    <form class='con' action='' method='post'>
                        <button type='submit' name='resend'>Resend OTP Code</button>
                    </form>
                ";
            }
        }
        
   }
   else{
    echo "Incorrect code!";
   }
}
if (isset($_POST['resend'])) {
    $newotp = rand(1111, 9999);
    $newtime = time();
    $query = mysqli_query($conn, "UPDATE users SET otp_code = '$newotp', regAtime = '$newtime' WHERE email = '$email'") or die('query failed');
    $select = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');
    if(mysqli_num_rows($select) > 0){
        while($row = mysqli_fetch_assoc($select)){
            $email = $row['email'];
        }
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'cecillesalon0@gmail.com';
        $mail->Password = 'pxlwhdcgshaiqalr';
        $mail->SMTPSecure = 'ssl'; // Change 'ssl' to 'tls'
        $mail->Port = 465; // Change 465 to 587

        $mail->setFrom('cecillesalon0@gmail.com');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = "Account Verification Code";
        $message = "Here's the code to activate your account: " . $newotp;
        $mail->Body = "<p>$message</p>";
        $mail -> send();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title></title>
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
</head>
</head>

<body style="background: #FFD93D;padding:10% 39%;">
    <?php
        include("navbar.php");
    ?>
    
        <div class="centered-div" style="box-shadow: 1px 2px 9px 0px #00000;border-radius: 20px;background: rgba(111,66,193,0.33);color: var(--bs-dark); padding:20px;width:350px;">
        <center>
            <h4>OTP code will expire in</h4> 
            <h1 id="countdown">2:00</h1>
        </center>
            
            <form action="" method="post">
                <input class="form-control" style="border-radius: 20px;" type="text" name="code">
                <button type="submit" class="btn d-block w-100" name="submit" style="border-radius: 20px;background: orange;margin:10px 0px;">Verify</button>
            </form>
            <form action='' method='post'>
            <button class="btn " name="resend" type="submit" style="border-radius: 20px;background: orange;margin:10px 0px;">Resend OTP</button>
            </form>
        </div>
    <script src="../../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    
    <script src="../../assets/js/bs-init.js"></script>
  
    <script>
        // Set the countdown duration in minutes
        var countdownDuration = 2;
        
        // Calculate the end time in milliseconds
        var endTime = new Date().getTime() + countdownDuration * 60 * 1000;
        
        // Update the countdown every second
        var countdownInterval = setInterval(updateCountdown, 1000);
        
        // Function to update the countdown timer
        function updateCountdown() {
            // Get the current time
            var currentTime = new Date().getTime();
            
            // Calculate the remaining time
            var remainingTime = endTime - currentTime;
            
            // Calculate minutes and seconds
            var minutes = Math.floor(remainingTime / (1000 * 60));
            var seconds = Math.floor((remainingTime % (1000 * 60)) / 1000);
            
            // Add leading zeros if necessary
            var formattedMinutes = ("0" + minutes).slice(-2);
            var formattedSeconds = ("0" + seconds).slice(-2);
            
            // Display the remaining time
            document.getElementById("countdown").innerHTML = formattedMinutes + ":" + formattedSeconds;
            
            // Check if the countdown has finished
            if (remainingTime <= 0) {
                clearInterval(countdownInterval);
                document.getElementById("countdown").innerHTML = "Code has expired";
            }
        }
    </script>
    
</body>
</html>
