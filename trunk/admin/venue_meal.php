<?php  
  include_once('header.php');
  $result = array();
  if($_SESSION['restaurant_id']!="")
  {
   $data = mysqli_query($GLOBALS['conn'],"SELECT *,rtp.id as item_price_id,rtp.status as sta FROM restaurant_item_price as rtp join restaurant_meal_details rmd on rtp.restaurant_meal_id = rmd.id join items i on rtp.item_id = i.id join meals m on  rmd .meal = m.id join subtitle s on rtp.subtitle = s.subtitle_id where rmd.restaurant_id = '".$_SESSION['restaurant_id']."'");
  }
  else
  {
     $data = mysqli_query($GLOBALS['conn'],"SELECT *,rtp.id as item_price_id,rtp.status as sta FROM restaurant_item_price as rtp join restaurant_meal_details rmd on rtp.restaurant_meal_id = rmd.id join items i on rtp.item_id = i.id join meals m on  rmd .meal = m.id join subtitle s on rtp.subtitle = s.subtitle_id where rmd.restaurant_id = '".$_GET['id']."'");
    
  }
 
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
                    <h2> Menu Management</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a href="add_menu_item.php?restaurant_id=<?php echo $_GET['id'];?>"><button type="button" class="btn btn-round btn-success">Add Menu</button></a>
                      </li>
                      <!-- <li><a href="item_list.php"><button type="button" class="btn btn-round btn-success">Item List</button></a> -->
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
                          <th>Menu Name</th>   
                          <th>Subtitle Name</th>                       
                          <th>Item Name</th>
                          <th>Price</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <input type="hidden" id = "delete_type" value = "items_price">
                       <input type="hidden" id = "item_id" value = "<?php echo $record['item_price_id'];?>">
                      <tbody>
                       <?php while($record = mysqli_fetch_assoc($data)){ ?>
                         <tr>
                          <td><?php echo $record['meal_name'];?></td>
                          <td><?php echo $record['subtitle'];?></td>
                          <td><?php echo $record['name'];?></td>
                          <td><?php echo $record['item_price'];?> </td>
                          <td>
                             <button type="button" id="deletepopup-<?php echo $record['item_price_id'];?>" class="btn btn-round btn-danger">Delete</button>
                              <a  href="edit_item_menu.php?id=<?php echo $record['item_price_id'];?>" class="btn btn-round btn-primary">Edit</a></td>
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
