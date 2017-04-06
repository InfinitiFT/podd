<?php
 header('Content-type: application/json');
 include('../functions/functions.php');
//Receiveing Input in Json and decoding
 basic_authentication($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);
 $data       = json_decode(file_get_contents('php://input'));
 $lat   = $data->{"latitude"};
 $long = $data->{"longitude"};
 $restaurant_id = $data->{"restaurant_id"};
 $deliver_food = $data->{"deliver_food"};

 $restaurant_data= mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'],"SELECT rd.*,GROUP_CONCAT(DISTINCT(rc.cuisine_name)) as cuisine_name,GROUP_CONCAT(DISTINCT(rdd.dietary_name)) as dietary_name,GROUP_CONCAT(DISTINCT(ra.ambience_name)) as ambience_name,GROUP_CONCAT(DISTINCT(rp.price_range)) as ranges FROM restaurant_details rd LEFT JOIN restaurant_cuisine as rc ON find_in_set(rc.id, rd.cuisine) LEFT JOIN restaurant_dietary as rdd ON find_in_set(rdd.id, rd.dietary) LEFT JOIN restaurant_ambience as ra ON find_in_set(ra.id, rd.ambience) LEFT JOIN restaurant_price_range as rp ON find_in_set(rp.id, rd.price_range)  where rd.restaurant_id= '".mysqli_real_escape_string($GLOBALS['conn'],$restaurant_id)."'"));
 if($restaurant_data){
    $response['restaurant_id']        = $restaurant_data['restaurant_id'];
    $response['restaurant_name']      = $restaurant_data['restaurant_name'];
    $restaurant_images = explode(",",$restaurant_data['restaurant_images']);
    $res_image_array = array();
    foreach($restaurant_images as $value)
	{
	  $res_image_array[] = url1().$value;
	}
    $response['restaurant_images']    = $res_image_array;   
    $response['location']             = $restaurant_data['restaurant_full_address'];
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
      $row_data_cuisine['id'] = $value;
      $row_data_cuisine['cuisine_name'] = $restaurantcuisine_name[$i];
      $restaurant_cuisine_array[]= $row_data_cuisine;
      $i++;
    }
    $response['cuisine']              = $restaurant_cuisine_array;
    $restaurant_dietary = explode(",",$restaurant_data['dietary']);
    $restaurantdietary_name= explode(",",$restaurant_data['dietary_name']);
    $restaurant_dietary_array = array();
    $j=0;
    foreach($restaurant_dietary as $value)
    {
      $row_data_dietary['id'] = $value;
      $row_data_dietary['dietary_name'] = $restaurantdietary_name[$j];
      $restaurant_dietary_array[]= $row_data_dietary;
      $j++;
    }
    $response['dietary']              = $restaurant_dietary_array;
    $response['distance']             = round($restaurant_data['distance'], 2).' '.Miles;
    $restaurant_ambience = explode(",",$restaurant_data['ambience']);
    $restaurantambience_name= explode(",",$restaurant_data['ambience_name']);
    $restaurant_ambience_array = array();
    $k=0;
    foreach($restaurant_ambience as $value)
    {
      $row_data_ambience['id'] = $value;
      $row_data_ambience['ambience_name'] = $restaurantambience_name[$k];
      $restaurant_ambience_array[]= $row_data_ambience;
      $k++;
    }
    $response['ambience']              = $restaurant_ambience_array;
    $response['price_range']           = (string)$restaurant_data['ranges'];
    $meal_data = array();
    $meal_details = mysqli_query($GLOBALS['conn'],"SELECT rmd.id as rmd_id,rmd.*,m.* FROM `restaurant_meal_details` rmd join meals m on rmd.meal = m.id join restaurant_item_price rip on rmd.id = rip.restaurant_meal_id WHERE rmd.restaurant_id = '".$restaurant_id."' AND rmd.deliver_food = '".$deliver_food."' GROUP BY rmd.meal  order by rip.id");
   
    if(mysqli_num_rows($meal_details) > 0)
    {
       while($meal_record = mysqli_fetch_assoc($meal_details))
       {
         
         $meal_d['rmd_id'] = $meal_record['rmd_id'];
         $meal_d['meal_id'] = $meal_record['id'];
		
         $meal_d['meal_name'] = ucwords($meal_record['meal_name']);
         $meal_d['deliver_food'] = $meal_record['deliver_food'];
         $meal_subtitles = mysqli_query($GLOBALS['conn'],"SELECT rip.*,s.* FROM restaurant_item_price rip join subtitle s on rip.subtitle = s.subtitle_id WHERE rip.restaurant_meal_id = '".$meal_record['rmd_id']."' GROUP BY s.subtitle_id order by rip.id");
         $meal_subtitle = array();
         if(mysqli_num_rows($meal_subtitles) > 0)
         {

            while($meal_subtitle1 = mysqli_fetch_assoc($meal_subtitles))
            {
                $subtitle_data['subtitle_id'] = $meal_subtitle1['subtitle_id'];
                $subtitle_data['subtitle_name'] = ucwords($meal_subtitle1['subtitle']);
                $meal_subtitless = mysqli_query($GLOBALS['conn'],"SELECT * FROM restaurant_item_price rip join items i on rip.item_id = i.id WHERE rip.subtitle = '".$meal_subtitle1['subtitle_id']."' AND rip.restaurant_meal_id = '".$meal_record['rmd_id']."' order by rip.id");
                $subtitle_meal = array();
                if(mysqli_num_rows($meal_subtitless) > 0)
                {  
                    $subtitle_meals = array();
                    while($meal_detail = mysqli_fetch_assoc($meal_subtitless))
                   {
                      $subtitle_meal['item_id'] = $meal_detail['item_id'];
                      $subtitle_meal['item_name'] = ucfirst($meal_detail['name']);
					  if($meal_detail['item_logo']){
						   $subtitle_meal['item_image'] = url1().$meal_detail['item_logo'];
					  }
					  else{
						  $subtitle_meal['item_image'] = "";
					  }
					 
                      $subtitle_meal['item_price'] = $meal_detail['item_price'];
                      $subtitle_meals[] = $subtitle_meal;
                      
                    }

                }
                
        
                $subtitle_data['subtitle_meal_details'] = $subtitle_meals;
                $meal_subtitle[] = $subtitle_data;
             }

         }
         $meal_d['meal_details'] = $meal_subtitle;
         $meal_data[] = $meal_d;
       }

    }
    
    $response['restaurant_menu']      = $meal_data;
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
