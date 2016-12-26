<?php 
  include_once('header.php');
  $result = array();
  if($_SESSION['restaurant_id']!="")
  {
    $data = mysqli_query($GLOBALS['conn'],"SELECT *,brr.email as booking_email,u.email as user_email FROM booked_records_restaurant brr JOIN restaurant_details rd ON brr.restaurant_id = rd.restaurant_id JOIN users u ON rd.user_id = u.user_id Where brr.restaurant_id = '".$_SESSION['restaurant_id']."' AND brr.booking_date >= CURRENT_DATE() order by booking_id desc");

  }
  else
  {
     $data = mysqli_query($GLOBALS['conn'],"SELECT *,brr.email as booking_email,u.email as user_email FROM booked_records_restaurant brr JOIN restaurant_details rd ON brr.restaurant_id = rd.restaurant_id JOIN users u ON rd.user_id = u.user_id Where `booking_date` >= CURRENT_DATE()  order by booking_id desc");

  }
  
  //Basic Validation  
  if(isset($_SESSION['msg']) == 'success'){
  if($_SESSION['msg'] == 'success'){
    $msg = '<div class="alert alert-warning">Resturant added successfully</div>';
      $_SESSION['msg'] ='';
  }
  if($_SESSION['msg'] == 'successEdit'){
    $msg = '<div class="alert alert-warning">Resturant edited successfully</div>';
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
                  <div class="count"><?php echo mysqli_num_rows(mysqli_query($GLOBALS['conn'],"SELECT * FROM `booked_records_restaurant` Where `booking_status`= 1 AND `restaurant_id`= '".$_SESSION['restaurant_id']."'"));?></div>
                  <h3>Pending Bookings</h3>
                </div>
              </div>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-comments-o"></i></div>
                  <div class="count"><?php echo mysqli_num_rows(mysqli_query($GLOBALS['conn'],"SELECT * FROM `booked_records_restaurant` Where `booking_status`= 2 AND `restaurant_id`= '".$_SESSION['restaurant_id']."'"));?></div>
                  <h3>Accepted Bookings</h3>
                </div>
              </div>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-sort-amount-desc"></i></div>
                  <div class="count"><?php echo mysqli_num_rows(mysqli_query($GLOBALS['conn'],"SELECT * FROM `booked_records_restaurant` Where `booking_status`= 0 AND `restaurant_id`= '".$_SESSION['restaurant_id']."'"));?></div>
                  <h3>Declined Bookings</h3>
                </div>
              </div>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-check-square-o"></i></div>
                  <div class="count"><?php echo mysqli_num_rows(mysqli_query($GLOBALS['conn'],"SELECT * FROM `booked_records_restaurant` Where `booking_date` < CURRENT_DATE() AND `restaurant_id`= '".$_SESSION['restaurant_id']."'"));?></div>
                  <h3>Confirmed Bookings</h3>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Venue Booking List</h2>
                   <ul class="nav navbar-right panel_toolbox">
                   <?php if($_SESSION['restaurant_id']!=""){ ?>
                       <li><a href="booking_glance.php"><button type="button" class="btn btn-round btn-success">Booking at Glance</button></a>
                       </li>    
                   <?php }?>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <p class="text-muted font-13 m-b-30">
                    </p>
                    <table id="datatable-responsive" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                           <th>Name</th>
                           <th>Mobile</th>
                           <th>User Email</th>
                           <th>Venue Email</th>
                           <th>Date</th>
                           <th>Time</th>
                           <th>Number of people</th>
                           <th>Booking Status</th>
                           <th>Action</th>
                        </tr>
                      </thead>
                      <input type="hidden" id = "delete_type" value ="booked_restaurant">
                      <tbody>
                       <?php 
                              $currentDate = date("Y-m-d");
                              $currentTime = date("H:i");
                            
                       if($data)
                       { 
                          while($record = mysqli_fetch_assoc($data)){ 
							
                            if($currentDate == $record['booking_date'] ){
                              if(strtotime($currentTime) > strtotime($record['booking_time']))
                                  continue;
                           }

                          ?>
                         <tr>
                          <td><?php echo $record['name'];?></td>
                          <td><?php echo $record['contact_no'];?></td>
                          <td><?php echo $record['booking_email'];?></td>
                           <td><?php echo $record['user_email'];?></td>
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
                                <?php 
                               $change = bookingTimeChange($record['booking_date'],$record['booking_time']);
                               if($change==1){?>
                               <button type="button" id="timeChange-<?php echo $record['booking_id'].'-'.$record['opening_time'].'-'.$record['closing_time'];?>" class="btn btn-round btn-primary" data-toggle="modal" data-target="#myModal1">Modify</button>
                               <?php } ?>
                               
                              <?php }else{?>
                               <button type="button" id="confirm-<?php echo $record['booking_id'];?>" class="btn btn-round btn-success">Accept</button>
                               <?php 
                               $change = bookingTimeChange($record['booking_date'],$record['booking_time']);
                               if($change==1){?>
                               <button type="button" id="timeChange-<?php echo $record['booking_id'].'-'.$record['opening_time'].'-'.$record['closing_time'];?>" class="btn btn-round btn-primary" data-toggle="modal" data-target="#myModal1">Modify</button>
                               <?php } ?>
                              <?php } ?>
                             <!-- <button type="button" id="deletepopup-<?php echo $record['booking_id'];?>" class="btn btn-round btn-danger">Delete</button> -->
                            
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
          <select id="declined" name="declined" value="">
			 <option value="">Select Reason</option>
			<option value="Venue closed">Venue closed</option>
			<option value="No availability for selected date">No availability for selected date</option>
			<option value="No availability for selected time">No availability for selected time</option>
			<option value="Other">Other</option>
          </select>
          <input type="hidden" name="booking_res_id" id="booking_res_id">          
			<ul class="nav navbar-right panel_toolbox">                            
				<li><input type="text" class="form-control" placeholder="Enter custom reason"  id="reason" name="reason" style="display:none; width:220px; top:100px" value=""/></li>
			</ul>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-default" id="yes">OK</button>
        </div>
      </div>
      
    </div>
  </div>
       
         <!-- Modal -->
<!-- Modal -->
<div id="myModal1" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body">
       
        <div id="timeData"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-default" id="timeYes">Ok</button>
      </div>
    </div>

  </div>
</div>
 <?php include_once('footer.php'); ?>
