<?php
  header('Content-type: application/json');
  include('../functions/functions.php');
  //Receiveing Input in Json and decoding
  basic_authentication($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);
  $data = json_decode(file_get_contents('php://input'));
  $result = array();
  $data = get_all_data('restaurant_logo');

	while($record = mysqli_fetch_assoc($data)){
		$allData['restaurant_name'] = $record['restaurant_name'];
		$allData['image_url'] = url1().$record['logo'];
		$result[] = $allData;
	}
		$response['restaurantlogo'] = $result;
		$response['responseCode'] = 200;
		$response['responseMessage'] = 'Restaurant list';
 
  //Sending response after json encoding
  $responseJson = json_encode($response);
  print $responseJson;
  
?>
