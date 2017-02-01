<?php
ob_start();
include_once('header.php');
$mes = '';
if ($_SESSION['msg'] == 'maxLimit') {
    $mes             = '<div class="alert alert-warning">Venue images maximum 6 uploaded</div>';
    $_SESSION['msg'] = '';
}
if ($_SESSION['msg'] == 'image') {
    $mes             = '<div class="alert alert-warning">Venue images not uploaded. Please try again</div>';
    $_SESSION['msg'] = '';
}
if ($_SESSION['msg'] == 'location') {
    $mes             = '<div class="alert alert-warning">Please enter valid location</div>';
    $_SESSION['msg'] = '';
}
$booking_id = decrypt_var($_GET['id']);

$bookingData                = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'], "SELECT * FROM `booked_records_restaurant` WHERE `booking_id` ='" . $booking_id . "'"));
$restaurant_opening_closing = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'], "SELECT * FROM `restaurant_details` WHERE `booking_id` ='" . $booking_id . "'"));
if (isset($_REQUEST['submit'])) {
    $booking_time = mysqli_real_escape_string($conn, trim($_POST['booking_time']));
    $people       = mysqli_real_escape_string($conn, trim($_POST['people']));
    $name         = mysqli_real_escape_string($conn, trim($_POST['name']));
    $email        = mysqli_real_escape_string($conn, trim($_POST['email']));
    $phone        = mysqli_real_escape_string($conn, trim($_POST['phone']));
    $booking_date = mysqli_real_escape_string($conn, trim($_POST['booking_date']));
    $update       = mysqli_query($GLOBALS['conn'], "UPDATE `booked_records_restaurant` SET booking_time ='" . $booking_time . "',number_of_people ='" . $people . "',name='" . $name . "',email='" . $email . "',booking_date='" . $booking_date . "',contact_no='" . $phone . "' WHERE `booking_id` ='" . mysqli_real_escape_string($conn, $booking_id) . "'");
    if ($update) {
        $_SESSION['updateBooking'] = 1;
        if ($_GET['list'] == 'list')
            header('Location: booking_list_restaurant.php');
        else
            header('Location: booking_list_restaurant.php');
    }
    
}
?>

        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
            </div>
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2> Edit Booking</h2>
                    <?php echo $mes; ?>
					<div class="clearfix"></div>
                  </div>
                  <div class="x_content">
					<form class="form-horizontal form-label-left" method="post" id="edit_booking" novalidate>
					 
                     <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="name" class="form-control col-md-7 col-xs-12" value="<?php if($_POST['name']){ echo $_POST['name'];}else{ echo $bookingData['name'];} ?>" data-validate-length-range="6" data-validate-words="2" name="name"  type="text">
                        </div>
                        <div id="mealAdded"></div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="email" id="email" name="email" disabled value="<?php if($_POST['email']){ echo $_POST['email'];}else{ echo $bookingData['email'];} ?>" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone">Phone
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="phone" name="phone" disabled value="<?php if($_POST['phone']){ echo $_POST['phone'];}else{ echo $bookingData['contact_no'];} ?>" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                     <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="booking_date">Booking Date </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="booking_date" name="booking_date" readonly value="<?php if($_POST['booking_date']){ echo $_POST['booking_date'];}else{ echo $bookingData['booking_date'];} ?>" data-validate-length-range="8,20" class="form-control col-md-7 col-xs-12" aria-describedby="inputSuccess2Status" >
                        </div>
                      </div>
                      <input type="hidden" name = "restaurant_id" id="restaurant_id" value="<?php echo $bookingData['restaurant_id'];  ?>">
                      <div class="item form-group">
                        <label for="booking_time" class="control-label col-md-3">Booking Time</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
							<select class="form-control col-md-7 col-xs-12" name="booking_time" id="booking_time">
							<?php 
               $date_interval = "";
               $day = date('D', strtotime($bookingData['booking_date']));
   
               $restaurant_data = mysqli_query($conn,"SELECT * FROM restaurant_details WHERE restaurant_id = '".mysqli_real_escape_string($conn,trim($bookingData['restaurant_id']))."' ");

        
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
                    $date_interval="";
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
                  $date_interval="";

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
                  $date_interval="";

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
                    $date_interval="";
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
                   $date_interval="";

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
                   $date_interval="";

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
                  
               }
            }
            else{
                
                   
            }
        }
                if(!empty($date_interval))
                {
                 
                foreach($date_interval as $record){
                 
                ?>
                <option value= "<?php echo $record;?>" <?php if($record == $bookingData['booking_time']){echo "selected";} ?>><?php echo $record;?></option>>
                <?php }} else{ } ?>
							</select>
                          
                        </div>
                      </div>
                     
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="people">Max number of people </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="people" name="people"  value="<?php if($_POST['people']){ echo $_POST['people'];}else{ echo $bookingData['number_of_people'];} ?>" data-validate-length-range="8,20" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                    <input type="hidden" value="<?php echo url();?>" id="urlData">
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                          <button id="send" type="submit" name="submit" class="btn btn-success">Save</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->

    <?php include_once('footer.php'); ?>

<script>
    $(document).ready(function() {
        $('#booking_date').daterangepicker({
            format: 'YYYY-MM-DD',
            singleDatePicker: true,
            calender_style: "picker_1",
        },
        function (start, end, label) {
            $.ajax
                ({
                  type: "POST",
                  url: "filter_list.php",
                  dataType: "json",
                  data: {date: $('#booking_date').val(),restaurant_id:$('#restaurant_id').val(),type:'date_interval'},
                  cache: false,
                  success: function (data) {
                    $("select#booking_time").html('');
                   $("select#booking_time").html(data);
                  }
                });
        });
    });
        </script>
