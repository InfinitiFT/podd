<?php
  header('Content-type: application/json');
  include('../functions/functions.php');
  //Receiveing Input in Json and decoding
  $data = json_decode(file_get_contents('php://input'));
  $page_id = $data->{"page_id"};
  $check = mysql_query("SELECT * FROM static_page WHERE id = '".$page_id."'");
  if(mysql_num_rows($check) > 0){
	  $get_page_data = mysql_fetch_assoc($check);
	  if(empty($get_page_data)) {
			$getID = new stdClass();
		}
	  $response['responseCode'] = 200;
	  $response['responseMessage'] = 'Your Static Page data fetched successfully.';
	  $response['page_name'] =  $get_page_data['name'];
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