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

    if (($user == 'Android123Native')&&($password == 'native@123#')) { return 1; }
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
function validate_items($item) {		
$item = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'],"SELECT name FROM `items` WHERE name = '".$item."'"));	
return $item;
}
function validate_items_edit($item,$itemId) {		
$item = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'],"SELECT name FROM `items` WHERE name = '".$item."' and id != '".$itemId."'"));	
return $item;
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
		
		return "http://ec2-52-1-133-240.compute-1.amazonaws.com/PROJECTS/IOSNativeAppDevelopment/trunk/";
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



function bookingTimeChange($booking_date,$bookingTime){
	$timestamp = strtotime($bookingTime) - 60*60;
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
function findtimeIntervalwebGlance($start,$end){
	$startTime = explode(':',$start);
	$endTime = explode(':',$end);
	$arr = array();
	$i =0;
	for($hours= $startTime[0]; $hours <=$endTime[0]; $hours++){ // the interval for hours is '1'
		for($mins=0; $mins<60; $mins+=30){
			 // the interval for mins is '30'
			 
			if($endTime[0] == $hours){
				if(($endTime[1] == '00') &&(str_pad($mins,2,'0',STR_PAD_LEFT) == '00')){
					$arr[] = str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT);
				}
				else if($endTime[1] == '30'){
					$arr[] = str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT);
				}
			}else{
				if($startTime[0] == $hours){
					if(($startTime[1] == '00') &&(str_pad($mins,2,'0',STR_PAD_LEFT) == '00')){
						$arr[] = str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT);
					}
				else if($startTime[1] == '30'){
					$arr[] = str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT);
				}
			}else{
				$arr[] = str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT);
				
			}
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
	$record = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'],"SELECT u.email,d.restaurant_name FROM `restaurant_details` as d join users as u on d.`user_id` = u.`user_id` WHERE `restaurant_id`='".$resturantID."'"));
	return $record;

}

function findAdminEmail(){
	$record = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'],"SELECT * FROM `users` WHERE `role`=1"));
	return $record['email'];

} 

function get_all_data_with_condition($table,$columnName,$value)
{
	/*$all_data = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'],"SELECT * FROM '".$table."' WHERE '".mysqli_real_escape_string($GLOBALS['conn'],$column_name)."' LIKE '%".mysqli_real_escape_string($GLOBALS['conn'],$value)."%'"));*/
	echo "SELECT * FROM '".$table."' WHERE '".mysqli_real_escape_string($GLOBALS['conn'],$columnName)."' LIKE '%".mysqli_real_escape_string($GLOBALS['conn'],$value)."%'";
	exit;
	return $all_data;
}


