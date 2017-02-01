<?php 
  include_once('header.php');
 
  if($_SESSION['updateBooking'] == 1){
		$msg = '<div class="alert alert-success">Booking updated successfully</div>';
	    $_SESSION['updateBooking'] ='';
	}
  $result = array();
  $time= time();
  $time = date('H:i:s', strtotime('-1 hour'));
  if($_SESSION['restaurant_id'] != "")
    {
         $booking_records = mysqli_query($GLOBALS['conn'],"SELECT db.delivery_id,db.* FROM delivery_bookings db JOIN restaurant_details rd ON db.restaurant_id = rd.restaurant_id Where db.restaurant_id = '".$_SESSION['restaurant_id']."' AND `delivery_date` < CURRENT_DATE() OR db.delivery_id in(SELECT db1.delivery_id FROM delivery_bookings db1  JOIN restaurant_details rd1 ON db1.restaurant_id = rd1.restaurant_id Where delivery_time < '".$time."' AND `delivery_date` = CURRENT_DATE()) order by db.delivery_id desc");
    	
    }
    else
    {
    	
    	 $booking_records = mysqli_query($GLOBALS['conn'],"SELECT db.delivery_id,db.* FROM delivery_bookings db JOIN restaurant_details rd ON db.restaurant_id = rd.restaurant_id Where `delivery_date` < CURRENT_DATE() OR db.delivery_id in(SELECT db1.delivery_id FROM delivery_bookings db1  JOIN restaurant_details rd1 ON db1.restaurant_id = rd1.restaurant_id Where delivery_time < '".$time."' AND `delivery_date` = CURRENT_DATE()) order by db.delivery_id desc");
    	
    }
    //echo mysqli_num_rows($booking_records);exit;

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
                    <input type="text" style="width: 200px" name="booking_history_delivery_cal" id="booking_history_delivery_cal" placeholder="Search" readonly class="form-control" />
                  </div>
                  
                  <div class="col-md-2 col-sm-2 col-xs-2 form-group">
                    <select name="booking_history_delivery_status" id="booking_history_delivery_status" class="form-control">
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
                    <table id="booking_history_delivery" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th width="30%">Date</th>
                          <th width="10%">Time</th>
                          <th width="10%">Status</th>
                          <th width="50%">Action</th>
                        </tr>
                      </thead>
                      
                      <tbody>
                       <?php if($booking_records){ 
						     while($record = mysqli_fetch_assoc($booking_records)){ ?>
								<tr>
									<td><?php echo $record['delivery_date'];?></td>
									<td><?php echo $record['delivery_time'];?></td>
									
									<td><?php if($record['delivery_status']=="1"){
                         echo "Pending";
                        }else if($record['delivery_status']=="2"){
                          echo "Confirmed";
                        }else{
                          echo "Declined";
                        } ?></td>
                  <td>
                     <a href="edit_delivery.php?id=<?php echo encrypt_var($record['delivery_id']);?>" class="btn btn-round btn-primary">Edit</a>
                  
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
