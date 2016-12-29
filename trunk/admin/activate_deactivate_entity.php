<?php
include('../functions/functions.php');
$type = $_POST['pagetype'];
$id   = $_POST['id'];
$status   = $_POST['status'];  
if($type == "service_management")
{
  if(mysqli_query($GLOBALS['conn'],"UPDATE `service_management` SET `status`= '".mysqli_real_escape_string($GLOBALS['conn'],$status)."' WHERE `service_id` = '".mysqli_real_escape_string($GLOBALS['conn'],$id)."'"))
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
	if(mysqli_query($GLOBALS['conn'],"UPDATE `users` SET `status`= '".mysqli_real_escape_string($GLOBALS['conn'],$status)."' WHERE `user_id` = '".mysqli_real_escape_string($GLOBALS['conn'],$id)."'"))
  {
    $restaurant_id = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'],"SELECT * FROM `restaurant_details` WHERE `user_id` = '".mysqli_real_escape_string($GLOBALS['conn'],$id)."'"));
    if(mysqli_query($GLOBALS['conn'],"UPDATE `restaurant_details` SET `status`= '".mysqli_real_escape_string($GLOBALS['conn'],$status)."' WHERE `restaurant_id` = '".$restaurant_id['restaurant_id']."'"))
     {
       echo "success";
     }
     else
     {
       echo "error";
     }
  
  }
  else
  {
  	echo "error";
  }
}
else if($type == "restaurant")
{
  if(mysqli_query($GLOBALS['conn'],"UPDATE `restaurant_details` SET `status`= '".mysqli_real_escape_string($GLOBALS['conn'],$status)."' WHERE `restaurant_id` = '".mysqli_real_escape_string($GLOBALS['conn'],$id)."'"))
  {
    $user_id = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'],"SELECT * FROM `restaurant_details` WHERE `restaurant_id` = '".mysqli_real_escape_string($GLOBALS['conn'],$id)."'"));
    if(mysqli_query($GLOBALS['conn'],"UPDATE `users` SET `status`= '".mysqli_real_escape_string($GLOBALS['conn'],$status)."' WHERE `user_id` = '".mysqli_real_escape_string($GLOBALS['conn'],$user_id['user_id'])."'"))
     {
       echo "success";
     }
     else
     {
       echo "error";
     }
  }
  else
  {
    echo "error";
  }
}
else if($type == "menu_management")
{
  if(mysqli_query($GLOBALS['conn'],"UPDATE `restaurant_menu_details` SET `status`= '".mysqli_real_escape_string($GLOBALS['conn'],$status)."' WHERE `id` = '".mysqli_real_escape_string($GLOBALS['conn'],$id)."'"))
  {
    echo "success";
  }
  else
  {
    echo "error";
  }
}
else if($type == "items")
{
  if(mysqli_query($GLOBALS['conn'],"UPDATE `items` SET `status`= '".mysqli_real_escape_string($GLOBALS['conn'],$status)."' WHERE `id` = '".mysqli_real_escape_string($GLOBALS['conn'],$id)."'"))
  {
    echo "success";
  }
  else
  {
    echo "error";
  }
} 
 
?>

  