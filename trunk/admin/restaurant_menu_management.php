<?php 
  include_once('header.php');
  $result = array();
  $data = get_all_data('restaurant_menu_details');
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
                    <h2>Menu Management List</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a href="add_menu_restaurant.php"><button type="button" class="btn btn-round btn-success">Add Menu</button></a>
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
                          <th>Meal Name</th>
                          <th>Menu File</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <input type="hidden" id = "delete_type" value = "menu_management">
                      <tbody>
                       <?php while($record = mysqli_fetch_assoc($data)){ ?>
                         <tr>
                          <td><?php echo $record['meal'];?> </td>
                          <td><?php  if($record['menu_url']){ ?><a href="<?php echo url().'uploads/menu_file/'.$record['menu_url']; ?>" target="_blank"><?php }?></a></td>
                          
                          <td><?php if($record['status']=="1"){?>
                             <button type="button" id="activatedeactivate-<?php echo $record['id'];?>" class="btn btn-round btn-warning">Deactivate</button>
                              <?php }else{?>
                              <button type="button" id="activatedeactivate-<?php echo $record['id'];?>" class="btn btn-round btn-success">Activate</button>
                              <?php }?>
                             <button type="button" id="deletepopup-<?php echo $record['id'];?>" class="btn btn-round btn-danger">Delete</button>
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