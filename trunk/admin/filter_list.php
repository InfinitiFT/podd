<?php
include('../functions/config.php');
include('../functions/functions.php');
$time= time();
$time = date('H:i:s', strtotime('-1 hour'));
// function for booking history restaurant
if((isset($_POST['fromdate']) || isset($_POST['todate'])) && $_POST['type'] == 'booking_history')
{	
	
    $fromdate = $_POST['fromdate'];
    $todate = $_POST['todate'];
    $i = 1;
    $fdate = date('Y-m-d ',strtotime($fromdate). " +1 day");
    $tdate = date('Y-m-d ',strtotime($todate));
    
    if($_SESSION['restaurant_id'] != "")
    {

        $booking_records = mysqli_query($GLOBALS['conn'],"SELECT brr.booking_id,brr.* FROM booked_records_restaurant brr JOIN restaurant_details rd ON brr.restaurant_id = rd.restaurant_id Where booking_date BETWEEN '".mysqli_real_escape_string($GLOBALS['conn'],$fdate)."' AND '".mysqli_real_escape_string($GLOBALS['conn'],$tdate)."' AND brr.restaurant_id = '".$_SESSION['restaurant_id']."' AND `booking_date` < CURRENT_DATE() OR brr.booking_id in(SELECT brr1.booking_id FROM booked_records_restaurant brr1  JOIN restaurant_details rd1 ON brr1.restaurant_id = rd1.restaurant_id Where booking_time < '".$time."' AND `booking_date` = CURRENT_DATE()) order by brr.booking_id desc");
    	
    }
    else
    {
    	
    	 $booking_records = mysqli_query($GLOBALS['conn'],"SELECT brr.booking_id,brr.* FROM booked_records_restaurant brr JOIN restaurant_details rd ON brr.restaurant_id = rd.restaurant_id Where booking_date BETWEEN '".mysqli_real_escape_string($GLOBALS['conn'],$fdate)."' AND '".mysqli_real_escape_string($GLOBALS['conn'],$tdate)."' AND `booking_date` < CURRENT_DATE() OR brr.booking_id in(SELECT brr1.booking_id FROM booked_records_restaurant brr1  JOIN restaurant_details rd1 ON brr1.restaurant_id = rd1.restaurant_id Where booking_time < '".$time."' AND `booking_date` = CURRENT_DATE()) order by brr.booking_id desc");
    }

	$res = array();  
    
     while($record = mysqli_fetch_assoc($booking_records)){ 
        if($record['booking_status']=="1"){
                         $booking_status = "Pending";
                        }else if($record['booking_status']=="2"){
                          $booking_status = "Confirmed";
                        }else{
                          $booking_status = "Declined";
                        } 
        $part[0]   = $record['booking_date'];
        $part[1]   = $record['booking_time'];
        $part[2]   = $record['number_of_people'];
        $part[3]   = $booking_status; 
        $part[4]   = "<a href='".'edit_booking.php?id= '.$record['booking_id']."' class='btn btn-round btn-primary'>Edit</a>";
        
        $res[] = $part;
     }  
   
    $result['data1'] = $res;
    
    echo json_encode($result);
   
}
// function for booking restaurant list
if((isset($_POST['fromdate']) || isset($_POST['todate'])) && $_POST['type'] == 'booking_management_list')
{   
    
    $fromdate = $_POST['fromdate'];
    $todate = $_POST['todate'];
    $i = 1;
   $fdate = date('Y-m-d ',strtotime($fromdate). " +1 day");
   
   
    $tdate = date('Y-m-d',strtotime($todate));
    
    if($_SESSION['restaurant_id'] != "")
    {

        $booking_records = mysqli_query($GLOBALS['conn'],"SELECT brr.booking_id,brr.* FROM booked_records_restaurant brr JOIN restaurant_details rd ON brr.restaurant_id = rd.restaurant_id Where booking_date BETWEEN '".mysqli_real_escape_string($GLOBALS['conn'],$fdate)."' AND '".mysqli_real_escape_string($GLOBALS['conn'],$tdate)."' AND brr.restaurant_id = '".$_SESSION['restaurant_id']."' AND `booking_date` > CURRENT_DATE() OR brr.booking_id in(SELECT brr1.booking_id FROM booked_records_restaurant brr1  JOIN restaurant_details rd1 ON brr1.restaurant_id = rd1.restaurant_id Where booking_time > '".$time."' AND `booking_date` = CURRENT_DATE()) order by brr.booking_id desc");
        
    }
    else
    {
        
         $booking_records = mysqli_query($GLOBALS['conn'],"SELECT brr.booking_id,brr.* FROM booked_records_restaurant brr JOIN restaurant_details rd ON brr.restaurant_id = rd.restaurant_id Where booking_date BETWEEN '".mysqli_real_escape_string($GLOBALS['conn'],$fdate)."' AND '".mysqli_real_escape_string($GLOBALS['conn'],$tdate)."' AND `booking_date` > CURRENT_DATE() OR brr.booking_id in(SELECT brr1.booking_id FROM booked_records_restaurant brr1  JOIN restaurant_details rd1 ON brr1.restaurant_id = rd1.restaurant_id Where booking_time > '".$time."' AND `booking_date` = CURRENT_DATE()) order by brr.booking_id desc");
			
    }

    $res = array();  
    
     while($record = mysqli_fetch_assoc($booking_records)){ 
        $date = date_create ($record['booking_date']);
        if($record['booking_status']=="1"){
            $booking_status = "Pending";
        }else if($record['booking_status']=="2"){
            $booking_status = "Accepted";
        }else{
            $booking_status = "Declined";
        } 
         if($record['booking_status']=="1"){
            $action_data = "<button type='button' id='confirm-''".$record['booking_id']."' class='btn btn-round btn-success'>Accept</button><button type='button' class='btn btn-round btn-warning'  id='declines-''".$record['booking_id']."' data-toggle='modal' data-target='#myModal'>Decline</button><a href='".'edit_booking.php?id= '.$record['booking_id']."' class='btn btn-round btn-info'>Edit</a>";
                       }else if($record['booking_status']=="2"){
                         $action_data =  "<a href='".'edit_booking.php?id= '.$record['booking_id']."' class='btn btn-round btn-info'>Edit</a>";
                       }else{
                          $action_data = "<button type='button' id='confirm-''".$record['booking_id']."' class='btn btn-round btn-success'>Accept</button><a href='".'edit_booking.php?id= '.$record['booking_id']."' class='btn btn-round btn-info'>Edit</a>";
                        } ;
        $part[0]   = $record['name'];
        $part[1]   = $record['contact_no'];
        $part[2]   = $record['email'];
        $part[3]   = date_format($date,"d M Y");
        $part[4]   = $record['booking_time'];
        $part[5]   = $record['number_of_people'];
        $part[6]   = $booking_status;
        $part[7]   = $action_data;
       
        
        $res[] = $part;
     }  
   
    $result['data1'] = $res;
    
    echo json_encode($result);
   
}
else if((isset($_POST['fromdate']) || isset($_POST['todate'])) && $_POST['type'] == 'booking_history_delivery_cal')
{		
    $fromdate = $_POST['fromdate'];
    $todate = $_POST['todate'];
    $fdate = date('Y-m-d ',strtotime($fromdate). " +1 day");
    $tdate = date('Y-m-d ',strtotime($todate));
   if($_SESSION['restaurant_id'] != "")
    {
         $booking_records = mysqli_query($GLOBALS['conn'],"SELECT db.delivery_id,db.* FROM delivery_bookings db JOIN restaurant_details rd ON db.restaurant_id = rd.restaurant_id Where delivery_date BETWEEN '".mysqli_real_escape_string($GLOBALS['conn'],$fdate)."' AND '".mysqli_real_escape_string($GLOBALS['conn'],$tdate)."' AND db.restaurant_id = '".$_SESSION['restaurant_id']."'  AND `delivery_date` < CURRENT_DATE() OR db.delivery_id in(SELECT db1.delivery_id FROM delivery_bookings db1  JOIN restaurant_details rd1 ON db1.restaurant_id = rd1.restaurant_id Where delivery_time <'".$time."' AND `delivery_date` = CURRENT_DATE()) order by db.delivery_id desc");
      
    }
    else
    {
      
       $booking_records = mysqli_query($GLOBALS['conn'],"SELECT db.delivery_id,db.* FROM delivery_bookings db JOIN restaurant_details rd ON db.restaurant_id = rd.restaurant_id Where delivery_date BETWEEN '".mysqli_real_escape_string($GLOBALS['conn'],$fdate)."' AND '".mysqli_real_escape_string($GLOBALS['conn'],$tdate)."' AND `delivery_date` < CURRENT_DATE() OR db.delivery_id in(SELECT db1.delivery_id FROM delivery_bookings db1  JOIN restaurant_details rd1 ON db1.restaurant_id = rd1.restaurant_id Where delivery_time < '".$time."' AND `delivery_date` = CURRENT_DATE()) order by db.delivery_id desc");

      
    }

	$res = array();  
    
     while($record = mysqli_fetch_assoc($booking_records)){ 
        if($record['delivery_status']=="1"){
                         $booking_status = "Pending";
                        }else if($record['delivery_status']=="2"){
                          $booking_status = "Confirmed";
                        }else{
                          $booking_status = "Declined";
                        } 
        $part[0]   = $record['delivery_date'];
        $part[1]   = $record['delivery_time'];
        $part[2]   = $booking_status; 
        $part[3]   = "<a href='".'edit_delivery.php?id= '.$record['delivery_id']."' class='btn btn-round btn-primary'>Edit</a>";
        
        $res[] = $part;
     }  
   
    $result['data1'] = $res;
    
    echo json_encode($result);
   
}

