<?php
session_start();
if(($_SESSION['email'] == "") && ($_SESSION['password'] == ""))
{
header("Location:index.php");
exit();
}
?>