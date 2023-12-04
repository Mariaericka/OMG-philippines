<?php 
$server = "localhost";
$user = "root";
$pass = "";
$database = "omgph1";
$conn = new Mysqli($server, $user, $pass, $database);
if (!$conn) {
    die("<script>alert('Connection Failed.')</script>");
}
?>