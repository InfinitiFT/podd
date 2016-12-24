<?php
  include('../functions/functions.php');
  basic_authentication($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);
  $data = json_decode(file_get_contents('php://input'));
  $contact_no = $data->{"contact_no"};
  $otp = $data->{"otp"};
  if(empty($otp) || empty($contact_no)){
    $response['responseCode'] = 200;  
    $response['responseMessage'] = 'All fields are required.';
  }
  else
  {
    $otp1 = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'],"SELECT * FROM `booked_records_restaurant` WHERE `contact_no`='".$contact_no."'"));
    if($otp1['otp'] == $otp)
    {
      $response['responseCode'] = 200;  
      $response['responseMessage'] = 'Otp verified successfully.';
    }
    else
    {
      $response['responseCode'] =400;  
      $response['responseMessage'] = 'Wrong otp.';

    }
  }
  //Sending response after json encoding
  $responseJson = json_encode($response);
  print $responseJson;
?>
