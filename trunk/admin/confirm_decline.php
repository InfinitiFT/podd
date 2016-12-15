<?php
include('../functions/functions.php');
$type = $_POST['pagetype'];
$id   = $_POST['id'];
$status   = $_POST['status'];  
if($type == "booked_restaurant")
{
  if(mysqli_query($GLOBALS['conn'],"UPDATE `booked_records_restaurant` SET `booking_status`= '".$status."' WHERE `booking_id` = '".$id."'"))
  {
  	echo "success";
  }
  else
  {
  	echo "error";
  }
}

 
 
?>

  