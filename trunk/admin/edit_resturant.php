<?php 
  //error_reporting(0);
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
	if($_GET['id']){
		$_SESSION['user_id'] = decrypt_var($_GET['id']);
		
	}
	// function to get restaurant details through user_id
	if($_SESSION['user_id']){
		$detail = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM `users` as u join restaurant_details as r on u.`user_id` = r.user_id where u.`user_id`='".$_SESSION['user_id']."'"));
		$images =explode(',',$detail['restaurant_images']);
		$cuisineSel =explode(',',$detail['cuisine']);
		$ambienceSel =explode(',',$detail['ambience']);
		$dietarySel =explode(',',$detail['dietary']);
		$allImages =explode(',',$detail['restaurant_images']);
	}
	
	if(isset($_REQUEST['submit']))
	{
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
		
		$j =0;
		if(!empty($_FILES['resturant_images']['name'][0])){
			for($i=0; $i < $countFile; $i++){
			    $ext = pathinfo($_FILES["resturant_images"]['name'][$i],PATHINFO_EXTENSION);
			    $image_name = time().rand(100,999).'.'.$ext;
				$target_dir = "../uploads/resturant/";
				$imageUpload = imageUpload($target_dir,trim($image_name),$_FILES["resturant_images"]['tmp_name'][$i]);
				if($imageUpload){
					$img[] = "uploads/resturant/".trim($image_name);
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
			$locationData = getLatLong($_POST['locationTest']);
			$location_data = mysqli_real_escape_string($conn,trim($_POST['locationTest']));
			$latitude = mysqli_real_escape_string($conn,trim($locationData['latitude']));
			$longitude = mysqli_real_escape_string($conn,trim($locationData['longitude']));
			$loction = mysqli_real_escape_string($conn,$_POST['location']);
			$email = mysqli_real_escape_string($conn,$_POST["email"]);
			$phone = mysqli_real_escape_string($conn,trim($_POST['phone']));
			$about = mysqli_real_escape_string($conn,$_POST['about']);
			$people = mysqli_real_escape_string($conn,$_POST['people']);
			$price = mysqli_real_escape_string($conn,$_POST['price']);
			$resturantID = mysqli_real_escape_string($conn,$_POST['resturantID']);
			$user_id = mysqli_real_escape_string($conn,$_SESSION['user_id']);
			$is_Sun = mysqli_real_escape_string($conn,$_POST['is_Sun']);
			$opentimeSun = mysqli_real_escape_string($conn,$_POST['opentimeSun']);
			$closetimeSun = mysqli_real_escape_string($conn,$_POST['closetimeSun']);
			$is_Mon = mysqli_real_escape_string($conn,$_POST['is_Mon']);
			$opentimeMon = mysqli_real_escape_string($conn,$_POST['opentimeMon']);
			$closetimeMon = mysqli_real_escape_string($conn,$_POST['closetimeMon']);
			$is_Tue = mysqli_real_escape_string($conn,$_POST['is_Tue']);
			$opentimeTue = mysqli_real_escape_string($conn,$_POST['opentimeTue']);
			$closetimeTue = mysqli_real_escape_string($conn,$_POST['closetimeTue']);
			$is_Wed = mysqli_real_escape_string($conn,$_POST['is_Wed']);
			$opentimeWed = mysqli_real_escape_string($conn,$_POST['opentimeWed']);
			$closetimeWed = mysqli_real_escape_string($conn,$_POST['closetimeWed']);
			$is_Thu = mysqli_real_escape_string($conn,$_POST['is_Thu']);
			$opentimeThu = mysqli_real_escape_string($conn,$_POST['opentimeThu']);
			$closetimeThu = mysqli_real_escape_string($conn,$_POST['closetimeThu']);
			$is_Fri = mysqli_real_escape_string($conn,$_POST['is_Fri']);
			$opentimeFri = mysqli_real_escape_string($conn,$_POST['opentimeFri']);
			$closetimeFri = mysqli_real_escape_string($conn,$_POST['closetimeFri']);
			$is_Sat = mysqli_real_escape_string($conn,$_POST['is_Sat']);
			$opentimeSat = mysqli_real_escape_string($conn,$_POST['opentimeSat']);
			$closetimeSat = mysqli_real_escape_string($conn,$_POST['closetimeSat']);

			$updateUser = mysqli_query($conn,"UPDATE `users` SET email ='".$email."',mobile_no ='".$phone."' where user_id ='".$user_id."'");
			if($updateUser){
				$name = mysqli_real_escape_string($conn,trim($_POST['name']));
				mysqli_query($conn," UPDATE `restaurant_details` SET restaurant_name = '".$name."',location='".$loction."',latitude='".$latitude."',longitude='".$longitude."',restaurant_full_address='".$location_data."',about_text='".$about."',max_people_allowed='".$people."',cuisine='".$cuisine."',ambience='".$ambience."',dietary='".$dietary."',price_range='".$price."',`sun_open_time`='".$opentimeSun."',`sun_close_time`='".$closetimeSun."',`is_sun`='".$is_Sun."',`mon_open_time`='".$opentimeMon."',`mon_close_time`='".$closetimeMon."',`is_mon`='".$is_Mon."',`tue_open_time`='".$opentimeTue."',`tue_close_time`='".$closetimeTue."',`is_tue`='".$is_Tue."',`wed_open_time`='".$opentimeWed."',`wed_close_time`='".$closetimeWed."',`is_wed`='".$is_Wed."',`thu_open_time`='".$opentimeThu."',`thu_close_time`='".$closetimeThu."',`is_thu`='".$is_Thu."',`fri_open_time`='".$opentimeFri."',`fri_close_time`='".$closetimeFri."',`is_fri`='".$is_Fri."',`sat_open_time`='".$opentimeSat."',`sat_close_time`='".$closetimeSat."',`is_sat`='".$is_Sat."',restaurant_images ='".$allResturantImg."' where restaurant_id ='".$resturantID."'");	
				
			}

		   $_SESSION['msg']= 'successEdit';
		   if($detail['email'] != $email)
		   {
		   	  $to = $email;
			  $subject = "Welcome to podd";
				   $message = '
					<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
					  <html xmlns="http://www.w3.org/1999/xhtml">
					 <head>
					 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
					
				     </head>
				      <body>
				        <tbody>
					      <tr>
					        <td style="padding-left:0px;font-size:14px;font-family:Helvetica,Arial,sans-serif" valign="top">
					          <div style="line-height:1.3em">
					            <div>Hello <b>'.$_POST['name'].'</b>,</div>
					              <div class="m_-7807612712962067148paragraph_break"><br></div>
					              <div>Welcome to podd. Your account has been created successfully.</div>
					              <div class="m_-7807612712962067148paragraph_break"><br></div>
					              <div>Please click on this link to login using the credentials below:<b> <a href = "http://ec2-52-1-133-240.compute-1.amazonaws.com/PROJECTS/IOSNativeAppDevelopment/trunk/admin/index.php">Linkforlogin</a></b>
					              </div>
					              <div class="m_-7807612712962067148paragraph_break"><br></div>
					              <div><strong>Email:</strong><b>               <strong>'.$_POST['email'].'</strong></b></div>
					              <div class="m_-7807612712962067148paragraph_break"><br></div>
					              <div><strong>Password:</strong>               <b><strong>'.$passwordRandom.'</strong></b></div>
					              <div class="m_-7807612712962067148paragraph_break"><br></div>
					              <div>When you login for the first time, you may be required to change your password</div>
					              <div class="m_-7807612712962067148paragraph_break"><br></div>
					              <div>Best regards,</div>
					              <div>The podd Team</div>
					         </div>
					      </td>
					    </tr>
					  </tbody>				
				    </body>
				 </html>';
		         // Always set content-type when sending HTML email
		         $headers = "MIME-Version: 1.0" . "\r\n";
		         $headers .= 'Cc: hello@poddapp.com' . "\r\n";
		         $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		         // More headers
		         $headers .= 'From: podd' . "\r\n"; 
		         mail($to,$subject,$message,$headers);

		   }
		   
         
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
								if($_SESSION['restaurant_id'] != "")
								{
									foreach($allImages as $allImg){
									echo '
									<img src="'.url().$allImg.'"  height="80" width="80" ><input type="hidden" value="'.$allImg.'" id="imgName-'.$i.'"></li>';
									$i =$i +1;
								    }

								}
								else
								{
									foreach($allImages as $allImg){
									echo '<li id="removeImg-'.$i.'"><i class="glyphicon glyphicon-remove"  id="removeImgs-'.$i.'" onclick ="removeImg(this)" ></i>
									<img src="'.url().$allImg.'"  height="80" width="80" ><input type="hidden" value="'.$allImg.'" id="imgName-'.$i.'"></li>';
									$i =$i +1;
								   }

								}
								
							}
							$p = $i -1;
							
						?>
						</ul>
						</div>
						</div>
						<div id="allRemoveImg"></div>
					 <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Images <span class="required">*</span>
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
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Dietary</label>
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
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Cuisine</label>
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
                    
                      
                      
                        <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Ambience</label>
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
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Address</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="website" placeholder="Enter Full Address" name="locationTest" value="<?php if($_POST['locationTest']){ echo $_POST['locationTest'];}else{ echo $detail['restaurant_full_address'];} ?>" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation">
                        Venue Description 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        
                          <textarea id="about"  class="form-control" name="about" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.."
                            data-parsley-validation-threshold="10" <?php if(@$_SESSION['restaurant_id']!="")
                               { echo "disabled"; }?>><?php if($_POST['about']){ echo $_POST['about'];}else{ echo $detail['about_text']; }?></textarea>
                        </div>
                      </div>
                       <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation">
                        Time available for booking on podd 
                        </label>
                       
                      </div>
                      <div class="item form-group">
						    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation"></label>
						   <div class="col-md-6">
							  <div class="col-sm-2">
								  <?php 
									$checked='';
									$disable = '';
									if($detail['is_sun'] >0){
										$checked = 'checked';
									}else{
										$disable = 'disabled';
									}
										
										
									?> 

								
								<label for="password" class="control-label">Sunday</label>
								<input type="checkbox" value="7" class="check_day form-control" id="check_day7" name="is_Sun" <?php echo $checked;?> >
							</div>
							  <div class="col-sm-4">
							 <label for="password" class="control-label">From</label>
								<select class="form-control day-7" name="opentimeSun" id="opentime-Sun" onchange="timeValidateClose(this)" <?php echo $disable; ?>>
							  <?php $i =0;
							for($hours=0; $hours<24; $hours++) {// the interval for hours is '1'
								for($mins=0; $mins<60; $mins+=30) // the interval for mins is '30'
									{
									   if($i == 0){
										 echo '<option value="">'.str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT).'</option>';
									    }    
									    else{ 		
											$selected ='';
											if(str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT) == $detail['sun_open_time'] )
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
							</div>
							 <div class="col-sm-4">
							 <label for="password" class="control-label">To</label>
								<select class="form-control rday-7" name="closetimeSun" id="closetime-Sun" onchange="timeValidate(this)" <?php echo $disable; ?>>
							  <?php $i =0;
							for($hours=0; $hours<24; $hours++) {// the interval for hours is '1'
								for($mins=0; $mins<60; $mins+=30) // the interval for mins is '30'
									{
									   if($i == 0){
										 echo '<option value="">'.str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT).'</option>';
									    }    
									    else{ 		
											$selected ='';
											if(str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT) == $detail['sun_close_time'] )
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
							</div>
							
						  </div>
					</div>
                      
                      <div class="item form-group">
						     <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation">
                        </label>
						   <div class="col-md-6">
						    <div class="col-sm-2">
							<?php 
								$checked='';
								$disable = '';
								if($detail['is_mon']>0){
									$checked = 'checked';
								}else{
									$disable = 'disabled';
								}
								?> 
								 <label for="password" class="control-label">Monday</label>
								  <input type="checkbox" class="check_day form-control" id="check_day1" value="1"  <?php echo $checked;?> name="is_Mon">
							</div>
							 <div class="col-sm-4">
							 <label for="password" class="control-label">From</label>
								<select class="form-control  day-1" name="opentimeMon" id="opentime-Mon" onchange="timeValidateClose(this)" <?php echo $disable; ?>>
							<?php $i =0;
							for($hours=0; $hours<24; $hours++) {// the interval for hours is '1'
								for($mins=0; $mins<60; $mins+=30) // the interval for mins is '30'
									{
									   if($i == 0){
										 echo '<option value="">'.str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT).'</option>';
									    }    
									    else{ 		
											$selected ='';
											if(str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT) == $detail['mon_open_time'] )
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
							</div>
							  <div class="col-sm-4">
							 <label for="password" class="control-label">To</label>
								<select class="form-control rday-1" name="closetimeMon" id="closetime-Mon" onchange="timeValidate(this)" <?php echo $disable; ?>>
							  <?php $i =0;
							for($hours=0; $hours<24; $hours++) {// the interval for hours is '1'
								for($mins=0; $mins<60; $mins+=30) // the interval for mins is '30'
									{
									   if($i == 0){
										 echo '<option value="">'.str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT).'</option>';
									    }    
									    else{ 		
											$selected ='';
											if(str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT) == $detail['mon_close_time'] )
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
							</div>
							
						</div>
					</div>
                      
                      <div class="item form-group">
						     <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation">
                        </label>
						   <div class="col-md-6">
						 <div class="col-sm-2">
						  <?php 
							  $checked='';
							  $disable = '';
							  if($detail['is_tue'] >0){
								  $checked = 'checked';
							  }else{
									$disable = 'disabled';
									
								}
							?> 
							   <label for="password" class="control-label">Tuesday</label>
								<input type="checkbox" class="check_day form-control" id="check_day2" value="2" name="is_Tue" <?php echo $checked;?>>
							</div>>  
							  <div class="col-sm-4">
							 <label for="password" class="control-label">From</label>
								<select class="form-control col-sm-1 day-2" name="opentimeTue" id="opentime-Tue" onchange="timeValidateClose(this)" <?php echo $disable;?>>
							<?php $i =0;
							for($hours=0; $hours<24; $hours++) {// the interval for hours is '1'
								for($mins=0; $mins<60; $mins+=30) // the interval for mins is '30'
									{
									   if($i == 0){
										 echo '<option value="">'.str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT).'</option>';
									    }    
									    else{ 		
											$selected ='';
											if(str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT) == $detail['tue_open_time'] )
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
							</div>
							<div class="col-sm-4">
							 <label for="password" class="control-label">To</label>
								<select class="form-control rday-2" name="closetimeTue" id="closetime-Tue" onchange="timeValidate(this)" <?php echo $disable; ?>>
							  <?php $i =0;
							for($hours=0; $hours<24; $hours++) {// the interval for hours is '1'
								for($mins=0; $mins<60; $mins+=30) // the interval for mins is '30'
									{
									   if($i == 0){
										 echo '<option value="">'.str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT).'</option>';
									    }    
									    else{ 		
											$selected ='';
											if(str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT) == $detail['tue_close_time'] )
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
							</div>
							
						</div>
					</div>
                      
                      <div class="item form-group">
						     <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation">
                        </label>
						   <div class="col-md-6">
						    <div class="col-md-2">
							<?php 
							  $checked='';
							  $disable = '';
							  if($detail['is_wed'] >0){
								$checked = 'checked';
							  }else{
							  	$disable = 'disabled';
							  }
							?> 
							 
							  <label for="password" class="control-label">Wednesday</label>
								<input type="checkbox" class="check_day form-control" id="check_day3" value="3" <?php echo $checked;?> name="is_Wed">
							 </div>
							  <div class="col-sm-4">
							 <label for="password" class="control-label">From</label>
								<select class="form-control day-3" name="opentimeWed" id="opentime-Wed" onchange="timeValidateClose(this)" <?php echo $disable; ?>>
							<?php $i =0;
							for($hours=0; $hours<24; $hours++) {// the interval for hours is '1'
								for($mins=0; $mins<60; $mins+=30) // the interval for mins is '30'
									{
									   if($i == 0){
										 echo '<option value="">'.str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT).'</option>';
									    }    
									    else{ 		
											$selected ='';
											if(str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT) == $detail['wed_open_time'] )
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
							</div>
							<div class="col-sm-4">
							 <label for="password" class="control-label">To</label>
								<select class="form-control rday-3" name="closetimeWed" id="closetime-Wed" onchange="timeValidate(this)" <?php echo $disable; ?>>
							  <?php $i =0;
							for($hours=0; $hours<24; $hours++) {// the interval for hours is '1'
								for($mins=0; $mins<60; $mins+=30) // the interval for mins is '30'
									{
									   if($i == 0){
										 echo '<option value="">'.str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT).'</option>';
									    }    
									    else{ 		
											$selected ='';
											if(str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT) == $detail['wed_close_time'] )
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
							</div>
						</div>
					</div>
                       <div class="item form-group">
						     <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation">
                        </label>
						   <div class="col-md-6">
						   <div class="col-md-2">
						   
							<?php 
							  $checked='';
							  $disable = '';
							  if($detail['is_thu'] >0){
								  $checked = 'checked';
							  }else{
							  	 $disable = 'disabled';
							  }
							?> 
							 <label for="password" class="control-label">Thursday</label>
								<input type="checkbox" class="check_day form-control" id="check_day4" value="4" <?php echo $checked;?> name="is_Thu">
							</div>  
							  <div class="col-sm-4">
								  
							 <label for="password" class="control-label">From</label>
								<select class="form-control day-4" name="opentimeThu" id="opentime-Thu" onchange="timeValidateClose(this)" <?php echo $disable; ?>>
							<?php $i =0;
							for($hours=0; $hours<24; $hours++) {// the interval for hours is '1'
								for($mins=0; $mins<60; $mins+=30) // the interval for mins is '30'
									{
									   if($i == 0){
										 echo '<option value="">'.str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT).'</option>';
									    }    
									    else{ 		
											$selected ='';
											if(str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT) == $detail['thu_open_time'] )
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
							</div>
							  <div class="col-sm-4">
							 <label for="password" class="control-label">To</label>
								<select class="form-control rday-4" name="closetimeThu" id="closetime-Thu" onchange="timeValidate(this)" <?php echo $disable; ?>>
							  <?php $i =0;
							for($hours=0; $hours<24; $hours++) {// the interval for hours is '1'
								for($mins=0; $mins<60; $mins+=30) // the interval for mins is '30'
									{
									   if($i == 0){
										 echo '<option value="">'.str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT).'</option>';
									    }    
									    else{ 		
											$selected ='';
											if(str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT) == $detail['thu_close_time'] )
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
							</div>
						</div>
					</div>
                      
                       <div class="item form-group">
						     <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation">
                        </label>
						   <div class="col-md-6">
						   <div class="col-md-2">
							<?php 
							  $checked='';
							  $disable = "";
							  if($detail['is_fri'] >0){
								  $checked = 'checked';
							  }else{
							  	 $disable = 'disabled';
							  }
							 ?> 
							  
							  <label for="password" class="control-label">Friday</label>
								<input type="checkbox" class="check_day form-control" id="check_day5" value="5"  <?php echo $checked;?> name="is_Fri">
						    </div>
							  <div class="col-sm-4">
							 <label for="password" class="control-label">From</label>
								<select class="form-control day-5" name="opentimeFri" id="opentime-Fri" onchange="timeValidateClose(this)" <?php echo $disable; ?>>
							<?php $i =0;
							for($hours=0; $hours<24; $hours++) {// the interval for hours is '1'
								for($mins=0; $mins<60; $mins+=30) // the interval for mins is '30'
									{
									   if($i == 0){
										 echo '<option value="">'.str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT).'</option>';
									    }    
									    else{ 		
											$selected ='';
											if(str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT) == $detail['fri_open_time'] )
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
							</div>
							 <div class="col-sm-4">
							 <label for="password" class="control-label">To</label>
								<select class="form-control rday-5" name="closetimeFri" id="closetime-Fri" onchange="timeValidate(this)" <?php echo $disable; ?>>
							  <?php $i =0;
							for($hours=0; $hours<24; $hours++) {// the interval for hours is '1'
								for($mins=0; $mins<60; $mins+=30) // the interval for mins is '30'
									{
									   if($i == 0){
										 echo '<option value="">'.str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT).'</option>';
									    }    
									    else{ 		
											$selected ='';
											if(str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT) == $detail['fri_close_time'] )
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
							</div>
						</div>
					</div>
                      
                      <div class="item form-group">
						     <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation">
                        </label>
						   <div class="col-md-6">
						   <div class="col-md-2">
							<?php 
							  $checked='';
							  $disable = "";
							  if($detail['is_sat'] >0){
								  $checked = 'checked';
							  }else{
							  	 $disable = 'disabled';
							  }
							?> 
							  <label for="password" class="control-label">Saturday</label>
								<input type="checkbox" class="check_day form-control" id="check_day6" value="6"  name="is_Sat"  <?php echo $checked;?> name="is_Sat">
							</div>
							  <div class="col-sm-4">
							 <label for="password" class="control-label">From</label>
								<select class="form-control day-6" name="opentimeSat" id="opentime-Sat" onchange="timeValidateClose(this)" <?php echo $disable; ?>>
							<?php $i =0;
							//echo $detail['sat_open_time'];exit;
							for($hours=0; $hours<24; $hours++) {// the interval for hours is '1'
								for($mins=0; $mins<60; $mins+=30) // the interval for mins is '30'
									{
									   if($i == 0){
										 echo '<option value="">'.str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT).'</option>';
									    }    
									    else{ 		
											$selected ='';
											if(str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT) == $detail['sat_open_time'] )
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
							</div>
							   <div class="col-sm-4">
							 <label for="password" class="control-label">To</label>
								<select class="form-control rday-6" name="closetimeSat" id="closetime-Sat" onchange="timeValidate(this)" <?php echo $disable; ?>>
							  <?php $i =0;
							for($hours=0; $hours<24; $hours++) {// the interval for hours is '1'
								for($mins=0; $mins<60; $mins+=30) // the interval for mins is '30'
									{
									   if($i == 0){
										 echo '<option value="">'.str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT).'</option>';
									    }    
									    else{ 		
											$selected ='';
											if(str_pad($hours,2,'0',STR_PAD_LEFT).':'.str_pad($mins,2,'0',STR_PAD_LEFT) == $detail['sat_close_time'] )
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
							</div>
						</div>
					</div>
                      <input type="hidden"  id ="countTime" name="countTime" value="0">
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="telephone">Maximum covers </label>
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
