<?php
include('../functions/functions.php');
basic_authentication($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);
$data             = json_decode(file_get_contents('php://input'));
//print_r($data);exit;
$user_name = $data->{"user_name"};
$date_travel = $data->{"date_travel"};
$number_bags = $data->{"number_bags"};
$pickup_location = $data->{"pickup_location"};
$delevery_airport = $data->{"delevery_airport"};
$contact_number   = $data->{"contact_number"};
$select_time         = $data->{"select_time"};

 if (mysqli_query($GLOBALS['conn'], "INSERT INTO `airport_data`(`user_name`, `date_travel`, `number_bags`, `pickup_location`, `delevery_airport`, `contact_number`, `select_time`) VALUES ('".mysqli_real_escape_string($conn,trim($user_name))."','".mysqli_real_escape_string($conn,trim($date_travel))."','".mysqli_real_escape_string($conn,trim($number_bags))."','".mysqli_real_escape_string($conn,trim($pickup_location))."','".mysqli_real_escape_string($conn,trim($delevery_airport))."','".mysqli_real_escape_string($conn,trim($contact_number))."','".mysqli_real_escape_string($conn,trim($select_time))."')")) 
 {
    $mail_data['to']= "Poddapp@airportr.com";
	$mail_data['cc']= "hello@poddapp.com";
	$mail_data['subject']= "podd - new call-back request";
	$mail_data['html']= '
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
                <div>Hello Airportr,</div>
                <div class="m_-7807612712962067148paragraph_break"><br></div>
                <div>You have received a new call-back request.</div>
                <div class="m_-7807612712962067148paragraph_break"><br></div>
                <div>
                <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
	            <tr>
		        <td>
			    <table style="background:#f6f6f6;border:1px solid #000;" valign="top" align="center" width="600px" cellpadding="5" cellspacing="0" border="0">
				<tr>
			    <td valign="top" colspan="2" style="text-align:center;background:#000;color:#fff;border-top:1px solid #000;">
				Request Summary
				</td>
				</tr>
				<tr>
		        <td valign="top" width="30%" style="text-align:leftr;background:#000;color:#fff; border-top:1px solid #000;">
				Name
				</td>
				<td style="border-top:1px solid #000;">' . $user_name . '</td>
				</tr>
				<tr>
				<td valign="top" width="30%" style="text-align:leftr;background:#000;color:#fff; border-top:1px solid #000;">Date of Travel
				</td>
				<td style="border-top:1px solid #000;">' . $date_travel . '
				</td>
				</tr>
				<tr>
                <td valign="top" width="30%" style="text-align:leftr;background:#000;color:#fff; border-top:1px solid #000;">Number of Bags
				</td>
				<td style="border-top:1px solid #000;">' . $number_bags . '
				</td>
				</tr><tr>
				<td valign="top" width="30%" style="text-align:leftr;background:#000;color:#fff; border-top:1px solid #000;">Pick-up Address
				</td>
				<td style="border-top:1px solid #000;">' .$pickup_location.'	</td>
				</tr>
				<tr>
				<td valign="top" width="30%" style="text-align:leftr;background:#000;color:#fff; border-top:1px solid #000;">Delivery Airport
				</td>
				<td style="border-top:1px solid #000;">' . $delevery_airport . '	
				</td>
				</tr>
				<tr>
				<td valign="top" width="30%" style="text-align:leftr;background:#000;color:#fff; border-top:1px solid #000;">Contact Number
				</td>
				<td style="border-top:1px solid #000;">' . $contact_number . '
				</td>
				</tr>
				<tr>
				<td valign="top" width="30%" style="text-align:leftr;background:#000;color:#fff; border-top:1px solid #000;">Preferred Call Back Time
				</td>
				<td style="border-top:1px solid #000;">' . $select_time . '
				</td>
				</tr>
			    </table>
              </td>
	         </tr>
              </table></div>
                        <div class="m_-7807612712962067148paragraph_break"><br></div>
						<div>Please note that we have not charged the customer for this request. Please contact the customer directly to arrange delivery and payment.</div>
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
				 
                 $email_issue = send_email($mail_data);
				  if(json_decode($email_issue)->message == 'success'){ 
					$response['responseCode']    = 200;
					$response['responseMessage'] = 'Success.'; 
				  } else {
					$response['responseCode']    = 400;
					$response['responseMessage'] = 'Email Sending Errors.';
								
				   }	
				   
       }
            
     else {
        $response['responseCode']    = 400;
        $response['responseMessage'] = 'Incorrect verification code.';
        
    }
//Sending response after json encoding
$responseJson = json_encode($response);
print $responseJson;
?>