// function for booking restaurant list
if((isset($_POST['fromdate']) || isset($_POST['todate'])) && $_POST['type'] == 'booking_deliverytable_cal')
{   
    
    $fromdate = $_POST['fromdate'];
    $todate = $_POST['todate'];
    $i = 1;
    $fdate = date('Y-m-d ',strtotime($fromdate). " +1 day");
    $tdate = date('Y-m-d ',strtotime($todate));
    
    if($_SESSION['restaurant_id'] != "")
    {
         $booking_records = mysqli_query($GLOBALS['conn'],"SELECT db.delivery_id,db.* FROM delivery_bookings db JOIN restaurant_details rd ON db.restaurant_id = rd.restaurant_id Where delivery_date BETWEEN '".mysqli_real_escape_string($GLOBALS['conn'],$fdate)."' AND '".mysqli_real_escape_string($GLOBALS['conn'],$tdate)."' AND db.restaurant_id = '".$_SESSION['restaurant_id']."'  AND `delivery_date` > CURRENT_DATE() OR db.delivery_id in(SELECT db1.delivery_id FROM delivery_bookings db1  JOIN restaurant_details rd1 ON db1.restaurant_id = rd1.restaurant_id Where delivery_time >'".$time."' AND `delivery_date` = CURRENT_DATE()) order by db.delivery_id desc");
      
    }
    else
    {
      
       $booking_records = mysqli_query($GLOBALS['conn'],"SELECT db.delivery_id,db.* FROM delivery_bookings db JOIN restaurant_details rd ON db.restaurant_id = rd.restaurant_id Where delivery_date BETWEEN '".mysqli_real_escape_string($GLOBALS['conn'],$fdate)."' AND '".mysqli_real_escape_string($GLOBALS['conn'],$tdate)."' AND `delivery_date` > CURRENT_DATE() OR db.delivery_id in(SELECT db1.delivery_id FROM delivery_bookings db1  JOIN restaurant_details rd1 ON db1.restaurant_id = rd1.restaurant_id Where delivery_time > '".$time."' AND `delivery_date` = CURRENT_DATE()) order by db.delivery_id desc");

      
    }

    $res = array();  
    
     while($record = mysqli_fetch_assoc($booking_records)){ 
        $date = date_create ($record['delivery_date']);
        if($record['delivery_status']=="1"){
            $booking_status = "Pending";
        }else if($record['delivery_status']=="2"){
            $booking_status = "Accepted";
        }else{
            $booking_status = "Declined";
        } 
         if($record['delivery_status']=="1"){
            $action_data = "<button type='button' id='confirm-''".$record['delivery_id']."' class='btn btn-round btn-success'>Accept</button><button type='button' class='btn btn-round btn-warning'  id='declines-''".$record['delivery_id']."' data-toggle='modal' data-target='#myModal'>Decline</button><a href='".'edit_delivery.php?id= '.$record['delivery_id']."' class='btn btn-round btn-primary'>Edit</a><a href='".'delivery_order.php?delivery_id= '.$record['delivery_id']."' class='btn btn-round btn-primary'>View</a>";
                       }else if($record['delivery_status']=="2"){
                         $action_data =  "<button type='button' class='btn btn-round btn-warning'  id='declines-''".$record['delivery_id']."' data-toggle='modal' data-target='#myModal'>Decline</button><a href='".'edit_delivery.php?id= '.$record['delivery_id']."' class='btn btn-round btn-primary'>Edit</a><a href='".'delivery_order.php?delivery_id= '.$record['delivery_id']."' class='btn btn-round btn-primary'>View</a>";
                       }else{
                          $action_data = "<button type='button' id='confirm-''".$record['delivery_id']."' class='btn btn-round btn-success'>Accept</button><a href='".'edit_delivery.php?id= '.$record['delivery_id']."' class='btn btn-round btn-primary'>Edit</a><a href='".'delivery_order.php?delivery_id= '.$record['delivery_id']."' class='btn btn-round btn-primary'>View</a>";
                        } ;
        $part[0]   = $record['name'];
        $part[1]   = $record['contact_no'];
        $part[2]   = $record['email'];
        $part[3]   = date_format($date,"d M Y");
        $part[4]   = $record['delivery_time'];
        $part[5]   = $booking_status;
        $part[6]   = $action_data;
       
        
        $res[] = $part;
     }  
   
    $result['data1'] = $res;
    
    echo json_encode($result);
   
}

