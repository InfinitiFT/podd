<?php 
  include_once('header.php');
 
  if($_SESSION['updateBooking'] == 1){
		$msg = '<div class="alert alert-success">Booking updated successfully</div>';
	    $_SESSION['updateBooking'] ='';
	}
  $result = array();
  $time= time();
  $time = date('H:i:s', strtotime('-1 hour'));
  if($_SESSION['restaurant_id']!="")
  {
  
    $data = mysqli_query($GLOBALS['conn'],"SELECT brr.booking_id,brr.* FROM booked_records_restaurant brr JOIN restaurant_details rd ON brr.restaurant_id = rd.restaurant_id Where brr.restaurant_id = '".$_SESSION['restaurant_id']."' AND `booking_date` < CURRENT_DATE() OR brr.booking_id in(SELECT brr1.booking_id FROM booked_records_restaurant brr1  JOIN restaurant_details rd1 ON brr1.restaurant_id = rd1.restaurant_id Where booking_time < '".$time."' AND `booking_date` = CURRENT_DATE()) order by brr.booking_id desc");
  
  }
  else
  {

    $data = mysqli_query($GLOBALS['conn'],"SELECT brr.booking_id,brr.* FROM booked_records_restaurant brr JOIN restaurant_details rd ON brr.restaurant_id = rd.restaurant_id Where `booking_date` < CURRENT_DATE() OR brr.booking_id in(SELECT brr1.booking_id FROM booked_records_restaurant brr1  JOIN restaurant_details rd1 ON brr1.restaurant_id = rd1.restaurant_id Where booking_time < '".$time."' AND `booking_date` = CURRENT_DATE()) order by brr.booking_id desc");
   

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
                     <?php echo $msg;?>
                     <div>
               <div class="x_content">
                <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-3 form-group">
                 
                  </div>
                  <div class="col-md-3 col-sm-3 col-xs-3 form-group">
                    <input type="text" style="width: 200px" name="booking_history_range" id="booking_history_range" placeholder="Search" readonly class="form-control" />
                  </div>
                  
                  <div class="col-md-2 col-sm-2 col-xs-2 form-group">
                    <select name="booking_history_status" id="booking_history_status" class="form-control">
                      <option value="2">Confirmed</option>
                      <option value="0">Declined</option>
                    </select>
                  </div>
                </div>
               </div>
							
                     </div>                     
                  <div class="x_content">
                    <p class="text-muted font-13 m-b-30">
                    </p>
                    <table id="booking_history" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Date</th>
                          <th>Time</th>
                          <th>Number of People</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <input type="hidden" id = "delete_type" value ="booked_restaurant">
                      <tbody>
                       <?php if($data){ 
						     while($record = mysqli_fetch_assoc($data)){ ?>
								<tr>
									<td><?php echo $record['booking_date'];?></td>
									<td><?php echo $record['booking_time'];?></td>
									<td><?php echo $record['number_of_people'];?></td>
									<td><?php if($record['booking_status']=="1"){
                         echo "Pending";
                        }else if($record['booking_status']=="2"){
                          echo "Confirmed";
                        }else{
                          echo "Declined";
                        } ?></td>
                  <td>
                     <a href="edit_booking.php?id=<?php echo $record['booking_id'];?>" class="btn btn-round btn-primary">Edit</a>
                  </td>
                  </td>
								</tr>
					  <?php } }?> 
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
