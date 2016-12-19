<?php 
  include_once('header.php');
  $result = array();
  $data = mysqli_query($GLOBALS['conn'],"SELECT * FROM booked_records_restaurant brr JOIN restaurant_details rd ON brr.restaurant_id = rd.restaurant_id Where brr.restaurant_id = '".$_SESSION['restaurant_id']."' AND `booking_date` >= CURRENT_DATE() ");
  //Basic Validation  
  
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
                    <h2>Restaurant Booking List</h2>
                   <ul class="nav navbar-right panel_toolbox">
                      <li><a href="restaurant_details.php"><button type="button" class="btn btn-round btn-success">View Restaurant</button></a>
                      </li>
                      
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <p class="text-muted font-13 m-b-30">
                    </p>
                    <table id="datatable-responsive" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>User Name</th>
                          <th>Email</th>
                          <th>Contact no</th>
                          <th>Booking Date</th>
                          <th>Booking Time</th>
                          <th>Number of people</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <input type="hidden" id = "delete_type" value ="booked_restaurant">
                      <tbody>
                       <?php if($data){ while($record = mysqli_fetch_assoc($data)){ ?>
                         <tr>
                          <td><?php echo $record['name'];?></td>
                          <td><?php echo $record['email'];?></td>
                          <td><?php echo $record['contact_no'];?></td>
                          <td><?php echo $record['booking_date'];?></td>
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
                          <td><?php if($record['booking_status']=="1"){?>
                             <button type="button" id="confirm-<?php echo $record['booking_id'];?>" class="btn btn-round btn-success">Accept</button>
                             <button type="button" id="decline-<?php echo $record['booking_id'];?>" class="btn btn-round btn-warning">Decline</button>
                              <?php }else if($record['booking_status']=="2"){?>
                              <button type="button" id="decline-<?php echo $record['booking_id'];?>" class="btn btn-round btn-warning">Decline</button>
                              <?php }else{?>
                               <button type="button" id="confirm-<?php echo $record['booking_id'];?>" class="btn btn-round btn-success">Accept</button>
                              <?php } ?>
                             <button type="button" id="deletepopup-<?php echo $record['booking_id'];?>" class="btn btn-round btn-danger">Delete</button>
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

        <?php include_once('footer.php'); ?>
         <!-- Modal -->