function bookingRecordStatus($status,$session){
	if($session!=""){
		$data = mysqli_query($GLOBALS['conn'],"SELECT *,brr.email as booking_email,u.email as user_email FROM booked_records_restaurant brr JOIN restaurant_details rd ON brr.restaurant_id = rd.restaurant_id JOIN users u ON rd.user_id = u.user_id Where brr.restaurant_id = '".$session."' AND brr.booking_status = '".$status."' AND brr.booking_date >= CURRENT_DATE() order by booking_id desc");
    }else{
		$data = mysqli_query($GLOBALS['conn'],"SELECT *,brr.email as booking_email,u.email as user_email FROM booked_records_restaurant brr JOIN restaurant_details rd ON brr.restaurant_id = rd.restaurant_id JOIN users u ON rd.user_id = u.user_id Where `booking_date` >= CURRENT_DATE() AND brr.booking_status = '".$status."' order by booking_id desc");
	}	
		$currentTime = date("H:i");
        $currentDate = date("Y-m-d");
        $html ='';
	while($record = mysqli_fetch_assoc($data)){
		 $recordShow = 0;
		  if($currentDate == $record['booking_date']){
			 if(strtotime($currentTime) <= strtotime(date('H:i', strtotime($record['booking_time'].'+1 hour'))))
			   $recordShow =1;
			}else{
				$recordShow =1;
			}	
		if($recordShow){
			$date = date_create ($record['booking_date']);
			if($record['booking_status']=="0"){ 
			  $statusData = "Declined";
			}
			else if($record['booking_status']=="1"){
			   $statusData =  "Pending";
			}
			else{
			   $statusData =  "Accepted";             
			}
                            
				$html .= '<tr>
                          <td>'.$record['name'].'</td>
                          <td>'.$record['contact_no'].'</td>
                          <td>'.$record['booking_email'].'</td>
                           <td>'.$record['user_email'].'</td>
                          <td>'.date_format($date,"d M Y").'</td>
                          <td>'.$record['booking_time'].'</td>
                          <td>'.$record['number_of_people'].'</td>
                           <td>'.$statusData.'</td>
                          <td>';
					  if($record['booking_status']=="1"){
						$html .= '<button type="button" id="confirm-'.$record['booking_id'].'" class="btn btn-round btn-success">Accept</button>
						 <button type="button" class="btn btn-round btn-warning"  id="declines-'.$record['booking_id'].'" data-toggle="modal" data-target="#myModal">Decline</button>';
					  }else if($record['booking_status']=="2")
					  {
							$html .= '<button type="button" class="btn btn-round btn-warning"  id="declines-'.$record['booking_id'].'" data-toggle="modal" data-target="#myModal">Decline</button>';
							$change = bookingTimeChange($record['booking_date'],$record['booking_time']);
						   if($change==1){
								$html .= '<button type="button" id="timeChange-'.$record['booking_id'].'-'.$record['opening_time'].'-'.$record['closing_time'].'" class="btn btn-round btn-primary" data-toggle="modal" data-target="#myModal1">Modify</button>';
							} 
					   
					 }else{
						   $html .= '<button type="button" id="confirm-'.$record['booking_id'].'" class="btn btn-round btn-success">Accept</button>';
						 
						   $change = bookingTimeChange($record['booking_date'],$record['booking_time']);
						   if($change==1){
						   $html .= '<button type="button" id="timeChange-'.$record['booking_id'].'-'.$record['opening_time'].'-'.$record['closing_time'].'" class="btn btn-round btn-primary" data-toggle="modal" data-target="#myModal1">Modify</button>';
						   }
						  } 
						$html .= '<a href="edit_booking.php?id='.$record['booking_id'].'&list=list" class="btn btn-round btn-info">Edit</a></td></tr>';
	    }
    }
    print_r($html);
		
}

//Get all items
function get_all_items(){
	$allItems = mysqli_query($GLOBALS['conn'],"SELECT * FROM items WHERE status = 1");
	return $allItems;
}
	
