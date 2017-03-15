<?php
include('../functions/functions.php');
basic_authentication($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);
$data             = json_decode(file_get_contents('php://input'));
//print_r($data);exit;
$restaurant_id = $data->{"restaurant_id"};
$delivery_date = $data->{"booking_date"};
$delivery_time = $data->{"booking_time"};
$order_details = $data->{"order_details"};
$name          = $data->{"name"};
$total_price   = $data->{"total_price"};
$email         = $data->{"email"};
$contact_no    = $data->{"contact_no"};
$address    = $data->{"address"};
$otp           = $data->{"otp"};

if (empty($otp) || empty($contact_no) || empty($restaurant_id) || empty($delivery_date) || empty($delivery_time) || empty($order_details)) {
    
    $response['responseCode']    = 200;
    $response['responseMessage'] = 'All fields are required.';
} else {
        $otp1 = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'], "SELECT * FROM `number_verification` WHERE `contact_no`='" . mysqli_real_escape_string($conn, trim($contact_no)) . "'"));
        if ($otp1['otp'] == $otp) {
        $date_for_database = date ("Y-m-d", strtotime($delivery_date));
         if (mysqli_query($GLOBALS['conn'], "INSERT INTO `delivery_bookings`(`restaurant_id`, `delivery_date`, `delivery_time`, `name`, `email`, `contact_no`,`verification`,`total_price`,`address`) VALUES('" .mysqli_real_escape_string($GLOBALS['conn'], $restaurant_id) . "','" . mysqli_real_escape_string($GLOBALS['conn'], $date_for_database) . "','" . mysqli_real_escape_string($GLOBALS['conn'], $delivery_time) . "','" . mysqli_real_escape_string($GLOBALS['conn'], $name) . "','" . mysqli_real_escape_string($GLOBALS['conn'], $email) . "','" . mysqli_real_escape_string($GLOBALS['conn'], $contact_no) . "','1','" . mysqli_real_escape_string($GLOBALS['conn'], $total_price) . "','" . mysqli_real_escape_string($GLOBALS['conn'], $address) . "')")) {
          
            $booking_order_id = mysqli_insert_id($GLOBALS['conn']);

            if(!empty($order_details))
            {
               foreach($order_details as $order){
               
                mysqli_query($GLOBALS['conn'], "INSERT INTO `order_item`(`order_id`, `meal_name`, `subtitle_name`, `item_name`,`quantity`, `price`) VALUES ('" . mysqli_real_escape_string($GLOBALS['conn'], $booking_order_id) . "','" . mysqli_real_escape_string($GLOBALS['conn'], $order->meal_id) . "','" . mysqli_real_escape_string($GLOBALS['conn'],$order->subtitle_id) . "','" . mysqli_real_escape_string($GLOBALS['conn'], $order->item_id) . "','" . mysqli_real_escape_string($GLOBALS['conn'], $order->count) . "','" . mysqli_real_escape_string($GLOBALS['conn'], $order->price) . "')");
               
               }

               if (mysqli_query($GLOBALS['conn'], "DELETE FROM `number_verification` WHERE `contact_no`='" . $contact_no . "'")) {
				        $date = date_create ($delivery_date);
						$order_data = mysqli_query($GLOBALS['conn'],"SELECT * FROM `order_item` oi join meals m on oi.meal_name = m.id join subtitle s on oi.subtitle_name = s.subtitle_id join items i on oi.item_name = i.id WHERE `order_id` ='".$booking_order_id."'");
						$order_sumray = '';
						
						while($record = mysqli_fetch_assoc($order_data)){
							$price = str_replace("£","",$record['price']); 
							$total_p = "£".$record['quantity']*$price;
									   $order_sumray .= '<tr>
					<td valign="top" style="border-top:1px solid #000;">
					
						' . $record['name'] . '
					</td>
					<td valign="top" style="border-top:1px solid #000;">
						' . $record['price'] . '
					</td>
					<td valign="top" style="border-top:1px solid #000;">
						' . $record['quantity'] . '
					</td>
					<td valign="top" style="border-top:1px solid #000;">
						' . $total_p . '
					</td>
				</tr>';
								   }
									  
				   $resturantEmail = findResturantEmail($restaurant_id);
				   $mail_data['to']= $resturantEmail['email'];
				   $mail_data['subject']= "podd - new order request";
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
							   <div>Hello <b>'.$resturantEmail['restaurant_name'].'</b>,</div>
							   <div class="m_-7807612712962067148paragraph_break"><br></div>
							   <div>You have received a new booking request from podd. Please click on the following link to log into</div> 
							   <div>your portal to proceed <a href="'.url().''.'/delivery_order.php?delivery_id='.encrypt_var($booking_order_id).''.'&restaurant_id='.encrypt_var($restaurant_id).'">Go to Portal</a></div>
							   <div class="m_-7807612712962067148paragraph_break"><br></div>
							   <div>
							    <table style="background:#f6f6f6;border:1px solid #000;" valign="top" align="center" width="600px" cellpadding="5" cellspacing="0" border="0">
				<tr>
					<td valign="top" colspan="4" style="text-align:center;background:#000;color:#fff;border-top:1px solid #000;">
						NEW ORDER REQUEST
					</td>
				</tr>
				<tr>
					<td valign="top" width="30%" style="text-align:leftr;background:#000;color:#fff; border-top:1px solid #000;">
						Name
					</td>
					<td colspan="3" style="border-top:1px solid #000;">
						' . $name . '
					</td>
				</tr>
				<tr>
					<td valign="top" width="30%" style="text-align:leftr;background:#000;color:#fff; border-top:1px solid #000;">
						Address
					</td>
					<td colspan="3" style="border-top:1px solid #000;">
						' .$address. '
					</td>
				</tr>
				<tr>
					<td valign="top" width="30%" style="text-align:leftr;background:#000;color:#fff; border-top:1px solid #000;">
						Telephone
					</td>
					<td colspan="3" style="border-top:1px solid #000;">
						' . $contact_no . '
					</td>
				</tr>
				<tr>
					<td valign="top" width="30%" style="text-align:leftr;background:#000;color:#fff; border-top:1px solid #000;">
						Email
					</td>
					<td colspan="3" style="border-top:1px solid #000;">
						' . $email . '
					</td>
				</tr>
				<tr>
					<td valign="top" width="30%" style="text-align:leftr;background:#000;color:#fff; border-top:1px solid #000;">
						Date
					</td>
					<td colspan="3" style="border-top:1px solid #000;">
						' .date_format($date,"d-M-Y").'
					</td>
				</tr>
				<tr>
					<td valign="top" width="30%" style="text-align:leftr;background:#000;color:#fff; border-top:1px solid #000;">
						Time
					</td>
					<td colspan="3" style="border-top:1px solid #000;">
						'.$delivery_time.'
					</td>
				</tr>
				<tr>
					<td valign="top" colspan="4" style="text-align:center;background:#000;color:#fff;border-top:1px solid #000;">
						 ORDER SUMMARY
					</td>
				</tr>
				<tr>
					<td valign="top" style="background:#ddd;border-top:1px solid #000;" width="50%">
						Item
					</td>
					<td valign="top" style="background:#ddd;border-top:1px solid #000;" width="20%">
						Unit Price
					</td>
					<td valign="top" style="background:#ddd;border-top:1px solid #000;" width="20%">
						Quantity
					</td>
					<td valign="top" style="background:#ddd;border-top:1px solid #000;" width="10%">
						Total Price
					</td>
				</tr>
				'.$order_sumray.'
				<tr>
					<td valign="top" colspan="2" style="text-align:left;background:#000;color:#fff;border-top:1px solid #000;">
						GRAND TOTAL
					</td>
					<td valign="top" colspan="2" style="text-align:right;background:#000;color:#fff;border-top:1px solid #000;">
						 '.$total_price.'
					</td>
				</tr>
				
			</table>
		</td>
	</tr>
</table></div>
								<div class="m_-7807612712962067148paragraph_break"><br></div>
								 
							   <div class="m_-7807612712962067148paragraph_break"><br></div>
							   Please note that we have not charged the customer for this order. Please contact the customer directly to arrange delivery and payment.
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
					$response['responseMessage'] = 'Order booked Successfully.'; 
				  } else {
					$response['responseCode']    = 400;
					$response['responseMessage'] = 'Email Sending Errors.';
								
				   }		
               }
            
               else {
                $response['responseCode']    = 400;
                $response['responseMessage'] = 'Database Errors.';
                }
            

            }
            else
            {
              $response['responseCode']    = 400;
              $response['responseMessage'] = 'Order details is empty.';

            }   
        } else {
            $response['responseCode']    = 400;
            $response['responseMessage'] = 'Booking Errors.';
            
            
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
