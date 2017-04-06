<?php
  header('Content-type: application/json');
  include('../functions/functions.php');
  //Receiveing Input in Json and decoding
  basic_authentication($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);
  $data = json_decode(file_get_contents('php://input'));
  $result = array();
  $data = mysqli_query($GLOBALS['conn'],"SELECT * FROM `home_page_image` WHERE `status`=1");

	while($record = mysqli_fetch_assoc($data)){
		if($record['image_url'])
		{
			$allData['image_url'] = url1().$record['image_url'];
		}
		else
		{
			$allData['image_url'] = "";
		}
		$allData['image_id'] = $record['image_id'];
		$allData['image_message'] = $record['image_message'];
		
		$result[] = $allData;
	}
		$response['homePageData'] = $result;
		$response['responseCode'] = 200;
		$response['responseMessage'] = 'All home page image list';
 
  //Sending response after json encoding
  $responseJson = json_encode($response);
  print $responseJson;
  
?>
