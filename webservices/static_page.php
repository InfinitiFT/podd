<?php
  header('Content-type: application/json');
  include('../functions/functions.php');
  //Receiveing Input in Json and decoding
  basic_authentication($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);
  $data = json_decode(file_get_contents('php://input'));
  $page_id = $data->{"page_id"};
  $check = mysqli_query($conn,"SELECT * FROM static_page WHERE id = '".mysqli_real_escape_string($conn,trim($page_id))."' ");
  if(mysqli_num_rows($check) > 0){
	  $get_page_data = mysqli_fetch_assoc($check);
	  $response['responseCode'] = 200;
	  $response['responseMessage'] = 'Your Static Page data fetched successfully.';
	  $response['name'] =  $get_page_data['name'];
	  $response['page_data'] =  $get_page_data['content'];
	  }
  else {
	  $response['responseCode'] = 0;
	  $response['responseMessage'] = 'Invalid Page Id';
	}
  //Sending response after json encoding
  $responseJson = json_encode($response);
  print $responseJson;
?>
