<?php 
  include_once('header.php');
  $result = array();
  $data = mysqli_query($GLOBALS['conn'],"SELECT * FROM booked_records_restaurant brr JOIN restaurant_details rd ON brr.restaurant_id = rd.restaurant_id Where brr.restaurant_id = '".$_SESSION['restaurant_id']."' AND `booking_date` < CURRENT_DATE()");
  //Basic Validation  
  
 ?> 
     <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>
             

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Restaurant Booking History</h2>
                   <ul class="nav navbar-right panel_toolbox">
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
                          <th>Booking Status</th>
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
                          <td><?php if($record['booking_status']=="1"){
                                     echo "Pending";
                                    }else if($record['booking_status']=="2"){
                                      echo "Confirmed";
                                    }else{
                                      echo "Declined";
                                    } ?>
                          </td>
                          <td>
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