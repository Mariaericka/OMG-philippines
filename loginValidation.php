<?php
include 'condb.php'; 
session_start();
// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve the email and password from the POST data
    $email = $_POST["email"];
    $password = md5($_POST["password"]);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the SQL query to check if the email and password match a user in the database
    $sql = "SELECT * FROM users WHERE email = '$email' AND isActivated = 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $validate = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
        $validated = $conn->query($validate);
        if ($validated->num_rows > 0){
            echo "success";
            foreach($validated as $row){
                $_SESSION['user_id'] = $row['id'];
            }
        }else{
            echo "failure";
        }
    } else {
        // check if activated
        echo "failed";
    }

    // Close the database connection
    $conn->close();
}
?>