<?php
/**
 * Created by PhpStorm.
 * User: ankitsing
 * Date: 24/12/16
 * Time: 11:22 AM
 */
session_start();
include('../functions/config.php');
$restaurant_id = isset($_SESSION['restaurant_id']) ? $_SESSION['restaurant_id'] : $_REQUEST['restaurant_id'];
$find_interval = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM restaurant_details WHERE restaurant_id = '".$restaurant_id."' "));
$a = explode(':',$find_interval['opening_time']);
$b = explode(':',$find_interval['closing_time']);
$array = array();
for($hours=$a[0]; $hours<$b[0]; $hours++) {
    // the interval for hours is '1'
    for ($mins = $a[1]; $mins < 60; $mins += 30) {
        // the interval for mins is '30'
        $array[] = str_pad($hours, 2, '0', STR_PAD_LEFT) . ':' . str_pad($mins, 2, '0', STR_PAD_LEFT);
        //$i = $i + 1;
    }
}

?>
<table class="table">
    <thead>
    <tr>
        <th>#</th>
        <th>Time Interval</th>
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
            $wholeArray[] = $no_of_booking['number_of_people'];
        }
        $bookings=  implode(' ',$wholeArray);
        echo '<tr>
                                <th scope="row">'.$i.'</th>
                                <td>'.$value.'</td>
                                <td>'.$bookings.'</td>
                            </tr>';
        $i++;
    }
    ?>
    </tbody>
</table>
