<?php
include('../functions/functions.php');
switch($_REQUEST['type']) {
	case 'allMeal':
	$allMeals = implode(',',$_POST['meal']);
	$data = mysqli_query($conn,"SELECT * FROM `restaurant_menu` WHERE `id` NOT IN(".$allMeals.")");
	while($meal = mysqli_fetch_assoc($data)){
		$allRecord['id'] = $meal['id'];
		$allRecord['name'] = $meal['menu_name'];
		$allMeal[] = $allRecord;
	}
	print_r(json_encode($allMeal));
	break;
	
	case 'foget_password':
	print_r(json_encode("Password send to your email."));
	break;
	
	case 'email_validation':
	$email = $_POST['email'];
	$data = validate_email_admin($email);
	if($data)
		print 1;
	else
		print 0;
	break;



	
	
	
}
?>
