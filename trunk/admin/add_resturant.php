<?php include_once('header.php'); 
error_reporting(0);
if(isset($_REQUEST['submit'])){
	$countFile = count($_FILES['resturant_images']);
	$location = getLatLong($_POST['location']);
	$j =0;
	for($i=0; $i < $countFile; $i++){
		$target_dir = "upload/";
		$imageUpload = imageUpload($target_dir,$_FILES["resturant_images"]['name'][$i],$_FILES["resturant_images"]['tmp_name'][$i]);
		if($imageUpload)
			$img[] = $imageUpload;
		else
			
	}
	$allImages = implode(',',$img);
	$dietary = implode(',',$_POST['dietary']);
	$cuisine = implode(',',$_POST['cuisine']);
	$ambience = implode(',',$_POST['ambience']);
	
	mysql_query("INSERT INTO `users`(`email`, `password`, `mobile_no`, `role`) VALUES('".mysql_real_escape_string($_POST['email'])."','".md5($_POST['name'])."','".mysql_real_escape_string($_POST['phone'])."','2')");
	$id = mysql_insert_id();
	
	mysql_query("INSERT INTO `restaurant_details`(`restaurant_name`, `restaurant_images`, `location`,`latitude`, `longitude`, `deliver_food`, `opening_time`, `closing_time`, `about_text`, `max_people_allowed`, `cuisine`, `ambience`, `dietary`, `price_range`, `user_id`) VALUES('".mysql_real_escape_string($_POST['name'])."','".$allImages."','".mysql_real_escape_string($_POST['location'])."','".$location['latitude']."','".$location['longitude']."','".$_POST['deliver']."','".mysql_real_escape_string($_POST['opentime'])."','".mysql_real_escape_string($_POST['closetime'])."','".mysql_real_escape_string($_POST['about'])."','".mysql_real_escape_string($_POST['people'])."','".$cuisine."','".$ambience."','".$dietary."','".$_POST['price']."','".$id."')");
	$resturnatID = mysql_insert_id();
	foreach($_POST['meal'] as $meal){
		$target_dir = "upload/";
		$target_file = $target_dir . basename($_FILES["document"]["name"][$j]);
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		$pdfUrl ='';
		if($_FILES["document"]["name"][$j])
			$pdfUrl = $target_dir.$_FILES["document"]["name"][$j];
		move_uploaded_file($_FILES["document"]["tmp_name"][$j], $target_file);
		mysql_query("INSERT INTO `restaurant_menu_details`(`restaurant_id`, `meal`, `menu_url`) VALUES('".$resturnatID."','".$meal."','".$pdfUrl."')");
		$j =$j +1;
	}exit;
	
	
	
	
}	




?>

        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
            </div>
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2> Add Resturant </h2>
					<div class="clearfix"></div>
                  </div>
                  <div class="x_content">
					<form class="form-horizontal form-label-left" method="post" enctype = "multipart/form-data" novalidate>
					 <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Resturant Images <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input  class="form-control col-md-7 col-xs-12"  name="resturant_images[]" type="file" multiple>
                        </div>
                      </div>
                     <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="name" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="name" required="required" type="text">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="email" id="email" name="email" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Phone <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="phone" name="phone" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                       <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Select Dietary</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="select2_multiple form-control" multiple="multiple" name="dietary[]">
							  <option value="">Select Dietary</option>
							  <?php 
								  $dietary = get_all_data('restaurant_dietary');
									while($die = mysql_fetch_assoc($dietary))
									  echo '<option value="'.$die['id'].'">'.$die['dietary_name'].'</option>';
								?>
                          </select>
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Select Cuisine</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="select2_multiple form-control" multiple="multiple" name="cuisine[]">
							  <option value="">Select Cuisine</option>
                            <?php 
								  $cuisine = get_all_data('restaurant_cuisine');
									while($cus = mysql_fetch_assoc($cuisine))
									  echo '<option value="'.$cus['id'].'">'.$cus['cuisine_name'].'</option>';
								?>
                          </select>
                        </div>
                      </div>
                      <div class="item form-group" id="allMeal-1">
						   <div class="item form-group col-sm-6">
                        <label class="control-label col-md-6 col-sm-3 col-xs-12">Select Meal</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="select2_multiple form-control" name="meal[]" id="allMealling-1">
							   <option value="">Select Meal</option>
						   <?php 
							  $dietary = get_all_data('restaurant_meal');
								while($die = mysql_fetch_assoc($dietary))
								  echo '<option value="'.$die['id'].'">'.$die['meal_type'].'</option>';
							?>
                          </select>
                        </div>
                        </div>
                         <div class="item form-group col-sm-6">
							<label class="control-label col-md-2 col-sm-6 col-xs-6">Document</label>
                           <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="name" class="form-control col-md-7 col-xs-12"  name="document[]" type="file" >
                          </div>
                         
                        </div>
                      </div>
                      <div id="addMeal"></div>
                       <span class="glyphicon glyphicon-plus" id="meal-1" onclick="addMeal(this)"></span>
                      
                        <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Select Ambience</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="select2_multiple form-control" multiple="multiple" name="ambience[]">
							   <option value="">Select Ambience</option>
							<?php 
								$ambience = get_all_data('restaurant_ambience');
								while($amb = mysql_fetch_assoc($ambience))
								  echo '<option value="'.$amb['id'].'">'.$amb['ambience_name'].'</option>';
							?>
                          </select>
                         
                        </div>
                      </div>

                        <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Price Range</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="select2_multiple form-control" name="price">
							  <option value="">Select Price Range</option>
                           <?php 
								$price = get_all_data('restaurant_price_range');
								while($pri = mysql_fetch_assoc($price))
								  echo '<option value="'.$pri['id'].'">'.$pri['price_range'].'</option>';
								?>
                          </select>
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="website"> Location <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="website" name="location" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation">About <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea id="about" required="required" class="form-control" name="about" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.."
                            data-parsley-validation-threshold="10"></textarea>
                        </div>
                      </div>
                      <div class="item form-group">
                        <label for="password" class="control-label col-md-3">Opening Time</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="opentime" type="text" name="opentime" class="form-control col-md-7 col-xs-12" required="required">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label for="password2" class="control-label col-md-3 col-sm-3 col-xs-12">Closing Time</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="closetime" type="text" name="closetime" data-validate-linked="password" class="form-control col-md-7 col-xs-12" required="required">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="telephone">Max number of people <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="people" name="people" required="required" data-validate-length-range="8,20" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                    <input type="hidden" value="<?php echo url();?>" id="urlData">
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                          <button type="submit" class="btn btn-primary">Cancel</button>
                          <button id="send" type="submit" name="submit" class="btn btn-success">Submit</button>
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
