<?php
  include('../functions/functions.php');
  basic_authentication($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);
  $data = json_decode(file_get_contents('php://input'));
  $contact_no = $data->{"contact_no"};
  if(empty($contact_no)){
    $response['responseCode'] = 200;  
    $response['responseMessage'] = 'All fields are required.';
  }
  else
  {
    $random_number = rand(1000,9999);
    $status_varification = mysqli_query($GLOBALS['conn'],"SELECT * FROM `number_verification` WHERE `contact_no`='".mysqli_real_escape_string($conn,trim($contact_no))."'");
    if($status_varification->num_rows!= 0)
    {
       if(mysqli_query($GLOBALS['conn'],"DELETE FROM `number_verification` WHERE `contact_no`='" .mysqli_real_escape_string($conn,trim($contact_no)) . "'")){
            if(mysqli_query($GLOBALS['conn'],"UPDATE `number_verification` SET `otp`='".mysqli_real_escape_string($conn,trim($random_number))."' WHERE `contact_no`='".mysqli_real_escape_string($conn,trim($contact_no))."'"))
             {
                $resend_message = send_sms($contact_no,$random_number);
                if($resend_message == "1"){
                  $response['responseCode'] = 200;  
                  $response['responseMessage'] = 'Otp sent successfully.';

                }
                else
                { 
                  $response['responseCode'] = 400;  
                  $response['responseMessage'] = $resend_message;
                }
             }
             else{
                $response['responseCode'] = 400;  
                $response['responseMessage'] = "Error";
             }
       }
        else{
                $response['responseCode'] = 400;  
                $response['responseMessage'] = "Error";
             } 

    }
     else{
          $response['responseCode'] = 400;  
          $response['responseMessage'] = "Contact number is not registerd.";
       }
  } 
  //Sending response after json encoding
  $responseJson = json_encode($response);
  print $responseJson;
?>
