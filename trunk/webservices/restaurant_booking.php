<?php
include('../functions/functions.php');
basic_authentication($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);
$data             = json_decode(file_get_contents('php://input'));
$restaurant_id    = $data->{"restaurant_id"};
$booking_date     = $data->{"booking_date"};
$booking_time     = $data->{"booking_time"};
$number_of_people = $data->{"number_of_people"};
$name             = $data->{"name"};
$email            = $data->{"email"};
$contact_no       = $data->{"contact_no"};
$otp = $data->{"otp"};
if (empty($otp) || empty($contact_no)) {
    
    $response['responseCode']    = 200;
    $response['responseMessage'] = 'All fields are required.';
} else {
    $otp1 = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'], "SELECT * FROM `number_verification` WHERE `contact_no`='" . mysqli_real_escape_string($conn, trim($contact_no)) . "'"));
    
    if ($otp1['otp'] == $otp) {
      $date_for_database = date ("Y-m-d", strtotime($booking_date));
        $booking = mysqli_query($GLOBALS['conn'], "INSERT INTO `booked_records_restaurant`(`restaurant_id`, `booking_date`, `booking_time`, `number_of_people`, `name`, `email`, `contact_no`,`verification`) VALUES('" . mysqli_real_escape_string($GLOBALS['conn'], $restaurant_id) . "','" . mysqli_real_escape_string($GLOBALS['conn'], $date_for_database) . "','" . mysqli_real_escape_string($GLOBALS['conn'], $booking_time) . "','" . mysqli_real_escape_string($GLOBALS['conn'], $number_of_people) . "','" . mysqli_real_escape_string($GLOBALS['conn'], $name) . "','" . mysqli_real_escape_string($GLOBALS['conn'], $email) . "','" . mysqli_real_escape_string($GLOBALS['conn'], $contact_no) . "','1')");
        
        if (mysqli_query($GLOBALS['conn'], "DELETE FROM `number_verification` WHERE `contact_no`='" . $contact_no . "'")) {
            if ($booking) {
                $date = date_create ($booking_date);
                $resturantEmail = findResturantEmail($restaurant_id);
                $adminEmail     = findAdminEmail();
                $to = $resturantEmail['email'];
                $subject = "podd - new customer booking request";
                $message = '
                  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                  <html xmlns="http://www.w3.org/1999/xhtml">
                  <head>
                  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                 
                  </head>
                  <body style="padding:0;margin:0;">
                  <tbody>
                     <tr>
                       <td style="padding-left:0px;font-size:14px;font-family:Helvetica,Arial,sans-serif" valign="top">
                       <div style="line-height:1.3em">
                       <div>Hello <b>'.$resturantEmail['restaurant_name'].'</b>,</div>
                       <div class="m_-7807612712962067148paragraph_break"><br></div>
                       <div>You have received a new booking request. Please click on the link below and log into your Admin panel to proceed</div>
                       <div class="m_-7807612712962067148paragraph_break"><br></div>
                       <div>
                       <table style="border:1px solid #000000;max-width:600px;margin:0 auto;" cellpadding="5">
                           <thead>
                               <tr>
                                <th colspan="2">Booking details</th>
                               
                               </tr>
                            </thead>
                           <tbody>
                               <tr>
                                  <td style="width:50%;border:1px solid #ccc;padding:8px;font-weight:bold">Name:</td>
                                  <td style="width:50%;border:1px solid #ccc;padding:8px">' . $name . '</td>
                              </tr>
                              <tr>
                                  <td style="width:50%;border:1px solid #ccc;padding:8px;font-weight:bold">Date</td>
                                  <td style="width:50%;border:1px solid #ccc;padding:8px">' .date_format($date,"d-M-Y").'</td>
                             </tr>
                              <tr>
                                  <td style="width:50%;border:1px solid #ccc;padding:8px;font-weight:bold">Time</td>
                                  <td style="width:50%;border:1px solid #ccc;padding:8px">' . $booking_time . '</td>
                             </tr>
                             <tr>
                                  <td style="width:50%;border:1px solid #ccc;padding:8px;font-weight:bold">Number of covers</td>
                                  <td style="width:50%;border:1px solid #ccc;padding:8px">' . $number_of_people . '</td>
                             </tr>
                              <tr>
                                   <td style="width:50%;border:1px solid #ccc;padding:8px;font-weight:bold">Telephone</td>
                                    <td style="width:50%;border:1px solid #ccc;padding:8px">' . $contact_no . '</td>
                              </tr>
                               <tr>
                                   <td style="width:50%;border:1px solid #ccc;padding:8px;font-weight:bold">Email</td>
                                    <td style="width:50%;border:1px solid #ccc;padding:8px">' . $email . '</td>
                              </tr>
                          </tbody>
                        </table></div>
                        <div class="m_-7807612712962067148paragraph_break"><br></div>
                         <div>Linkforlogin :<a href="'.url().''.'admin/booking_list_restaurant.php">Linkforlogin</a></div>
                       <div class="m_-7807612712962067148paragraph_break"><br></div>
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
      
      $headers = "MIME-Version: 1.0" . "\r\n";
      $headers .= 'Cc: hello@poddapp.com' . "\r\n";
      $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

      // More headers
      $headers .= 'From: podd' . "\r\n"; 
	 
      if(mail($to,$subject,$message,$headers)){ 
        $response['responseCode']    = 200;
        $response['responseMessage'] = 'Restaurant booking successfully.'; 
      } else {
        $response['responseCode']    = 400;
       $response['responseMessage'] = 'Email Sending Errors.';
                    
      }
    }
            
    else {
        $response['responseCode']    = 400;
        $response['responseMessage'] = 'Booking Errors.';
    }
            
            
  } else {
    $response['responseCode']    = 400;
    $response['responseMessage'] = 'Database Errors.';
            
            
 }
        
 } else {
        $response['responseCode']    = 400;
        $response['responseMessage'] = 'Incorrect verification code.';
        
    }
}
//Sending response after json encoding
$responseJson = json_encode($response);
print $responseJson;
?>
