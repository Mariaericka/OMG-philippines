<?php
include 'condb.php';
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the email exists in the database
if (isset($_POST["email"])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $password = mysqli_real_escape_string($conn, md5($_POST['password']));
    // Prepare the SQL statement
    $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch the count
    $row = $result->fetch_assoc();
    $count = $row["count"];

    // Close the statement
    $stmt->close();

    // Send the response back to the JavaScript code
    if ($count > 0) {
        echo "exists";
    } else {
        echo "not_exists";
        $_SESSION['email'] = $email;
        $activated = 0;
        $time = time();
        $newotp = rand(1111, 9999);

        mysqli_query($conn, "INSERT INTO `users`(name, email, number, password, date, otp_code, regAtime, isActivated) 
                    VALUES('$name', '$email', '$number', '$password', NOW(), '$newotp', '$time', '$activated')") or die('query failed');

        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'omgphilippines123@gmail.com';
        $mail->Password = 'qcdjmrfckncojvsy';
        $mail->SMTPSecure = 'ssl'; // Change 'ssl' to 'tls'
        $mail->Port = 465; // Change 465 to 587

        $mail->setFrom('omgphilippines123@gmail.com');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = "Account Verification Code";
        $message = "Here's the code to activate your account: " . $newotp;
        $mail->Body = "<p>$message</p>";

        $mail->send();
    }
}

// Close the database connection
$conn->close();
?>