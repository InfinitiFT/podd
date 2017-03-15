<?php

 header('Content-type: application/json');
 include('../functions/functions.php');
//Receiveing Input in Json and decoding
 basic_authentication($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);
 $data       = json_decode(file_get_contents('php://input'));
 $lat   = $data->{"latitude"};
 $long = $data->{"longitude"};
 $deliver_food = $data->{"deliver_food"};
 $pageSize   = $data->{"page_size"};
 $pageNumber = $data->{"page_number"};

 if($deliver_food)
 {
    $restaurant_data   = mysqli_query($GLOBALS['conn'],"SELECT *,( 3959 * acos( cos( radians($lat) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians($long) ) + sin( radians($lat) ) * sin( radians( latitude ) ) ) ) AS distance FROM restaurant_details rd join restaurant_meal_details rmd on rd.restaurant_id = rmd.restaurant_id WHERE rd.status = 1 AND rmd.deliver_food = 1  group by rd.restaurant_id");
 }
 else
 {
     $restaurant_data   = mysqli_query($GLOBALS['conn'],"SELECT *,( 3959 * acos( cos( radians($lat) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians($long) ) + sin( radians($lat) ) * sin( radians( latitude ) ) ) ) AS distance FROM restaurant_details rd left join restaurant_meal_details rmd on rd.restaurant_id = rmd.restaurant_id WHERE rd.status = 1 and (rmd.deliver_food = 0 OR rmd.deliver_food IS NULL) group by rd.restaurant_id");
     	 
 }
 
 
 if (mysqli_num_rows($restaurant_data)>0) {
    
    $restaurant_rows    = mysqli_num_rows($restaurant_data);
    $maxPageNumber = ceil($restaurant_rows / $pageSize);
    $minLimit      = ($pageNumber - 1) * $pageSize;
    if($deliver_food)
    {
        $restaurant_list   = mysqli_query($GLOBALS['conn'],"SELECT *,rd.restaurant_id as restaurant_id,( 3959 * acos( cos( radians($lat) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians($long) ) + sin( radians($lat) ) * sin( radians( latitude ) ) ) ) AS distance FROM restaurant_details rd join restaurant_meal_details rmd on rd.restaurant_id = rmd.restaurant_id WHERE rd.status = 1 AND rmd.deliver_food = 1  group by rd.restaurant_id ORDER BY distance  Limit $minLimit, $pageSize");

          
    }
    else
    {
         $restaurant_list   = mysqli_query($GLOBALS['conn'],"SELECT *,rd.restaurant_id as restaurant_id,( 3959 * acos( cos( radians($lat) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians($long) ) + sin( radians($lat) ) * sin( radians( latitude ) ) ) ) AS distance FROM restaurant_details rd left join restaurant_meal_details rmd on rd.restaurant_id = rmd.restaurant_id WHERE rd.status = 1 and (rmd.deliver_food = 0 OR rmd.deliver_food IS NULL) group by rd.restaurant_id ORDER BY distance  Limit $minLimit, $pageSize");
         
    }
    
    $rows=array();
   
    while ($restaurant_data = mysqli_fetch_array($restaurant_list)) {

        
        $row['restaurant_id']        = $restaurant_data['restaurant_id'];
        $row['restaurant_name']      = $restaurant_data['restaurant_name'];

        if(!empty($restaurant_data['location']))
        {
            $location_array = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'],"SELECT `location` FROM restaurant_location WHERE id = '".mysqli_real_escape_string($GLOBALS['conn'],$restaurant_data['location'])."'"));
            $location = $location_array['location'];

        }
        else
        {
           $location = "";
        }
        
        $row['location']             = $location;
        $row['postcode']             = $restaurant_data['postcode'];
        $row['latitude']             = $restaurant_data['latitude'];
        $row['longitude']            = $restaurant_data['longitude'];
        $restaurant_images = explode(",",$restaurant_data['restaurant_images']);
        $res_image_array = array();
        foreach($restaurant_images as $value)
         {
          $res_image_array[] = url1().$value;
         }
        $row['restaurant_images']    = $res_image_array;
        $row['deliver_food']         = $restaurant_data['deliver_food'];
        $row['opening_time']         = $restaurant_data['opening_time'];
        $row['closing_time ']        = $restaurant_data['closing_time'];
        $row['about_text']           = $restaurant_data['about_text'];
        $row['max_people_allowed']   = $restaurant_data['max_people_allowed'];
        $cuisine_data                = explode(",",$restaurant_data['cuisine']);
        $cuisine_rows=array();
        if($cuisine_data[0])
        {
            foreach($cuisine_data as $value)
            {
               $cuisine_name = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'],"SELECT * FROM restaurant_cuisine WHERE id = '".mysqli_real_escape_string($GLOBALS['conn'],$value)."'"));
                $cuisine_rows[] = $cuisine_name;
            }
        }
        $row['cuisine']              = $cuisine_rows;
        $ambience_data                = explode(",",$restaurant_data['ambience']);
        $ambience_rows=array();
        if($ambience_data[0])
        {
            foreach($ambience_data as $value)
            {
               $ambience_name = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'],"SELECT * FROM restaurant_ambience WHERE id = '".mysqli_real_escape_string($GLOBALS['conn'],$value)."'"));
                $ambience_rows[] = $ambience_name;
            }
        }
        $row['ambience']              = $ambience_rows;
        $dietary_data                = explode(",",$restaurant_data['dietary']);
        $dietary_rows=array();
        if($dietary_data[0])
        {
            foreach($dietary_data as $value)
            {
               $dietary_name = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'],"SELECT * FROM restaurant_dietary WHERE id = '".mysqli_real_escape_string($GLOBALS['conn'],$value)."'"));
                $dietary_rows[] = $dietary_name;
            }
        }
        $row['dietary']              = $dietary_rows;
        $price_range_data                = explode(",",$restaurant_data['price_range']);
      
        if($price_range_data[0])
        {
            foreach($price_range_data as $value)
            {
               $price_range_name = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'],"SELECT * FROM restaurant_price_range WHERE id = '".mysqli_real_escape_string($GLOBALS['conn'],$value)."'"));
               $price_range_rows = $price_range_name['price_range'];
            }
        }
        $row['distance']             = round($restaurant_data['distance'], 2).' '.Miles;
        

        $rows[]                 = $row;
     }
    //print_r($rows);exit;
    $pagination['page_number']        = $pageNumber;
    $pagination['page_size']          = $pageSize;
    $pagination['max_page_number']    = $maxPageNumber;
    $pagination['total_record_count'] = $restaurant_rows;
    $response['responseCode']         = 200;
    $response['responseMessage']      = 'Your Restaurant List Fetched Successfully.';
    $response['restaurant_list']      =$rows;
    $response['pagination']           = $pagination;
} else {
    $response['responseCode']    = 200;
    $response['responseMessage'] = 'No Records.';
}

//print_r($rows);exit;
 
 //Sending response after json encoding
  $responseJson = json_encode($response);
  print $responseJson;exit;

?>
