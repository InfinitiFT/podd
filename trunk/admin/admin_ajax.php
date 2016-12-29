<?php
include('../functions/functions.php');
switch($_REQUEST['type']) {
	
	case 'allMeal':
	if($_POST['meal']){
		$allMeals = implode(',',$_POST['meal']);
		$data = mysqli_query($conn,"SELECT * FROM `restaurant_menu` WHERE `id` NOT IN(".$allMeals.")");
		while($meal = mysqli_fetch_assoc($data)){
			$allRecord['id'] = $meal['id'];
			$allRecord['name'] = $meal['menu_name'];
			$allMeal[] = $allRecord;
		}
		print_r(json_encode($allMeal));
	}else{
		
		$data = mysqli_query($conn,"SELECT * FROM `restaurant_menu`");
		while($meal = mysqli_fetch_assoc($data)){
			$allRecord['id'] = $meal['id'];
			$allRecord['name'] = $meal['menu_name'];
			$allMeal[] = $allRecord;
		}
		print_r(json_encode($allMeal));
		
		
	}	
	break;
	
	case 'foget_password':
	print_r(json_encode("Password send to your email."));
	break;
	
	case 'email_validation':
	$email = $_POST['email'];
	$userID = $_POST['userID'];
	$data = validate_email_admin($email,$userID);
	if($data)
		print 1;
	else
		print 0;
	break;
    case 'val_item':
	$item = $_POST['item'];
	$data = validate_items($item);
	if($data)
		print 1;
	else
		print 0;
	break;
	case 'alreadyitemedit':
	$item = $_POST['item'];
	$item_id = $_POST['item_id'];
	$data = validate_items_edit($item,$item_id);
	if($data)
		print 1;
	else
		print 0;
	break;
	case 'decline':	
	$bookingID = $_GET['bookingID'];
	$declined = $_GET['declined'];
	//alert($bookingID);
	$update = mysqli_query($conn,"UPDATE `booked_records_restaurant` SET `booking_status`='0',`decline_region`='".$declined."' WHERE `booking_id`='".$bookingID."'");
	if($update)
		print 1;
	else
		print 0;
	break;

	
	case 'timeInterval':
	$start = $_GET['start'];
	$end = $_GET['end'];
	$timeInterval = findtimeInterval($start,$end);
	print $timeInterval;
	break;

	case 'bookingTimeChange':
	$time = $_GET['time'];
	$bookingID = $_GET['bookingID'];
	$change = bookingTimeChanges($time,$bookingID);
	print $change;
	break;
	
	case 'bookingRecordStatus':
	$status = $_GET['status'];
	$session = $_GET['session'];
	$record = bookingRecordStatus($status,$session);
	print_r($record);
	break;


	
}
?>
