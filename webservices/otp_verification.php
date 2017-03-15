<?php
header('Content-type: application/json');
include('../functions/functions.php');
//Receiveing Input in Json and decoding
basic_authentication($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);
$data                = json_decode(file_get_contents('php://input'));
$contact_no          = $data->{"contact_no"};
$number = mysqli_query($GLOBALS['conn'], "SELECT * FROM `number_verification` WHERE `contact_no`='" . mysqli_real_escape_string($GLOBALS['conn'],$contact_no). "'");

if($number->num_rows > 0)
{
    $random_number = rand(1000,9999);
     if(mysqli_query($GLOBALS['conn'],"UPDATE `number_verification` SET `otp`='".mysqli_real_escape_string($conn,trim($random_number))."' WHERE `contact_no`='".mysqli_real_escape_string($conn,trim($contact_no))."'"))
      {
         $resend_message = send_sms($contact_no,"Your verification code is".' '.$random_number.'.');
          if ($resend_message == "1") {
            $response['responseCode']        = 200;
            $response['responseMessage']     = 'Please verify your number.';
          } else {
            $response['responseCode']    = 400;
            $response['responseMessage'] = $resend_message;
          }
       } else {
          $response['responseCode']    = 400;
          $response['responseMessage'] = "Database Error ";
        }
}
else
{
  $random_number = rand(1000,9999);
  if (mysqli_query($GLOBALS['conn'], "INSERT INTO `number_verification`(`contact_no`, `otp`) VALUES ('" . mysqli_real_escape_string($GLOBALS['conn'],$contact_no) . "','" . mysqli_real_escape_string($GLOBALS['conn'],$random_number). "')")) {
  $resend_message = send_sms($contact_no,"Your verification code is".' '.$random_number.'.');
  if ($resend_message == "1") {
    $response['responseCode']        = 200;
    $response['responseMessage']     = 'Please verify your number.';
  } else {
    $response['responseCode']    = 400;
    $response['responseMessage'] = $resend_message;
  }
  } else {
    $response['responseCode']    = 400;
    $response['responseMessage'] = "Database Error ";
  }
}


//Sending response after json encoding
$responseJson = json_encode($response);
print $responseJson;

?>