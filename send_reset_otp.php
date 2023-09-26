<?php
include 'condb.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $otp = rand(1111, 9999);
    $query = "UPDATE users SET otp_code='$otp', regAtime=UNIX_TIMESTAMP() WHERE email='$email'";
    if (mysqli_query($conn, $query)) {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'omgphilippines123@gmail.com';
        $mail->Password = 'qcdjmrfckncojvsy';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('omgphilippines123@gmail.com');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = "Password Reset OTP";
        $mail->Body = "Here's your OTP to reset your password: $otp";
        $mail->send();

        header("Location: verify_reset_otp.php?email=$email");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
