

<?php
include 'condb.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $otp = $_POST['otp'];
    $query = "SELECT * FROM users WHERE email='$email' AND otp_code='$otp' AND UNIX_TIMESTAMP() - regAtime <= 120";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        header("Location: reset_password.php?email=$email");
    } else {
        echo "Invalid or expired OTP.";
    }
}
?>
