<?php 
ob_start();
include_once('header.php'); 
error_reporting(0);

$mes ='';
if($_SESSION['msg'] == 'maxLimit'){
	$mes = '<div class="alert alert-warning">Venue images maximum 6 uploaded</div>';
	$_SESSION['msg'] ='';
}
if ($_SESSION['msg'] == 'image'){
	$mes = '<div class="alert alert-warning">Venue images not uploaded. Please try again</div>';
	$_SESSION['msg'] ='';
}
if ($_SESSION['msg'] == 'location'){
	$mes = '<div class="alert alert-warning">Please enter valid location</div>';
	$_SESSION['msg'] ='';
}

$bookingData = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'],"SELECT * FROM `booked_records_restaurant` WHERE `booking_id` ='".$_GET['id']."'"));
if(isset($_REQUEST['submit'])){
	
	$update = mysqli_query($GLOBALS['conn'],"UPDATE `booked_records_restaurant` SET booking_time ='".$_POST['booking_time']."',number_of_people ='".$_POST['people']."',name='".$_POST['name']."',email='".$_POST['email']."',booking_date='".$_POST['booking_date']."',contact_no='".$_POST['phone']."' WHERE `booking_id` ='".$_GET['id']."'");
	if($update){
		$_SESSION['updateBooking'] = 1;
		header('Location: booking_history.php');
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
                          <input type="email" id="email" name="email"  value="<?php if($_POST['email']){ echo $_POST['email'];}else{ echo $bookingData['email'];} ?>" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone">Phone
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="phone" name="phone"  value="<?php if($_POST['phone']){ echo $_POST['phone'];}else{ echo $bookingData['contact_no'];} ?>" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                     <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="booking_date">Booking Date </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="booking_date" name="booking_date"  value="<?php if($_POST['booking_date']){ echo $_POST['booking_date'];}else{ echo $bookingData['booking_date'];} ?>" data-validate-length-range="8,20" class="form-control col-md-7 col-xs-12" aria-describedby="inputSuccess2Status" >
                        </div>
                      </div>
                      <div class="item form-group">
                        <label for="booking_time" class="control-label col-md-3">Booking Time</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
							<select class="form-control col-md-7 col-xs-12" name="booking_time" id="booking_time" onchange="timeValidateClose(this)">
							<?php $i =0;
								for($hours=0; $hours<24; $hours++){ // the interval for hours is '1'
									for($mins=0; $mins<60; $mins+=30){
										 // the interval for mins is '30'
										 if($i == 0)
											echo '<option value="">'.str_pad($hours,2,'0',STR_PAD_LEFT).':'
														   .str_pad($mins,2,'0',STR_PAD_LEFT).'</option>';
										 $selected ='';
										if(str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT) == $bookingData['booking_time'])
											$selected ='selected';
											echo '<option value="'.str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT).'" '.$selected.'>'.str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT).'</option>';
										   $i =$i+1;
								    }
							    }
							?>
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
        }, function (start, end, label) {
            console.log(start.toISOString(), end.toISOString(), label);
        });
    });
        </script>