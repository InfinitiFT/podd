<?php include_once('header.php'); 
error_reporting(0);
if(isset($_REQUEST['submit'])){
	
	$countFile = count($_FILES['resturant_images']['name']);
	$location = getLatLong($_POST['location']);
	$j =0;
	
	if($countFile > 6){
		$_SESSION['msg']= 'count';
		header("Location: add_resturant.php"); /* Redirect browser */
		
	}	
	for($i=0; $i < $countFile; $i++){
		$target_dir = "upload/";
		$imageUpload = imageUpload($target_dir,$_FILES["resturant_images"]['name'][$i],$_FILES["resturant_images"]['tmp_name'][$i]);
		if($imageUpload){
			$img[] = $imageUpload;
		}else{
			$_SESSION['msg']= 'image';
			header("Location: add_resturant.php"); /* Redirect browser */
		}	
	}
	$allImages = implode(',',$img);
	$dietary = implode(',',$_POST['dietary']);
	$cuisine = implode(',',$_POST['cuisine']);
	$ambience = implode(',',$_POST['ambience']);
	$email = mysqli_real_escape_string($conn,trim($_POST["email"]));

	$addUser = mysqli_query($conn,"INSERT INTO `users`(`email`, `password`, `mobile_no`, `role`) VALUES('".$email."','".md5($_POST['name'])."','".$_POST['phone']."','2')");
	//echo $addUser;exit;
	if($addUser == 1){
		$id = mysqli_insert_id($conn);
		$resturant = mysqli_query($conn,"INSERT INTO `restaurant_details`(`restaurant_name`, `restaurant_images`, `location`,`latitude`, `longitude`, `deliver_food`, `opening_time`, `closing_time`, `about_text`, `max_people_allowed`, `cuisine`, `ambience`, `dietary`, `price_range`, `user_id`) VALUES('".$_POST['name']."','".$allImages."','".$_POST['location']."','".$location['latitude']."','".$location['longitude']."','".$_POST['deliver']."','".$_POST['opentime']."','".$_POST['closetime']."','".$_POST['about']."','".$_POST['people']."','".$cuisine."','".$ambience."','".$dietary."','".$_POST['price']."','".$id."')");
		if($resturant){
			$resturnatID = mysqli_insert_id($conn);
			foreach($_POST['meal'] as $meal){
				$target_dir = "upload/";
				$pdfUrl ='';
				if($_FILES["document"]["name"][$j]){
					$imageUpload = imageUpload($target_dir,$_FILES["document"]['name'][$j],$_FILES["document"]['tmp_name'][$j]);
					if($imageUpload){
						$pdfUrl = $target_dir.$_FILES["document"]["name"][$j];
						mysqli_query($conn,"INSERT INTO `restaurant_menu_details`(`restaurant_id`, `meal`, `menu_url`) VALUES('".$resturnatID."','".$meal."','".$pdfUrl."')");
					}
			   }
				$j =$j +1;
			}
		}
		$_SESSION['msg']= 'success';
		header("Location: add_resturantb.php"); /* Redirect browser */

	}
	
	
	
	

	
	
	
	
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
                    <?php 
                    if($_SESSION['msg'] == 'count'){
						echo '<div class="alert alert-warning">
							    <strong>Warning!</strong> Indicates a warning that might need attention.
						     </div>';
						     $_SESSION['msg'] ='';
                    }
                    ?>
					<div class="clearfix"></div>
                  </div>
                  <div class="x_content">
					<form class="form-horizontal form-label-left" method="post" id="addResturant" enctype = "multipart/form-data" novalidate>
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
                          <input id="name" class="form-control col-md-7 col-xs-12" value="<?php if($_POST['name']){ echo $_POST['name'];}else{ echo '';} ?>" data-validate-length-range="6" data-validate-words="2" name="name" required="required" type="text">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="email" id="email" name="email" required="required" value="<?php if($_POST['email']){ echo $_POST['email'];}else{ echo '';} ?>" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Phone <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="phone" name="phone" required="required" value="<?php if($_POST['phone']){ echo $_POST['phone'];}else{ echo '';} ?>" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                       <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Select Dietary</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="select2_multiple form-control" multiple="multiple" name="dietary[]">
							  <option value="">Select Dietary</option>
							  <?php 
								  $dietary = get_all_data('restaurant_dietary');
									while($die = mysqli_fetch_assoc($dietary))
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
									while($cus = mysqli_fetch_assoc($cuisine))
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
								while($die = mysqli_fetch_assoc($dietary))
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
								while($amb = mysqli_fetch_assoc($ambience))
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
								while($pri = mysqli_fetch_assoc($price))
								  echo '<option value="'.$pri['id'].'">'.$pri['price_range'].'</option>';
								?>
                          </select>
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="website"> Location <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="website" name="location" value="<?php if($_POST['location']){ echo $_POST['location'];}else{ echo '';} ?>" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation">About <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea id="about" required="required" class="form-control" name="about" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.."
                            data-parsley-validation-threshold="10"><?php if($_POST['about']){ echo $_POST['about'];}else{ echo '';} ?></textarea>
                        </div>
                      </div>
                      <div class="item form-group">
                        <label for="password" class="control-label col-md-3">Opening Time</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="opentime" type="text" name="opentime" class="form-control col-md-7 col-xs-12" <?php if($_POST['opentime']){ echo $_POST['opentime'];}else{ echo '';} ?> required="required">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label for="password2" class="control-label col-md-3 col-sm-3 col-xs-12">Closing Time</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="closetime" type="text" value="<?php if($_POST['closetime']){ echo $_POST['closetime'];}else{ echo '';} ?>" name="closetime" data-validate-linked="password" class="form-control col-md-7 col-xs-12" required="required">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="telephone">Max number of people <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="people" name="people" required="required" value="<?php if($_POST['people']){ echo $_POST['people'];}else{ echo '';} ?>" data-validate-length-range="8,20" class="form-control col-md-7 col-xs-12">
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
