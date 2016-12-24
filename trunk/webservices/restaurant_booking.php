<?php
header('Content-type: application/json');
include('../functions/functions.php');
//Receiveing Input in Json and decoding
basic_authentication($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);
$data                = json_decode(file_get_contents('php://input'));
$restaurant_id       = $data->{"restaurant_id"};
$booking_date        = $data->{"booking_date"};
$booking_time        = $data->{"booking_time"};
$number_of_people    = $data->{"number_of_people"};
$name                = $data->{"name"};
$email               = $data->{"email"};
$contact_no          = $data->{"contact_no"};
$status_varification = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'], "SELECT * FROM `booked_records_restaurant` WHERE `contact_no`='" . $contact_no . "'"));
if ($status_varification->num_rows != 0) {
    $status_varification = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'], "SELECT verification FROM `booked_records_restaurant` WHERE `contact_no`='" . $contact_no . "'"));
    if ($status_varification['verification'] == "1") {
        $booking = mysqli_query($GLOBALS['conn'], "INSERT INTO `booked_records_restaurant`(`restaurant_id`, `booking_date`, `booking_time`, `number_of_people`, `name`, `email`, `contact_no`,`verification`) VALUES('" . $restaurant_id . "','" . $booking_date . "','" . $booking_time . "','" . $number_of_people . "','" . $name . "','" . $email . "','" . $contact_no . "','1')");
        if ($booking) {
            $resturantEmail = findResturantEmail($restaurant_id);
            $adminEmail     = findAdminEmail();
            // Mail Function with HTML template
            $to             = $resturantEmail['email'];
            $subject        = "Resturant Booking";
            
            
            // Always set content-type when sending HTML email
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            
            // More headers
            $headers .= 'From: ippodDevlopment@gmail.com' . "\r\n";
            
            if (mail($to, $subject, $message, $headers)) {
                // Always set content-type when sending HTML email
                $to      = $adminEmail;
                $subject = "Resturant Booking";
                
                
                // Always set content-type when sending HTML email
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                
                // More headers
                $headers .= 'From: ippodDevlopment@gmail.com' . "\r\n";
                
                if (mail($to, $subject, $message, $headers)) {
                    $response['responseCode']        = 200;
                    $response['verification_status'] = $status_varification['verification'];
                    $response['responseMessage']     = 'Restaurant booking successfully.'; //response for success case
                } else {
                    $response['responseCode']    = 400;
                    $response['responseMessage'] = 'Email Sending Errors.';
                }
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
        $random_number = rand(1000, 9999);
        if (mysqli_query($GLOBALS['conn'], "UPDATE `booked_records_restaurant` SET `otp`='" . $random_number . "' WHERE `contact_no`='" . $contact_no . "'")) {
            $resend_message = send_sms($contact_no, $random_number);
            if ($resend_message == "1") {
                $response['responseCode']        = 200;
                $response['verification_status'] = $status_varification['verification'];
                $response['responseMessage']     = 'Please verify your number.';
            } else {
                $response['responseCode']    = 400;
                $response['responseMessage'] = $resend_message;
            }
        } else {
            $response['responseCode']    = 400;
            $response['responseMessage'] = "Database Error ";
        }
    }
} else {
    $random_number = rand(1000, 9999);
    if (mysqli_query($GLOBALS['conn'], "UPDATE `booked_records_restaurant` SET `otp`='" . $random_number . "' WHERE `contact_no`='" . $contact_no . "'")) {
        $resend_message = send_sms($contact_no, $random_number);
        if ($resend_message == "1") {
            $booking = mysqli_query($GLOBALS['conn'], "INSERT INTO `booked_records_restaurant`(`restaurant_id`, `booking_date`, `booking_time`, `number_of_people`, `name`, `email`, `contact_no`) VALUES('" . $restaurant_id . "','" . $booking_date . "','" . $booking_time . "','" . $number_of_people . "','" . $name . "','" . $email . "','" . $contact_no . "')");
            
            if ($booking) {
                $resturantEmail = findResturantEmail($restaurant_id);
                $adminEmail     = findAdminEmail();
                // Mail Function with HTML template
                $to             = $resturantEmail['email'];
                $subject        = "Resturant Booking";
                $message        = '<!DOCTYPE html>
                      <html><head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
                      <title>Reservation Confirmation Navajo White</title>
                      <style type="text/css"><!--
                      body,td,th {
                      font-size: medium;
                      color: #000000;
                      }
                      body {
                            background-color: #ffdead;
                           }
                      .style3 {
                            font-size: 18px;
                            font-weight: bold;
                            }
                      .style4 {
                            font-size: small;
                            font-weight: bold;
                          }
                      .style5 {font-size: small}
                      -->
                      </style></head>
                      <body style="        background-color: #FFDEAD;">
                      <div align="center">
                      <table width="600" border="1" bordercolor="99CCFF">
                      <tbody>
                        <tr>
                          <td colspan="5" bordercolor="99CCFF" bgcolor="99CCFF">
                            <div align="center">
                              <p class="style3"><a href="http://setupmyhotel.com/formats/fo/266-reservation-template.html" target="_parent">Booking Request</a></p>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="5" bordercolor="99CCFF" bgcolor="99CCFF">
                          <div align="left"><strong>Hello , </strong><br>
                          </div></td>
                        </tr>
                        <tr>
                          <td colspan="5" bordercolor="99CCFF" bgcolor="#FFC977"><div align="left"><strong>Booking Details:</strong></div></td>
                        </tr>
                        <tr>
                          <td width="121" bordercolor="99CCFF" bgcolor="99CCFF"><div align="left"><span class="style4">User Name</span></div></td>
                          <td width="473" colspan="4" bordercolor="99CCFF" bgcolor="99CCFF">&nbsp;' . $name . '</td>
                        </tr>
                        <tr>
                          <td bordercolor="99CCFF" bgcolor="99CCFF"><div align="left"><span class="style4">Contact No</span></div></td>
                          <td colspan="4" bordercolor="99CCFF" bgcolor="99CCFF">&nbsp;' . $contact_no . '</td>
                        </tr>
                        <tr>
                          <td bordercolor="99CCFF" bgcolor="99CCFF"><div align="left"><span class="style4">Booking Date</span></div></td>
                          <td colspan="4" bordercolor="99CCFF" bgcolor="99CCFF">&nbsp;' . $booking_date . '</td>
                        </tr>
                        <tr>
                          <td bordercolor="99CCFF" bgcolor="99CCFF"><div align="left"><span class="style4">Booking Time</span></div></td>
                          <td colspan="4" bordercolor="99CCFF" bgcolor="99CCFF">&nbsp;' . $booking_time . '</td>
                        </tr>
                        <tr>
                          <td bordercolor="99CCFF" bgcolor="99CCFF"><div align="left"><span class="style4">Number Of people</span></div></td>
                          <td colspan="4" bordercolor="99CCFF" bgcolor="99CCFF">&nbsp;' . $number_of_people . '</td>
                        </tr>
                        <tr>
                          <td bordercolor="99CCFF" bgcolor="99CCFF"><div align="left"><span class="style4">Email</span></div></td>
                          <td colspan="4" bordercolor="99CCFF" bgcolor="99CCFF">&nbsp;' . $email . '</td>
                        </tr>
                        <tr>
                          <td colspan="5" bordercolor="99CCFF" bgcolor="#FFC977"><div align="left"><strong>Booking Status:</strong></div></td>
                       </tr>
                       <tr>
                          <td bordercolor="99CCFF" bgcolor="99CCFF"><div align="left" class="style4">Status</div></td>
                          <td colspan="4" bordercolor="99CCFF" bgcolor="99CCFF"><div align="left"><span class="style5">Pending</span></div></td>
                       </tr>
                   
                       </div></td>
                    </tr>
                  </tbody></table>
                </div>


              </body></html>';
                
                // Always set content-type when sending HTML email
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                
                // More headers
                $headers .= 'From: ippodDevlopment@gmail.com' . "\r\n";
                
                if (mail($to, $subject, $message, $headers)) {
                    // Always set content-type when sending HTML email
                    $to      = $adminEmail;
                    $subject = "Resturant Booking";
                    $message = '<!DOCTYPE html>
                      <html><head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
                      <title>Reservation Confirmation Navajo White</title>
                      <style type="text/css"><!--
                      body,td,th {
                      font-size: medium;
                      color: #000000;
                      }
                      body {
                            background-color: #ffdead;
                           }
                      .style3 {
                            font-size: 18px;
                            font-weight: bold;
                            }
                      .style4 {
                            font-size: small;
                            font-weight: bold;
                          }
                      .style5 {font-size: small}
                      -->
                      </style></head>
                      <body style="        background-color: #FFDEAD;">
                      <div align="center">
                      <table width="600" border="1" bordercolor="99CCFF">
                      <tbody>
                        <tr>
                          <td colspan="5" bordercolor="99CCFF" bgcolor="99CCFF">
                            <div align="center">
                              <p class="style3"><a href="http://setupmyhotel.com/formats/fo/266-reservation-template.html" target="_parent">Booking Request</a></p>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="5" bordercolor="99CCFF" bgcolor="99CCFF">
                          <div align="left"><strong>Hello , </strong><br>
                           <br>
                           New Booking <br>
                          </div></td>
                        </tr>
                        <tr>
                          <td colspan="5" bordercolor="99CCFF" bgcolor="#FFC977"><div align="left"><strong>Booking Details:</strong></div></td>
                        </tr>
                        <tr>
                          <td width="121" bordercolor="99CCFF" bgcolor="99CCFF"><div align="left"><span class="style4">User Name</span></div></td>
                          <td width="473" colspan="4" bordercolor="99CCFF" bgcolor="99CCFF">&nbsp;' . $name . '</td>
                        </tr>
                        <tr>
                          <td bordercolor="99CCFF" bgcolor="99CCFF"><div align="left"><span class="style4">Contact No</span></div></td>
                          <td colspan="4" bordercolor="99CCFF" bgcolor="99CCFF">&nbsp;' . $contact_no . '</td>
                        </tr>
                        <tr>
                          <td bordercolor="99CCFF" bgcolor="99CCFF"><div align="left"><span class="style4">Booking Date</span></div></td>
                          <td colspan="4" bordercolor="99CCFF" bgcolor="99CCFF">&nbsp;' . $booking_date . '</td>
                        </tr>
                        <tr>
                          <td bordercolor="99CCFF" bgcolor="99CCFF"><div align="left"><span class="style4">Booking Time</span></div></td>
                          <td colspan="4" bordercolor="99CCFF" bgcolor="99CCFF">&nbsp;' . $booking_time . '</td>
                        </tr>
                        <tr>
                          <td bordercolor="99CCFF" bgcolor="99CCFF"><div align="left"><span class="style4">Number Of people</span></div></td>
                          <td colspan="4" bordercolor="99CCFF" bgcolor="99CCFF">&nbsp;' . $number_of_people . '</td>
                        </tr>
                        <tr>
                          <td bordercolor="99CCFF" bgcolor="99CCFF"><div align="left"><span class="style4">Email</span></div></td>
                          <td colspan="4" bordercolor="99CCFF" bgcolor="99CCFF">&nbsp;' . $email . '</td>
                        </tr>
                
                        <tr>
                          <td colspan="5" bordercolor="99CCFF" bgcolor="#FFC977"><div align="left"><strong>Restaurant Details:</strong></div></td>
                        </tr>
                        <tr>
                          <td bordercolor="99CCFF" bgcolor="99CCFF"><div align="left"><span class="style4">Restaurant Name </span></div></td>
                          <td colspan="4" bordercolor="99CCFF" bgcolor="99CCFF"><span class="style5">' . $resturantEmail['restaurant_name'] . '</span></td>
                        </tr>
                        <tr>
                          <td bordercolor="99CCFF" bgcolor="99CCFF"><div align="left"><span class="style4">Restaurant Email</span></div></td>
                          <td colspan="4" bordercolor="99CCFF" bgcolor="99CCFF"><span class="style5">' . $resturantEmail['email'] . '</span></td>
                        </tr>
                        <tr>
                          <td bordercolor="99CCFF" bgcolor="99CCFF"><div align="left"><span class="style4">Restaurant Contact</span></div></td>
                          <td colspan="4" bordercolor="99CCFF" bgcolor="99CCFF"><span class="style5">' . $resturantEmail['mobile_no'] . '</span></td>
                        </tr>
                        <tr>
                          <td colspan="5" bordercolor="99CCFF" bgcolor="#FFC977"><div align="left"><strong>Booking Status:</strong></div></td>
                       </tr>
                       <tr>
                         <td bordercolor="99CCFF" bgcolor="99CCFF"><div align="left" class="style4">Status</div></td>
                         <td colspan="4" bordercolor="99CCFF" bgcolor="99CCFF"><div align="left"><span class="style5">Pending</span></div></td>
                        </tr>
               
                        </div></td>
                       </tr>
                    </tbody>
                  </table>
               </div>


              </body></html>';
                    
                    
                    // Always set content-type when sending HTML email
                    $headers = "MIME-Version: 1.0" . "\r\n";
                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                    
                    // More headers
                    $headers .= 'From: ippodDevlopment@gmail.com' . "\r\n";
                    
                    if (mail($to, $subject, $message, $headers)) {
                        $response['responseCode']        = 200;
                        $response['verification_status'] = "0";
                        $response['responseMessage']     = 'Restaurant booking successfully.'; //response for success case
                    } else {
                        $response['responseCode']    = 400;
                        $response['responseMessage'] = 'Email Sending Errors.';
                    }
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
            $response['responseMessage'] = $resend_message;
        }
    } else {
        $response['responseCode']    = 400;
        $response['responseMessage'] = "Database Error ";
    }
    
    
}

//Sending response after json encoding
$responseJson = json_encode($response);
print $responseJson;

?>