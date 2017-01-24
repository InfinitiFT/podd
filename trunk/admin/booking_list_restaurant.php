<?php 
  include_once('header.php');
  $result = array();
  if($_SESSION['updateBooking'] == 1){
		$msg = '<div class="alert alert-success">Booking updated successfully</div>';
	    $_SESSION['updateBooking'] ='';
	}
  $time= time();
  $time = date('H:i:s', strtotime('-1 hour'));
  if($_SESSION['restaurant_id']!="")
  {
    $data = mysqli_query($GLOBALS['conn'],"SELECT brr.booking_id,brr.* FROM booked_records_restaurant brr JOIN restaurant_details rd ON brr.restaurant_id = rd.restaurant_id Where brr.restaurant_id = '".$_SESSION['restaurant_id']."' AND `booking_date` > CURRENT_DATE() OR brr.booking_id in(SELECT brr1.booking_id FROM booked_records_restaurant brr1  JOIN restaurant_details rd1 ON brr1.restaurant_id = rd1.restaurant_id Where booking_time > '".$time."' AND `booking_date` = CURRENT_DATE()) order by brr.booking_id desc");
  
  }
  else
  {

    $data = mysqli_query($GLOBALS['conn'],"SELECT brr.booking_id,brr.* FROM booked_records_restaurant brr JOIN restaurant_details rd ON brr.restaurant_id = rd.restaurant_id Where `booking_date` > CURRENT_DATE() OR brr.booking_id in(SELECT brr1.booking_id FROM booked_records_restaurant brr1  JOIN restaurant_details rd1 ON brr1.restaurant_id = rd1.restaurant_id Where booking_time > '".$time."' AND `booking_date` = CURRENT_DATE()) order by brr.booking_id desc");
   

  }
  
  //Basic Validation  
  if(isset($_SESSION['msg']) == 'success'){
  if($_SESSION['msg'] == 'success'){
    $msg = '<div class="alert alert-warning">Venue added successfully</div>';
      $_SESSION['msg'] ='';
  }
  if($_SESSION['msg'] == 'successEdit'){
    $msg = '<div class="alert alert-warning">Venue edited successfully</div>';
      $_SESSION['msg'] ='';
  }
 }
  