function items_name($itemsName){
	$id = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'],"SELECT id FROM items WHERE name = '".$itemsName."'"));
	return $id['id'];
}	
function subtitle_name($subtitleName){
	$id = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'],"SELECT subtitle_id FROM subtitle WHERE subtitle = '".$subtitleName."'"));
	return $id['subtitle_id'];
}	
function get_booking_details($id){
	$get_details = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'],"SELECT * FROM booked_records_restaurant WHERE booking_id = '".$id."'"));
	return $get_details;
}
function getQueryByType($status)
{	
if($_SESSION['restaurant_id']!="")
  {   	  
  $data = mysqli_query($GLOBALS['conn'],"SELECT * FROM booked_records_restaurant brr JOIN restaurant_details rd ON brr.restaurant_id = rd.restaurant_id Where brr.restaurant_id = '".$_SESSION['restaurant_id']."' AND `booking_date` <= CURRENT_DATE() order by brr.booking_id desc");
  return $data;
  }
  else
  {	  
    $data = mysqli_query($GLOBALS['conn'],"SELECT * FROM booked_records_restaurant brr JOIN restaurant_details rd ON brr.restaurant_id = rd.restaurant_id Where `booking_date` <= CURRENT_DATE() order by brr.booking_id desc");
    return $data;
  }
	
}
// Restaurant meal insertion
function getQueryByDate($Date)
{	
if($_SESSION['restaurant_id']!="")
  {   	  
  $data = mysqli_query($GLOBALS['conn'],"SELECT * FROM booked_records_restaurant brr JOIN restaurant_details rd ON brr.restaurant_id = rd.restaurant_id Where brr.restaurant_id = '".$_SESSION['restaurant_id']."' AND `booking_date` <= CURRENT_DATE() order by brr.booking_id desc");
  return $data;
  }
  else
  {	  
    $data = mysqli_query($GLOBALS['conn'],"SELECT * FROM booked_records_restaurant brr JOIN restaurant_details rd ON brr.restaurant_id = rd.restaurant_id Where `booking_date` <= CURRENT_DATE() order by brr.booking_id desc");
    return $data;
  }
	
}
//function to get query by date
function getQueryByBothDate($fromdate,$todate)
{
if($_SESSION['restaurant_id']!="")
  {
	$data = mysqli_query($GLOBALS['conn'],"SELECT * FROM booked_records_restaurant brr JOIN restaurant_details rd ON brr.restaurant_id = rd.restaurant_id Where brr.restaurant_id = '".$_SESSION['restaurant_id']."' AND `booking_date` <= CURRENT_DATE() order by brr.booking_id desc");
	return $data;
  }
  else
  {	  
    $data = mysqli_query($GLOBALS['conn'],"SELECT * FROM booked_records_restaurant brr JOIN restaurant_details rd ON brr.restaurant_id = rd.restaurant_id Where `booking_date` <= CURRENT_DATE() order by brr.booking_id desc");
    return $data;
  }
	
}
// Restaurant meal insertion
function restaurant_meal_insertion($restaurantId,$mealId,$deliverFood)
{
	$count_num = mysqli_query($GLOBALS['conn'],"SELECT * FROM restaurant_meal_details Where restaurant_id = '".$restaurantId."' AND meal = '".$mealId."'");
	if(mysqli_num_rows($count_num)>0)
	{	
		$restaurantMealid = mysqli_fetch_assoc($count_num);
        mysqli_query($GLOBALS['conn'],"UPDATE `restaurant_meal_details` SET `deliver_food`='".$deliverFood."' Where restaurant_id = '".$restaurantMealid['id']."'");
        return $restaurantMealid['id'];
	}
	else{
		mysqli_query($GLOBALS['conn'],"INSERT INTO `restaurant_meal_details`(`restaurant_id`,`meal`,`deliver_food`) VALUES ('".$restaurantId."','".$mealId."','".$deliverFood."')");
		return mysqli_insert_id($GLOBALS['conn']);
	}
}
//function to count number of bookings
function count_number_of_records($status)
{
	$time= time();
    $time = date('H:i:s', strtotime('-1 hour'));
	if(@$_SESSION['restaurant_id'] != "")
        {
            $count = mysqli_num_rows(mysqli_query($GLOBALS['conn'],"SELECT brr.booking_id,brr.* FROM booked_records_restaurant brr JOIN restaurant_details rd ON brr.restaurant_id = rd.restaurant_id Where brr.restaurant_id = '".$_SESSION['restaurant_id']."' AND `booking_status`= '".$status."' AND `booking_date` > CURRENT_DATE() OR brr.booking_id in(SELECT brr1.booking_id FROM booked_records_restaurant brr1  JOIN restaurant_details rd1 ON brr1.restaurant_id = rd1.restaurant_id Where booking_time > '".$time."' AND `booking_date` = CURRENT_DATE() AND `booking_status`='".$status."' AND brr1.restaurant_id = '".$_SESSION['restaurant_id']."') order by brr.booking_id desc"));
        }
    else
        {
            $count=mysqli_num_rows(mysqli_query($GLOBALS['conn'],"SELECT brr.booking_id,brr.* FROM booked_records_restaurant brr JOIN restaurant_details rd ON brr.restaurant_id = rd.restaurant_id Where `booking_date` > CURRENT_DATE() AND `booking_status`= '".$status."' OR brr.booking_id in(SELECT brr1.booking_id FROM booked_records_restaurant brr1  JOIN restaurant_details rd1 ON brr1.restaurant_id = rd1.restaurant_id Where booking_time > '".$time."' AND `booking_date` = CURRENT_DATE() AND `booking_status`= '".$status."') order by brr.booking_id desc"));
        }
  return $count;
}
//function to count number of bookings delivery section
function count_number_of_records_delivery($status)
{
	$time= time();
    $time = date('H:i:s', strtotime('-1 hour'));
	if(@$_SESSION['restaurant_id'] != "")
        {
            $count = mysqli_num_rows(mysqli_query($GLOBALS['conn'],"SELECT db.delivery_id,db.* FROM delivery_bookings db JOIN restaurant_details rd ON db.restaurant_id = rd.restaurant_id Where db.restaurant_id = '".$_SESSION['restaurant_id']."' AND `delivery_status`= '".$status."' AND `delivery_date` > CURRENT_DATE() OR db.delivery_id in(SELECT db1.delivery_id FROM delivery_bookings db1  JOIN restaurant_details rd1 ON db1.restaurant_id = rd1.restaurant_id Where delivery_time > '".$time."' AND `delivery_date` = CURRENT_DATE() AND brr1.restaurant_id = '".$_SESSION['restaurant_id']."' AND `delivery_status`= '".$status."') order by db.delivery_id desc"));
        }
    else
        {
            $count= mysqli_num_rows(mysqli_query($GLOBALS['conn'],"SELECT db.delivery_id,db.* FROM delivery_bookings db JOIN restaurant_details rd ON db.restaurant_id = rd.restaurant_id Where `delivery_date` > CURRENT_DATE() AND `delivery_status`= '".$status."' OR db.delivery_id in(SELECT db1.delivery_id FROM delivery_bookings db1  JOIN restaurant_details rd1 ON db1.restaurant_id = rd1.restaurant_id Where delivery_time > '".$time."' AND `delivery_date` = CURRENT_DATE() AND `delivery_status`= '".$status."') order by db.delivery_id desc"));
        }
  return $count;
}
//url variable value encryption 
function encrypt_var($string) {
  $key = "PODD321"; //key to encrypt and decrypts.
  $result = '';
  $test = "";
   for($i=0; $i<strlen($string); $i++) {
     $char = substr($string, $i, 1);
     $keychar = substr($key, ($i % strlen($key))-1, 1);
     $char = chr(ord($char)+ord($keychar));
     $test[$char]= ord($char)+ord($keychar);
     $result.=$char;
   }

   return urlencode(base64_encode($result));
}
//url variable value decryption
function decrypt_var($string) {
    $key = "PODD321"; //key to encrypt and decrypts.
    $result = '';
    $string = base64_decode(urldecode($string));
   for($i=0; $i<strlen($string); $i++) {
     $char = substr($string, $i, 1);
     $keychar = substr($key, ($i % strlen($key))-1, 1);
     $char = chr(ord($char)-ord($keychar));
     $result.=$char;
   }
   return $result;
}
//function to get options for select box in add restaurant

