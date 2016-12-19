<?php 
	include_once('header.php'); 
	$mes ='';
	if($_SESSION['msg'] == 'maxLimit'){
		$mes = '<div class="alert alert-warning">Resturant images maximum 6 uploaded</div>';
		$_SESSION['msg'] ='';
	}
	if ($_SESSION['msg'] == 'image'){
		$mes = '<div class="alert alert-warning">Resturant images not uploaded. Please try again</div>';
		$_SESSION['msg'] ='';
	}
	if ($_SESSION['msg'] == 'location'){
		$mes = '<div class="alert alert-warning">Please enter valid location</div>';
		$_SESSION['msg'] ='';
	}
	if($_GET['id']){
		$_SESSION['user_id'] = $_GET['id'];
		
	}
	//print_r($_SESSION);
	error_reporting(0);
	if($_SESSION['user_id']){
		$detail = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM `users` as u join restaurant_details as r on u.`user_id` = r.user_id where u.`user_id`='".$_SESSION['user_id']."'"));
		
		$mealRecord = mysqli_query($conn,"SELECT * FROM `restaurant_menu_details` WHERE `restaurant_id`='".$detail['restaurant_id']."'");
		$images =explode(',',$detail['restaurant_images']);
		$cuisineSel =explode(',',$detail['cuisine']);
		$ambienceSel =explode(',',$detail['ambience']);
		$dietarySel =explode(',',$detail['dietary']);
		$allImages =explode(',',$detail['restaurant_images']);
	}
	
	if(isset($_REQUEST['submit'])){
		
		$meal =$_POST['meal'];
		$remainImg =array_diff($images,$_POST['remImg']);
		
			
		$countFile = count($_FILES['resturant_images']['name']);
		$countImg = (int)$countFile + (int)$_POST['countImg'];
		if($countImg > 6){
			$_SESSION['msg']= 'maxLimit';
		}
		if($_POST['locationTest']){
			 $locationData = getLatLong($_POST['locationTest']);
			 if(empty($locationData['latitude'])){
				 $_SESSION['msg']= 'location';
				 if($_GET['id'])
					header('Location: edit_resturant.php?id='.$_GET['id']);
				else
					header('Location: edit_resturant.php');
				
			 }
			 $locationAdd = mysqli_query($conn,"INSERT INTO `restaurant_location`(`location`, `latitude`, `longitude`) VALUES('".$_POST['locationTest']."','".$locationData['latitude']."','".$locationData['longitude']."')");
			 $loction = mysqli_insert_id($conn);
		}else{
			 $loction = $_POST['location'];
		}
		$j =0;
		if(!empty($_FILES['resturant_images']['name'][0])){
			for($i=0; $i < $countFile; $i++){
				$target_dir = "../uploads/resturant/";
				$imageUpload = imageUpload($target_dir,$_FILES["resturant_images"]['name'][$i],$_FILES["resturant_images"]['tmp_name'][$i]);
				if($imageUpload){
					$img[] = $imageUpload;
				}else{
					$_SESSION['msg']= 'image';
					
				}	
			}
		}
		if(!empty($remainImg) &&(!empty($img)))
			$allResturantImg = implode(',',array_merge($remainImg,$img));
		if(empty($remainImg) &&(!empty($img)))
			$allResturantImg = implode(',',$img);
		if(!empty($remainImg) && (empty($img)))
			$allResturantImg = implode(',',$remainImg);
		
		//print_r($allResturantImg);exit;
		$dietary = implode(',',$_POST['dietary']);
		$cuisine = implode(',',$_POST['cuisine']);
		$ambience = implode(',',$_POST['ambience']);
		$location = getLatLong($_POST['location']);
	
		if(empty($_SESSION['msg']))
		{
			
			$email = mysqli_real_escape_string($conn,trim($_POST["email"]));
			$updateUser = mysqli_query($conn,"UPDATE `users` SET email ='".$email."',mobile_no ='".$_POST['phone']."' where user_id ='".$_SESSION['user_id']."'");
			if($updateUser){
				
				mysqli_query($conn,"UPDATE `restaurant_details` SET  restaurant_name = '".$_POST['name']."',location='".$loction."',opening_time='".$_POST['opentime']."',closing_time='".$_POST['closetime']."',about_text='".$_POST['about']."',max_people_allowed='".$_POST['people']."',cuisine='".$cuisine."',ambience='".$ambience."',dietary='".$dietary."',price_range='".$_POST['price']."',restaurant_images ='".$allResturantImg."' where restaurant_id ='".$_POST['resturantID']."'");
				$allRemoveMeal = implode(',',$_POST['deleteMeal']);
				$deleteMeal = mysqli_query($conn,"DELETE FROM `restaurant_menu_details` WHERE `id`IN ('".$allRemoveMeal."')");
				if($deleteMeal){
					$j = 0;
					foreach($meal as $allMeal){
						$pdfUrl ='';
						$target_dir = "../uploads/menu_file/";
						if($_POST['removeMeal'][$j]){
							$imageUpload = imageUpload($target_dir,$_FILES["document"]['name'][$j],$_FILES["document"]['tmp_name'][$j]);
							if($_FILES["document"]["name"][$j])
								$pdfUrl = $target_dir.$_FILES["document"]["name"][$j];
							else
								$pdfUrl ='';
							mysqli_query($conn,"UPDATE restaurant_menu_details SET meal ='".$allMeal."', menu_url='".$pdfUrl."' where id ='".$_POST['removeMeal'][$j]."' ");
							
						}else{
							
							   $imageUpload = imageUpload($target_dir,$_FILES["document"]['name'][$j],$_FILES["document"]['tmp_name'][$j]);
							   $pdfUrl = $target_dir.$_FILES["document"]["name"][$j];
							   mysqli_query($conn,"INSERT INTO restaurant_menu_details(restaurant_id, meal, menu_url, status) VALUES ('".$_POST['resturantID']."','".$allMeal."','".$pdfUrl."')");
						}
						$j =$j+1;
						
					}
				}
				
			}
			$_SESSION['msg']= 'successEdit';
			if($_GET['id'])
				header('Location: restaurant_list.php');
			else
				header('Location: booking_list_restaurant.php');
		}else{
			if($_GET['id'])
				header('Location: edit_resturant.php?id='.$_GET['id']);
			else
				header('Location: edit_resturant.php');
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
                    <h2> Edit Resturant </h2>
                     <?php echo $mes; ?>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
					<form class="form-horizontal form-label-left" method="post" id="editResturant" enctype = "multipart/form-data" novalidate>
						<?php $i = 1;
							if($allImages[0]){
								foreach($allImages as $allImg){
									echo '<p class="glyphicon glyphicon-remove" onclick ="removeImg(this)" id="removeImg-'.$i.'"><img src="'.url().'admin/'.$allImg.'"  height="60" width="60"><input type="hidden" value="'.$allImg.'" id="imgName-'.$i.'"></p>';
									$i =$i +1;
								}
							}
							$p = $i -1;
							
						?>
						<div id="allRemoveImg"></div>
					 <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Resturant Images <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input  class="form-control col-md-7 col-xs-12"  name="resturant_images[]" type="file" onchange="myFunction22(this)" multiple>
                         <?php  echo '<input type="hidden" name="countImg" id ="countImg" value="'.$p.'">';?>
                        </div>
                      </div>
                      <input type="hidden" value="<?php echo $detail['user_id'];?>" id="userID">
                     <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
							<input type="hidden" value="<?php echo $detail['restaurant_id'];?>" name="resturantID">
                          <input id="name" class="form-control col-md-7 col-xs-12" value="<?php if($_POST['name']){ echo $_POST['name'];}else{ echo $detail['restaurant_name']; }?>" data-validate-length-range="6" data-validate-words="2" name="name"  type="text">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="email" id="email" name="email"  value="<?php if($_POST['email']){ echo $_POST['email'];}else{ echo $detail['email']; }?>" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Phone <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="phone" name="phone"  value="<?php if($_POST['phone']){ echo $_POST['phone'];}else{ echo $detail['mobile_no']; }?>" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                       <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Select Dietary</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="select2_multiple form-control" multiple="multiple" name="dietary[]">
							  <?php 
								  $dietary = get_all_data('restaurant_dietary');
									while($die = mysqli_fetch_assoc($dietary)){
										$selected ='';
										if(in_array($die['id'],$dietarySel)){
											$selected ='selected';
										}
									 echo '<option value="'.$die['id'].'" '.$selected.'>'.$die['dietary_name'].'</option>';
									}
								?>
                          </select>
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Select Cuisine</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="select2_multiple form-control" multiple="multiple" name="cuisine[]">
                            <?php 
								  $cuisine = get_all_data('restaurant_cuisine');
									while($cus = mysqli_fetch_assoc($cuisine)){
										$selected ='';
										if(in_array($cus['id'],$cuisineSel)){
											$selected ='selected';
										
										}
											echo '<option value="'.$cus['id'].'" '.$selected.'>'.$cus['cuisine_name'].'</option>';
										
									}
								?>
                          </select>
                        </div>
                      </div>
                       
                      <?php  
						$j = 1;
						$selectMeal = array();
						while($allMeal = mysqli_fetch_assoc($mealRecord))
							{ ?>
							  <div class="item form-group" id="allMeal-<?php echo $j;?>">
								   <div class="item form-group col-sm-6">
								<label class="control-label col-md-6 col-sm-3 col-xs-12">Select Meal</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
								  <select class="select2_multiple form-control" name="meal[]" id="allMealling-<?php echo $j;?>">
									<?php 
										$k = 0;
									  $meal = get_all_data('restaurant_menu');
										while($mealData = mysqli_fetch_assoc($meal)){
											$k = $k +1;
											$selected='';
											if($allMeal['meal'] == $mealData['id']){
												$selected = 'selected';
													$selectMeal[] =$mealData['id'];
											}
										  echo '<option value="'.$mealData['id'].'" '.$selected.'>'.$mealData['menu_name'].'</option>';
										}
									?>
								  </select>
								</div>
								</div>
								 <div class="item form-group col-sm-6">
									<label class="control-label col-md-2 col-sm-6 col-xs-6">Menu </label>
								   <div class="col-md-6 col-sm-6 col-xs-12">
									<input id="name" class="form-control col-md-7 col-xs-12"  name="document[]" type="file" >
									<?php if($allMeal['menu_url']){?>
										<span><?php echo  url().$allMeal['menu_url'];?></span>
									<?php } ?>
								  </div>
								 </div>
								 
								 <input type="hidden" value="<?php echo $allMeal['id'];?>" name="removeMeal[]" id="removeMeal-<?php echo $j;?>">
								 <?php if($j != 1){?>
									 
									<span class="glyphicon glyphicon-remove" id="removeMeal-<?php echo $j;?>" onclick="removeMeal(<?php echo $j;?>)"></span>
								 <?php } ?>
							  </div>
						  <?php $j =$j +1;} $allSelectMeasl = implode(',',$selectMeal); ?>
							<input type="hidden" name="selected_meals" id="selected_meals" value="<?php echo $allSelectMeasl;?>" />
						   <input type="hidden" value="<?php echo $k;?>" id="totalMeal">
                      <div id="addMeal"></div>
                      <div id="deleteMeal"></div>
                       <span class="glyphicon glyphicon-plus" id="meal-<?php echo $j-1;?>" onclick="addMeal(this)"></span>
                      
                        <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Select Ambience</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="select2_multiple form-control" multiple="multiple" name="ambience[]">
							<?php 
								$ambience = get_all_data('restaurant_ambience');
								while($amb = mysqli_fetch_assoc($ambience)){
									$selected ='';
										if(in_array($amb['id'],$ambienceSel)){
											$selected ='selected';
										}
								  echo '<option value="'.$amb['id'].'" '.$selected.'>'.$amb['ambience_name'].'</option>';
								}
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
								while($pri = mysqli_fetch_assoc($price)){
									$selected ='';
									if($detail['price_range'] == $pri['id'])
										$selected ='selected';
								  echo '<option value="'.$pri['id'].'" '.$selected.'>'.$pri['price_range'].'</option>';
							  }
								?>
                          </select>
                        </div>
                      </div>
                      
                      <div class="item form-group" id="locationSelect">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="website"> Location
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
							<select class="select2_multiple form-control" name="location" id="">
							   <option value="">Select Location</option>
						   <?php 
							  $loc = get_all_data('restaurant_location');
								while($location = mysqli_fetch_assoc($loc)){
									$selected ='';
									if($detail['location'] == $location['id']){
										$selected ='selected';
									}
								  echo '<option value="'.$location['id'].'" '.$selected.'>'.$location['location'].'</option>';
							    }
							?>
                          </select>
                           </div>
                          </div>
                        
                       <div class="item form-group" id="location">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="website" placeholder="Other Location" name="locationTest" value="<?php if($_POST['locationTest']){ echo $_POST['locationTest'];}else{ echo '';} ?>" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation">About 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea id="about"  class="form-control" name="about" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.."
                            data-parsley-validation-threshold="10"><?php if($_POST['about']){ echo $_POST['about'];}else{ echo $detail['about_text']; }?></textarea>
                        </div>
                      </div>
                      <div class="item form-group">
                        <label for="password" class="control-label col-md-3">Opening Time</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="opentime" type="text" name="opentime" class="form-control col-md-7 col-xs-12" value="<?php if($_POST['opentime']){ echo $_POST['opentime'];}else{ echo $detail['opening_time']; }?>">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label for="password2" class="control-label col-md-3 col-sm-3 col-xs-12">Closing Time</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="closetime" type="text"  name="closetime" data-validate-linked="password" class="form-control col-md-7 col-xs-12" value="<?php if($_POST['closetime']){ echo $_POST['closetime'];}else{ echo $detail['closing_time']; }?>" >
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="telephone">Max number of people </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="people" name="people"  value="<?php if($_POST['people']){ echo $_POST['people'];}else{ echo $detail['max_people_allowed']; }?>" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                    <input type="hidden" value="<?php echo url();?>" id="urlData">
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                         
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
