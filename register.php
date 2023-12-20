<?php

include 'components/connect.php';

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
   <title>OMGPH SIGN UP</title>
   <link rel="icon"  href="images/omg-logo.png">

   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style2.css">

</head>
<body>
<?php include 'components/user_header.php'; ?>
<div class="container1">
      <div class="frame">
         <div class="nav1">
            <li class="signin-active"><a class="btn1">Sign up</a></li>
            <div class="form-signin">
               <input type="text" class="form-styling" id="name" name="name"title="Enter your First name" maxlength="50" placeholder="First name" required="required" style="background-color: white;background-image: none; color: black;">
               

               <input type="text" class="form-styling" id="lname" name="lname" title="Enter your last name"maxlength="50" placeholder="Last name" required="required" style="background-color: white;background-image: none; color: black;">
             

               <input type="text" class="form-styling" id="email" name="email" title="Enter a valid email address" maxlength="30" placeholder="E-mail address" required="required" style="background-color: white;background-image: none; color: black;">
               

               <input type="tel" class="form-styling" id="number" name="number" title="Enter your 11-digit phone number starting with 0" maxlength="11" placeholder="Phone number" required="required" style="background-color: white;background-image: none; color: black;">
             

               <div style="position: relative;">
    <input type="password" class="form-styling" id="password" name="password" title="At least 8 characters long, 1 uppercase letter, 1 lowercase letter, 1 number, and 1 special character" placeholder="Password" required="required" style="background-color: white; background-image: none; color: black; padding-right: 30px;">
    <i class="far fa-eye" id="togglePassword" style="position: absolute; top: 33%; right: 10px; transform: translateY(-50%); cursor: pointer;"></i>
</div>
              
<div style="position: relative;">
               <input type="password" class="form-styling" id="cpass" name="cpass"title="Confirm your password" placeholder="Confirm password" required="required" style="background-color: white;background-image: none; color: black;">
               <i class="far fa-eye" id="toggleCpass" style="position: absolute; top: 33%; right: 10px; transform: translateY(-50%); cursor: pointer;"></i>
</div>
               <input type="submit" onclick="signUpBtn()" name="submit" value="Sign-up" class="btn">
            </div>
         </div>
      </div>
   </div>
<?php include 'components/footer.php'; ?>
<script src="js/script.js"></script>
<script>


$(document).ready(function () {
    new jBox('Tooltip', {
      attach: '#password',  
      });
});

let strength = 0;
let message = '';

function setStrength(txtstr){
  strength = txtstr;
}
function getStrength(){
  return strength;
}

function setMessage(msg){
   message = msg;
}
function getMessage(){
  return message;
}

