<?php
  header('Content-type: application/json');
  include('../functions/functions.php');
  //Receiveing Input in Json and decoding
  $data = json_decode(file_get_contents('php://input'));
  $result = array();
  $data = get_all_data('service_management');
	
	while($record = mysql_fetch_assoc($data)){
		$allData['id'] = $record['service_id'];
		$allData['service_name'] = $record['service_name'];
		$allData['service_name'] = url().$record['service_image'];
		$result[] = $allData;
	}
		$response['allServiceList'] = $result;
		$response['responseCode'] = 200;
		$response['responseMessage'] = 'All service list';
 
  //Sending response after json encoding
  $responseJson = json_encode($response);
  print $responseJson;
  
?>
