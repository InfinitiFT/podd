<?php 
  include_once('header.php');
  $result = array();
  $data = mysqli_query($GLOBALS['conn'],"SELECT * FROM table_management  JOIN restaurant_details ON table_management.restaurant = restaurant_details.restaurant_id");
 
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
                    <h2>Table List</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a href="add_service_category.php"><button type="button" class="btn btn-round btn-success">Add Category</button></a>
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
                          <th>Date</th>
                          <th>Time</th>
                          <th>No Of Table </th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <input type="hidden" id = "delete_type" value = "table_management">
                      <tbody>
                       <?php if($data){ while($record = mysqli_fetch_assoc($data)){ ?>
                         <tr>
                          <td><?php echo $record['table_date'];?></td>
                          <td><?php echo $record['table_time'];?></td>
                          <td><?php echo $record['number_of_table'];?></td>
                          <td>
                             <button type="button" id="deletepopup-<?php echo $record['service_id'];?>" class="btn btn-round btn-danger">Delete</button>
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