$('#password').on('keyup', function() {
   message = '';
   temp_strength = 0;
   const uppercasePattern = /[A-Z]/;
      const lowercasePattern = /[a-z]/;
      const numberPattern = /\d/;
      const specialCharPattern = /[!@#$%^&*()_+\-=[\]{};':"\\|,.<>/?]/;
      const minLength = 8;
               password = $("#password").val();
               if (password.length >= minLength) {
                temp_strength++;
      } else {
        message = "Password must be at least " + minLength + " characters long.";
        $("#password").css({
                    'outline-color': 'pink',
                    'background-color': 'pink'
                });
      }

      if (uppercasePattern.test(password)) {
        temp_strength++;
      } else {
        message += "\nPassword must contain at least one uppercase letter.";
        $("#password").css({
                    'outline-color': 'pink',
                    'background-color': 'pink'
                });
      }

      if (lowercasePattern.test(password)) {
        temp_strength++;
      } else {
        message += "\nPassword must contain at least one lowercase letter.";
        $("#password").css({
                    'outline-color': 'pink',
                    'background-color': 'pink'
                });
      }

      if (numberPattern.test(password)) {
        temp_strength++;
      } else {
        message += "\nPassword must contain at least one number.";
        $("#password").css({
                    'outline-color': 'pink',
                    'background-color': 'pink'
                });
      }

      if (specialCharPattern.test(password)) {
        temp_strength++;
      } else {
        message += "\nPassword must contain at least one special character.";
        $("#password").css({
                    'outline-color': 'pink',
                    'background-color': 'pink'
                });
      }
      if (temp_strength === 5) {
          console.log("Password strength: Strong");
          $("#password").css({
                    'outline-color': 'lightgreen',
                    'background-color': 'lightgreen'
                });
      }
      setStrength(temp_strength);
      setMessage(message)
   });
   
   $('#cpass').on('keyup', function() {
      const Password = document.getElementById("password").value;
      const Cpass = document.getElementById("cpass").value;

      if (Password === Cpass){
         $("#password").css({
                    'outline-color': 'lightgreen',
                    'background-color': 'lightgreen'
                });
         $("#cpass").css({
                    'outline-color': 'lightgreen',
                    'background-color': 'lightgreen'
                });
      }else{
         $("#password").css({
                    'outline-color': 'pink',
                    'background-color': 'pink'
                });
         $("#cpass").css({
                    'outline-color': 'pink',
                    'background-color': 'pink'
                });
      }
   });
function signUpBtn() {

      const name = document.getElementById("name").value;
      const lname = document.getElementById("lname").value;
      const email = document.getElementById("email").value;
      const number = document.getElementById("number").value;
      const password = document.getElementById("password").value;
      const cpass = document.getElementById("cpass").value;
      
 


      let strength = getStrength();
      let message = getMessage();
      // Check if any of the form fields are empty
    if (name.trim() === '' || lname.trim() === '' || email.trim() === '' || number.trim() === '' || password.trim() === '' || cpass.trim() === '') {
        alert("Please fill out all the required fields.");
        return; // Stop form submission
    }
 
 // Validate phone number length
 if (number.length !== 11) {
        alert("Phone number must be exactly 11 digits.");
        return;
    }
  // Validate email format using a regular expression
  const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (emailPattern.test(email)) {
      if (password === cpass) {
        if (strength === 5) {
         console.log("success");

         //  Proceed with form submission using AJAX
          const formData = new FormData();
          formData.append("name", name);
          formData.append("lname", lname);
          formData.append("email", email);
          formData.append("number", number);
          formData.append("password", password);

          const url = "registration_process.php";
          const xhr = new XMLHttpRequest();

          xhr.open("POST", url, true);
          xhr.onreadystatechange = function () {
           if (xhr.readyState === 4 && xhr.status === 200) {
                const response = xhr.responseText;
                if (response === "exists") {
                    alert("Email already exists in the database. Please use a different email.");
                    // Display an error message to the user, e.g., alert or show a message on the page
                } else {
                    alert("Email is available. Proceeding with form submission...");
                    window.location.href = "otpCheck.php";
                }
            }
            else {
                console.log("Error occurred while checking email existence.");
            }
          };
          xhr.send(formData);
   
        } else if (strength >= 3) {
          alert("Password strength: Moderate" + message);
          // You can handle passwords with moderate strength as needed
        } else {
          alert("Password strength: Weak");
        
          // You may display an error message to the user or take other actions for weak passwords
        }
      } else {
         alert("Password Doesn't Match!");
      }
   } else {
        alert("Invalid email format. Please enter a valid email address.");
    }

    }
     // Use jQuery to restrict the input to numbers only
$(document).ready(function () {
    $('#number').on('input', function () {
        // Remove non-numeric characters from the input value
        $(this).val(function (index, value) {
            return value.replace(/\D/g, '');
        });
    });
});
$(document).ready(function () {
    $('#togglePassword').click(function () {
        const passwordInput = $('#password');
        const type = passwordInput.attr('type') === 'password' ? 'text' : 'password';
        passwordInput.attr('type', type);
    });
});
$(document).ready(function () {
    $('#toggleCpass').click(function () {
        const cpassInput = $('#cpass');
        const type = cpassInput.attr('type') === 'password' ? 'text' : 'password';
        cpassInput.attr('type', type);
    });
});
</script>

</body>
</html>