<?php
  header('Content-type: application/json');
  include('../functions/functions.php');
  //Receiveing Input in Json and decoding
  basic_authentication($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);
  $data = json_decode(file_get_contents('php://input'));
  $type = $data->{"type"};
  $result = array();
  //Basic Validation  
	if($type == 'cuisine')
		$data = get_all_data('restaurant_cuisine');
	else if($type == 'dietary')
		$data = get_all_data('restaurant_dietary');
	else if($type == 'ambience')
		$data = get_all_data('restaurant_ambience');
	else if($type == 'meal')
		$data = get_all_data('restaurant_menu');	
	else
		$data = get_all_data('restaurant_price_range');
	while($record = mysqli_fetch_assoc($data)){
		$allData['id'] = $record['id'];
		if($type == 'cuisine')
			$allData['name'] = $record['cuisine_name'];
		else if($type == 'dietary')
			$allData['name'] = $record['dietary_name'];
		else if($type == 'ambience')
			$allData['name'] = $record['ambience_name'];
		else if($type == 'meal')
			$allData['name'] = $record['menu_name'];
		else
			$allData['name'] = $record['price_range'];
		$result[] = $allData;
	}
		$response['allList'] = $result;
		$response['responseCode'] = 200;
		$response['responseMessage'] = 'All list';
 
  //Sending response after json encoding
  $responseJson = json_encode($response);
  print $responseJson;
  
?>
