<?php
include('config.php');
//Header Authntication
error_reporting(0);
function basic_authentication($authname, $authpw) {
 if (!isset($_SERVER['PHP_AUTH_USER'])) {
  header('WWW-Authenticate: Basic realm="My Realm"');
  header('HTTP/1.0 401 Unauthorized');
  echo 'Sorry you are not authorize to access this service.';
  exit;
 }
 else {
  $uid = authenticate($authname, $authpw);
  if(!$uid) {
   header('WWW-Authenticate: Basic realm="My Realm"');
   header('HTTP/1.0 401 Unauthorized');
   echo 'Invalid Credentials.';
   exit;
     }
 } 	
}
function authenticate($user, $password) {

    if (($user == 'admin')&&($password == '1234')) { return 1; }
    else { return 0; };
}
//Function for user Authntication 

function user_authenticate($email, $password) {
	$adminQuery = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'],"SELECT * FROM users WHERE email = '".$email."' AND password = '".md5($password)."'"));
	return $adminQuery;
}

//Function for validate Email
function validate_email_admin($email,$userID) {
	if($userID){
		
		$adminEmail = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'],"SELECT email FROM `users` WHERE email = '".$email."' and user_id!='".$userID."'"));
	}else{
		$adminEmail = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'],"SELECT email FROM `users` WHERE email = '".$email."'"));
	}
	return $adminEmail;
}
//Function for Get All data
function get_all_data($table) {
	$all_data = mysqli_query($GLOBALS['conn'],"SELECT * FROM ".$table."");
	return $all_data;
}
//Function delete data
function delete_data($table,$id) {
	if(mysqli_query($GLOBALS['conn'],"DELETE FROM '".$table."' WHERE '".$condition."' "))
	  return 1;
	else
	  return 0;	
}
//Function for Get current url
/*function url(){
		$url = sprintf("%s://%s%s",isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',$_SERVER['SERVER_NAME'],$_SERVER['REQUEST_URI']);
		$slashPos = (strrpos($url,'/'));
		$baseUrl = substr($url,0,$slashPos -5);
		return $baseUrl;
	}*/
function url(){
		
		return "http://172.16.0.9/PROJECTS/IOSNativeAppDevelopment/trunk/";
	}


 // function to get table data with condition

   function get_table_data_with_condition($table,$condition)
   {
     $all_data = mysqli_query($GLOBALS['conn'],"SELECT * FROM '".$table."' Where '".$condition."'");
	 return $all_data; 
   }

	/**
	* Author: CodexWorld
	* Author URI: http://www.codexworld.com
	* Function Name: getLatLong()
	* $address => Full address.
	* Return => Latitude and longitude of the given address.
	**/
	function getLatLong($address){
		
		if(!empty($address)){
			
			//Formatted address
			$formattedAddr = str_replace(' ','+',$address);
			//Send request and receive json data by address
			$geocodeFromAddr = file_get_contents("http://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&sensor=false"); 
			$output = json_decode($geocodeFromAddr);
			//Get latitude and longitute from json data
			$data['latitude']  = $output->results[0]->geometry->location->lat; 
			$data['longitude'] = $output->results[0]->geometry->location->lng;
			//Return latitude and longitude of the given address
			if(!empty($data)){
				return $data;
			}else{
				return false;
			}
		}else{
			return false;   
		}
	}
	
	// function create for image upload
	function imageUpload($folder,$filename,$filtTemp){
		$target_file = $folder . basename($filename);
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		if(move_uploaded_file($filtTemp, $target_file))
			return $folder.$filename;
		else
			return false;
			
	}

	function randomPassword() {
		$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$pass = array(); //remember to declare $pass as an array
		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		for ($i = 0; $i < 8; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass); //turn the array into a string
}
  // Function to send message
  function send_sms($to,$message){	
	require('twilio-php/Services/Twilio.php'); 

	$account_sid = 'ACb3a57cb22ea64c448c2ee9e84f992988'; 
	$auth_token = '51a67c0cc1f067fcce6821d447aba75a'; 
	$client = new Services_Twilio($account_sid, $auth_token); 
	try {
    $client->account->messages->create(array( 
	'To' => $to, 	
	'From' => "+447481342650", 
	'Body' => "".$message, 	
	)); 

	return true;

	}
    catch (Services_Twilio_RestException $e)
    {
        return $e->getMessage();
    }
}


function bookingTimeChange($booking_date,$booking_time){
	$timestamp = strtotime($booking_time) - 60*60;
	$time = date('H:i', $timestamp);
	$currentDate = date("Y-m-d");
	$currentTime = date("H:i");
	if($booking_date >= $currentDate){
		if($booking_date == $currentDate){
			if(strtotime($currentTime) <=strtotime($time))
				return 1;
		   else
			   return 2;
		}else{
			return 1;
		}
	}else{
		return 2;
		
	}
}


function findtimeInterval($start,$end){
	$startTime = explode(':',$start);
	$endTime = explode(':',$end);
	$arr = array();
	for($hours= $startTime[0]; $hours <=$endTime[0]; $hours++){ // the interval for hours is '1'
		for($mins=0; $mins<60; $mins+=30){
			 // the interval for mins is '30'
			if($endTime[0] == $hours){
				if($endTime[1] != '00'){
					if(str_pad($mins,2,'0',STR_PAD_LEFT) != '30')
						$arr[] = str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT);
				}
			}else{
				$arr[] = str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT);
			}
		}
	}
	return json_encode($arr);
}

function findtimeIntervalweb($start,$end){
	$startTime = explode(':',$start);
	$endTime = explode(':',$end);
	$arr = array();
	for($hours= $startTime[0]; $hours <=$endTime[0]; $hours++){ // the interval for hours is '1'
		for($mins=0; $mins<60; $mins+=30){
			 // the interval for mins is '30'
			if($endTime[0] == $hours){
				if($endTime[1] != '00'){
					if(str_pad($mins,2,'0',STR_PAD_LEFT) != '30')
						$arr[] = str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT);
				}
			}else{
				$arr[] = str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT);
			}
		}
	}
	return $arr;
}


function bookingTimeChanges($time,$bookingID){
	$update = mysqli_query($GLOBALS['conn'],"UPDATE `booked_records_restaurant` SET `booking_time`='".$time."' WHERE `booking_id`='".$bookingID."'");
	if($update)
		return 1;
	else
		return 2;
}

function findResturantEmail($resturantID){
	$record = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'],"SELECT u.email FROM `restaurant_details` as d join users as u on d.`user_id` = u.`user_id` WHERE `restaurant_id`='".$resturantID."'"));
	return $record;

}

function findAdminEmail(){
	$record = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'],"SELECT * FROM `users` WHERE `role`=1"));
	return $record['email'];

} 
?>
