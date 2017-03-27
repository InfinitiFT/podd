<?php 
  include_once('header.php');
  $result = array();
  $data = get_all_data('airport_section_data');
 
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
                    <h2>Airport Transfer List</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a href="add_airport_page_image.php"><button type="button" class="btn btn-round btn-success">Add Image</button></a>
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
						  <th>Image</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <input type="hidden" id = "delete_type" value = "airport_i">
                      <tbody>
                       <?php while($record = mysqli_fetch_assoc($data)){ ?>
                         <tr>
                        
						   <td><img src="<?php echo url1().$record['airport_image'];?>" alt="Smiley face" height="42" width="42"></td>
                          <td>
                             <a type="button" href="edit_airport_page_image.php?id=<?php echo encrypt_var($record['id']);?>" id="edit" class="btn btn-round btn-primary">Edit</a>
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
