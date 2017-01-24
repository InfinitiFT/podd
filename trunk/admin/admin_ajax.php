<?php
include('../functions/functions.php');
switch ($_REQUEST['type']) {

    case 'allMeal':
        if ($_POST['meal']) {
            $allMeals = implode(',', $_POST['meal']);
            $data = mysqli_query($conn, "SELECT * FROM `restaurant_menu` WHERE `id` NOT IN(" . $allMeals . ")");
            while ($meal = mysqli_fetch_assoc($data)) {
                $allRecord['id'] = $meal['id'];
                $allRecord['name'] = $meal['menu_name'];
                $allMeal[] = $allRecord;
            }
            print_r(json_encode($allMeal));
        } else {

            $data = mysqli_query($conn, "SELECT * FROM `restaurant_menu`");
            while ($meal = mysqli_fetch_assoc($data)) {
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
        $data = validate_email_admin($email, $userID);
        if ($data)
            print 1;
        else
            print 0;
        break;
    case 'val_item':
        $item = $_POST['item'];
        $data = validate_items($item);
        if ($data)
            print 1;
        else
            print 0;
        break;
    case 'alreadyitemedit':
        $item = $_POST['item'];
        $item_id = $_POST['item_id'];
        $data = validate_items_edit($item, $item_id);
        if ($data)
            print 1;
        else
            print 0;
        break;
    case 'decline':
        $bookingID = $_GET['bookingID'];
        $declined = $_GET['declined'];
        //alert($bookingID);
        $update = mysqli_query($conn, "UPDATE `booked_records_restaurant` SET `booking_status`='0',`decline_region`='" . $declined . "' WHERE `booking_id`='" . $bookingID . "'");
        $booking_details = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'], "SELECT * FROM `booked_records_restaurant`brr join restaurant_details rd on brr.restaurant_id = rd.restaurant_id  WHERE `booking_id`='" . mysqli_real_escape_string($conn, trim($bookingID)) . "'"));
      
        $message = "We are unable to confirm your booking with this venue, please try a different time or select another venue";
       send_sms($booking_details['contact_no'],$message);
        if ($update)
            print 1;
        else
            print 0;
        break;
        
    case 'declineDev':
        $bookingID = $_GET['bookingIDDev'];
        $declined = $_GET['declinedDev'];        
        $update = mysqli_query($conn, "UPDATE `delivery_bookings` SET `delivery_status`='0',`dcline_region`='" . $declined . "' WHERE `delivery_id`='" . $bookingID . "'");
        if ($update)
            print 1;
        else
            print 0;
        break;
    case 'alreadyadd_item_price':
        $restaurant_id = $_REQUEST['restaurant_id'];
        $meal_id = $_REQUEST['meal_id'];
        $item = $_REQUEST['item'];
        //alert($bookingID);
        $num_rows = mysqli_query($conn, "SELECT * FROM items WHERE id IN (SELECT item_id FROM restaurant_item_price JOIN restaurant_meal_details ON restaurant_item_price.restaurant_meal_id = restaurant_meal_details.id WHERE restaurant_meal_details.restaurant_id =  '" . $restaurant_id . "' 
         ) AND status =  '1' AND name = '" . $item . "'");

        if (mysqli_num_rows($num_rows) > 0)
            print 1;
        else
            print 0;
        break;
    case 'alreadyadd_exists_or_not':
        $item = $_REQUEST['item'];
        $num_rows = mysqli_query($conn, "SELECT * FROM items WHERE status =  '1' AND name = '" . $item . "'");
        if (mysqli_num_rows($num_rows) > 0)
            print 0;
        else
            print 1;
        break;
    case 'timeInterval':
        $start = $_GET['start'];
        $end = $_GET['end'];
        $timeInterval = findtimeInterval($start, $end);
        print $timeInterval;
        break;

    case 'bookingTimeChange':
        $time = $_GET['time'];
        $bookingID = $_GET['bookingID'];
        $change = bookingTimeChanges($time, $bookingID);
        print $change;
        break;

    case 'bookingRecordStatus':
        $status = $_GET['status'];
        $session = $_GET['session'];
        $record = bookingRecordStatus($status, $session);
        print_r($record);
        break;

    case 'bookingDetails':
        $rest_id = $_POST['id'];
        $record = get_booking_details($rest_id);
        $table = '<table class="table"><tr><td>Name</td><td>'.$record['name'].'</td></tr><tr><td>Email</td><td>'.$record['email'].'</td></tr><tr><td>Contact No</td><td>'.$record['contact_no'].'</td></tr><tr><td>Booking Date</td><td>'.$record['booking_date'].'</td></tr><tr><td>Booking Time</td><td>'.$record['booking_time'].'</td></tr><tr><td>Number of People</td><td>'.$record['number_of_people'].'</td></tr></table>';
        print_r($table);
        break;
    case 'locationValid':
        $record = getLatLong($_POST['location']);
        if($record['latitude']!="")
        {
           echo "0";
        }
        else
        {
           echo "1";
        }
        break;
       


}
?>
