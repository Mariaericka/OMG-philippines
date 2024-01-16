<?php

include 'components/connect.php';
error_reporting(0);
session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>OMGPH LOGIN</title>
   <link rel="icon"  href="images/omg-logo.png">

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style2.css">

</head>
<body>
   

<?php include 'components/user_header.php'; ?>


<div class="frame">
<div class="nav1">
<li class="signin-active"><a class="btn1">Sign in</a></li>

<div class="form-signin">
<label for="Email">Email</label>            
<input type="text" class="form-styling" id="email" name="email" placeholder="Enter Email" maxlength="30"required="required" style="background-color: white;background-image: none; color: black;">
<br><br>
<label for="Password">Password</label>  
<input type="password"  class="form-styling" id="password" name="password" placeholder="Enter Password" required="required" style="background-color: white;background-image: none; color: black;"> 
<input type="submit" onclick="LoginBtn()" name="submit" value="Sign-in" class="btn" >
</div>
<center> <p>Forgot Password? <a href="request_reset.php">click here </a></p></center>

<center> <p>You don't have account? <a href="register.php">SIGN UP </a></p></center>

</div>
</div>
</div>
<?php include 'components/footer.php'; ?>
<script src="js/script.js"></script>
<script>
function LoginBtn() {
        const email = document.getElementById("email").value;
        const password = document.getElementById("password").value;
        const formData = new FormData();
        formData.append("email", email);
        formData.append("password", password);

        const xhr = new XMLHttpRequest();
        const url = "loginValidation.php"; // Replace with the correct path to loginValidation.php

        xhr.open("POST", url, true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    const response = xhr.responseText;
                    if (response === "success") {
                        alert("You are now logged in!");
                        // Login success, redirect to the dashboard or any other page
                        window.location.href = "index.php";
                    } else if (response === "failed") {
                        window.alert("Account is not Activated!!");
                    }
                    else {
                        // Login failed, show an alert with the error message
                        window.alert("Invalid email or password.");
                    }
                } else {
                    // Error occurred while validating login
                    window.alert("Error occurred while validating login.");
                }
            }
        };
        xhr.send(formData);
    }

</script>
</body>
</html>




     
    
    