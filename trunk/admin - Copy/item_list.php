<?php 
  include_once('header.php');
  $result = array();
  $data = get_all_data('items');
 
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
                    <h2>Item List</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a href="add_item.php"><button type="button" class="btn btn-round btn-success">Add Item</button></a>
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
                          <th>Name</th>
                          <th>Created By</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <input type="hidden" id = "delete_type" value = "items">
                       <input type="hidden" id = "item_id" value = "<?php echo $record['id'];?>">
                      <tbody>
                       <?php while($record = mysqli_fetch_assoc($data)){ ?>
                         <tr>
                          <td><?php echo $record['name'];?></td>
                          <td><?php echo $record['created_by'];?></td>
                          <td><?php if($record['status']=="1"){?>
                             <button type="button" id="activatedeactivate-<?php echo $record['id'];?>" class="btn btn-round btn-warning">Deactivate</button>
                              <?php }else{?>
                              <button type="button" id="activatedeactivate-<?php echo $record['id'];?>" class="btn btn-round btn-success">Activate</button>
                              <?php }?>
                              <a href="edit_item.php?id=<?php echo $record['id'];?>" class="btn btn-round btn-info">Edit</a>
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