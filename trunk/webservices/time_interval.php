<?php
  header('Content-type: application/json');
  include('../functions/functions.php');
  //Receiveing Input in Json and decoding
  basic_authentication($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);
  $data = json_decode(file_get_contents('php://input'));
  $restaurant_id = $data->{"restaurant_id"};
  $date = $data->{"date"};
  //Basic Validation  
  if (empty($restaurant_id) || empty($date)) {
	$response['responseCode'] = 0;
	$response['responseMessage'] = 'All fields are required.';
  }  
  else {
        $timestamp = strtotime($date);
        $day = date('D', $timestamp);
        $restaurant_data = mysqli_query($conn,"SELECT * FROM restaurant_details WHERE restaurant_id = '".mysqli_real_escape_string($conn,trim($restaurant_id))."' ");
        
        if(mysqli_num_rows($restaurant_data)>0)
        {
             $find_interval = mysqli_fetch_assoc($restaurant_data);
            if($day == 'Sun'){
               if($find_interval['is_sun'] != 0)
               {
                 $response['restaurant_time_interval'] = findtimeIntervalweb($find_interval['sun_open_time'],$find_interval['sun_close_time']);
                 $response['responseCode'] = 200;

               }
               else
               {
                  $response['restaurant_time_interval'] = array();
                   $response['responseCode'] = 200;

               }
               

            }
            else if($day == 'Mon'){
               if($find_interval['is_mon'] != 0)
               {
                 $response['restaurant_time_interval'] = findtimeIntervalweb($find_interval['mon_open_time'],$find_interval['mon_close_time']);
                 $response['responseCode'] = 200;

               }
               else
               {
                  $response['restaurant_time_interval'] = array();
                  $response['responseCode'] = 200;

               }

            }
            else if($day == 'Tue'){
              if($find_interval['is_tue'] != 0)
               {
                 $response['restaurant_time_interval'] = findtimeIntervalweb($find_interval['tue_open_time'],$find_interval['tue_close_time']);
                 $response['responseCode'] = 200;

               }
               else
               {
                  $response['restaurant_time_interval'] = array();
                   $response['responseCode'] = 200;

               }
            }
            else if($day == 'Wed'){
              if($find_interval['is_wed'] != 0)
               {
                 $response['restaurant_time_interval'] = findtimeIntervalweb($find_interval['wed_open_time'],$find_interval['wed_close_time']);
                 $response['responseCode'] = 200;

               }
               else
               {
                  $response['restaurant_time_interval'] = array();
                  $response['responseCode'] = 200;

               }
            }
            else if($day == 'Thu'){
               if($find_interval['is_thu'] != 0)
               {
                 $response['restaurant_time_interval'] = findtimeIntervalweb($find_interval['thu_open_time'],$find_interval['thu_close_time']);
                 $response['responseCode'] = 200;

               }
               else
               {
                  $response['restaurant_time_interval'] = array();
                   $response['responseCode'] = 200;

               }
            }
            else if($day == 'Fri'){

               if($find_interval['is_fri'] != 0)
               {
                 $response['restaurant_time_interval'] = findtimeIntervalweb($find_interval['fri_open_time'],$find_interval['fri_close_time']);
                 $response['responseCode'] = 200;

               }
               else
               {
                  $response['restaurant_time_interval'] = array();
                   $response['responseCode'] = 200;

               }
            }
            else if($day == 'Sat'){
              
               if($find_interval['is_sat'] != 0)
               {
                 $response['restaurant_time_interval'] = findtimeIntervalweb($find_interval['sat_open_time'],$find_interval['sat_close_time']);
                 $response['responseCode'] = 200;

               }
               else
               {
                  $response['restaurant_time_interval'] = array();
                   $response['responseCode'] = 200;

               }
            }
            else{
                 $response['responseCode'] = 400;
                 $response['responseMessage'] = 'Date is not valid.';
                   
            }
        }
        else
        {
           $response['responseCode'] = 400;
           $response['responseMessage'] = 'Restaurant does not exists.';

        }
	}
    //Sending response after json encoding
    $responseJson = json_encode($response);
    print $responseJson;
  
?>