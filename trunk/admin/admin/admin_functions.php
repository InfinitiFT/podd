<?php
include('../webservices/function.php');
//Function for user Authntication 

function user_authenticate($email, $password) {
	$adminQuery = mysql_fetch_assoc(mysql_query("SELECT * FROM '".$table."' WHERE email = '".$email."' AND password = '".md5($password)."'"));
	return $adminQuery;
}

//Function for validate Email
function validate_email_admin($email) {
	$adminEmail = mysql_fetch_assoc(mysql_query("SELECT email FROM '".$table."' WHERE email = '".$email."'"));
	return $adminEmail;
}
//Function for Get All data
function get_all_data($table) {
	$adminEmail = mysql_fetch_assoc(mysql_query("SELECT * FROM '".$table."'"));
	return $adminEmail;
}
//Function delete data
function delete_data($table,$id) {
	mysql_query("DELETE FROM '".$table."' WHERE '".$condition."' ");
	return 1;
}



?>
