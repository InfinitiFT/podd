<?php
include('../functions/functions.php');
$type = $_POST['pagetype'];
$id   = $_POST['id'];
$status   = $_POST['status'];  
if($type == "booked_restaurant")
{
  if(mysqli_query($GLOBALS['conn'],"UPDATE `booked_records_restaurant`  SET `booking_status`= '".$status."' WHERE `booking_id` = '".$id."'"))
  {
  	
  	if(trim($status) == '2')
  	{
      $booking_details = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'], "SELECT * FROM `booked_records_restaurant` brr join restaurant_details rd on brr.restaurant_id = rd.restaurant_id  WHERE `booking_id`='" . mysqli_real_escape_string($conn, trim($id)) . "'"));
      $booking_date = date('l', strtotime($booking_details['booking_date'])); // note: first arg to date() is lower-case L
      $date = date_create ($booking_details['booking_date']);
      $message = "Your booking has been confirmed at ".$booking_details['restaurant_name'].",".$booking_details['restaurant_full_address']."on".$booking_date.",".date_format($date,"d M Y")."at".$booking_details['booking_time']."";
	  send_sms($booking_details['contact_no'],preg_replace('/^\s+|\s+$|\s+(?=\s)/', '', $message));
	   
  	}
  	
    else
    {

    }
  	echo "success";
  }
  else
  {
  	echo "error";
  }
}
if($type == "booked_restaurant_delivery")
{
  if(mysqli_query($GLOBALS['conn'],"UPDATE `delivery_bookings` SET `delivery_status`= '".$status."' WHERE `delivery_id` = '".$id."'"))
  {
    
    if(trim($status) == '2')
    {
      
    }
    else
    {

    }
    echo "success";
  }
  else
  {
    echo "error";
  }
}

 
 
?>

  