<?php
  header('Content-type: application/json');
  include('../functions/functions.php');
  $data = json_decode(file_get_contents('php://input'));
  $email = $data->{"email"};
  $password = $data->{"password"};
  $device_token = $data->{"device_token"};
  $device_type= $data->{"device_type"};
  // Empty value Validation
  if (empty($email) || empty($password)){
	$response['responseCode'] = 400;
	$response['responseMessage'] = 'Email and Password fields are required.';
  }  
  else{
    $checkQry = mysql_query("SELECT * FROM users WHERE email = '".$email."' AND password = '".md5($password)."'");
    if(mysql_num_rows($checkQry) >0){
		$get_userInfo = mysql_fetch_assoc($checkQry);
		$userQry = mysql_query("SELECT * FROM device WHERE user_id = '".$get_userInfo['user_id']."'");
		$get_userID = mysql_fetch_assoc($userQry);
		$deviceEntry = addDeviceToken($get_userInfo['user_id'], $device_token,$device_type);
		if($deviceEntry == 1){
		    $response['responseCode'] = 200;
			$response['responseMessage'] = 'You have logged in successfully';
			$response['userInfo'] = array("user_id"=>$get_userInfo['user_id']);
        }
		else {
		    $response['responseCode'] = 400;
		    $response['responseMessage'] = 'Authentication Not Success.';
		}
	}	
	else {
		$response['responseCode'] = 400;
		$response['responseMessage'] = 'Email or Password is wrong.';
	}			

  }	
   $responseJson = json_encode($response);
   print $responseJson;
  
?>
