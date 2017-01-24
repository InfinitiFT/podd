<?php
ob_start();
session_start();
if(($_SESSION['email'] == "") && ($_SESSION['password'] == ""))
{
   header("Location:index.php");
   exit();
}
/*if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    // last request was more than 30 minutes ago
    session_unset();     // unset $_SESSION variable for the run-time 
    session_destroy(); 
    header("Location:index.php");
    exit();  // destroy session data in storage
}
$_SESSION['LAST_ACTIVITY'] = time();*/ // update last activity time stamp
?>

