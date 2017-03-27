<?php 
  include_once('header.php');
  $result = array();
  $data = mysqli_query($GLOBALS['conn'],"SELECT * FROM airport_data ORDER BY airport_id Desc");
  //Basic Validation  
  $msg ='';
  if(isset($_SESSION['msg']) == 'success'){
	if($_SESSION['msg'] == 'success'){
		$msg = '<div class="alert alert-success">Venue added successfully</div>';
	    $_SESSION['msg'] ='';
	}
	if($_SESSION['msg'] == 'successEdit'){
		$msg = '<div class="alert alert-success">Venue edited successfully</div>';
	    $_SESSION['msg'] ='';
	}
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
                    <h2>Venue List</h2>
                    
				
                    <div class="clearfix"></div>
                     
                  </div>
                    <?php echo $msg; ?>
                  <div class="x_content">
                    <p class="text-muted font-13 m-b-30">
                    </p>
                    <table id="datatable-responsive" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th width="10%">Name</th>
                          <th width="10%">Date of Travel</th>
                          <th width="10%">Bags</th>
						  <th width="20%">Pickup Location</th>
                          <th width="20%">Delivery Airport</th>
						  <th width="10%">Contact No</th>
						  <th width="10%">Selected Time</th>
						  <th width="10%">Action</th>
                       
                        </tr>
                      </thead>
                      <input type="hidden" id = "delete_type" value ="airport_history">
                      <tbody>
                       <?php while($record = mysqli_fetch_assoc($data)){ ?>
                         <tr>
						 <td><?php echo $record['user_name']; ?></td>
						 <td><?php echo $record['date_travel']; ?></td>
						 <td><?php echo $record['number_bags']; ?></td>
						 <td><?php echo $record['pickup_location']; ?></td>
						 <td><?php echo $record['delevery_airport']; ?></td>
						 <td><?php echo $record['contact_number']; ?></td>
						 <td><?php echo $record['select_time']; ?></td>
						 
                          
                          <td>
                             <button type="button" id="deletepopup-<?php echo $record['airport_id'];?>" class="btn btn-round btn-danger">Delete</button>
                            
                          </td>
                         </tr>
                        <?php }?> 
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
