<?php 
	include_once('header.php'); 
	$mes ='';
	if($_SESSION['msg'] == 'maxLimit'){
		$mes = '<div class="alert alert-warning">Venue images maximum 6 uploaded</div>';
		$_SESSION['msg'] ='';
	}
	if ($_SESSION['msg'] == 'image'){
		$mes = '<div class="alert alert-warning">Venue images not uploaded. Please try again</div>';
		$_SESSION['msg'] ='';
	}
	if ($_SESSION['msg'] == 'location'){
		$mes = '<div class="alert alert-warning">Please enter valid location</div>';
		$_SESSION['msg'] ='';
	}
	if($_GET['id']){
		$_SESSION['user_id'] = $_GET['id'];
		
	}
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
		$delMeal = explode(',',$_POST['deleteMeal']);
		$meal =$_POST['meal'];
		if($_POST['remImg'])
			$remainImg =array_diff($images,$_POST['remImg']);
		else 	
			$remainImg = $images;
		
		if($_FILES['resturant_images']['name'][0])
			$countFile = count($_FILES['resturant_images']['name']);
		else 
			$countFile = 0;
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
			 $locationTest =  mysqli_real_escape_string($conn,$_POST['locationTest']);
			 $latitude =  mysqli_real_escape_string($conn,$locationData['latitude']);
			 $longitude =  mysqli_real_escape_string($conn,$locationData['longitude']);
			 $locationAdd = mysqli_query($conn,"INSERT INTO `restaurant_location`(`location`,`latitude`, `longitude`) VALUES('".$locationTest."','".$latitude."','".$longitude."')");
			 $loction = mysqli_insert_id($conn);
		}else{
			 $loction = mysqli_real_escape_string($conn,$_POST['location']);
		}
		$j =0;
		if(!empty($_FILES['resturant_images']['name'][0])){
			for($i=0; $i < $countFile; $i++){
				$target_dir = "../uploads/resturant/";
				$imageUpload = imageUpload($target_dir,$_FILES["resturant_images"]['name'][$i],$_FILES["resturant_images"]['tmp_name'][$i]);
				if($imageUpload){
					$img[] = "uploads/resturant/".$_FILES["resturant_images"]['name'][$i];
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

		$dietary = implode(',',$_POST['dietary']);
		$cuisine = implode(',',$_POST['cuisine']);
		$ambience = implode(',',$_POST['ambience']);
		$location = getLatLong($_POST['location']);
	
		if(empty($_SESSION['msg']))
		{
			
			$email = mysqli_real_escape_string($conn,$_POST["email"]);
			$phone = mysqli_real_escape_string($conn,trim($_POST['phone']));
			$opentime = mysqli_real_escape_string($conn,$_POST['opentime']);
			$closetime = mysqli_real_escape_string($conn,$_POST['closetime']);
			$about = mysqli_real_escape_string($conn,$_POST['about']);
			$people = mysqli_real_escape_string($conn,$_POST['people']);
			$price = mysqli_real_escape_string($conn,$_POST['price']);
			$resturantID = mysqli_real_escape_string($conn,$_POST['resturantID']);
			$user_id = mysqli_real_escape_string($conn,$_SESSION['user_id']);
		
			$updateUser = mysqli_query($conn,"UPDATE `users` SET email ='".$email."',mobile_no ='".$phone."' where user_id ='".$user_id."'");
			if($updateUser){
				$name = mysqli_real_escape_string($conn,trim($_POST['name']));
				$lat_long_data = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'],"SELECT * FROM restaurant_location WHERE id = '".$loction."'"));
				$latitude = $lat_long_data['latitude'];
				$longitude = $lat_long_data['longitude'];
				mysqli_query($conn,"UPDATE `restaurant_details` SET  restaurant_name = '".$name."',location='".$loction."',latitude='".$latitude."',longitude='".$longitude."',opening_time='".$opentime."',closing_time='".$closetime."',about_text='".$about."',max_people_allowed='".$people."',cuisine='".$cuisine."',ambience='".$ambience."',dietary='".$dietary."',price_range='".$price."',restaurant_images ='".$allResturantImg."' where restaurant_id ='".$resturantID."'");
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
								$pdfUrl = "uploads/menu_file/".$_FILES["document"]["name"][$j];
							else
								$pdfUrl ='';
								mysqli_query($conn,"UPDATE restaurant_menu_details SET meal ='".$allMeal."', menu_url='".$pdfUrl."' where id ='".$_POST['removeMeal'][$j]."' ");
							
						}else{
							
							   $imageUpload = imageUpload($target_dir,$_FILES["document"]['name'][$j],$_FILES["document"]['tmp_name'][$j]);
							   if($_FILES["document"]["name"][$j])
									$pdfUrl = "uploads/menu_file/".$_FILES["document"]["name"][$j];
							   else
									$pdfUrl = '';
								 mysqli_query($conn,"INSERT INTO restaurant_menu_details(restaurant_id, meal, menu_url) VALUES ('".$resturantID."','".$allMeal."','".$pdfUrl."')");
						}
						$j =$j+1;
						
					}
				}
				
				 mysqli_query($conn,"DELETE FROM `restaurant_menu_details` WHERE `id` IN ('".$delMeal."')");
				
				
			}
			$_SESSION['msg']= 'successEdit';
			if($_GET['id'])
				header('Location: restaurant_list.php');
			else
				header('Location: restaurant_details.php');
		}else{
			if($_GET['id'])
				header('Location: edit_resturant.php?id='.$_GET['id']);
			else
				header('Location: edit_resturant.php');
		}
	}	
	 $mealCount = mysqli_num_rows(get_all_data('restaurant_menu'));
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
                    <h2> Edit Venue </h2>
                     <ul class="nav navbar-right panel_toolbox">
						<li>
							<?php if($_SESSION['restaurant_id']){?>
									<a href="restaurant_details.php"><button type="button" class="btn btn-round btn-success">Back</button></a>
							<?php } else{?>
									<a href="restaurant_list.php"><button type="button" class="btn btn-round btn-success">Back</button></a>
							<?php  } ?>
						</li>
					</ul>
                     <?php echo $mes; ?>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
					<form class="form-horizontal form-label-left" method="post" id="editResturant" enctype = "multipart/form-data" novalidate>
						<div class="item form-group">
						<div class="img-sel col-sm-6 col-sm-offset-3">
							<ul>
							<?php $i = 1;
							if($allImages[0]){
								foreach($allImages as $allImg){
									echo '<li id="removeImg-'.$i.'"><i class="glyphicon glyphicon-remove"  id="removeImgs-'.$i.'" onclick ="removeImg(this)" ></i>
									<img src="'.url().$allImg.'"  height="80" width="80" ><input type="hidden" value="'.$allImg.'" id="imgName-'.$i.'"></li>';
									$i =$i +1;
								}
							}
							$p = $i -1;
							
						?>
						</ul>
						</div>
						</div>
						<div id="allRemoveImg"></div>
					 <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Venue Images <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input  class="form-control col-md-7 col-xs-12"  name="resturant_images[]" type="file" onchange="fileCountEdit(this)" multiple>
                         <?php  echo '<input type="hidden" name="countImg" id ="countImg" value="'.$p.'">';
                         echo '<input type="hidden"  id ="countImgs" name="countImgs" value="'.$p.'">';
                             echo '<input type="hidden" value="'.$p.'" id="imageCount" name="imageCount">';?>
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
									 
									<span class="glyphicon glyphicon-remove btn btn-danger" id="removeMeal-<?php echo $j;?>" onclick="removeMeal(<?php echo $j;?>)"></span>
								 <?php } ?>
							  </div>
						  <?php $j =$j +1;} $allSelectMeasl = implode(',',$selectMeal); ?>
						 
							<input type="hidden" name="selected_meals" id="selected_meals" value="<?php echo $allSelectMeasl;?>" />
						   <input type="hidden" value="<?php echo $mealCount;?>" id="totalMeal">
                     <!--  <div id="addMeal"></div>
                      <div id="deleteMeal"></div>
                      <div class="item form-group">
						  <div class="col-md-6 col-sm-offset-3">
							   <span class="glyphicon glyphicon-plus btn btn-success" id="meal-<?php echo $j-1;?>" onclick="addMeal(this)">Add</span>
							</div>
					  </div> -->
                      
                      
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
							<select class="form-control col-md-7 col-xs-12" name="opentime" id="opentime" onchange="timeValidateClose(this)">
							<?php $i =0;
							for($hours=0; $hours<24; $hours++) {// the interval for hours is '1'
								for($mins=0; $mins<60; $mins+=30) // the interval for mins is '30'
									{
									   if($i == 0){
										 echo '<option value="">'.str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT).'</option>';
									    }    
									    else{ 		
											$selected ='';
											if(str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT) == $detail['opening_time'] )
												$selected ='selected';
											 echo '<option value="'.str_pad($hours,2,'0',STR_PAD_LEFT).':'
													   .str_pad($mins,2,'0',STR_PAD_LEFT).'" '.$selected.'>'.str_pad($hours,2,'0',STR_PAD_LEFT).':'
													   .str_pad($mins,2,'0',STR_PAD_LEFT).'</option>';
										}
										$i =$i+1;
									}
								}
							
							?>
							</select>
                          <!--<input id="opentime" type="text" name="opentime" class="form-control col-md-7 col-xs-12" value="<?php //if($_POST['opentime']){ echo $_POST['opentime'];}else{ echo $detail['opening_time']; }?>">-->
                        </div>
                      </div>
                      <div class="item form-group">
                        <label for="password2" class="control-label col-md-3 col-sm-3 col-xs-12">Closing Time</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
							<select class="form-control col-md-7 col-xs-12" name="closetime" id="closetime" onchange="timeValidate(this)">
							<?php 
							for($hours=0; $hours<24; $hours++){ // the interval for hours is '1'
								for($mins=0; $mins<60; $mins+=30){
									 // the interval for mins is '30'
									 if($i == 0){
										 echo '<option value="">'.str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT).'</option>';
										}
										else{  
											$selected ='';
											if(str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT) == $detail['closing_time'] )
												$selected ='selected';
												echo '<option value="'.str_pad($hours,2,'0',STR_PAD_LEFT).':'
													   .str_pad($mins,2,'0',STR_PAD_LEFT).'" '.$selected.'>'.str_pad($hours,2,'0',STR_PAD_LEFT).':'
													   .str_pad($mins,2,'0',STR_PAD_LEFT).'</option>';
										}
										$i =$i+1;
							
							    }
						    }
							?>
							</select>
							<input type="hidden"  id ="countTime" name="countTime" value="0">
                          <!--<input id="closetime" type="text"  name="closetime" data-validate-linked="password" class="form-control col-md-7 col-xs-12" value="<?php //if($_POST['closetime']){ echo $_POST['closetime'];}else{ echo $detail['closing_time']; }?>" >-->
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
