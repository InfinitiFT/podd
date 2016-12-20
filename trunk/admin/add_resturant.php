<?php 
ob_start();
include_once('header.php'); 
error_reporting(0);

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
if(isset($_REQUEST['submit'])){

	$countFile = count($_FILES['resturant_images']['name']);
	if($countFile > 6){
		$_SESSION['msg']= 'maxLimit';
	}
	
	$j =0;
	if($countFile <= 6){
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
	
	if(empty($_SESSION['msg']))
	{
		
		$allImages = implode(',',$img);
		$dietary = implode(',',$_POST['dietary']);
		$cuisine = implode(',',$_POST['cuisine']);
		$ambience = implode(',',$_POST['ambience']);
		$email = mysqli_real_escape_string($conn,trim($_POST["email"]));
		$passwordRandom = randomPassword();
		
		$addUser = mysqli_query($conn,"INSERT INTO `users`(`email`, `password`, `mobile_no`, `role`) VALUES('".$email."','".md5($passwordRandom)."','".$_POST['phone']."','2')");
		if($addUser == 1){
			
			$id = mysqli_insert_id($conn);
				if($_POST['locationTest']){
					 $locationData = getLatLong($_POST['locationTest']);
					 if(empty($locationData['latitude'])){
						 $_SESSION['msg']= 'location';
						 header('Location: add_resturant.php');
					 }
					
					 $locationAdd = mysqli_query($conn,"INSERT INTO `restaurant_location`(`location`, `latitude`, `longitude`) VALUES('".$_POST['locationTest']."','".$locationData['latitude']."','".$locationData['longitude']."')");
					 $loction = mysqli_insert_id($conn);
				}else{
					 $loction = $_POST['location'];
				}
				
			$resturant = mysqli_query($conn,"INSERT INTO `restaurant_details`(`restaurant_name`, `restaurant_images`, `location`, `deliver_food`, `opening_time`, `closing_time`, `about_text`, `max_people_allowed`, `cuisine`, `ambience`, `dietary`, `price_range`, `user_id`) VALUES('".$_POST['name']."','".$allImages."','".$loction."','".$_POST['deliver']."','".$_POST['opentime']."','".$_POST['closetime']."','".$_POST['about']."','".$_POST['people']."','".$cuisine."','".$ambience."','".$dietary."','".$_POST['price']."','".$id."')");
			if($resturant){
				
				$resturnatID = mysqli_insert_id($conn);
				foreach($_POST['meal'] as $meal){
					$target_dir = "../uploads/menu_file/";
					$pdfUrl ='';
					if($_FILES["document"]["name"][$j]){
						$imageUpload = imageUpload($target_dir,$_FILES["document"]['name'][$j],$_FILES["document"]['tmp_name'][$j]);
						if($imageUpload){
							if($_FILES["document"]["name"][$j])
								$pdfUrl = 'uploads/resturant/'.$_FILES["document"]["name"][$j];
								
							mysqli_query($conn,"INSERT INTO `restaurant_menu_details`(`restaurant_id`, `meal`, `menu_url`) VALUES('".$resturnatID."','".$meal."','".$pdfUrl."')");
						}
				   }else{
					   mysqli_query($conn,"INSERT INTO `restaurant_menu_details`(`restaurant_id`, `meal`) VALUES('".$resturnatID."','".$meal."')");
				   }
					$j =$j +1;
				}
			}
			
		}

		 $to = $email;
		   $subject = "Password";
		   $message = '
			<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			  <html xmlns="http://www.w3.org/1999/xhtml">
			 <head>
			 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			 <title>Password Recovery</title>
		   </head>
		   <body>
			<table cellpadding="0" cellspacing="0"  width="80%"  align="center">
			  <tr>
				<td width="48%" valign="top" style="border:solid 2px #303030;" colspan="3">
				  <table cellpadding="0" cellspacing="0"  width="100%"  >
					<TR>
					  <TD height="40" align="center" bgcolor="#272727" style="border:solid 2px #303030;">
						<strong style="color:#fff;">Account Created Successfully</strong>
					  </TD>
					</TR>
					<TR>
					  <TD style="padding:5px; background-color:#fff;">
						<table cellpadding="0" cellspacing="0" border="0" width="100%"  style="padding:5px;"> 
						  <tr>
							<td width="2" align="center"  valign="bottom" style="padding-top:5px;"> </td>
							<td colspan="2" width="394" >
						  <strong>Hello '.$_POST['name'].' ,</strong><br/>
						  You account is successfully created on IOSNativeAppDevelopment.<br>Your password is  <b>'.$passwordRandom.'</b> 
							</td>
						  </tr>
						  <tr>
							<td width="2" align="center"  valign="bottom" style="padding-top:5px;"> </td>
							<td colspan="2" width="394" >
							   Thank you for your interest in our app!</br>
							</td>
						  </tr>

						  <tr>
							<td colspan="3" height="6px"> </td>
						  </tr>
						</table>
					  </TD>
					</TR>
				  </table>
				</td> 
			  </tr>
			</table>
		  </body>
		</html>';

		
		
      // Always set content-type when sending HTML email
      
      $headers = "MIME-Version: 1.0" . "\r\n";
      $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

      // More headers
      $headers .= 'From: ippodDevlopment@gmail.com' . "\r\n"; 
      if(mail($to,$subject,$message,$headers)){  
			$_SESSION["successmsg"] = "Password Send to your email.";
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
                    <h2> Add Resturant </h2>
                    <?php echo $mes; ?>
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
                          <input id="name" class="form-control col-md-7 col-xs-12" value="<?php if($_POST['name']){ echo $_POST['name'];}else{ echo '';} ?>" data-validate-length-range="6" data-validate-words="2" name="name"  type="text">
                        </div>
                        <div id="mealAdded"></div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="email" id="email" name="email"  value="<?php if($_POST['email']){ echo $_POST['email'];}else{ echo '';} ?>" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Phone <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="phone" name="phone"  value="<?php if($_POST['phone']){ echo $_POST['phone'];}else{ echo '';} ?>" class="form-control col-md-7 col-xs-12">
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
                      <input type="hidden" name="selected_meals" id="selected_meals" value="" />
                      <div class="item form-group" id="allMeal-1">
						   <div class="item form-group col-sm-6">
                        <label class="control-label col-md-6 col-sm-3 col-xs-12">Select Meal</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="select2_multiple form-control" name="meal[]" id="allMealling-1">
							   <option value="">Select Meal</option>
						   <?php 
							  $meal = get_all_data('restaurant_menu');
							  $i =1;
								while($mealData = mysqli_fetch_assoc($meal)){
								  echo '<option value="'.$mealData['id'].'">'.$mealData['menu_name'].'</option>';
								  $i = $i +1;
							    }
							?>
                          </select>
                        </div>
                        </div>
                        <input type="hidden" value="<?php echo $i-1;?>" id="totalMeal">
                         <div class="item form-group col-sm-6">
							<label class="control-label col-md-2 col-sm-6 col-xs-6">Menu</label>
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
                      <div class="item form-group" id="locationSelect">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="website"> Location
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
                        <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="website" name="locationTest" placeholder ="Other Location" value="<?php if($_POST['location']){ echo $_POST['location'];}else{ echo '';} ?>" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      
                      
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation">About 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea id="about"  class="form-control" name="about" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.."
                            data-parsley-validation-threshold="10"><?php if($_POST['about']){ echo $_POST['about'];}else{ echo '';} ?></textarea>
                        </div>
                      </div>
                      
                      <div class="item form-group">
                        <label for="password" class="control-label col-md-3">Opening Time</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
							<select class="form-control col-md-7 col-xs-12" name="opentime" id="opentime" onchange="timeValidateClose(this)">
							<?php $i =0;
								for($hours=0; $hours<24; $hours++) // the interval for hours is '1'
									for($mins=0; $mins<60; $mins+=30){
										 // the interval for mins is '30'
									if($i == 0)
											echo '<option value="">'.str_pad($hours,2,'0',STR_PAD_LEFT).':'
														   .str_pad($mins,2,'0',STR_PAD_LEFT).'</option>';
										else
											echo '<option value="'.str_pad($hours,2,'0',STR_PAD_LEFT).':'
														   .str_pad($mins,2,'0',STR_PAD_LEFT).'">'.str_pad($hours,2,'0',STR_PAD_LEFT).':'
														   .str_pad($mins,2,'0',STR_PAD_LEFT).'</option>';
										$i =$i+1;
								 }
							?>
							</select>
                          <!--<input id="opentime" type="text" name="opentime" class="form-control col-md-7 col-xs-12" <?php //if($_POST['opentime']){ echo $_POST['opentime'];}else{ echo '';} ?> >-->
                        </div>
                      </div>
                      <div class="item form-group">
                        <label for="password2" class="control-label col-md-3 col-sm-3 col-xs-12" >Closing Time</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
							<select class="form-control col-md-7 col-xs-12" name="closetime" id="closetime" onchange="timeValidate(this)">
							<?php 
								$i =0;
								for($hours=0; $hours<24; $hours++) // the interval for hours is '1'
									for($mins=0; $mins<60; $mins+=30){ // the interval for mins is '30'
										if($i == 0)
											echo '<option value="">'.str_pad($hours,2,'0',STR_PAD_LEFT).':'
														   .str_pad($mins,2,'0',STR_PAD_LEFT).'</option>';
										else
											echo '<option value="'.str_pad($hours,2,'0',STR_PAD_LEFT).':'
														   .str_pad($mins,2,'0',STR_PAD_LEFT).'">'.str_pad($hours,2,'0',STR_PAD_LEFT).':'
														   .str_pad($mins,2,'0',STR_PAD_LEFT).'</option>';
										$i =$i+1;
								
						       }
							?>
							</select>
							<input type="hidden"  id ="countTime" name="countTime" value="1">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="telephone">Max number of people </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="people" name="people"  value="<?php if($_POST['people']){ echo $_POST['people'];}else{ echo '';} ?>" data-validate-length-range="8,20" class="form-control col-md-7 col-xs-12">
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
