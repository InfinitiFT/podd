<?php
$servername = "localhost";
$username 	= "pro_stephen";
$password 	= "@##sweWE";
$database 	= "pro_stephen_23feb17";
// Create connection
$conn = mysqli_connect($servername, $username, $password,$database);
$GLOBALS['conn'] =$conn;
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
 //date_default_timezone_set('Asia/Calcutta'); 
 date_default_timezone_set('Europe/London');
?>
