<?php
include('../functions/functions.php');
$type = $_POST['pagetype'];
$id   = $_POST['id'];
//print_r($_POST);
//$userQry = mysql_query("DELETE FROM '".$_POST['type']."' WHERE service_id = '".$_POST['id']."'"); 
if($type == "service_management")
{
  if(mysqli_query($GLOBALS['conn'],"DELETE FROM `service_management` WHERE `service_id` = '".$id."'"))
  {
    echo "success";
  }
  else
  {
    echo "error";
  }
} 
else if($type == "users")
{
	if(mysqli_query($GLOBALS['conn'],"DELETE FROM `users` WHERE `user_id` = '".$id."'"))
  {
    echo "success";
  }
  else
  {
    echo "error";
  }

}
 

?>

  