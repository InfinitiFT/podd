
<?php 
  include_once('header.php');
  $result = array();
  if(@$_SESSION['updateBooking'] == 1){
		$msg = '<div class="alert alert-success">Booking updated successfully</div>';
	    $_SESSION['updateBooking'] ='';
	}
  $time= time();
  $time = date('H:i:s', strtotime('-1 hour'));
  if(@$_SESSION['restaurant_id']!="")
  {
    $data = mysqli_query($GLOBALS['conn'],"SELECT brr.booking_id,brr.*,rd.restaurant_name FROM booked_records_restaurant brr JOIN restaurant_details rd ON brr.restaurant_id = rd.restaurant_id Where brr.restaurant_id = '".$_SESSION['restaurant_id']."' AND `booking_date` > CURRENT_DATE() OR brr.booking_id in(SELECT brr1.booking_id FROM booked_records_restaurant brr1  JOIN restaurant_details rd1 ON brr1.restaurant_id = rd1.restaurant_id Where booking_time > '".$time."' AND `booking_date` = CURRENT_DATE() AND brr1.restaurant_id = '".$_SESSION['restaurant_id']."') order by brr.booking_id desc");
  
  }
  else
  {

    $data = mysqli_query($GLOBALS['conn'],"SELECT brr.booking_id,brr.*,rd.restaurant_name FROM booked_records_restaurant brr JOIN restaurant_details rd ON brr.restaurant_id = rd.restaurant_id Where `booking_date` > CURRENT_DATE() OR brr.booking_id in(SELECT brr1.booking_id FROM booked_records_restaurant brr1  JOIN restaurant_details rd1 ON brr1.restaurant_id = rd1.restaurant_id Where booking_time > '".$time."' AND `booking_date` = CURRENT_DATE()) order by brr.booking_id desc");
   

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
                  <div class="count pull-left">
                  
                  <?php echo count_number_of_records(1);
                   ?></div>
                   <div class="pull-right blk-padding"><h4 class="blk-padding-s">Pending</h4></div>
                </div>
              </div>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="count pull-left"><?php echo count_number_of_records(2);
                   ?></div>
                   <div class="pull-right blk-padding"><h4 class="blk-padding-s">Accepted</h4></div>
                  
                </div>
              </div>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                 
                  <div class="count pull-left"><?php 
                  echo count_number_of_records(0); ?></div>
                   <div class="pull-right blk-padding"><h4 class="blk-padding-s">Declined</h4></div>
                  
                </div>
              </div>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                     <div class="count pull-left"><?php 
                  if($_SESSION['restaurant_id'] != "")
                  {
                     echo mysqli_num_rows(mysqli_query($GLOBALS['conn'],"SELECT brr.booking_id,brr.* FROM booked_records_restaurant brr JOIN restaurant_details rd ON brr.restaurant_id = rd.restaurant_id Where brr.restaurant_id = '".$_SESSION['restaurant_id']."' AND `booking_status`= 2 AND `booking_date` < CURRENT_DATE() OR brr.booking_id in(SELECT brr1.booking_id FROM booked_records_restaurant brr1  JOIN restaurant_details rd1 ON brr1.restaurant_id = rd1.restaurant_id Where booking_time < '".$time."' AND `booking_date` = CURRENT_DATE() AND `booking_status`= 2) order by brr.booking_id desc"));
                    
                  }
                  else
                  {
                     echo mysqli_num_rows(mysqli_query($GLOBALS['conn'],"SELECT brr.booking_id,brr.* FROM booked_records_restaurant brr JOIN restaurant_details rd ON brr.restaurant_id = rd.restaurant_id Where `booking_status`= 2 AND `booking_date` < CURRENT_DATE() OR brr.booking_id in(SELECT brr1.booking_id FROM booked_records_restaurant brr1  JOIN restaurant_details rd1 ON brr1.restaurant_id = rd1.restaurant_id Where booking_time < '".$time."' AND `booking_date` = CURRENT_DATE() AND `booking_status`= 2) order by brr.booking_id desc"));
                  }
                  ?>
                  
                 </div>
                  <div class="pull-right blk-padding"><h4 class="blk-padding-s">Confirmed</h4></div>
                
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title clearfix">
                    <h2>Booking Management</h2>
						         <input type="hidden" value="<?php echo $_SESSION['restaurant_id'];?>" id="session">
      
                                      
                 
                  </div>
                    <?php echo $msg; ?>
                    <div class="x_content">
                <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-3 form-group">
                 
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
                           <th width="10%">Name</th>
                           <th width="10%">Mobile</th>
                           <th width="10%">Email</th>
                           <th width="10%">Date</th>
                           <th width="10%">Time</th>
                           <?php if($_SESSION['restaurant_id'] == "") { ?>
                           <th width="10%">Restaurant Name</th>
                           <?php }?>
                           <th width="12%">No. of Covers</th>
                           <th width="12%">Status</th>
                           <th width="16%">Action</th>
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
								echo date_format($date,"d-M-Y");?>
						  </td>
                          <td><?php echo $record['booking_time'];?></td>
                          <?php if($_SESSION['restaurant_id'] == "") { ?>
                           <td><?php echo $record['restaurant_name'];?></td>
                           <?php }?> 
                          <td><?php echo $record['number_of_people'];?></td>
                           <td><?php if($record['booking_status']=="0"){ 
                                      echo "Declined";
                                    }
                                    else if($record['booking_status']=="1"){
                                      echo "Pending";
                                    }
                                    else {
                                      echo "Accepted";             
                                    }
                            ?></td>
                          <td>
                          <?php if($record['booking_status']=="1"){?>
                             <button type="button" id="confirm-<?php echo $record['booking_id'];?>" class="btn btn-round btn-success">Accept</button>
                             <button type="button" class="btn btn-round btn-warning"  id="declines-<?php echo $record['booking_id'];?>"data-toggle="modal" data-target="#myModal">Decline</button>
                              <?php }else if($record['booking_status']=="2"){?>
            								  
                               
                              <?php }else{?>
                               <button type="button" id="confirm-<?php echo $record['booking_id'];?>" class="btn btn-round btn-success">Accept</button>
                            
                              <?php } ?>

                            <a href="edit_booking.php?id=<?php echo encrypt_var($record['booking_id']);?>&list=list" class="btn btn-round btn-info">Edit</a>
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
      <div class="modal-header modal">
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
