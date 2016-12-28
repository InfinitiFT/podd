<?php
  header('Content-type: application/json');
  include('../functions/functions.php');
  //Receiveing Input in Json and decoding
  basic_authentication($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);
  $data = json_decode(file_get_contents('php://input'));
  $restaurant_id = $data->{"restaurant_id"};
  //Basic Validation  
  if (empty($restaurant_id)) {
	$response['responseCode'] = 0;
	$response['responseMessage'] = 'Restaurant id is required.';
  }  
  else {
    $result = array();
    $find_interval = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM restaurant_details WHERE restaurant_id = '".mysqli_real_escape_string($conn,trim($restaurant_id))."' "));
    $response['restaurant_time_interval'] = findtimeIntervalweb($find_interval['opening_time'],$find_interval['closing_time']);
	  $response['responseCode'] = 200;
	}
    //Sending response after json encoding
    $responseJson = json_encode($response);
    print $responseJson;
  
?>