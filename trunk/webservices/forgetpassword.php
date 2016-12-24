<?php
  header('Content-type: application/json');
  include('../functions/functions.php');
   $data = json_decode(file_get_contents('php://input'));
   $email = $data->{"email"};
    if (empty($email)) {
		$response['responseCode'] = 400;
		$response['responseMessage'] = 'email address field is required.';
	}
  	else {
		$userQry = mysql_query("SELECT * FROM users WHERE email  = '".$email."'");
		$userData = mysql_fetch_assoc($userQry);
		if(mysql_num_rows($userQry) == 0) {
			$response['responseCode'] = 400;
			$response['responseMessage'] = 'Sorry,email does not exist. Please try again.'; //response for failure case 1
		}else {
				$password = rand();
				$updateQry =  mysql_query("UPDATE users SET password = '".md5($password)."' WHERE email = '".$email."'");
				// Mail Function with HTML template
				$to = $email;
				$subject = "Password Recovery Management";
				$message = 'Hello'.' '.$userData['name'].' '.'your new password is'.' '.$password.'.';

			// Always set content-type when sending HTML email
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

			// More headers
			$headers .= 'From: IPODD' . "\r\n";

			if(mail($to,$subject,$message,$headers)) {
				
				$response['responseCode'] = 200;
				$response['responseMessage'] = 'Please check your inbox for your new password'; //response for success case
				
			}
			else {
				$response['responseCode'] = 0;
				$response['responseMessage'] = 'Email Sending error.'; //response for success case 2
			}
		}
  }
  //Sending response after json encoding
  $responseJson = json_encode($response);
  print $responseJson;
  
?>
	
		
		

