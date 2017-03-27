<?php
include('../functions/functions.php');
$type   = $_POST['pagetype'];
$id     = $_POST['id'];
$status = $_POST['status'];
if ($type == "booked_restaurant") {
    if (mysqli_query($GLOBALS['conn'], "UPDATE `booked_records_restaurant`  SET `booking_status`= '" . $status . "' WHERE `booking_id` = '" . $id . "'")) {
        
        if (trim($status) == '2') {
            $booking_details = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'], "SELECT * FROM `booked_records_restaurant` brr join restaurant_details rd on brr.restaurant_id = rd.restaurant_id  WHERE `booking_id`='" . mysqli_real_escape_string($conn, trim($id)) . "'"));
            $booking_date    = date('l', strtotime($booking_details['booking_date'])); // note: first arg to date() is lower-case L
            $date            = date_create($booking_details['booking_date']);
            $message         = "Your booking has been confirmed at".' '.$booking_details['restaurant_name'] . ",".' '. $booking_details['restaurant_full_address'] . "".' '."on" .' '. $booking_date . "," . date_format($date, "d-M-Y") .' ' ."at" .' '. $booking_details['booking_time'] . "";
            send_sms($booking_details['contact_no'],$message);
            if($booking_details['email']){
				$mail_data['to']= $booking_details['email'];
		        $mail_data['subject']= "Booking confirmation on podd";
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
                                  <div>Your booking has been confirmed at '. $booking_details['restaurant_name'] . ',' . $booking_details['restaurant_full_address'] . ''.' '.'on'.' '.''. $booking_date . ',' . date_format($date, "d-M-Y") . ''.' '.'at '.' '.'' . $booking_details['booking_time'] . '</div>
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
             
            
        } else {
            
        }
        echo "success";
    } else {
        echo "error";
    }
}
if ($type == "booked_restaurant_delivery") {
    if (mysqli_query($GLOBALS['conn'], "UPDATE `delivery_bookings` SET `delivery_status`= '" . $status . "' WHERE `delivery_id` = '" . $id . "'")) {
        if (trim($status) == '2') {
           $booking_details = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'], "SELECT * FROM `delivery_bookings` db join restaurant_details rd on db.restaurant_id = rd.restaurant_id WHERE `delivery_id`='" . mysqli_real_escape_string($conn, trim($id)) . "'"));
            $message         = "Your Order has been confirmed by ".' '.$booking_details['restaurant_name'].".".' '."A member of their team will call you shortly to complete the booking.";
            send_sms($booking_details['contact_no'],$message);
			
            if($booking_details['email']){
			  $mail_data['to']= $booking_details['email'];
		        $mail_data['subject']= "Booking confirmation on podd";
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
                                  <div>Your Order has been confirmed by '.$booking_details['restaurant_name'].'. A member of their team will call you shortly to complete the booking. 
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
		 echo "success";
        
    } else {
        echo "error";
    }
}
}




?>

  