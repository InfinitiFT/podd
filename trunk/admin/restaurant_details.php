<?php 
  include_once('header.php');
  $result = array();
  if(@$_SESSION['restaurant_id'] !="")
  {
  $restaurant_data = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'],"SELECT rd.*,GROUP_CONCAT(DISTINCT(rc.cuisine_name)) as cuisine_name,GROUP_CONCAT(DISTINCT(rdd.dietary_name)) as dietary_name,GROUP_CONCAT(DISTINCT(ra.ambience_name)) as ambience_name,GROUP_CONCAT(DISTINCT(rp.price_range)) as price_range1 FROM restaurant_details rd LEFT JOIN restaurant_cuisine as rc ON find_in_set(rc.id, rd.cuisine) LEFT JOIN restaurant_dietary as rdd ON find_in_set(rdd.id, rd.dietary) LEFT JOIN restaurant_ambience as ra ON find_in_set(ra.id, rd.ambience) LEFT JOIN restaurant_price_range as rp ON find_in_set(rp.id, rd.price_range) where rd.restaurant_id= '".mysqli_real_escape_string($GLOBALS['conn'],$_SESSION['restaurant_id'])."'"));
 }
 else
 {
   $restaurant_data = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'],"SELECT rd.*,GROUP_CONCAT(DISTINCT(rc.cuisine_name)) as cuisine_name,GROUP_CONCAT(DISTINCT(rdd.dietary_name)) as dietary_name,GROUP_CONCAT(DISTINCT(ra.ambience_name)) as ambience_name,GROUP_CONCAT(DISTINCT(rp.price_range)) as price_range1 FROM restaurant_details rd LEFT JOIN restaurant_cuisine as rc ON find_in_set(rc.id, rd.cuisine) LEFT JOIN restaurant_dietary as rdd ON find_in_set(rdd.id, rd.dietary) LEFT JOIN restaurant_ambience as ra ON find_in_set(ra.id, rd.ambience) LEFT JOIN restaurant_price_range as rp ON find_in_set(rp.id, rd.price_range) where rd.restaurant_id= '".mysqli_real_escape_string($GLOBALS['conn'],decrypt_var($_GET['restaurant_id']))."'"));
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
                    <h2>Venue Management</h2>
                   
                    <div class="clearfix"></div>
                  </div>
                  <div class="col-md-3 col-sm-3 col-xs-6">
                  </div>
                   <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="x_content">

                    <table class="table table-bordered">
                        <tr>
                          <td>Name</td>
                          <td><?php echo $restaurant_data['restaurant_name']; ?></td>
                          
                        </tr>
                         <tr>
                           
                          <td>Images</td>
                          <td> 
                          <?php $restaurant_images = explode(",",$restaurant_data['restaurant_images']);
                           if($restaurant_images[0])
                            {
                              foreach($restaurant_images as $value){  ?>  <img src="<?php echo url().$value; ?>"  height="42" width="42">
                         <?php }} ?>
                        </td>
                          
                        </tr>
                        <tr>
                           
                          <td>Location</td>
                          <td><?php 
                          if($restaurant_data['location'])
                          {
                           $location = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'],"SELECT location FROM restaurant_location WHERE id = '".$restaurant_data['location']."'"));
                           echo $location['location'];
                          }
                         ?> </td>
                          
                        </tr>
                        <tr>
                          
                          <td>Deliver Food</td>
                          <td><?php  if($restaurant_data['deliver_food']==1) echo 'YES'; else echo 'NO'; ?></td>
                          
                        </tr>
                        <tr>
                          
                          <td>Sunday</td>
                          <td><?php if($restaurant_data['is_sun'] != 0){ 
                               echo $restaurant_data['sun_open_time'].'-'.$restaurant_data['sun_close_time'] ;
                             }
                               else{
                                echo "Closed";
                                } ?>
                         </td>
                          
                        </tr>
                        <tr>
                          
                          <td>Monday</td>
                          <td><?php if($restaurant_data['is_mon'] != 0){ 
                               echo $restaurant_data['mon_open_time'].'-'.$restaurant_data['mon_close_time'] ;
                             }
                               else{
                                echo "Closed";
                                } ?></td>
                          
                        </tr>
                        <tr>
                           
                          <td>Tuesday</td>
                          <td><?php if($restaurant_data['is_tue'] != 0){ 
                               echo $restaurant_data['tue_open_time'].'-'.$restaurant_data['tue_close_time'] ;
                             }
                               else{
                                echo "Closed";
                                } ?></td>
                          
                        </tr>
                        <tr>
                           
                          <td>Wednesday</td>
                          <td><?php if($restaurant_data['is_wed'] != 0){ 
                               echo $restaurant_data['wed_open_time'].'-'.$restaurant_data['wed_close_time'] ;
                             }
                               else{
                                echo "Closed";
                                } ?></td>
                          
                        </tr>
                        <tr>
                          
                          <td>Thursday</td>
                          <td><?php if($restaurant_data['is_thu'] != 0){ 
                               echo $restaurant_data['thu_open_time'].'-'.$restaurant_data['thu_close_time'] ;
                             }
                               else{
                                echo "Closed";
                                } ?></td>
                          
                        </tr>
                        <tr>
                           
                          <td>Friday</td>
                          <td><?php if($restaurant_data['is_fri'] != 0){ 
                               echo $restaurant_data['fri_open_time'].'-'.$restaurant_data['fri_close_time'] ;
                             }
                               else{
                                echo "Closed";
                                } ?></td>
                          
                        </tr>
                        <tr>
                          
                          <td>Saturday</td>
                          <td><?php if($restaurant_data['is_sat'] != 0){ 
                               echo $restaurant_data['sat_open_time'].'-'.$restaurant_data['sat_close_time'] ;
                             }
                               else{
                                echo "Closed";
                                } ?></td>
                          
                        </tr>
                        <tr>
                          
                          <td>Venue Description</td>
                          <td><?php echo $restaurant_data['about_text']; ?></td>
                          
                        </tr>
                         <tr>
                           
                          <td>Maximum covers</td>
                          <td><?php echo $restaurant_data['max_people_allowed']; ?></td>
                          
                        </tr>
                         <tr>
                           
                          <td>Cuisine</td>
                          <td><?php echo $restaurant_data['cuisine_name']; ?></td>
                          
                        </tr>
                         <tr>
                           
                          <td>Dietary</td>
                          <td><?php echo $restaurant_data['dietary_name']; ?></td>
                          
                        </tr>
                         <tr>
                           
                          <td>Ambience</td>
                          <td><?php echo $restaurant_data['ambience_name']; ?></td>
                          
                        </tr>
                         <tr>
                           
                          <td>Price Range</td>
                          <td><?php echo $restaurant_data['price_range1']; ?></td>
                          
                        </tr>
                         <tr>
                           
                          <td></td>
                          <td> <?php if($restaurant_id !=""){ ?>
                          <a href="edit_resturant.php" class="btn btn-success">Edit</a>
                          <?php } else {?>
                           <a href="edit_resturant.php?id=<?php echo encrypt_var($restaurant_data['user_id'])?>" class="btn btn-success">Edit</a>
                          <?php }?></td>
                          
                        </tr>
                    </table>

                  </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <?php include_once('footer.php'); ?>
