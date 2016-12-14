<?php
  include('../functions/functions.php');
  $data = json_decode(file_get_contents('php://input'));
  $user_id = $data->{"user_id"};
  $device_token = $data->{"device_token"};
  $device_type= $data->{"device_type"};
  $userQry = mysql_query("DELETE FROM device WHERE user_id = '".$user_id."' AND device_token = '".$device_token."'");
  if($userQry){
	  $response['responseCode'] = 200;	
	  $response['responseMessage'] = 'Logout successfully.';
	}	
  else{
    $response['responseCode'] = 400;  
    $response['responseMessage'] = 'Error.';
  } 
  //Sending response after json encoding
  $responseJson = json_encode($response);
  print $responseJson; 
?>
