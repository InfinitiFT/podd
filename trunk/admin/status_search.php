<?php
include('../functions/session.php');
include('../functions/config.php');
include('../functions/functions.php');
$time = time();
$time = date('H:i:s', strtotime('-1 hour'));
// function for search booking restaurant list through status
if ($_POST['type'] == 'booking_management_status') {
    $fromdate = $_POST['fromdate'];
    $todate   = $_POST['todate'];
    $i        = 1;
    $fdate    = date('Y-m-d ', strtotime($fromdate));
    $tdate    = date('Y-m-d ', strtotime($todate));
    if ($_SESSION['restaurant_id'] != "") {
        $booking_records = mysqli_query($GLOBALS['conn'], "SELECT brr.booking_id,brr.*,rd.restaurant_name FROM booked_records_restaurant brr JOIN restaurant_details rd ON brr.restaurant_id = rd.restaurant_id Where brr.restaurant_id = '" . $_SESSION['restaurant_id'] . "' AND `booking_date` > CURRENT_DATE() AND `booking_status` = '" . mysqli_real_escape_string($GLOBALS['conn'], $_POST['st']) . "' OR brr.booking_id in(SELECT brr1.booking_id FROM booked_records_restaurant brr1  JOIN restaurant_details rd1 ON brr1.restaurant_id = rd1.restaurant_id Where booking_time > '" . $time . "' AND `booking_date` = CURRENT_DATE() AND brr1.restaurant_id = '" . $_SESSION['restaurant_id'] . "' AND `booking_status`= '" . mysqli_real_escape_string($GLOBALS['conn'], $_POST['st']) . "') order by brr.booking_id desc");
    } else {
        
        $booking_records = mysqli_query($GLOBALS['conn'], "SELECT brr.booking_id,brr.*,rd.restaurant_name FROM booked_records_restaurant brr JOIN restaurant_details rd ON brr.restaurant_id = rd.restaurant_id Where `booking_date` > CURRENT_DATE() AND `booking_status` = '" . mysqli_real_escape_string($GLOBALS['conn'], $_POST['st']) . "' OR brr.booking_id in(SELECT brr1.booking_id FROM booked_records_restaurant brr1  JOIN restaurant_details rd1 ON brr1.restaurant_id = rd1.restaurant_id Where booking_time > '" . $time . "' AND `booking_date` = CURRENT_DATE() AND `booking_status`= '" . mysqli_real_escape_string($GLOBALS['conn'], $_POST['st']) . "') order by brr.booking_id desc");  
    }
    $res = array();
    while ($record = mysqli_fetch_assoc($booking_records)) {
        $date = date_create($record['booking_date']);
        if ($record['booking_status'] == "1") {
            $booking_status1 = "Pending";
        } else if ($record['booking_status'] == "2") {
            $booking_status1 = "Accepted";
        } else {
            $booking_status1 = "Declined";
        }
        if ($record['booking_status'] == "1") {
            $action_data = "<button type='button' id='confirm-''" . encrypt_var($record['booking_id']) . "' class='btn btn-round btn-success'>Accept</button><button type='button' class='btn btn-round btn-warning'  id='declines-''" . encrypt_var($record['booking_id']) . "' data-toggle='modal' data-target='#myModal'>Decline</button><a href='" . 'edit_booking.php?id= ' . encrypt_var($record['booking_id']) . "' class='btn btn-round btn-info'>Edit</a>";
        } else if ($record['booking_status'] == "2") {
            $action_data = "<a href='" . 'edit_booking.php?id= ' . encrypt_var($record['booking_id']) . "' class='btn btn-round btn-info'>Edit</a>";
        } else {
            $action_data = "<button type='button' id='confirm-''" . encrypt_var($record['booking_id']) . "' class='btn btn-round btn-success'>Accept</button><a href='" . 'edit_booking.php?id= ' . encrypt_var($record['booking_id']) . "' class='btn btn-round btn-info'>Edit</a>";
        }
        ;
        $part[0] = $record['name'];
        $part[1] = $record['contact_no'];
        $part[2] = $record['email'];
        $part[3] = date_format($date, "d M Y");
        $part[4] = $record['booking_time'];
        $part[5] = $record['restaurant_name'];
        $part[6] = $record['number_of_people'];
        $part[7] = $booking_status1;
        $part[8] = $action_data;
        $res[] = $part;
    }
    $result['data1'] = $res;
    echo json_encode($result);
}
if ($_POST['type'] == 'booking_history_status') {
    if ($_SESSION['restaurant_id'] != "") {
        $booking_records = mysqli_query($GLOBALS['conn'], "SELECT brr.booking_id,brr.* FROM booked_records_restaurant brr JOIN restaurant_details rd ON brr.restaurant_id = rd.restaurant_id Where brr.restaurant_id = '" . $_SESSION['restaurant_id'] . "' AND `booking_date` < CURRENT_DATE() AND `booking_status` = '" . mysqli_real_escape_string($GLOBALS['conn'], $_POST['st']) . "' OR brr.booking_id in(SELECT brr1.booking_id FROM booked_records_restaurant brr1  JOIN restaurant_details rd1 ON brr1.restaurant_id = rd1.restaurant_id Where booking_time < '" . $time . "' AND `booking_date` = CURRENT_DATE() AND `booking_status`= '" . mysqli_real_escape_string($GLOBALS['conn'], $_POST['st']) . "' AND brr1.restaurant_id = '" . $_SESSION['restaurant_id'] . "') order by brr.booking_id desc");
        
    } else {
        
        $booking_records = mysqli_query($GLOBALS['conn'], "SELECT brr.booking_id,brr.* FROM booked_records_restaurant brr JOIN restaurant_details rd ON brr.restaurant_id = rd.restaurant_id Where `booking_date` < CURRENT_DATE() AND `booking_status` = '" . mysqli_real_escape_string($GLOBALS['conn'], $_POST['st']) . "' OR brr.booking_id in(SELECT brr1.booking_id FROM booked_records_restaurant brr1  JOIN restaurant_details rd1 ON brr1.restaurant_id = rd1.restaurant_id Where booking_time < '" . $time . "' AND `booking_date` = CURRENT_DATE()) order by brr.booking_id desc");  
    }
     $res = array();
     $newdate = date('Y-m-d', strtotime('-1 day', time()));
     $booking_date = date('Y-m-d', strtotime($record['booking_date']));
     $currettime = date('H:i',time());
     $booking_time = date('H:i',strtotime($record['booking_time']));
     if($booking_date > $newdate)
      {
        $edit_button = "<a href='" . 'edit_booking.php?id= ' . encrypt_var($record['booking_id']) . "&edit_type=edit_booking' class='btn btn-round btn-primary'>Edit</a>";
      } 
     else if($booking_date == $newdate && $booking_time > $currettime)
     {
       $edit_button = "<a href='" . 'edit_booking.php?id= ' . encrypt_var($record['booking_id']) . "&edit_type=edit_booking' class='btn btn-round btn-primary'>Edit</a>";
     }
     else
     {
       $edit_button = "<a href='#' class='btn btn-round btn-primary' disabled>Edit</a>";
     }
                     
    while ($record = mysqli_fetch_assoc($booking_records)) {
        if ($record['booking_status'] == "1") {
            $booking_status1 = "Pending";
        } else if ($record['booking_status'] == "2") {
            $booking_status1 = "Confirmed";
        }
         else if ($record['booking_status'] == "3") {
            $booking_status1 = "Cancelled";
        }
        else if ($record['booking_status'] == "4") {
            $booking_status1 = "No Show";
        }
         else {
            $booking_status1 = "Declined";
        }
        $part[0] = $record['booking_date'];
        $part[1] = $record['booking_time'];
        $part[2] = $record['number_of_people'];
        $part[3] = $booking_status1;
        $part[4] = $edit_button;
        //$part[4] = "<a href='" . 'edit_booking.php?id= ' . $record['booking_id'] . "' class='btn btn-round btn-primary'>Edit</a>";
        $res[]   = $part;
    }
    $result['data1'] = $res;
    echo json_encode($result);
}
if ($_POST['type'] == 'booking_history_delivery_status') {
    if ($_SESSION['restaurant_id'] != "") {
        $data = mysqli_query($GLOBALS['conn'], "SELECT db.delivery_id,db.* FROM delivery_bookings db JOIN restaurant_details rd ON db.restaurant_id = rd.restaurant_id Where db.restaurant_id = '" . $_SESSION['restaurant_id'] . "' ND `delivery_status` = '" . mysqli_real_escape_string($GLOBALS['conn'], $_POST['st']) . "' AND `delivery_date` < CURRENT_DATE() OR db.delivery_id in(SELECT db1.delivery_id FROM delivery_bookings db1  JOIN restaurant_details rd1 ON db1.restaurant_id = rd1.restaurant_id Where delivery_time < '" . $time . "' AND `delivery_date` = CURRENT_DATE() AND `delivery_status`= '" . mysqli_real_escape_string($GLOBALS['conn'], $_POST['st']) . "' AND db1.restaurant_id = '" . $_SESSION['restaurant_id'] . "') order by db.delivery_id desc");
    } else {
        $data = mysqli_query($GLOBALS['conn'], "SELECT db.delivery_id,db.* FROM delivery_bookings db JOIN restaurant_details rd ON db.restaurant_id = rd.restaurant_id Where `delivery_date` < CURRENT_DATE() ND `delivery_status` = '" . mysqli_real_escape_string($GLOBALS['conn'], $_POST['st']) . "' OR db.delivery_id in(SELECT db1.delivery_id FROM delivery_bookings db1  JOIN restaurant_details rd1 ON db1.restaurant_id = rd1.restaurant_id Where delivery_time < '" . $time . "' AND `delivery_date` = CURRENT_DATE() AND `delivery_status`= '" . mysqli_real_escape_string($GLOBALS['conn'], $_POST['st']) . "') order by db.delivery_id desc");
    }
    $res = array();
    while ($record = mysqli_fetch_assoc($booking_records)) {
        if ($record['delivery_status'] == "1") {
            $booking_status = "Pending";
        } else if ($record['delivery_status'] == "2") {
            $booking_status = "Confirmed";
        } else {
            $booking_status = "Declined";
        }
        $part[0] = $record['delivery_date'];
        $part[1] = $record['delivery_time'];
        $part[2] = $booking_status;
        $part[3] = "<a href='" . 'edit_booking.php?id= ' . encrypt_var($record['delivery_id']) . "' class='btn btn-round btn-primary'>Edit</a>";
        $res[]   = $part;
    }
    $result['data1'] = $res;
    echo json_encode($result);
}
if ($_POST['type'] == 'booking_delivery_status') {
    
    if ($_SESSION['restaurant_id'] != "") {
        $booking_records = mysqli_query($GLOBALS['conn'], "SELECT db.delivery_id,db.* FROM delivery_bookings db JOIN restaurant_details rd ON db.restaurant_id = rd.restaurant_id Where db.restaurant_id = '" . $_SESSION['restaurant_id'] . "' AND `delivery_status` = '" . mysqli_real_escape_string($GLOBALS['conn'], $_POST['st']) . "' AND `delivery_date` > CURRENT_DATE() OR db.delivery_id in(SELECT db1.delivery_id FROM delivery_bookings db1  JOIN restaurant_details rd1 ON db1.restaurant_id = rd1.restaurant_id Where delivery_time > '" . $time . "' AND `delivery_date` = CURRENT_DATE()  AND `delivery_status`= '" . mysqli_real_escape_string($GLOBALS['conn'], $_POST['st']) . "' AND db1.restaurant_id = '" . $_SESSION['restaurant_id'] . "') order by db.delivery_id desc");
    } else {
        $booking_records = mysqli_query($GLOBALS['conn'], "SELECT db.delivery_id,db.* FROM delivery_bookings db JOIN restaurant_details rd ON db.restaurant_id = rd.restaurant_id Where `delivery_date` > CURRENT_DATE() AND `delivery_status` = '" . mysqli_real_escape_string($GLOBALS['conn'], $_POST['st']) . "' OR db.delivery_id in(SELECT db1.delivery_id FROM delivery_bookings db1  JOIN restaurant_details rd1 ON db1.restaurant_id = rd1.restaurant_id Where delivery_time > '" . $time . "' AND `delivery_date` = CURRENT_DATE() AND `delivery_status`= '" . mysqli_real_escape_string($GLOBALS['conn'], $_POST['st']) . "') order by db.delivery_id desc");
    
    while ($record = mysqli_fetch_assoc($booking_records)) {
        $date = date_create($record['delivery_date']);
        if ($record['delivery_status'] == "1") {
            $booking_status1 = "Pending";
        } else if ($record['delivery_status'] == "2") {
            $booking_status1 = "Accepted";
        } 
        else if ($record['delivery_status'] == "3") {
            $booking_status1 = "Cancelled";
        }
        else if ($record['delivery_status'] == "4") {
            $booking_status1 = "No Show";
        }
        else {
            $booking_status1 = "Declined";
        }
        if ($record['delivery_status'] == "1") {
            $action_data = "<button type='button' id='confirm-''" . encrypt_var($record['delivery_id']) . "' class='btn btn-round btn-success'>Accept</button><button type='button' class='btn btn-round btn-warning'  id='declines-''" . encrypt_var($record['delivery_id']) . "' data-toggle='modal' data-target='#myModal'>Decline</button><a href='" . 'edit_delivery.php?id= ' . encrypt_var($record['delivery_id']) . "' class='btn btn-round btn-primary'>Edit</a><a href='" . 'delivery_order.php?delivery_id= ' . encrypt_var($record['delivery_id']) . "' class='btn btn-round btn-primary'>View</a>";
        } else if ($record['delivery_status'] == "2") {
            $action_data = "<a href='" . 'edit_delivery.php?id= ' . encrypt_var($record['delivery_id']) . "' class='btn btn-round btn-primary'>Edit</a><a href='" . 'delivery_order.php?delivery_id= ' . encrypt_var($record['delivery_id']). "' class='btn btn-round btn-primary'>View</a>";
        } else {
            $action_data = "<button type='button' id='confirm-''" . encrypt_var($record['delivery_id']) . "' class='btn btn-round btn-success'>Accept</button><a href='" . 'edit_delivery.php?id= ' . encrypt_var($record['delivery_id']) . "' class='btn btn-round btn-primary'>Edit</a><a href='" . 'delivery_order.php?delivery_id= ' . encrypt_var($record['delivery_id']) . "' class='btn btn-round btn-primary'>View</a>";
        }
        ;
        $part[0] = $record['name'];
        $part[1] = $record['contact_no'];
        $part[2] = $record['email'];
        $part[3] = date_format($date, "d M Y");
        $part[4] = $record['delivery_time'];
        $part[5] = $booking_status1;
        $part[6] = $action_data;
        $res[] = $part;
    }
    $result['data1'] = $res;
    echo json_encode($result);
}
}
?>
