 <?php
  header('Content-type: application/json');
  include('../functions/functions.php');

  //Receiveing Input in Json and decoding
   basic_authentication($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);

  $data = json_decode(file_get_contents('php://input'));
  $cuisine = $data->{"cusine"};
  $dietary = $data->{"dietary"};
  $meal = $data->{"meal"};
  $ambience = $data->{"ambience"};
  $location = $data->{"location"};
  $pageSize   = $data->{"page_size"};
  $pageNumber = $data->{"page_number"};
  $lat   = $data->{"latitude"};
  $long = $data->{"longitude"};
  $where ='';
  $join ='';
  $result=array();
  
    if(!empty($cuisine)){
	  $condition= mysqli_real_escape_string($GLOBALS['conn'],$cuisine);
	  $column="cuisine";
	}  
    if(!empty($dietary)){
	  $condition= mysqli_real_escape_string($GLOBALS['conn'],$dietary);
	  $column="dietary";
	}  
	if(!empty($ambience)){
	  $condition= mysqli_real_escape_string($GLOBALS['conn'],$ambience);
	  $column="ambience";
	}  
	 if(!empty($location)){
	  $condition= mysqli_real_escape_string($GLOBALS['conn'],$location);
	  $column="location";
	}  
	if(!empty($meal)){
	    $join = " join restaurant_meal_details as m on m.restaurant_id = d.restaurant_id";
	    if(!empty($where))
		$where .= ' and';
	    $where .= " m.meal =".$meal."";
	}

	if(!empty($join)){
	
		//$data = mysqli_query($GLOBALS['conn'],"SELECT d.*,( 3959 * acos( cos( radians($lat) ) * cos(radians(latitude ) ) * cos( radians( longitude ) - radians($long) ) + sin( radians($lat) ) * sin( radians(latitude ) ) ) ) AS distance FROM `restaurant_details` as d ".$join." WHERE  find_in_set(".$condition.", ".$column.") > 0 ".$where." HAVING distance <= 5");
		$data = mysqli_query($GLOBALS['conn'],"SELECT d.*,( 3959 * acos( cos( radians($lat) ) * cos(radians(latitude ) ) * cos( radians( longitude ) - radians($long) ) + sin( radians($lat) ) * sin( radians(latitude ) ) ) ) AS distance FROM `restaurant_details` as d ".$join." WHERE  find_in_set(".$condition.", ".$column.") > 0 ".$where."");
		

	}else{
		
		//$data = mysqli_query($GLOBALS['conn'],"SELECT *,( 3959 * acos( cos(radians($lat) ) * cos( radians(latitude ) ) * cos(radians(longitude ) - radians($long) ) + sin( radians($lat) ) * sin( radians(latitude ) ) ) ) AS distance  FROM `restaurant_details` WHERE  find_in_set(".$condition.", ".$column.") > 0 HAVING distance <= 5");
		$data = mysqli_query($GLOBALS['conn'],"SELECT *,( 3959 * acos( cos(radians($lat) ) * cos( radians(latitude ) ) * cos(radians(longitude ) - radians($long) ) + sin( radians($lat) ) * sin( radians(latitude ) ) ) ) AS distance  FROM `restaurant_details` WHERE  find_in_set(".$condition.", ".$column.") > 0");
		
	}
   if ($data) {
		$restaurant_rows    = mysqli_num_rows($data);
		$maxPageNumber = ceil($restaurant_rows / $pageSize);
		$minLimit      = ($pageNumber - 1) * $pageSize;
	  if(!empty($join)){
		
			//$query = mysqli_query($GLOBALS['conn'],"SELECT d.*,( 3959 * acos( cos( radians($lat) ) * cos( radians(latitude ) ) * cos( radians(longitude ) - radians($long) ) + sin( radians($lat) ) * sin  (radians(latitude ) ) ) ) AS distance FROM `restaurant_details` as d".$join." WHERE  find_in_set(".$condition.", ".$column.") > 0 ".$where." HAVING distance <= 5 ORDER BY distance Limit $minLimit, $pageSize");
			$query = mysqli_query($GLOBALS['conn'],"SELECT d.*,( 3959 * acos( cos( radians($lat) ) * cos( radians(latitude ) ) * cos( radians(longitude ) - radians($long) ) + sin( radians($lat) ) * sin  (radians(latitude ) ) ) ) AS distance FROM `restaurant_details` as d".$join." WHERE  find_in_set(".$condition.", ".$column.") > 0 ".$where." ORDER BY distance Limit $minLimit, $pageSize");
		}else{
			
			//$query = mysqli_query($GLOBALS['conn'],"SELECT *,( 3959 * acos(cos( radians($lat) ) * cos( radians(latitude ) ) * cos( radians(longitude ) - radians($long) ) + sin( radians($lat) ) * sin( radians(latitude ) ) ) ) AS distance FROM `restaurant_details` WHERE  find_in_set(".$condition.", ".$column.") > 0  HAVING distance <= 5 ORDER BY distance Limit $minLimit, $pageSize");
			$query = mysqli_query($GLOBALS['conn'],"SELECT *,( 3959 * acos(cos( radians($lat) ) * cos( radians(latitude ) ) * cos( radians(longitude ) - radians($long) ) + sin( radians($lat) ) * sin( radians(latitude ) ) ) ) AS distance FROM `restaurant_details` WHERE  find_in_set(".$condition.", ".$column.") > 0 ORDER BY distance Limit $minLimit, $pageSize");

		}
	}
  
  while($restaurant_data = mysqli_fetch_assoc($query)){
	$record['restaurant_id']        = $restaurant_data['restaurant_id'];
    $record['restaurant_name']      = $restaurant_data['restaurant_name'];
    $recordImg = explode(",",$restaurant_data['restaurant_images']);
    if($recordImg)
    {
    	$res_image_array=array();
        foreach($recordImg as $value)
        {
          $res_image_array[] = url().$value;
        }
    }
    
    $record['restaurant_images']    =  $res_image_array;  
     if(!empty($restaurant_data['location']))
        {
            $location_array = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'],"SELECT `location` FROM restaurant_location WHERE id = '".mysqli_real_escape_string($GLOBALS['conn'],$restaurant_data['location'])."'"));
            $location = $location_array['location'];

        }
        else
        {
           $location = "";
        }
        
    $record['location']             = $location;
    $record['postcode']             = $restaurant_data['postcode'];
    $record['latitude']             = $restaurant_data['latitude'];
    $record['longitude']            = $restaurant_data['longitude'];
    $record['deliver_food']         = $restaurant_data['deliver_food'];
    $record['opening_time']         = $restaurant_data['opening_time'];
    $record['closing_time ']        = $restaurant_data['closing_time'];
    $record['about_text']           = $restaurant_data['about_text'];
    $record['max_people_allowed']   = $restaurant_data['max_people_allowed'];
    $restaurant_cuisine = explode(",",$restaurant_data['cuisine']);
    
    $restaurant_dietary = explode(",",$restaurant_data['dietary']);
    $restaurant_ambience = explode(",",$restaurant_data['ambience']);
    $recordCusine = array();
      foreach($restaurant_cuisine as $cuisine)
        {
			$cuisineRecord = mysqli_fetch_assoc(get_name_asset('restaurant_cuisine',$cuisine));
			$cuisineData['id'] = $cuisineRecord['id'];
			$cuisineData['cuisine_name'] = $cuisineRecord['cuisine_name'];
			$recordCusine[] = $cuisineData;
		}
		$record['cuisine']   = $recordCusine;
	  $recordDietary = array();
	  foreach($restaurant_dietary as $dietary)
        {
        	$dietaryRecord = mysqli_fetch_assoc(get_name_asset('restaurant_dietary',$dietary));
			$dietaryData['id'] = $dietaryRecord['id'];
			$dietaryData['dietary_name'] = $dietaryRecord['dietary_name'];
			$recordDietary[] = $dietaryData;
		}
		$record['dietary']   = $recordDietary;
	  $recordAmbience = array();
	  foreach($restaurant_ambience as $ambience)
        {
        	$ambienceRecord = mysqli_fetch_assoc(get_name_asset('restaurant_ambience',$ambience));
			$ambienceData['id'] = $ambienceRecord['id'];
			$ambienceData['ambience_name'] = $ambienceRecord['ambience_name'];
			$recordAmbience[] = $ambienceData;
		}
		$record['ambience']   = $recordAmbience;
		$record['distance']             = round($restaurant_data['distance'], 2).' '.Miles;
		$price = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'],"SELECT * FROM `restaurant_price_range` WHERE `id`='".$restaurant_data['price_range']."'"));
		$userDetail = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'],"SELECT * FROM `users` WHERE `user_id`='".$restaurant_data['user_id']."'"));
		$record['price_range']  = $price['price_range'];
		$result[] =$record;
		
  }
  
    
    $pagination['page_number']        = $pageNumber;
    $pagination['page_size']          = $pageSize;
    $pagination['max_page_number']    = $maxPageNumber;
    $pagination['total_record_count'] = $restaurant_rows;
    $response['pagination']           = $pagination;
	$response['restaurant_list']      = $result;
    $response['responseCode']         = 200;
    $response['responseMessage']      = 'Your Restaurant List Fetched Successfully.';
  
  
 
	 
  //Sending response after json encoding
  $responseJson = json_encode($response);
  print $responseJson;
?>
