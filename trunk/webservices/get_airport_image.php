<?php
  header('Content-type: application/json');
  include('../functions/functions.php');
  //Receiveing Input in Json and decoding
  basic_authentication($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);
  $data = json_decode(file_get_contents('php://input'));
  $result = array();
  $data = get_all_data('airport_section_data');

	while($record = mysqli_fetch_assoc($data)){
		$allData['image_url'] = url1().$record['airport_image'];
		$result[] = $allData;
	}
		$response['airport_image'] = $result;
		$response['responseCode'] = 200;
		$response['responseMessage'] = 'All airport image list';
 
  //Sending response after json encoding
  $responseJson = json_encode($response);
  print $responseJson;
  
?>
