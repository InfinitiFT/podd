<?php 
  include_once('header.php');
  $result = array();
  if($restaurant_id !="")
  {
  $restaurant_data = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'],"SELECT rd.*,GROUP_CONCAT(DISTINCT(rc.cuisine_name)) as cuisine_name,GROUP_CONCAT(DISTINCT(rdd.dietary_name)) as dietary_name,GROUP_CONCAT(DISTINCT(ra.ambience_name)) as ambience_name,GROUP_CONCAT(DISTINCT(rp.price_range)) as price_range1 FROM restaurant_details rd LEFT JOIN restaurant_cuisine as rc ON find_in_set(rc.id, rd.cuisine) LEFT JOIN restaurant_dietary as rdd ON find_in_set(rdd.id, rd.dietary) LEFT JOIN restaurant_ambience as ra ON find_in_set(ra.id, rd.ambience) LEFT JOIN restaurant_price_range as rp ON find_in_set(rp.id, rd.price_range) where rd.restaurant_id= '".mysqli_real_escape_string($GLOBALS['conn'],$_SESSION['restaurant_id'])."'"));
 }
 else
 {
   $restaurant_data = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'],"SELECT rd.*,GROUP_CONCAT(DISTINCT(rc.cuisine_name)) as cuisine_name,GROUP_CONCAT(DISTINCT(rdd.dietary_name)) as dietary_name,GROUP_CONCAT(DISTINCT(ra.ambience_name)) as ambience_name,GROUP_CONCAT(DISTINCT(rp.price_range)) as price_range1 FROM restaurant_details rd LEFT JOIN restaurant_cuisine as rc ON find_in_set(rc.id, rd.cuisine) LEFT JOIN restaurant_dietary as rdd ON find_in_set(rdd.id, rd.dietary) LEFT JOIN restaurant_ambience as ra ON find_in_set(ra.id, rd.ambience) LEFT JOIN restaurant_price_range as rp ON find_in_set(rp.id, rd.price_range) where rd.restaurant_id= '".mysqli_real_escape_string($GLOBALS['conn'],$_GET['restaurant_id'])."'"));
 }
  //Basic Validation  
  //print_r($restaurant_data);exit;
  
 ?> 
     <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>
           <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Venue Details</h2>
                     <ul class="nav navbar-right panel_toolbox">
                      
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
                        <div class="col-md-6 col-sm-offset-1 col-sm-6 col-xs-12">
                        <label class="control-label control-label-left col-md-12 col-sm-12 col-xs-12" for="name"> <?php echo $restaurant_data['restaurant_name']; ?>
                        
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Images 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
                        </div>
						          <div class="img-sel col-md-6 col-sm-offset-1 col-sm-6 col-xs-12 ">
							          <ul>
							            <?php $restaurant_images = explode(",",$restaurant_data['restaurant_images']);
                           if($restaurant_images[0])
                            {
                              foreach($restaurant_images as $value){  ?> <li> <img src="<?php echo url().$value; ?>"  height="42" width="42"></li>
									       <?php }} ?>
						            </ul>
						         </div>
						       </div>
                      
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Location
                        </label>
                           <div class="col-md-6 col-sm-offset-1 col-sm-6 col-xs-12">
                          <label class="control-label control-label-left col-md-3 col-sm-3 col-xs-12" for="name"> <?php 
                          if($restaurant_data['location'])
                          {
                           $location = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'],"SELECT location FROM restaurant_location WHERE id = '".$restaurant_data['location']."'"));
                           echo $location['location'];
                          }
                         ?> 
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number">Deliver Food
                        </label>
                           <div class="col-md-6 col-sm-offset-1 col-sm-6 col-xs-12">
                          <label class="control-label control-label-left col-md-3 col-sm-3 col-xs-12" for="name"> <?php  if($restaurant_data['deliver_food']==1) echo 'YES'; else echo 'NO'; ?>
                        </div>
                      </div>
                       <?php if($restaurant_data['is_sun'] != 0){ ?>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="website">Sunday
                        </label>
                            <div class="col-md-6 col-sm-offset-1 col-sm-6 col-xs-12">
                          <label class="control-label control-label-left col-md-3 col-sm-3 col-xs-12" for="name"> <?php echo $restaurant_data['sun_open_time'].'-'.$restaurant_data['sun_close_time'] ; ?>
                        </div>
                      </div>
                      <?php } else{?>
                       <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation">Sunday
                        </label>
                           <div class="col-md-6 col-sm-offset-1 col-sm-6 col-xs-12">
                          <label class="control-label control-label-left col-md-3 col-sm-3 col-xs-12" for="name"> Closed 
                        </div>
                      </div>
                      <?php } ?>
                       <?php if($restaurant_data['is_mon'] != 0){ ?>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="website">Monday
                        </label>
                            <div class="col-md-6 col-sm-offset-1 col-sm-6 col-xs-12">
                          <label class="control-label control-label-left col-md-3 col-sm-3 col-xs-12" for="name"> <?php echo $restaurant_data['mon_open_time'].'-'.$restaurant_data['mon_close_time'] ; ?>
                        </div>
                      </div>
                      <?php } else{?>
                       <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation">Monday 
                        </label>
                           <div class="col-md-6 col-sm-offset-1 col-sm-6 col-xs-12">
                          <label class="control-label control-label-left col-md-3 col-sm-3 col-xs-12" for="name"> Closed 
                        </div>
                      </div>
                      <?php } ?>
                       <?php if($restaurant_data['is_tue'] != 0){ ?>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="website">Tuesday
                        </label>
                            <div class="col-md-6 col-sm-offset-1 col-sm-6 col-xs-12">
                          <label class="control-label control-label-left col-md-3 col-sm-3 col-xs-12" for="name"> <?php echo $restaurant_data['tue_open_time'].'-'.$restaurant_data['tue_close_time'] ; ?>
                        </div>
                      </div>
                      <?php } else{?>
                       <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation">Tuesday 
                        </label>
                           <div class="col-md-6 col-sm-offset-1 col-sm-6 col-xs-12">
                          <label class="control-label control-label-left col-md-3 col-sm-3 col-xs-12" for="name"> Closed 
                        </div>
                      </div>
                      <?php } ?>
                       <?php if($restaurant_data['is_wed'] != 0){ ?>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="website">Wednesday
                        </label>
                            <div class="col-md-6 col-sm-offset-1 col-sm-6 col-xs-12">
                          <label class="control-label control-label-left col-md-3 col-sm-3 col-xs-12" for="name"> <?php echo $restaurant_data['wed_open_time'].'-'.$restaurant_data['wed_close_time'] ; ?>
                        </div>
                      </div>
                      <?php } else{?>
                       <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation">Wednesday 
                        </label>
                           <div class="col-md-6 col-sm-offset-1 col-sm-6 col-xs-12">
                          <label class="control-label control-label-left col-md-3 col-sm-3 col-xs-12" for="name"> Closed 
                        </div>
                      </div>
                      <?php } ?>
                       <?php if($restaurant_data['is_thu'] != 0){ ?>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="website">Thursday
                        </label>
                            <div class="col-md-6 col-sm-offset-1 col-sm-6 col-xs-12">
                          <label class="control-label control-label-left col-md-3 col-sm-3 col-xs-12" for="name"> <?php echo $restaurant_data['thu_open_time'].'-'.$restaurant_data['thu_close_time'] ; ?>
                        </div>
                      </div>
                      <?php } else{?>
                       <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation">Thursday 
                        </label>
                           <div class="col-md-6 col-sm-offset-1 col-sm-6 col-xs-12">
                          <label class="control-label control-label-left col-md-3 col-sm-3 col-xs-12" for="name"> Closed 
                        </div>
                      </div>
                      <?php } ?>
                       <?php if($restaurant_data['is_fri'] != 0){ ?>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="website">Friday
                        </label>
                            <div class="col-md-6 col-sm-offset-1 col-sm-6 col-xs-12">
                          <label class="control-label control-label-left col-md-3 col-sm-3 col-xs-12" for="name"> <?php echo $restaurant_data['fri_open_time'].'-'.$restaurant_data['fri_close_time'] ; ?>
                        </div>
                      </div>
                      <?php } else{?>
                       <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation">Friday 
                        </label>
                           <div class="col-md-6 col-sm-offset-1 col-sm-6 col-xs-12">
                          <label class="control-label control-label-left col-md-3 col-sm-3 col-xs-12" for="name"> Closed 
                        </div>
                      </div>
                      <?php } ?>
                      <?php if($restaurant_data['is_sat'] != 0){ ?>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="website">Saturday
                        </label>
                            <div class="col-md-6 col-sm-offset-1 col-sm-6 col-xs-12">
                          <label class="control-label control-label-left col-md-3 col-sm-3 col-xs-12" for="name"> <?php echo $restaurant_data['sat_open_time'].'-'.$restaurant_data['sat_close_time'] ; ?>
                        </div>
                      </div>
                      <?php } else{?>
                       <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation">Saturday 
                        </label>
                           <div class="col-md-6 col-sm-offset-1 col-sm-6 col-xs-12">
                          <label class="control-label control-label-left col-md-3 col-sm-3 col-xs-12" for="name"> Closed 
                        </div>
                      </div>
                      <?php } ?>
                      <div class="item form-group">
                        <label for="password" class="control-label col-md-3">Venue Description</label>
                           <div class="col-md-6 col-sm-offset-1 col-sm-6 col-xs-12">
                        <label class="control-label control-label-left col-md-12 col-sm-12 col-xs-12" for="name"> <?php echo $restaurant_data['about_text']; ?>
                        
                         
                        </div>
                      </div>
                      <div class="item form-group">
                        <label for="password2" class="control-label col-md-3 col-sm-3 col-xs-12">Maximum covers</label>
                           <div class="col-md-6 col-sm-offset-1 col-sm-6 col-xs-12">
                         <label class="control-label control-label-left col-md-3 col-sm-3 col-xs-12" for="name"> <?php echo $restaurant_data['max_people_allowed']; ?>
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="telephone">Cuisine 
                        </label>
                            <div class="col-md-6 col-sm-offset-1 col-sm-6 col-xs-12">
                          <label class="control-label control-label-left col-md-3 col-sm-3 col-xs-12" for="name"> <?php echo $restaurant_data['cuisine_name']; ?>
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Dietary 
                        </label>
                            <div class="col-md-6 col-sm-offset-1 col-sm-6 col-xs-12">
                          <label class="control-label control-label-left col-md-3 col-sm-3 col-xs-12" for="name"> <?php echo $restaurant_data['dietary_name']; ?>
                        </div>
                      </div>
                       <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Ambience 
                        </label>
                            <div class="col-md-6 col-sm-offset-1 col-sm-6 col-xs-12">
                          <label class="control-label control-label-left col-md-3 col-sm-3 col-xs-12" for="name"> <?php echo $restaurant_data['ambience_name']; ?>
                        </div>
                      </div>
                       <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Price Range 
                        </label>
                           <div class="col-md-6 col-sm-offset-1 col-sm-6 col-xs-12">
                          <label class="control-label control-label-left col-md-3 col-sm-3 col-xs-12" for="name"> <?php echo $restaurant_data['price_range1']; ?>
                        </div>
                      </div>
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                          <?php if($restaurant_id !=""){ ?>
                          <a href="edit_resturant.php" class="btn btn-success">Edit</a>
                          <?php } else {?>
                           <a href="edit_resturant.php?id=<?php echo $restaurant_data['user_id']?>" class="btn btn-success">Edit</a>
                          <?php }?>
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
