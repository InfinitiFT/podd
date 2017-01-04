<?php
/**
 * Created by PhpStorm.
 * User: ankitsing
 * Date: 24/12/16
 * Time: 11:22 AM
 */
session_start();
//include('../functions/config.php');
include('../functions/functions.php');
$restaurant_id = isset($_SESSION['restaurant_id']) ? $_SESSION['restaurant_id'] : $_REQUEST['restaurant_id'];
$find_interval = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM restaurant_details WHERE restaurant_id = '".$restaurant_id."' "));
/*$a = explode(':',$find_interval['opening_time']);
$b = explode(':',$find_interval['closing_time']);*/
$interval = 1800; // Interval in seconds

$date_first     = "07:30";
$date_second    = "11:30";

$time_first     = strtotime($find_interval['opening_time']);
$time_second    = strtotime($find_interval['closing_time']);
$array = array();
for ($i = $time_first; $i <= $time_second;){
    $array[] =  date('H:i', $i);
    $i += $interval;
}

?>
<div class="table-responsive">
<table class="table table-bordered table-hover">
    <thead>
    <tr>
        <th width="160">Time Interval</th>
        <th>Bookings</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $i= 1;
    foreach ($array as $value) {
        $find_booking = mysqli_query($conn,"SELECT * FROM booked_records_restaurant WHERE restaurant_id = '".$restaurant_id."' AND booking_time = '".$value."' AND booking_date = '".$_POST['date1']."' ");
        $wholeArray = array();
        while($no_of_booking = mysqli_fetch_assoc($find_booking)){
            $wholeArray[] = '<span class="booking-circle">'.$no_of_booking['number_of_people'].'</span>';
        }
        $bookings=  implode(' ',$wholeArray);
        echo '<tr>
                                
                                <td>'.$value.'</td>
                                <td>'.$bookings.'</td>
                            </tr>';
        $i++;
    }
    ?>
    </tbody>
</table>
</div>