function  get_select_option()
{
	$i =0;
	$option="";
	for($hours=0; $hours<24; $hours++) // the interval for hours is '1'
		for($mins=0; $mins<60; $mins+=30){// the interval for mins is '30'
			if($i == 0)

				$option .= '<option value="">'.str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT).'</option>';
			else
				$option .= '<option value="'.str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT).'">'.str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT).'</option>';
				$i =$i+1;
	   }
    return $option;
} 
//function to get options for select box in edit restaurant for opening time
function  get_select_option_open_edit($openTime)
{
	$i =0;
	$option="";
	for($hours=0; $hours<24; $hours++) {// the interval for hours is '1'
		for($mins=0; $mins<60; $mins+=30) // the interval for mins is '30'
			{
			   if($i == 0){
				 $option .= '<option value="">'.str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT).'</option>';
			    }    
			    else{ 		
					$selected ='';
					if(str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT) == $openTime)
						$selected ='selected';
					$option .= '<option value="'.str_pad($hours,2,'0',STR_PAD_LEFT).':'
							   .str_pad($mins,2,'0',STR_PAD_LEFT).'" '.$selected.'>'.str_pad($hours,2,'0',STR_PAD_LEFT).':'
							   .str_pad($mins,2,'0',STR_PAD_LEFT).'</option>';
				}
				$i =$i+1;
			}
		}
	return $option;						
} 
//function to get options for select box in edit restaurant for closing time
function  get_select_option_close_edit($closeTime)
{
	$i =0;
	$option="";
	for($hours=0; $hours<24; $hours++) {// the interval for hours is '1'
		for($mins=0; $mins<60; $mins+=30) // the interval for mins is '30'
			{
			   if($i == 0){
				 $option .= '<option value="">'.str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT).'</option>';
			    }    
			    else{ 		
					$selected ='';
					if(str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT) == $closeTime)
						$selected ='selected';
					$option .= '<option value="'.str_pad($hours,2,'0',STR_PAD_LEFT).':'
							   .str_pad($mins,2,'0',STR_PAD_LEFT).'" '.$selected.'>'.str_pad($hours,2,'0',STR_PAD_LEFT).':'
							   .str_pad($mins,2,'0',STR_PAD_LEFT).'</option>';
				}
				$i =$i+1;
			}
		}
	return $option;				
} 
function num_of_booking($restaurantId)
{
	$num_count = mysqli_num_rows(mysqli_query($GLOBALS['conn'], "SELECT brr.booking_id,brr.* FROM booked_records_restaurant brr JOIN restaurant_details rd ON brr.restaurant_id = rd.restaurant_id Where brr.restaurant_id = '" . $restaurantId . "' AND `booking_date` > CURRENT_DATE() OR brr.booking_id in(SELECT brr1.booking_id FROM booked_records_restaurant brr1  JOIN restaurant_details rd1 ON brr1.restaurant_id = rd1.restaurant_id Where booking_time > '" . $time . "' AND `booking_date` = CURRENT_DATE() AND brr1.restaurant_id = '" . $restaurantId . "')"));
	return $num_count;
}
function get_name_asset($table,$type){
	$data = mysqli_query($GLOBALS['conn'],"SELECT * FROM $table WHERE id = '".$type."'");
	return $data;
}
function edit_booking_delivery_option($restaurantId,$bookingDate)
{
	           $date_interval = "";
               $day = date('D', strtotime($bookingDate));
               $restaurant_data = mysqli_query($GLOBALS['conn'],"SELECT * FROM restaurant_details WHERE restaurant_id = '".$restaurantId."' ");
               if(mysqli_num_rows($restaurant_data)>0)
                {
                 $find_interval = mysqli_fetch_assoc($restaurant_data);
                 if($day == 'Sun'){
             
                 if($find_interval['is_sun'] != 0)
                 {
                   $time_first = strtotime($find_interval['sun_open_time']);
                   $time_second = strtotime($find_interval['sun_close_time']);
                   $interval = 1800; // Interval in seconds
                   $array = array();
                   for ($i = $time_first; $i <= $time_second;){
                     $array[] =  date('H:i', $i);
                     $i += $interval;
                   }
                   $date_interval = $array;
                  }
                  else
                 {
                    $date_interval="";
                 }
               

               }
              else if($day == 'Mon'){
               if($find_interval['is_mon'] != 0)
               {
                  $time_first = strtotime($find_interval['mon_open_time']);
                   $time_second = strtotime($find_interval['mon_close_time']);
                   $interval = 1800; // Interval in seconds
                   $array = array();
                   for ($i = $time_first; $i <= $time_second;){
                     $array[] =  date('H:i', $i);
                     $i += $interval;
                   }
                   $date_interval = $array;

               }
               else
               {
                  $date_interval="";

               }

            }
            else if($day == 'Tue'){
              if($find_interval['is_tue'] != 0)
               {
                   $time_first = strtotime($find_interval['tue_open_time']);
                   $time_second = strtotime($find_interval['tue_close_time']);
                   $interval = 1800; // Interval in seconds
                   $array = array();
                   for ($i = $time_first; $i <= $time_second;){
                     $array[] =  date('H:i', $i);
                     $i += $interval;
                   }
                   $date_interval = $array;
                 

               }
               else
               {
                  $date_interval="";

               }
            }
            else if($day == 'Wed'){
              if($find_interval['is_wed'] != 0)
               {
                 $time_first = strtotime($find_interval['wed_open_time']);
                   $time_second = strtotime($find_interval['wed_close_time']);
                   $interval = 1800; // Interval in seconds
                   $array = array();
                   for ($i = $time_first; $i <= $time_second;){
                     $array[] =  date('H:i', $i);
                     $i += $interval;
                   }
                   $date_interval = $array;
                 
               }
               else
               {
                    $date_interval="";
               }
            }
            else if($day == 'Thu'){
               if($find_interval['is_thu'] != 0)
               {
                 $time_first = strtotime($find_interval['thu_open_time']);
                   $time_second = strtotime($find_interval['thu_close_time']);
                   $interval = 1800; // Interval in seconds
                   $array = array();
                   for ($i = $time_first; $i <= $time_second;){
                     $array[] =  date('H:i', $i);
                     $i += $interval;
                   }
                   $date_interval = $array;
                

               }
               else
               {
                   $date_interval="";

               }
            }
            else if($day == 'Fri'){

               if($find_interval['is_fri'] != 0)
               {
                 $time_first = strtotime($find_interval['fri_open_time']);
                   $time_second = strtotime($find_interval['fri_close_time']);
                   $interval = 1800; // Interval in seconds
                   $array = array();
                   for ($i = $time_first; $i <= $time_second;){
                     $array[] =  date('H:i', $i);
                     $i += $interval;
                   }
                   $date_interval = $array;
                

               }
               else
               {
                   $date_interval="";

               }
            }
            else if($day == 'Sat'){
              
               if($find_interval['is_sat'] != 0)
               {
                 $time_first = strtotime($find_interval['sat_open_time']);
                   $time_second = strtotime($find_interval['sat_close_time']);
                   $interval = 1800; // Interval in seconds
                   $array = array();
                   for ($i = $time_first; $i <= $time_second;){
                     $array[] =  date('H:i', $i);
                     $i += $interval;
                   }
                   $date_interval = $array;
                

               }
               else
               {
                  
               }
            }
            else{
                
                   
            }
        }
    return  $date_interval;

}
?>
