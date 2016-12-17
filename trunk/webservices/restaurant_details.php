<?php
 header('Content-type: application/json');
 include('../functions/functions.php');
//Receiveing Input in Json and decoding
 basic_authentication($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);
 $data       = json_decode(file_get_contents('php://input'));
 $lat   = $data->{"latitude"};
 $long = $data->{"longitude"};
 $restaurant_id = $data->{"restaurant_id"};
 $restaurant_data= mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'],"SELECT rd.*,( 3959 * acos( cos( radians($lat) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians($long) ) + sin( radians($lat) ) * sin( radians( latitude ) ) ) ) AS distance,GROUP_CONCAT(DISTINCT(rc.cuisine_name)) as cuisine_name,GROUP_CONCAT(DISTINCT(rdd.dietary_name)) as dietary_name,GROUP_CONCAT(DISTINCT(ra.ambience_name)) as ambience_name,GROUP_CONCAT(DISTINCT(rp.price_range)) as price_range FROM restaurant_details rd LEFT JOIN restaurant_cuisine as rc ON find_in_set(rc.id, rd.cuisine) LEFT JOIN restaurant_dietary as rdd ON find_in_set(rdd.id, rd.dietary) LEFT JOIN restaurant_ambience as ra ON find_in_set(ra.id, rd.ambience) LEFT JOIN restaurant_price_range as rp ON find_in_set(rp.id, rd.price_range) where rd.restaurant_id= '".$restaurant_id."'"));
 if($restaurant_data){
    $response['restaurant_id']        = $restaurant_data['restaurant_id'];
    $response['restaurant_name']      = $restaurant_data['restaurant_name'];
    $restaurant_images = explode(",",$restaurant_data['restaurant_images']);
    $res_image_array = array();
    if($res_image_array)
    {
        foreach($restaurant_images as $value)
        {
          $res_image_array[] = url().'/'.$value;
        }
    }
    
    $response['restaurant_images']    =  $res_image_array;
    $response['location']             = $restaurant_data['location'];
    $response['postcode']             = $restaurant_data['postcode'];
    $response['latitude']             = $restaurant_data['latitude'];
    $response['longitude']            = $restaurant_data['longitude'];
    $response['deliver_food']         = $restaurant_data['deliver_food'];
    $response['opening_time']         = $restaurant_data['opening_time'];
    $response['closing_time ']        = $restaurant_data['closing_time'];
    $response['about_text']           = $restaurant_data['about_text'];
    $response['max_people_allowed']   = $restaurant_data['max_people_allowed'];
    $restaurant_cuisine = explode(",",$restaurant_data['cuisine']);
    $restaurantcuisine_name= explode(",",$restaurant_data['cuisine_name']);
    $restaurant_cuisine_array = array();
    $i=0;
    foreach($restaurant_cuisine as $value)
    {
      $row_data['id'] = $value;
      $row_data['name'] = $restaurantcuisine_name[$i];
      $restaurant_cuisine_array[]= $row_data;
      $i++;
    }
    $response['cuisine']              = $restaurant_cuisine_array;
    $restaurant_dietary = explode(",",$restaurant_data['dietary']);
    $restaurantdietary_name= explode(",",$restaurant_data['dietary_name']);
    $restaurant_dietary_array = array();
    $i=0;
    foreach($restaurant_dietary as $value)
    {
      $row_data['id'] = $value;
      $row_data['name'] = $restaurantdietary_name[$i];
      $restaurant_dietary_array[]= $row_data;
      $i++;
    }
    $response['dietary']              = $restaurant_dietary_array;
    $restaurant_ambience = explode(",",$restaurant_data['ambience']);
    $restaurantambience_name= explode(",",$restaurant_data['ambience_name']);
    $restaurant_ambience_array = array();
    $i=0;
    foreach($restaurant_ambience as $value)
    {
      $row_data['id'] = $value;
      $row_data['name'] = $restaurantambience_name[$i];
      $restaurant_ambience_array[]= $row_data;
      $i++;
    }
    $response['ambience']              = $restaurant_ambience_array;
    $restaurant_price_range            = explode(",",$restaurant_data['price_range']);
    $restaurantprice_range             = explode(",",$restaurant_data['price_range']);
    $restaurant_price_range_array = array();
    $i=0;
    foreach($restaurant_price_range as $value)
    {
      $row_data['id'] = $value;
      $row_data['name'] = $restaurantprice_range[$i];
      $restaurant_price_range[]= $row_data;
      $i++;
    }
    $response['price_range']          = $restaurant_price_range_array;
    $restaurant_menu_data = mysqli_query($GLOBALS['conn'],"SELECT * FROM restaurant_menu_details rdm Join restaurant_menu rm on rdm.meal = rm.id WHERE rdm.restaurant_id = '".$restaurant_id."'");
    $restaurant_menu = array();
    if($restaurant_menu_data)
    {
        while($record = mysqli_fetch_assoc($restaurant_menu_data)){ 
        $res_menu_data['menu_name']= $record['menu_name'];
        $res_menu_data['menu_url']=  $record['menu_url'];
        $restaurant_menu[] = $res_menu_data;
        }

    }
    
    $response['restaurant_menu']              = $restaurant_menu;
    $response['responseCode']         = 200;
    $response['responseMessage']      = 'Your Restaurant List Fetched Successfully.';

}
else{
    $response['responseCode']    = 200;
    $response['responseMessage'] = 'No Records.';
     }

//Sending response after json encoding
$responseJson = json_encode($response);
print $responseJson;

?>
