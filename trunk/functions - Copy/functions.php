<?php
include('config.php');


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

    if (($user == 'test')&&($password == 'test')) { return 1; }
    else { return 0; };
}
//Function for user Authntication 

function user_authenticate($email, $password) {
	$adminQuery = mysql_fetch_assoc(mysql_query("SELECT * FROM users WHERE email = '".$email."' AND password = '".md5($password)."'"));
	return $adminQuery;
}

//Function for validate Email
function validate_email_admin($email) {
	$adminEmail = mysql_fetch_assoc(mysql_query("SELECT email FROM '".$table."' WHERE email = '".$email."'"));
	return $adminEmail;
}
//Function for Get All data
function get_all_data($table) {
	
	$adminEmail = mysql_query("SELECT * FROM ".$table."");
	return $adminEmail;
}
//Function delete data
function delete_data($table,$id) {
	mysql_query("DELETE FROM '".$table."' WHERE '".$condition."' ");
	return 1;
}
//Function for Get current url
function url(){
		$url = sprintf("%s://%s%s",isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',$_SERVER['SERVER_NAME'],$_SERVER['REQUEST_URI']);
		$slashPos = (strrpos($url,'/'));
		$baseUrl = substr($url,0,$slashPos + 1);
		return $baseUrl;
	}
//Function for Add or update device token of particular user
 function addDeviceToken($user_id,$device_token,$device_type){
	$checkDevice=mysql_query("SELECT * FROM `device` WHERE  device_token ='".$device_token."'");
	if(mysql_num_rows($checkDevice) >0){
		$get_deviceInfo = mysql_fetch_assoc($checkDevice);  
		$update_device=mysql_query("UPDATE `device` SET `user_id`='".$user_id."',`device_token`='".$device_token."',`created_on`='".$get_deviceInfo['created_on']."',`updated_on`= now() WHERE `device_id`='".$get_deviceInfo['device_id']."'");
				return 1;
	}
	else{
	    $add_device=mysql_query("INSERT INTO `device`( `user_id`, `device_token`,`device_type`, `created_on`,`updated_on`) VALUES ('".$user_id."','".$device_token."','".$device_type."',now(),now())");
			      return 1;
	}
}	


?>
