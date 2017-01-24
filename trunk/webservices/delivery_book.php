<?php
include('../functions/functions.php');
basic_authentication($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);
$data             = json_decode(file_get_contents('php://input'));
//print_r($data);exit;
$restaurant_id    = $data->{"restaurant_id"};
$delivery_date     = $data->{"booking_date"};
$delivery_time     = $data->{"booking_time"};
$order_details    = $data->{"order_details"};
$name             = $data->{"name"};
$email            = $data->{"email"};
$contact_no       = $data->{"contact_no"};
$otp = $data->{"otp"};

if (empty($otp) || empty($contact_no) || empty($restaurant_id) || empty($delivery_date) || empty($delivery_time) || empty($order_details)) {
    
    $response['responseCode']    = 200;
    $response['responseMessage'] = 'All fields are required.';
} else {
        $otp1 = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'], "SELECT * FROM `number_verification` WHERE `contact_no`='" . mysqli_real_escape_string($conn, trim($contact_no)) . "'"));
        if ($otp1['otp'] == $otp) {
        
         if (mysqli_query($GLOBALS['conn'], "INSERT INTO `delivery_bookings`(`restaurant_id`, `delivery_date`, `delivery_time`, `name`, `email`, `contact_no`,`verification`) VALUES('" .mysqli_real_escape_string($GLOBALS['conn'], $restaurant_id) . "','" . mysqli_real_escape_string($GLOBALS['conn'], $delivery_date) . "','" . mysqli_real_escape_string($GLOBALS['conn'], $delivery_time) . "','" . mysqli_real_escape_string($GLOBALS['conn'], $name) . "','" . mysqli_real_escape_string($GLOBALS['conn'], $email) . "','" . mysqli_real_escape_string($GLOBALS['conn'], $contact_no) . "','1')")) {
          
            $booking_order_id = mysqli_insert_id($GLOBALS['conn']);

            if(!empty($order_details))
            {
               foreach($order_details as $order){
               
                mysqli_query($GLOBALS['conn'], "INSERT INTO `order_item`(`order_id`, `meal_name`, `subtitle_name`, `item_name`, `price`) VALUES ('" . mysqli_real_escape_string($GLOBALS['conn'], $booking_order_id) . "','" . mysqli_real_escape_string($GLOBALS['conn'], $order->meal_id) . "','" . mysqli_real_escape_string($GLOBALS['conn'],$order->subtitle_id) . "','" . mysqli_real_escape_string($GLOBALS['conn'], $order->item_id) . "','" . mysqli_real_escape_string($GLOBALS['conn'], $order->price) . "')");
               
               }

               if (mysqli_query($GLOBALS['conn'], "DELETE FROM `number_verification` WHERE `contact_no`='" . $contact_no . "'")) {
                   
                   $response['responseCode']    = 200;
                   $response['responseMessage'] = 'Order booked Successfully.';

                 }
            
               else {
                $response['responseCode']    = 400;
                $response['responseMessage'] = 'Database Errors.';
                }
            

            }
            else
            {
              $response['responseCode']    = 400;
              $response['responseMessage'] = 'Order details is empty.';

            }   
        } else {
            $response['responseCode']    = 400;
            $response['responseMessage'] = 'Booking Errors.';
            
            
        }
        
    } else {
        $response['responseCode']    = 400;
        $response['responseMessage'] = 'Wrong otp.';
        
    }
}
//Sending response after json encoding
$responseJson = json_encode($response);
print $responseJson;
?>
