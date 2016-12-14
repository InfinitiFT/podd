<?php
include('../functions/functions.php');
$type = $_POST['pagetype'];
$id   = $_POST['id'];
$status   = $_POST['status'];  
if($type == "service_management")
{
  if(mysqli_query($GLOBALS['conn'],"UPDATE `service_management` SET `status`= '".$status."' WHERE `service_id` = '".$id."'"))
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
	if(mysqli_query($GLOBALS['conn'],"UPDATE `users` SET `status`= '".$status."' WHERE `user_id` = '".$id."'"))
  {
  	echo "success";
  }
  else
  {
  	echo "error";
  }

}
 
 
?>

  