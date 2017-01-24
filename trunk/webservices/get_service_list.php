<?php
  header('Content-type: application/json');
  include('../functions/functions.php');
  //Receiveing Input in Json and decoding
  basic_authentication($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);
  $data = json_decode(file_get_contents('php://input'));
  $result = array();
  $data = get_all_data('service_management');

	while($record = mysqli_fetch_assoc($data)){
		$allData['id'] = $record['service_id'];
		$allData['service_name'] = $record['service_name'];
		$allData['service_image'] = url().$record['service_image'];
		$allData['status'] = $record['status'];
		$message = $record['message'];
		$result[] = $allData;
	}
		$response['allServiceList'] = $result;
		$response['message'] = $message;
		$response['responseCode'] = 200;
		$response['responseMessage'] = 'All service list';
 
  //Sending response after json encoding
  $responseJson = json_encode($response);
  print $responseJson;
  
?>
