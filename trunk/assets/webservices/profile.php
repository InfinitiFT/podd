<?php
//error_reporting(E_ALL);
  header('Content-type: application/json');
  require_once('config.php');
  require_once('function.php');
  //Receiveing Input in Json and decoding
  $data = json_decode(file_get_contents('php://input'));
  $user_id = $data->{"user_id"};
  $check = mysql_query("SELECT * FROM users WHERE user_id = '".$user_id."'");
  if(mysql_num_rows($check) > 0){
		  $getID = mysql_fetch_assoc($check);
		  if(empty($getID)) {
				$getID = new stdClass();
			}
		  $userQry = mysql_query("SELECT * from users WHERE user_id = '".$getID['user_id']."'");
		  $get_userInfo = mysql_fetch_assoc($userQry);
		  if(empty($get_userInfo)) {
				$get_userInfo = new stdClass();
			}
		  $response['responseCode'] = 200;
		  $response['responseMessage'] = 'Your profile fetched successfully.';
		   $url=str_replace("webapi","image", url());
		    if($get_userInfo['profile_image'])
			{
			    $image = $url.$get_userInfo['profile_image'];
		    }
			else{
			     $image="";
			}
	  		 $response['userInfo'] = array("user_id"=>$get_userInfo['user_id'],"email"=>$get_userInfo['email'],"dob"=>$get_userInfo['dob'],"user_name"=>$get_userInfo['first_name'].' '.$get_userInfo['last_name'],"imageURL"=>$image);
	  		 $user_time_settings = mysql_query("SELECT * FROM time_setting Where user_id='".$get_userInfo['user_id']."'");
			 $user_time_settings1 = mysql_fetch_assoc($user_time_settings);
			 $response['green'] =$user_time_settings1['green'];
			 $response['yellow'] =$user_time_settings1['yellow'];
			 $response['red'] =$user_time_settings1['red']; 
    }
	else{
			$response['responseCode'] = 0;
			$response['responseMessage'] = 'Invalid User';
		}
	//Sending response after json encoding
 	$responseJson = json_encode($response);
  	print $responseJson;
  
?>


