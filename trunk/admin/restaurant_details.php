<?php 
  include_once('header.php');
  $result = array();
  $restaurant_data = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'],"SELECT rd.*,GROUP_CONCAT(DISTINCT(rc.cuisine_name)) as cuisine_name,GROUP_CONCAT(DISTINCT(rdd.dietary_name)) as dietary_name,GROUP_CONCAT(DISTINCT(ra.ambience_name)) as ambience_name,GROUP_CONCAT(DISTINCT(rp.price_range)) as price_range1 FROM restaurant_details rd LEFT JOIN restaurant_cuisine as rc ON find_in_set(rc.id, rd.cuisine) LEFT JOIN restaurant_dietary as rdd ON find_in_set(rdd.id, rd.dietary) LEFT JOIN restaurant_ambience as ra ON find_in_set(ra.id, rd.ambience) LEFT JOIN restaurant_price_range as rp ON find_in_set(rp.id, rd.price_range) where rd.restaurant_id= '".$_SESSION['restaurant_id']."'"));
  //Basic Validation  
 // print_r($restaurant_data);exit;
  
 ?> 
     <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>
           <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Restaurant Details</h2>
                     <ul class="nav navbar-right panel_toolbox">
                      <li><a href="booking_list_restaurant.php"><button type="button" class="btn btn-round btn-success">Back</button></a>
                      </li>
                      
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <form class="form-horizontal form-label-left" novalidate>
                      </p>
                  
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name"> <?php echo $restaurant_data['restaurant_name']; ?>
                        
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Images 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email"> 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                         <?php $restaurant_images = explode(",",$restaurant_data['restaurant_images']);
                           if($restaurant_images[0])
                            {
                              foreach($restaurant_images as $value){  ?>
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">  <img src="<?php echo url().$value; ?>"  height="42" width="42"></label>
                             <?php }} ?>
                        
                        </div>
                      </div>

                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Location
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name"> <?php echo $restaurant_data['location']; ?>
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number">Deliver Food
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name"> <?php  if($restaurant_data['deliver_food']==1) echo 'YES'; else echo 'NO'; ?>
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="website">Opening Time 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name"> <?php echo $restaurant_data['opening_time']; ?>
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation">Closing Time
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name"> <?php echo $restaurant_data['closing_time']; ?> 
                        </div>
                      </div>
                      <div class="item form-group">
                        <label for="password" class="control-label col-md-3">About Text</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name"> <?php echo $restaurant_data['about_text']; ?>
                        
                         
                        </div>
                      </div>
                      <div class="item form-group">
                        <label for="password2" class="control-label col-md-3 col-sm-3 col-xs-12">Max people Allowed</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name"> <?php echo $restaurant_data['max_people_allowed']; ?>
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="telephone">Cuisine 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name"> <?php echo $restaurant_data['cuisine_name']; ?>
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Dietary 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name"> <?php echo $restaurant_data['dietary_name']; ?>
                        </div>
                      </div>
                       <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Ambience 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name"> <?php echo $restaurant_data['ambience_name']; ?>
                        </div>
                      </div>
                       <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Price Range 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name"> <?php echo $restaurant_data['price_range1']; ?>
                        </div>
                      </div>
                       <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Menu Details</label>
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea"></label>
                        </br>
                        </div>
                       
                        <?php  $restaurant_menu_data = mysqli_query($GLOBALS['conn'],"SELECT * FROM restaurant_menu_details rdm Join restaurant_menu rm on rdm.meal = rm.id WHERE rdm.restaurant_id = '".$_SESSION['restaurant_id']."'");
                          while($record = mysqli_fetch_assoc($restaurant_menu_data)){ ?>
                         <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea"><?php echo $record['menu_name'];  ?> 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name"> <?php  if($record['menu_url']){ ?><a href="<?php echo url().'uploads/menu_file/'.$record['menu_url']; ?>" target="_blank"><?php echo $record['menu_url'];  }?></a>
                        </div>
                      </div>
                             <?php  } ?>
                      
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                          <a href="edit_resturant.php" class="btn btn-success">Edit</a>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->

        <?php include_once('footer.php'); ?>
