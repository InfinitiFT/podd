<?php 
  include_once('header.php');
  $result = array();
  $data = mysqli_query($GLOBALS['conn'],"SELECT *, restaurant_details.status as st FROM restaurant_details  JOIN users ON restaurant_details.user_id = users.user_id");
  //Basic Validation  
  $msg ='';
  if(isset($_SESSION['msg']) == 'success'){
	if($_SESSION['msg'] == 'success'){
		$msg = '<div class="alert alert-warning">Resturant added successfully</div>';
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
                    <h2>Restaurant List</h2>
                    <?php echo $msg; ?>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <p class="text-muted font-13 m-b-30">
                    </p>
                    <table id="datatable-responsive" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Name</th>
                          <th>Email</th>
                          <th>Location</th>
                          <th>Contact No</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <input type="hidden" id = "delete_type" value ="restaurant">
                      <tbody>
                       <?php while($record = mysqli_fetch_assoc($data)){ ?>
                         <tr>
                          <td><?php echo $record['restaurant_name'];?></td>
                          <td><?php echo $record['email'];?></td>
                          <td><?php echo $record['location'];?></td>
                          <td><?php echo $record['country_code'].$record['mobile_no'];?></td>
                          <td><?php if($record['st'] == 1){?>
                             <button type="button" id="activatedeactivate-<?php echo $record['restaurant_id'];?>" class="btn btn-round btn-warning">Deactivate</button>
                              <?php }else{?>
                              <button type="button" id="activatedeactivate-<?php echo $record['restaurant_id'];?>" class="btn btn-round btn-success">Activate</button>
                              <?php }?>
                               <a  href="edit_resturant.php?id=<?php echo $record['user_id'];?>" class="btn btn-round btn-primary">Edit</a>
                             <button type="button" id="deletepopup-<?php echo $record['restaurant_id'];?>" class="btn btn-round btn-danger">Delete</button>
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
