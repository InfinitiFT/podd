<?php 
/**
 * Created by Rahul Kumar Choudhary.
 * Date: 30/12/16
 * Time: 5:16 PM
 */
ob_start();
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
if(isset($_REQUEST['submit'])){
	$countFile = count($_FILES['resturant_images']['name']);
	if($countFile > 6){
		$_SESSION['msg']= 'maxLimit';
	}
	
	$j =0;
	if($countFile <= 6){
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
	
	if(empty($_SESSION['msg']))
	{
		
		$allImages = implode(',',$img);
		$dietary = implode(',',$_POST['dietary']);
		$cuisine = implode(',',$_POST['cuisine']);
		$ambience = implode(',',$_POST['ambience']);
		$email = mysqli_real_escape_string($conn,trim($_POST["email"]));
		$phone = mysqli_real_escape_string($conn,trim($_POST['phone']));
		$passwordRandom = randomPassword();
		
		$addUser = mysqli_query($conn,"INSERT INTO `users`(`email`, `password`, `mobile_no`, `role`) VALUES('".$email."','".md5($passwordRandom)."','".$phone."','2')");
		if($addUser == 1){
			     $id = mysqli_insert_id($conn);
				 $locationData = getLatLong($_POST['locationTest']);
				 $location_data = mysqli_real_escape_string($conn,trim($_POST['locationTest']));
				 $latitude = mysqli_real_escape_string($conn,trim($locationData['latitude']));
				 $longitude = mysqli_real_escape_string($conn,trim($locationData['longitude']));
				 $loction = mysqli_real_escape_string($conn,$_POST['location']);
				 $name = mysqli_real_escape_string($conn,trim($_POST['name']));
				 $deliver = mysqli_real_escape_string($conn,$_POST['deliver']);
				 $about = mysqli_real_escape_string($conn,$_POST['about']);
				 $people = mysqli_real_escape_string($conn,$_POST['people']);
				 $price = mysqli_real_escape_string($conn,$_POST['price']);
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
				

			$resturant = mysqli_query($conn,"INSERT INTO `restaurant_details`(`restaurant_name`, `restaurant_images`, `location`,`latitude`,`longitude`,`restaurant_full_address`,`deliver_food`, `about_text`, `max_people_allowed`, `cuisine`, `ambience`, `dietary`, `price_range`,`sun_open_time`, `sun_close_time`, `is_sun`, `mon_open_time`, `mon_close_time`, `is_mon`, `tue_open_time`, `tue_close_time`, `is_tue`, `wed_open_time`, `wed_close_time`, `is_wed`, `thu_open_time`, `thu_close_time`,`is_thu`, `fri_open_time`, `fri_close_time`, `is_fri`, `sat_open_time`, `sat_close_time`, `is_sat`, `user_id`) VALUES('".$name."','".$allImages."','".$loction."','".$latitude."','".$longitude."','".$location_data."','".$deliver."','".$about."','".$people."','".$cuisine."','".$ambience."','".$dietary."','".$price."','".$opentimeSun."','".$closetimeSun."','".$is_Sun."','".$opentimeMon."','".$closetimeMon."','".$is_Mon."','".$opentimeTue."','".$closetimeTue."','".$is_Tue."','".$opentimeWed."','".$closetimeWed."','".$is_Wed."','".$opentimeThu."','".$closetimeThu."','".$is_Thu."','".$opentimeFri."','".$closetimeFri."','".$is_Fri."','".$opentimeSat."','".$closetimeSat."','".$is_Sat."','".$id."')");	
		}

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
			              <div>Please click on this link to login using the credentials below:<b> <a href = "'.url().''.'admin/index.php">Linkforlogin</a></b>
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
         if(mail($to,$subject,$message,$headers)){  
			$_SESSION["successmsg"] = "Venue add successfully.";
		 } else{ 
			$_SESSION["errormsg"] = "Error in sending email.";
		 } 
		 $_SESSION['msg']= 'success';
		 header('Location: restaurant_list.php');
	    }
	   else{
		header('Location: add_resturant.php');
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
                  <?php echo $mes; ?>
                    <h2> Add Venue </h2>
                     <ul class="nav navbar-right panel_toolbox">
                            <li><a href="restaurant_list.php"><button type="button" class="btn btn-round btn-success">Back</button></a>
                            </li>
                        </ul>
                    
                    
					<div class="clearfix"></div>
					
                  </div>
                  <div class="x_content">
					<form class="form-horizontal form-label-left" method="post" id="addResturant" enctype = "multipart/form-data" novalidate>
					 <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Images <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input  class="form-control col-md-7 col-xs-12"  name="resturant_images[]" type="file"  onchange ="fileCount(this)" multiple>
                          <input type="hidden" value="" id="imageCount" name="imageCount">
                        </div>
                      </div>
                     <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name" >Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="name" maxlength="100" class="form-control col-md-7 col-xs-12" value="<?php if($_POST['name']){ echo $_POST['name'];}else{ echo '';} ?>" maxlength="256" name="name"  type="text">
                        </div>
                        <div id="mealAdded"></div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="email" id="email" name="email" maxlength="50" value="<?php if($_POST['email']){ echo $_POST['email'];}else{ echo '';} ?>" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Phone <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="phone" maxlength="13" name="phone"  value="<?php if($_POST['phone']){ echo $_POST['phone'];}else{ echo '';} ?>" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                       <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Dietary</label>
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
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Cuisine</label>
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
                  

                        <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Ambience</label>
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
                      <div class="item form-group" id="locationSelect">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="website">Location
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
							<select class="select2_multiple form-control" name="location" id="">
							   <option value="">Select Location</option>
						   <?php 
							  $loc = get_all_data('restaurant_location');
								while($location = mysqli_fetch_assoc($loc)){
								  echo '<option value="'.$location['id'].'">'.$location['location'].'</option>';
							    }
							?>
                          </select>
                           </div>
                            
                        </div>
                        
                       <div class="item form-group" id="location">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Address</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="website" name="locationTest" placeholder ="Enter Full Address" value="<?php if($_POST['location']){ echo $_POST['location'];}else{ echo '';} ?>" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      
                      
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation">Description 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea id="about"  class="form-control" rows="5" name="about" data-parsley-trigger="keyup"  
                             ><?php if($_POST['about']){ echo $_POST['about'];}else{ echo '';} ?></textarea>
                        </div>
                      </div>
                      <input type="hidden"  id ="countTime" name="countTime" value="1">
                       <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation">Time available for booking on podd 
                        </label>
                        
                      </div>
                      
                      <div class="item form-group">
						     <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation">
                        </label>

						   <div class="col-md-6">
							 
							  <div class="col-sm-2">
								
								 <label for="password" class="control-label">Sunday</label>
								 <input type="checkbox" class="check_day form-control" value="7" id="check_day7" name="is_Sun">
							  </div>
							  <div class="col-sm-4">
								<label for="password" class="control-label">From</label>
								<select class="form-control col-sm-1 day-7" name="opentimeSun" id="opentime-Sun" onchange="timeValidateClose(this)" disabled>
								<?php echo get_select_option();?>
								</select>
							  </div>
							  <div class="col-sm-4">
							<label for="password2" class="control-label" >To</label>
							<select class="form-control rday-7" name="closetimeSun" id="closetime-Sun" onchange="timeValidate(this)" disabled>
							<?php echo get_select_option();?>
							</select>
							</div>
							
						  </div>
						 
					</div>
                       
                      
                      <div class="item form-group">
						     <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation">
                        </label>
						   <div class="col-md-6">
						   <div class="col-sm-2">
								
								 <label for="password" class="control-label">Monday</label>
								 <input type="checkbox" class="check_day form-control" id="check_day1" value="1"  name="is_Mon">
						   </div>
							 
							  <div class="col-sm-4">
							 <label for="password" class="control-label">From</label>
								<select class="form-control col-sm-1 day-1" name="opentimeMon" id="opentime-Mon" onchange="timeValidateClose(this)" disabled>
							<?php echo get_select_option();

							?>
							</select>
							</div>
							  <div class="col-sm-4">
							<label for="password2" class="control-label" >To</label>
							<select class="form-control rday-1" name="closetimeMon" id="closetime-Mon" onchange="timeValidate(this)" disabled>
							<?php echo get_select_option();?>
							</select>
							</div>
						</div>
					</div>
                      
                      <div class="item form-group">
						     <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation">
                        </label>
						   <div class="col-md-6">
						    <div class="col-sm-2">
								
								 <label for="password" class="control-label">Tuesday</label>
								 <input type="checkbox" class="check_day form-control" id="check_day2" value="2"  name="is_Tue">
								 
						   </div>
							  
							  <div class="col-sm-4">
							 <label for="password" class="control-label ">From</label>
								<select class="form-control col-sm-1 day-2" name="opentimeTue" id="opentime-Tue" onchange="timeValidateClose(this)" disabled>
							<?php echo get_select_option();?>
							</select>
							</div>
							  <div class="col-sm-4">
							<label for="password2" class="control-label" >To</label>
							<select class="form-control rday-2" name="closetimeTue" id="closetime-Tue" onchange="timeValidate(this)" disabled>
							<?php echo get_select_option();?>
							</select>
							</div>
						</div>
					</div>
                      
                      <div class="item form-group">
						     <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation">
                        </label>
						   <div class="col-md-6">
						      <div class="col-sm-2">
								
								 <label for="password" class="control-label">Wednesday</label>
								 <input type="checkbox" class="check_day form-control" id="check_day3" value="3"  name="is_Wed">
						      </div>
							 
							  <div class="col-sm-4">
							 <label for="password" class="control-label">From</label>
								<select class="form-control day-3" name="opentimeWed" id="opentime-Wed" onchange="timeValidateClose(this)" disabled>
							<?php echo get_select_option();?>
							</select>
							</div>
							  <div class="col-sm-4">
							<label for="password2" class="control-label" >To</label>
							<select class="form-control rday-3" name="closetimeWed" id="closetime-Wed" onchange="timeValidate(this)" disabled>
							<?php echo get_select_option();?>
							</select>
							</div>
						</div>
					</div>
                       <div class="item form-group">
						     <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation">
                        </label>
						   <div class="col-md-6">
						      <div class="col-sm-2">
								
								 <label for="password" class="control-label">Thursday</label>
								 <input type="checkbox" class="check_day form-control" id="check_day4" value="4"  name="is_Thu">
						      </div>
							  <div class="col-sm-4">
							 <label for="password" class="control-label">From</label>
								<select class="form-control day-4" name="opentimeThu" id="opentime-Thu" onchange="timeValidateClose(this)" disabled>
							<?php echo get_select_option();?>
							</select>
							</div>
							  <div class="col-sm-4">
							<label for="password2" class="control-label" >To</label>
							<select class="form-control day-4" name="closetimeThu" id="closetime-Thu" onchange="timeValidate(this)" disabled>
							<?php echo get_select_option();?>
							</select>
							</div>
						</div>
					</div>
                      
                       <div class="item form-group">
						     <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation">
                        </label>
						   <div class="col-md-6">
						      <div class="col-sm-2">
								 <label for="password" class="control-label">Friday</label>
								 <input type="checkbox" class="check_day form-control" id="check_day5" value="5"  name="is_Fri">
						      </div>
							  
							  <div class="col-sm-4">
							 <label for="password" class="control-label">From</label>
								<select class="form-control day-5" name="opentimeFri" id="opentime-Fri" onchange="timeValidateClose(this)" disabled>
							<?php echo get_select_option();?>
							</select>
							</div>
							  <div class="col-sm-4">
							<label for="password2" class="control-label" >To</label>
							<select class="form-control rday-5" name="closetimeFri" id="closetime-Fri" onchange="timeValidate(this)" disabled>
							<?php echo get_select_option();?>
							</select>
							</div>
						</div>
					</div>
                      
                      <div class="item form-group">
						     <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation">
                        </label>
						   <div class="col-md-6">
						      <div class="col-sm-2">
								 <label for="password" class="control-label">Saturday</label>
								 <input type="checkbox"  class="check_day form-control" id="check_day6" value="6"  name="is_Sat">
						      </div>
							  <div class="col-sm-4">
							 <label for="password" class="control-label">From</label>
								<select class="form-control col-sm-1 day-6" name="opentimeSat" id="opentime-Sat" disabled>
							<?php echo get_select_option();?>
							</select>
							</div>
							  <div class="col-sm-4">
							<label for="password2" class="control-label" >To</label>
							<select class="form-control rday-6" name="closetimeSat" id="closetime-Sat" onchange="timeValidate(this)" disabled>
							<?php echo get_select_option();?>
							</select>
							</div>
						</div>
					</div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="telephone">Maximum covers </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="number" id="people" name="people" min ="0" value="<?php if($_POST['people']){ echo $_POST['people'];}else{ echo '';} ?>"  class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                    <input type="hidden" value="<?php echo url();?>" id="urlData">
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                         <input type="submit" id="send" name="submit" class="btn btn-success" value="Save">
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
