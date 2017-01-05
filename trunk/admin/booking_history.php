<?php 
  include_once('header.php');
 
  if($_SESSION['updateBooking'] == 1){
		$msg = '<div class="alert alert-success">Booking updated successfully</div>';
	    $_SESSION['updateBooking'] ='';
	}
  $result = array();
  if($_SESSION['restaurant_id']!="")
  {
  $data = mysqli_query($GLOBALS['conn'],"SELECT * FROM booked_records_restaurant brr JOIN restaurant_details rd ON brr.restaurant_id = rd.restaurant_id Where brr.restaurant_id = '".$_SESSION['restaurant_id']."' AND `booking_date` <= CURRENT_DATE() order by brr.booking_id desc");
  }
  else
  {
    $data = mysqli_query($GLOBALS['conn'],"SELECT * FROM booked_records_restaurant brr JOIN restaurant_details rd ON brr.restaurant_id = rd.restaurant_id Where `booking_date` <= CURRENT_DATE() order by brr.booking_id desc");

  }

 ?> 
     <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>
             

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Booking history</h2>
                   <ul class="nav navbar-right panel_toolbox">
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                     <?php echo $msg; ?>
                  <div class="x_content">
                    <p class="text-muted font-13 m-b-30">
                    </p>
                    <table id="datatable-responsive" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Name</th>
                          <th>Email</th>
                          <th>Mobile</th>
                          <th>Date</th>
                          <th>Time</th>
                          <th>Number of people</th>
                          <th>Booking Status</th>
                          
							<th>Action</th>
                          
                        </tr>
                      </thead>
                      <input type="hidden" id = "delete_type" value ="booked_restaurant">
                      <tbody>
                       <?php if($data){ 
						    $currentTime = date("H:i");
						    $currentDate = date("Y-m-d");
						   while($record = mysqli_fetch_assoc($data)){ 
							   $recordShow = 0;
							   if($currentDate == $record['booking_date']){
							     if(strtotime($currentTime) > strtotime(date('H:i', strtotime($record['booking_time'].'+1 hour'))))
									$recordShow =1;
								}else{
										$recordShow =1;
									}	
								if($recordShow){
									?>
									 <tr>
									  <td><?php echo $record['name'];?></td>
									  <td><?php echo $record['email'];?></td>
									  <td><?php echo $record['contact_no'];?></td>
									  <td><?php echo $record['booking_date'];?></td>
									  <td><?php echo $record['booking_time'];?></td>
									  <td><?php echo $record['number_of_people'];?></td>
									  <td><?php if($record['booking_status']=="1"){
												 echo "Pending";
												}else if($record['booking_status']=="2"){
												  echo "Confirmed";
												}else{
												  echo "Declined";
												} ?>
									  </td>
									  <td>
										 <a href="edit_booking.php?id=<?php echo $record['booking_id'];?>" class="btn btn-round btn-primary">Edit</a>
									 <?php 
									$change = bookingTimeChange($record['booking_date'],$record['booking_time']);
									if($change==1){?>
									 <button type="button" id="timeChange-<?php echo $record['booking_id'].'-'.$record['opening_time'].'-'.$record['closing_time'];?>" class="btn btn-round btn-primary" data-toggle="modal" data-target="#myModal1">Modify</button>
										   <?php } ?>
									   <!-- <button type="button" id="deletepopup-<?php echo $record['booking_id'];?>" class="btn btn-round btn-danger">Delete</button> -->
									  </td>
									 </tr>
					  <?php }
							    }
                        }?> 
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->

        <?php include_once('footer.php'); ?>
