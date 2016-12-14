<?php
include('../functions/functions.php');


  switch($_REQUEST['type']) {
	  
	case 'allMeal':
	$data = get_all_data('restaurant_meal');
	while($meal = mysql_fetch_assoc($data)){
		$allRecord['id'] = $meal['id'];
		$allRecord['name'] = $meal['meal_type'];
		$allMeal[] = $allRecord;
	}
	print_r(json_encode($allMeal));
	break;
	

	
	
	
}
?>
