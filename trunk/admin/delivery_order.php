<?php 
ob_start();
include_once('header.php'); 
$error="";
$sucess="";
if($_SESSION['restaurant_id'] != "")
{
	if(!empty($_GET['restaurant_id']))
	{
      if($_SESSION['restaurant_id'] != decrypt_var($_GET['restaurant_id']))
	   {
         session_destroy();
         header("Location:index.php");
	   }
	}
	
	
}
try {
      $item_data = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'],"SELECT * FROM `delivery_bookings` db join restaurant_details rd on db.restaurant_id = rd.restaurant_id WHERE `delivery_id` ='".decrypt_var($_GET['delivery_id'])."'"));
	 
      $user_data = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'],"SELECT * FROM `users`  WHERE `user_id` ='".$item_data['user_id']."'"));  
      }
//catch exception
catch(Exception $e) {
  echo 'Message: ' .$e->getMessage();
}

?>
<!-- page content -->
       <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3><font color="black">Delivery Order</font></h3>
              </div>

              <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <a href="booking_list_restaurant_delivery.php"><button class="btn btn-success pull-right">Back</button></a>
                </div>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12">
                <div class="x_panel">
                  <div class="x_title">
                    <!-- <h2>Delivery Order</h2> -->
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <section class="content invoice">
                      <!-- title row -->
                      <div class="row">
                        <div class="col-xs-12 invoice-header">
                          <h1>
                                          <i class="fa fa-home"></i> <?php echo $item_data['restaurant_name'];?>
                                          
                                          <small class="pull-right">Date:<?php $date = date_create ($item_data['delivery_date']);
                                                                               echo date_format($date,"d-M-Y");?></small>
                                      </h1>
                        </div>
                        <!-- /.col -->
                      </div>
                      <!-- info row -->
                      <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                         <font color="black"> From</font>
                          <address>
                                          <strong><?php echo $item_data['restaurant_name'];?></strong>
                                          <br><b>Address:</b><?php echo $item_data['restaurant_full_address'];?>
                                          <br><b>Phone:</b> <?php echo $user_data['mobile_no'];?>
                                          <br><b>Email:</b> <?php echo $user_data['email'];?>
                                      </address>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                         <font color="black"> To</font> 
                          <address>
                                          <strong><?php echo $item_data['name'];?></strong>
                                          <br><b>Address</b>:<?php echo $item_data['address'];?>
                                          <br><b>Phone:</b> <?php echo $item_data['contact_no'];?>
                                          <br><b>Email:</b> <?php echo $item_data['email'];?>
                                      </address>
                        </div>
						<div class="col-sm-4 invoice-col">
                       
                          <address>
                                        
                                          <br><b>Status</b>:<?php if($item_data['delivery_status']=='1')
										  {
											  echo "Pending";
										  } 
										  else if($item_data['delivery_status']=='2')
										  {
											  echo "Accepted";
										  }
										  else if($item_data['delivery_status']=='3')
										  {
											  echo "Cancelled";
										  }
										  else{
											  echo "Declined";
										  }
											  ?>
                                         
                                      </address>
                        </div>
                        <!-- /.col -->
                        <!-- /.col -->
                      </div>
                      <!-- /.row -->

                      <!-- Table row -->
                      <div class="row">
                        <div class="col-xs-12 table">
                          <table  class="table table-striped">
                            <thead>
                              <tr>
                                <th width="20%">Item</th>
								<th width="20%">Unit Price</th>
                                <th width="15%">Quantity</th>
                                <th width="15%">Total Price</th>
                              </tr>
                            </thead>
                            <tbody>
                            <?php $order_data = mysqli_query($GLOBALS['conn'],"SELECT * FROM `order_item` oi join meals m on oi.meal_name = m.id join subtitle s on oi.subtitle_name = s.subtitle_id join items i on oi.item_name = i.id WHERE `order_id` ='".$item_data['delivery_id']."'");
                            
                             while($record = mysqli_fetch_assoc($order_data)){
                              
                            ?>
                              <tr>
                                <td><?php echo $record['name'];?></td>
								<td><?php echo $record['price'];?></td>
                                <td><?php echo $record['quantity'];?></td>
								 
                                <td><?php $price = str_replace("£","",$record['price']); echo "£".$record['quantity']*$price; ?> </td>
                               
                              </tr>
                              <?php } ?>
                              <tr>
                                <td></td>
								<td></td>
                                <td><b>Total Price:</b></td>
                                <td><b><?php echo $item_data['total_price'];?></b> </td>
                               
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <!-- /.col -->
                      </div>
                      <!-- /.row -->

                     <input type="hidden" id = "delete_type" value ="booked_restaurant_delivery">
                      <!-- /.row -->

                      <!-- this row will not appear when printing -->
                      <div class="row no-print">
                  <font color="black"><p><b>User Note:  </b><?php echo $item_data['user_msg'];?></p></font>
                         <div class="col-sm-12 text-center">
						 <?php $newdate = date('Y-m-d', strtotime('-1 day', time()));
                         $booking_date = date('Y-m-d', strtotime($item_data['delivery_date']));
                         $currettime = date('H:i',time());
                         $booking_time = date('H:i',strtotime($item_data['delivery_time']));
                        if($booking_date > $newdate)
                        {  ?>
                          <?php if($item_data['delivery_status']=="1"){?>
                              <button type="button" id="confirm-<?php echo $item_data['delivery_id'];?>" class="btn btn-round btn-success">Accept</button>
                              <button type="button" class="btn btn-round btn-warning"  id="declineDev-<?php echo $item_data['delivery_id'];?>"data-toggle="modal" data-target="#myModal">Decline</button>
                              <?php }else if($item_data['delivery_status']=="2"){?>
                              <a href="edit_delivery.php?id=<?php echo encrypt_var($item_data['delivery_id']);?>&list=list" class="btn btn-round btn-info">Edit</a>
                              <?php }else if($item_data['delivery_status']=="3"){?>
                              <button type="button" id="confirm-<?php echo $item_data['delivery_id'];?>" class="btn btn-round btn-success ">Accept</button>
                              <a href="edit_delivery.php?id=<?php echo encrypt_var($item_data['delivery_id']);?>&list=list" class="btn btn-round btn-info">Edit</a>
                               <?php }else{?>
                               <button type="button" id="confirm-<?php echo $item_data['delivery_id'];?>" class="btn btn-round btn-success">Accept</button>
                               <a href="edit_delivery.php?id=<?php echo encrypt_var($item_data['delivery_id']);?>&list=list" class="btn btn-round btn-info">Edit</a>
                             <?php } ?>
                       <?php } else if($booking_date == $newdate && $booking_time > $currettime){ ?>
                          <?php if($item_data['delivery_status']=="1"){?>
                              <button type="button" id="confirm-<?php echo $item_data['delivery_id'];?>" class="btn btn-round btn-success">Accept</button>
                              <button type="button" class="btn btn-round btn-warning"  id="declineDev-<?php echo $item_data['delivery_id'];?>"data-toggle="modal" data-target="#myModal">Decline</button>
                              <?php }else if($item_data['delivery_status']=="2"){?>
                              <a href="edit_delivery.php?id=<?php echo encrypt_var($item_data['delivery_id']);?>&list=list" class="btn btn-round btn-info">Edit</a>
                              <?php }else if($item_data['delivery_status']=="3"){?>
                              <button type="button" id="confirm-<?php echo $item_data['delivery_id'];?>" class="btn btn-round btn-success ">Accept</button>
                              <a href="edit_delivery.php?id=<?php echo encrypt_var($item_data['delivery_id']);?>&list=list" class="btn btn-round btn-info">Edit</a>
                               <?php }else{?>
                               <button type="button" id="confirm-<?php echo $item_data['delivery_id'];?>" class="btn btn-round btn-success">Accept</button>
                               <a href="edit_delivery.php?id=<?php echo encrypt_var($item_data['delivery_id']);?>&list=list" class="btn btn-round btn-info">Edit</a>
                             <?php } ?>
                       <?php }else{?>
                        <a href="booking_history_delivery.php" class="btn btn-round btn-primary">Back</a>
                       <?php } ?>
                        
                         
                       </div>
                       
                      </div>
					  </br>
					  <font color="black"><p><b>Note:  </b>Please note that we have not charged the customer for this order. Contact the customer directly to arrange delivery and payment.</p></font>
					  
                    </section>
				     
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
         <select class="form-control" id="declinedDev" name="declinedDev" value="">
           <option value="">Select Reason</option>
          <option value="Venue closed">Venue closed</option>
          <option value="No availability for selected date">No availability for selected date</option>
          <option value="No availability for selected time">No availability for selected time</option>
          <option value="Other">Other</option>
          </select>
          <input type="hidden" name="booking_res_idDev" id="booking_res_idDev">  
        </div>
        <div class="col-sm-6">
        <ul class="nav  panel_toolbox">                            
          <li><input type="text" class="form-control" placeholder="Enter custom reason"  id="reasonDev" name="reasonDev" style="display:none;" value=""/></li>
        </ul>
        </div>
      </div>
                 
      
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-close" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-default btn-ok" id="Dev">OK</button>
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