?> 
     <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>
             <div class="row top_tiles">
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-caret-square-o-right"></i></div>
                  <div class="count">
                  
                  <?php if($_SESSION['restaurant_id'] != "")
                          {
                            echo mysqli_num_rows(mysqli_query($GLOBALS['conn'],"SELECT brr.booking_id,brr.* FROM booked_records_restaurant brr JOIN restaurant_details rd ON brr.restaurant_id = rd.restaurant_id Where brr.restaurant_id = '".$_SESSION['restaurant_id']."' AND `booking_status`= 1 AND `booking_date` > CURRENT_DATE() OR brr.booking_id in(SELECT brr1.booking_id FROM booked_records_restaurant brr1  JOIN restaurant_details rd1 ON brr1.restaurant_id = rd1.restaurant_id Where booking_time > '".$time."' AND `booking_date` = CURRENT_DATE()) order by brr.booking_id desc"));
                          }
                        else
                          {
                             echo mysqli_num_rows(mysqli_query($GLOBALS['conn'],"SELECT brr.booking_id,brr.* FROM booked_records_restaurant brr JOIN restaurant_details rd ON brr.restaurant_id = rd.restaurant_id Where `booking_date` > CURRENT_DATE() AND `booking_status`= 1 OR brr.booking_id in(SELECT brr1.booking_id FROM booked_records_restaurant brr1  JOIN restaurant_details rd1 ON brr1.restaurant_id = rd1.restaurant_id Where booking_time > '".$time."' AND `booking_date` = CURRENT_DATE()) order by brr.booking_id desc"));
                          }
                   ?></div>
                  <h3>Pending</h3>
                </div>
              </div>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-comments-o"></i></div>
                  <div class="count"><?php if($_SESSION['restaurant_id'] != "")
                          {
                            echo mysqli_num_rows(mysqli_query($GLOBALS['conn'],"SELECT brr.booking_id,brr.* FROM booked_records_restaurant brr JOIN restaurant_details rd ON brr.restaurant_id = rd.restaurant_id Where brr.restaurant_id = '".$_SESSION['restaurant_id']."' AND `booking_status`= 2 AND `booking_date` > CURRENT_DATE() OR brr.booking_id in(SELECT brr1.booking_id FROM booked_records_restaurant brr1  JOIN restaurant_details rd1 ON brr1.restaurant_id = rd1.restaurant_id Where booking_time > '".$time."' AND `booking_date` = CURRENT_DATE()) order by brr.booking_id desc"));
                          }
                        else
                          {
                             echo mysqli_num_rows(mysqli_query($GLOBALS['conn'],"SELECT brr.booking_id,brr.* FROM booked_records_restaurant brr JOIN restaurant_details rd ON brr.restaurant_id = rd.restaurant_id Where `booking_date` > CURRENT_DATE() AND `booking_status`= 2 OR brr.booking_id in(SELECT brr1.booking_id FROM booked_records_restaurant brr1  JOIN restaurant_details rd1 ON brr1.restaurant_id = rd1.restaurant_id Where booking_time > '".$time."' AND `booking_date` = CURRENT_DATE()) order by brr.booking_id desc"));
                          }
                   ?></div>
                  <h3>Accepted</h3>
                </div>
              </div>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-sort-amount-desc"></i></div>
                  <div class="count"><?php if($_SESSION['restaurant_id'] != "")
                          {
                            echo mysqli_num_rows(mysqli_query($GLOBALS['conn'],"SELECT brr.booking_id,brr.* FROM booked_records_restaurant brr JOIN restaurant_details rd ON brr.restaurant_id = rd.restaurant_id Where brr.restaurant_id = '".$_SESSION['restaurant_id']."'  AND `booking_status`= 0 AND `booking_date` > CURRENT_DATE() OR brr.booking_id in(SELECT brr1.booking_id FROM booked_records_restaurant brr1  JOIN restaurant_details rd1 ON brr1.restaurant_id = rd1.restaurant_id Where booking_time > '".$time."' AND `booking_date` = CURRENT_DATE()) order by brr.booking_id desc"));
                          }
                        else
                          {
                             echo mysqli_num_rows(mysqli_query($GLOBALS['conn'],"SELECT brr.booking_id,brr.* FROM booked_records_restaurant brr JOIN restaurant_details rd ON brr.restaurant_id = rd.restaurant_id Where `booking_date` > CURRENT_DATE() AND `booking_status`= 0 OR brr.booking_id in(SELECT brr1.booking_id FROM booked_records_restaurant brr1  JOIN restaurant_details rd1 ON brr1.restaurant_id = rd1.restaurant_id Where booking_time > '".$time."' AND `booking_date` = CURRENT_DATE()) order by brr.booking_id desc"));
                          }
                   ?></div>
                  <h3>Declined</h3>
                </div>
              </div>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-check-square-o"></i></div>
                  <div class="count"><?php 
                  if($_SESSION['restaurant_id'] != "")
                  {
                     echo mysqli_num_rows(mysqli_query($GLOBALS['conn'],"SELECT brr.booking_id,brr.* FROM booked_records_restaurant brr JOIN restaurant_details rd ON brr.restaurant_id = rd.restaurant_id Where brr.restaurant_id = '".$_SESSION['restaurant_id']."' AND `booking_status`= 2 AND `booking_date` < CURRENT_DATE() OR brr.booking_id in(SELECT brr1.booking_id FROM booked_records_restaurant brr1  JOIN restaurant_details rd1 ON brr1.restaurant_id = rd1.restaurant_id Where booking_time < '".$time."' AND `booking_date` = CURRENT_DATE()) order by brr.booking_id desc"));
                    
                  }
                  else
                  {
                     echo mysqli_num_rows(mysqli_query($GLOBALS['conn'],"SELECT brr.booking_id,brr.* FROM booked_records_restaurant brr JOIN restaurant_details rd ON brr.restaurant_id = rd.restaurant_id Where `booking_status`= 2 AND `booking_date` < CURRENT_DATE() OR brr.booking_id in(SELECT brr1.booking_id FROM booked_records_restaurant brr1  JOIN restaurant_details rd1 ON brr1.restaurant_id = rd1.restaurant_id Where booking_time < '".$time."' AND `booking_date` = CURRENT_DATE()) order by brr.booking_id desc"));
                  }
                  ?>
                  
                 </div>
                  <h3>Confirmed</h3>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Booking Management</h2>
						         <input type="hidden" value="<?php echo $_SESSION['restaurant_id'];?>" id="session">
      
                    <div class="clearfix"></div>
                  </div>
                    <?php echo $msg; ?>
                    <div class="x_content">
                <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-3 form-group">
                 
                  </div>
                  <div class="col-md-3 col-sm-3 col-xs-3 form-group">
                    <input type="text" style="width: 200px" name="booking_management_cal" id="booking_management_cal" placeholder="Search" readonly class="form-control" />
                  </div>
                  
                  <div class="col-md-2 col-sm-2 col-xs-2 form-group">
                    <select name="booking_management_status" id="booking_management_status" class="form-control">
                      <option value="1">Pending</option>
                      <option value="2">Accepted</option>
                      <option value="0">Declined</option>
                    </select>
                  </div>
                </div>
               </div>
                  <div class="x_content">
                  
                    <p class="text-muted font-13 m-b-30">
                    </p>
                    
                    <table id="booking_management_table" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                           <th width="15%">Name</th>
                           <th width="10%">Mobile</th>
                           <th width="20%">User Email</th>
                           <th width="10%">Date</th>
                           <th width="5%">Time</th>
                           <th width="5%">Number of people</th>
                           <th width="10%">Booking Status</th>
                           <th width="25%">Action</th>
                        </tr>
                      </thead>
                      <input type="hidden" id = "delete_type" value ="booked_restaurant">
                      <tbody id="statusContent">
                       <?php
                             if($data)
                             { 
                               while($record = mysqli_fetch_assoc($data)){ 
								   
                     ?>
                         <tr>
                          <td><?php echo $record['name'];?></td>
                          <td><?php echo $record['contact_no'];?></td>
                           <td><?php echo $record['email'];?></td>
                          <td><?php $date = date_create ($record['booking_date']);
								echo date_format($date,"d M Y");?>
						  </td>
                          <td><?php echo $record['booking_time'];?></td>
                          <td><?php echo $record['number_of_people'];?></td>
                           <td><?php if($record['booking_status']=="0"){ 
                                      echo "Declined";
                                    }
                                    else if($record['booking_status']=="1"){
                                      echo "Pending";
                                    }
                                    else{
                                      echo "Accepted";             
                                    }
                            ?></td>
                          <td>
                          <?php if($record['booking_status']=="1"){?>
                             <button type="button" id="confirm-<?php echo $record['booking_id'];?>" class="btn btn-round btn-success">Accept</button>
                             <button type="button" class="btn btn-round btn-warning"  id="declines-<?php echo $record['booking_id'];?>"data-toggle="modal" data-target="#myModal">Decline</button>
                              <?php }else if($record['booking_status']=="2"){?>
            								   <button type="button" class="btn btn-round btn-warning"  id="declines-<?php echo $record['booking_id'];?>"data-toggle="modal" data-target="#myModal">Decline</button>
                                <!-- <?php 
                               $change = bookingTimeChange($record['booking_date'],$record['booking_time']);
                               if($change==1){?>
                               <button type="button" id="timeChange-<?php echo $record['booking_id'].'-'.$record['opening_time'].'-'.$record['closing_time'];?>" class="btn btn-round btn-primary" data-toggle="modal" data-target="#myModal1">Modify</button>
                               <?php } ?> -->
                               
                              <?php }else{?>
                               <button type="button" id="confirm-<?php echo $record['booking_id'];?>" class="btn btn-round btn-success">Accept</button>
                             <!--   <?php 
                               $change = bookingTimeChange($record['booking_date'],$record['booking_time']);
                               if($change==1){?>
                               <button type="button" id="timeChange-<?php echo $record['booking_id'].'-'.$record['opening_time'].'-'.$record['closing_time'];?>" class="btn btn-round btn-primary" data-toggle="modal" data-target="#myModal1">Modify</button>
                               <?php } ?> -->
                              <?php } ?>
                             <!-- <button type="button" id="deletepopup-<?php echo $record['booking_id'];?>" class="btn btn-round btn-danger">Delete</button> -->
                            <a href="edit_booking.php?id=<?php echo $record['booking_id'];?>&list=list" class="btn btn-round btn-info">Edit</a>
            			  </td>
                         </tr>
                        <?php }}?> 
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->
	<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Decline</h4>
        </div>
        <div class="modal-body">
			<div class="row">
				<div class="col-sm-6">
				 <select class="form-control" id="declined" name="declined" value="">
					 <option value="">Select Reason</option>
					<option value="Venue closed">Venue closed</option>
					<option value="No availability for selected date">No availability for selected date</option>
					<option value="No availability for selected time">No availability for selected time</option>
					<option value="Other">Other</option>
				  </select>
				  <input type="hidden" name="booking_res_id" id="booking_res_id">  
				</div>
				<div class="col-sm-6">
				<ul class="nav  panel_toolbox">                            
					<li><input type="text" class="form-control" placeholder="Enter custom reason"  id="reason" name="reason" style="display:none;" value=""/></li>
				</ul>
				</div>
			</div>
                 
			
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-close" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-default btn-ok" id="yes">OK</button>
        </div>
      </div>
      
    </div>
  </div>
       
         <!-- Modal -->
<!-- Modal -->
<div id="myModal1" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modify Booking</h4>
      </div>
      <div class="modal-body">
       
        <div id="timeData" class=""></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-info" id="timeYes">Ok</button>
      </div>
    </div>

  </div>
</div>
 <?php include_once('footer.php'); ?>
