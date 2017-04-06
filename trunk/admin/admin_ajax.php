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
      
        $message1 = "We are unable to confirm your booking with this venue, please try a different time or select another venue";
         if($booking_details['email']){
				$mail_data['to']= $booking_details['email'];
				$mail_data['cc']= "hello@poddapp.com";
		        $mail_data['subject']= "Booking declined on podd";
		        $mail_data['html']= '
                    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                      <html xmlns="http://www.w3.org/1999/xhtml">
                     <head>
                     <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                    
                     </head>
                      <body>
                        <tbody>
                          <tr>
                            <td style="padding-left:0px;font-size:14px;font-family:Helvetica,Arial,sans-serif" valign="top">
                              <div style="line-height:1.3em">
                                <div>Hello <b>'.$booking_details['name'].'</b>,</div>
                                  <div class="m_-7807612712962067148paragraph_break"><br></div>
                                  <div>We are unable to confirm your booking with this venue, please try a different time or select another venue. 
                                  <div class="m_-7807612712962067148paragraph_break"><br></div>
                                  <div>Best regards,</div>
                                  <div>The podd Team</div>
                             </div>
                          </td>
                        </tr>
                      </tbody>              
                    </body>
                 </html>';
		   // Always set content-type when sending HTML email
		    $mail_data['from']= "podd";
		    send_email($mail_data);

            }
       send_sms($booking_details['contact_no'],$message1);
        if ($update)
            print 1;
        else
            print 0;
        break;
        
    case 'declineDev':
        $id = $_GET['bookingIDDev'];
        $declined = $_GET['declinedDev'];  
        $decline_re = $_GET['decline_re'];
        if(mysqli_query($conn, "UPDATE `delivery_bookings` SET `delivery_status`='0',`decline_region`='" . $declined . "',`decline_re`='" . $decline_re . "' WHERE `delivery_id`='" . $id . "'"))
        {
            $booking_details = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'], "SELECT * FROM `delivery_bookings` db join restaurant_details rd on db.restaurant_id = rd.restaurant_id WHERE `delivery_id`='" .$id. "'"));
            $message         = "Hi ".$booking_details['name'].", unfortunately your order cannot be fulfilled at this time. Please select another option.";
            send_sms($booking_details['contact_no'], preg_replace('/^\s+|\s+$|\s+(?=\s)/', '', $message));
            if($booking_details['email']){
			  $mail_data['to']= $booking_details['email'];
			  $mail_data['cc']= "hello@poddapp.com";
		        $mail_data['subject']= "Order declined on podd";
		        $mail_data['html']= '
                    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                      <html xmlns="http://www.w3.org/1999/xhtml">
                     <head>
                     <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                     </head>
                      <body>
                        <tbody>
                          <tr>
                            <td style="padding-left:0px;font-size:14px;font-family:Helvetica,Arial,sans-serif" valign="top">
                              <div style="line-height:1.3em">
                                <div>Hello <b>'.$booking_details['name'].'</b>,</div>
                                  <div class="m_-7807612712962067148paragraph_break"><br></div>
                                  <div>unfortunately your order cannot be fulfilled at this time. Please select another option. 
                                  <div class="m_-7807612712962067148paragraph_break"><br></div>
                                  </div>
                                  <div class="m_-7807612712962067148paragraph_break"><br></div>
                                  <div>Best regards,</div>
                                  <div>The podd Team</div>
                             </div>
                          </td>
                        </tr>
                      </tbody>              
                    </body>
                 </html>';
		   // Always set content-type when sending HTML email
		    $mail_data['from']= "podd";
		    send_email($mail_data);
        }
       print 1;
      }
      else
      {
        
      }
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
     case 'booking_details_data':
        $restaurant_id = $_POST['restaurant_id'];
        $day_data = array();
        $day_data[0] = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM booked_records_restaurant WHERE restaurant_id = '".$restaurant_id."' AND booking_date = '".date('Y-m-d', strtotime($_POST['date1']))."' AND booking_status = '2' "));
        $day_data[1] = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM booked_records_restaurant WHERE restaurant_id = '".$restaurant_id."' AND booking_date = '".date('Y-m-d', strtotime($_POST['date1'] . " +1 days"))."' AND booking_status = '2' "));
        $day_data[2] = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM booked_records_restaurant WHERE restaurant_id = '".$restaurant_id."' AND booking_date = '".date('Y-m-d', strtotime($_POST['date1'] . " +2 days"))."' AND booking_status = '2' "));
        $day_data[3] = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM booked_records_restaurant WHERE restaurant_id = '".$restaurant_id."' AND booking_date = '".date('Y-m-d', strtotime($_POST['date1'] . " +3 days"))."' AND booking_status = '2' "));
        $day_data[4] = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM booked_records_restaurant WHERE restaurant_id = '".$restaurant_id."' AND booking_date = '".date('Y-m-d', strtotime($_POST['date1'] . " +4 days"))."' AND booking_status = '2' "));
        $day_data[5] = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM booked_records_restaurant WHERE restaurant_id = '".$restaurant_id."' AND booking_date = '".date('Y-m-d', strtotime($_POST['date1'] . " +5 days"))."' AND booking_status = '2' "));
        $day_data[6] = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM booked_records_restaurant WHERE restaurant_id = '".$restaurant_id."' AND booking_date = '".date('Y-m-d', strtotime($_POST['date1'] . " +6 days"))."' AND booking_status = '2'"));
        print_r(json_encode($day_data));
        break;

}
?>
