<?php
  header('Content-type: application/json');
  include('../functions/functions.php');
  //Receiveing Input in Json and decoding
  basic_authentication($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);
  $data = json_decode(file_get_contents('php://input'));
  $result = array();
  $data = get_all_data('home_page_image');

	while($record = mysqli_fetch_assoc($data)){
		$allData['image_id'] = $record['image_id'];
		$allData['image_message'] = $record['image_message'];
		$allData['image_url'] = $record['image_url'];
		$result[] = $allData;
	}
		$response['homePageData'] = $result;
		$response['responseCode'] = 200;
		$response['responseMessage'] = 'All service list';
 
  //Sending response after json encoding
  $responseJson = json_encode($response);
  print $responseJson;
  
?>
