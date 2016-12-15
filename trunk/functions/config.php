<?php
$servername = "localhost";
$username 	= "Dev_IOSNativeApp";
$password 	= "mobi123DB";
$database 	= "Dev_IOSNativeAppDevelopment_07Dec16_Ravi";
// Create connection
$conn = mysqli_connect($servername, $username, $password,$database);
$GLOBALS['conn'] =$conn;
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
 
?>