// function for booking restaurant list
if((isset($_POST['date']) && isset($_POST['restaurant_id'])) && $_POST['type'] == 'date_interval')
{ 
    $day = date('D', strtotime($_POST['date']));
   
    $restaurant_data = mysqli_query($conn,"SELECT * FROM restaurant_details WHERE restaurant_id = '".mysqli_real_escape_string($conn,trim($_POST['restaurant_id']))."' ");
        
        if(mysqli_num_rows($restaurant_data)>0)
        {
            
             $find_interval = mysqli_fetch_assoc($restaurant_data);

            
            if($day == 'Sun'){
             
               if($find_interval['is_sun'] != 0)
               {
                  $time_first = strtotime($find_interval['sun_open_time']);
                   $time_second = strtotime($find_interval['sun_close_time']);
                   $interval = 1800; // Interval in seconds
                   $array = array();
                   for ($i = $time_first; $i <= $time_second;){
                     $array[] =  date('H:i', $i);
                     $i += $interval;
                   }
                  $date_interval = $array;
               }
               else
               {
                  
                  $date_interval ="";
               }
               

            }
            else if($day == 'Mon'){
               if($find_interval['is_mon'] != 0)
               {
                  $time_first = strtotime($find_interval['mon_open_time']);
                   $time_second = strtotime($find_interval['mon_close_time']);
                   $interval = 1800; // Interval in seconds
                   $array = array();
                   for ($i = $time_first; $i <= $time_second;){
                     $array[] =  date('H:i', $i);
                     $i += $interval;
                   }
                  $date_interval = $array;
                  

               }
               else
               {
                  $date_interval ="";  

               }

            }
            else if($day == 'Tue'){
              if($find_interval['is_tue'] != 0)
               {
                 $time_first = strtotime($find_interval['tue_open_time']);
                   $time_second = strtotime($find_interval['tue_close_time']);
                   $interval = 1800; // Interval in seconds
                   $array = array();
                   for ($i = $time_first; $i <= $time_second;){
                     $array[] =  date('H:i', $i);
                     $i += $interval;
                   }
                  $date_interval = $array;
                
                 

               }
               else
               {
                  
                  $date_interval ="";
               }
            }
            else if($day == 'Wed'){
              if($find_interval['is_wed'] != 0)
               {
                 $time_first = strtotime($find_interval['wed_open_time']);
                   $time_second = strtotime($find_interval['wed_close_time']);
                   $interval = 1800; // Interval in seconds
                   $array = array();
                   for ($i = $time_first; $i <= $time_second;){
                     $array[] =  date('H:i', $i);
                     $i += $interval;
                   }
                  $date_interval = $array;
                
                 
               }
               else
               {
                  $date_interval ="";
               }
            }
            else if($day == 'Thu'){
               if($find_interval['is_thu'] != 0)
               {
                 $time_first = strtotime($find_interval['thu_open_time']);
                   $time_second = strtotime($find_interval['thu_close_time']);
                   $interval = 1800; // Interval in seconds
                   $array = array();
                   for ($i = $time_first; $i <= $time_second;){
                     $array[] =  date('H:i', $i);
                     $i += $interval;
                   }
                  $date_interval = $array;
                 
                

               }
               else
               {
                  $date_interval ="";

               }
            }
            else if($day == 'Fri'){

               if($find_interval['is_fri'] != 0)
               {
                 $time_first = strtotime($find_interval['fri_open_time']);
                   $time_second = strtotime($find_interval['fri_close_time']);
                   $interval = 1800; // Interval in seconds
                   $array = array();
                   for ($i = $time_first; $i <= $time_second;){
                     $array[] =  date('H:i', $i);
                     $i += $interval;
                   }
                  $date_interval = $array;
                 
                

               }
               else
               {
                 $date_interval ="";

               }
            }
            else if($day == 'Sat'){
              
               if($find_interval['is_sat'] != 0)
               {
                  $time_first = strtotime($find_interval['sat_open_time']);
                   $time_second = strtotime($find_interval['sat_close_time']);
                   $interval = 1800; // Interval in seconds
                   $array = array();
                   for ($i = $time_first; $i <= $time_second;){
                     $array[] =  date('H:i', $i);
                     $i += $interval;
                   }
                  $date_interval = $array;
                 
               }
               else
               {
                 $date_interval =""; 
               }
            }
            else{
                
                  $date_interval ="";
            }
        }
        if(!empty($date_interval))
        {
          foreach($date_interval as $value1) {
          $var .='<option value="'.$value1.'">'.$value1.'</option> ';
          }
        }
        else
        {
          $var .='<option value="">Closed</option> ';
        }
        echo json_encode($var);
  }
