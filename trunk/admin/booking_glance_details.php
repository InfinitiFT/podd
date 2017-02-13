<?php
/**
 * Created by PhpStorm.
 * User: ankitsing
 * Date: 24/12/16
 * Time: 11:22 AM
 */
session_start();
include('../functions/functions.php');
$restaurant_id = isset($_SESSION['restaurant_id']) ? $_SESSION['restaurant_id'] : $_REQUEST['restaurant_id'];
$restaurant_data = mysqli_query($conn,"SELECT * FROM restaurant_details WHERE restaurant_id = '".$restaurant_id."' ");
$day = date('D', strtotime($_POST['date1']));
if(mysqli_num_rows($restaurant_data)>0)
        {
            $find_interval = mysqli_fetch_assoc($restaurant_data);
            if($day == 'Sun'){
             
               if($find_interval['is_sun'] != '0')
               {
                  $time_first     = strtotime($find_interval['sun_open_time']);
                  $time_second    = strtotime($find_interval['sun_close_time']);
                 
               }
               else
               {
                  $time_first = ""; 
               }
               

            }
            else if($day == 'Mon'){
               if($find_interval['is_mon'] != '0')
               {
                  
                  $time_first     = strtotime($find_interval['mon_open_time']);
                  $time_second    = strtotime($find_interval['mon_close_time']);

               }
               else
               {
                  $time_first = "";
               }

            }
            else if($day == 'Tue'){
              if($find_interval['is_tue'] != '0')
               {
                  $time_first     = strtotime($find_interval['tue_open_time']);
                  $time_second    = strtotime($find_interval['tue_close_time']);


               }
               else
               {
                  $time_first = "";
               }
            }
            else if($day == 'Wed'){
              if($find_interval['is_wed'] != '0')
               {
                 
                  $time_first     = strtotime($find_interval['wed_open_time']);
                  $time_second    = strtotime($find_interval['wed_close_time']);
                  
               }
               else
               {
                 $time_first = "";
               }
            }
            else if($day == 'Thu'){
               if($find_interval['is_thu'] != '0')
               {
                  $time_first     = strtotime($find_interval['thu_open_time']);
                  $time_second    = strtotime($find_interval['thu_close_time']);

               }
               else
               {
                  
                  $time_first = "";
               }
            }
            else if($day == 'Fri'){

               if($find_interval['is_fri'] != '0')
               {
                  $time_first     = strtotime($find_interval['fri_open_time']);
                  $time_second    = strtotime($find_interval['fri_close_time']);

               }
               else
               {
                 $time_first = "";

               }
            }
            else if($day == 'Sat'){
              
               if($find_interval['is_sat'] != '0')
               {
                  $time_first     = strtotime($find_interval['sat_open_time']);
                  $time_second    = strtotime($find_interval['sat_close_time']);

               }
               else
               {
                  $time_first = "";
               }
            }
            else{
                
                $time_first = "";   
            }
        }
$interval = 1800; // Interval in seconds
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
    if(!empty($time_first))
    {
        foreach ($array as $value) {
        $find_booking = mysqli_query($conn,"SELECT * FROM booked_records_restaurant WHERE restaurant_id = '".$restaurant_id."' AND booking_time = '".$value."' AND booking_date = '".$_POST['date1']."' ");
        $wholeArray = array();
        while($no_of_booking = mysqli_fetch_assoc($find_booking)){
            $wholeArray[] = '<span class="booking-circle" id="resid-'.$no_of_booking['booking_id'].'">'.$no_of_booking['number_of_people'].'</span>';
        }
        $bookings=  implode(' ',$wholeArray);
        echo '<tr>
                                
                                <td>'.$value.'</td>
                                <td>'.$bookings.'</td>
                            </tr>';
        $i++;
       }

    }
    else
    {
        echo '<tr>
                                
                                <td colspan="2">Restaurant Closed</td>
                                
                            </tr>';
        
    }
    
    ?>
    </tbody>
</table>
</div>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Booking Details</h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<script>
    $(document).ready(function() {
        $("[id ^='resid-']").click(function () {
            var restID = $(this).attr('id');
            var restArr = restID.split('-');
            $.ajax({
                url:'admin_ajax.php',
                type: 'post',
                data: {type:'bookingDetails',id:restArr[1]},
                success: function(data, status) {
                    $("#myModal").modal('show');
                    $(".modal-body").html(data);
                },
                error: function(xhr, desc, err) {
                    console.log(xhr);
                }
            });
        }); 
                
    });
       
</script>
