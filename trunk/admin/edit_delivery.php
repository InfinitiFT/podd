<?php
ob_start();
include_once('header.php');
$mes = '';
$bookingData = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'], "SELECT * FROM `delivery_bookings` WHERE `delivery_id` ='" . decrypt_var($_GET['id']). "'"));
$restaurant_opening_closing = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'], "SELECT * FROM `restaurant_details` WHERE `` ='" . decrypt_var($_GET['id']). "'"));
if (isset($_REQUEST['submit'])) {
	
    $booking_time = mysqli_real_escape_string($conn, trim($_POST['delivery_time']));
    $name         = mysqli_real_escape_string($conn, trim($_POST['name']));
    $email        = mysqli_real_escape_string($conn, trim($_POST['email']));
    $phone        = mysqli_real_escape_string($conn, trim($_POST['phone']));
	$address = mysqli_real_escape_string($conn, trim($address));
    $booking_date = mysqli_real_escape_string($conn, trim($_POST['delivery_date']));
	if($_POST['booking_status']!="")
	{
		$update = mysqli_query($GLOBALS['conn'], "UPDATE `delivery_bookings` SET delivery_time ='" . $booking_time . "',delivery_date='" . $booking_date . "' ,delivery_status='" . $_POST['booking_status'] . "' WHERE `delivery_id` ='" . mysqli_real_escape_string($conn, decrypt_var($_GET['id'])) . "'");
	}
	else{
		$update = mysqli_query($GLOBALS['conn'], "UPDATE `delivery_bookings` SET delivery_time ='" . $booking_time . "',delivery_date='" . $booking_date . "' WHERE `delivery_id` ='" . mysqli_real_escape_string($conn, decrypt_var($_GET['id'])) . "'");
	}
    
	
    if ($update) {
        $_SESSION['updateBooking'] = 1;
        if ($_GET['list'] == 'list')
            header('Location: booking_list_restaurant_delivery.php');
        else
            header('Location: booking_list_restaurant_delivery.php');
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
                          <input type="text" id="phone" name="phone" disabled  value="<?php if($_POST['phone']){ echo $_POST['phone'];}else{ echo $bookingData['contact_no'];} ?>" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="booking_date">Address </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="address" name="address" readonly  value="<?php if($_POST['address']){ echo $_POST['address'];}else{ echo $bookingData['address'];} ?>" data-validate-length-range="8,20" class="form-control col-md-7 col-xs-12" aria-describedby="inputSuccess2Status" >
                        </div>
                      </div>
                     <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="booking_date">Delivery Date </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="booking_date" name="delivery_date" readonly  value="<?php if($_POST['delivery_date']){ echo $_POST['delivery_date'];}else{ echo $bookingData['delivery_date'];} ?>" data-validate-length-range="8,20" class="form-control col-md-7 col-xs-12" aria-describedby="inputSuccess2Status" >
                        </div>
                      </div>
                       
                      <input type="hidden" name = "restaurant_id" id="restaurant_id" value="<?php echo $bookingData['restaurant_id'];  ?>">
                      <div class="item form-group">
                        <label for="booking_time" class="control-label col-md-3">Delivery Time</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
							<select class="form-control col-md-7 col-xs-12" name="delivery_time" id="booking_time">
							<?php 
              $date_interval= edit_booking_delivery_option($bookingData['restaurant_id'],$bookingData['booking_data']);
							  if(!empty($date_interval))
                {
                 
								foreach($date_interval as $record){
							   
							  ?>
							   <option value= "<?php echo $record;?>" <?php if($record == $bookingData['delivery_time']){echo "selected";} ?>><?php echo $record;?></option>>
							  <?php }} else{ } ?>
							</select>                          
                        </div>
                      </div>
                       <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone">Status
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control col-md-7 col-xs-12" name="booking_status">
                              <option value=""></option>
                              <option value="3">Cancelled</option>
                            </select>
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
        }, function (start, end, label) {
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
