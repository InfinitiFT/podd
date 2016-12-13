<?php
error_reporting(0);
	include('config/config.php');
	include('admin_functions.php');
	session_start();
	validate_session_admin($_SESSION['uid']);
	include('header.php');
	$practitioner = getpractitionerInfo($_REQUEST['practitionerid']);
  $categoryName = getCategoryName($practitioner['category']);
  if(isset($_POST['save'])) {

		if(empty($_POST['firstname'])){
			$error = 'First Name is required';
		}
		else if(!is_numeric($_POST['contact'])) {
			$error = 'Contact number must be numeric';
		}
		else if(empty($_POST['category'])){
			$error = 'Category is required';
		}
		else if(empty($_POST['startdate'])) {
			$error = 'Start date is required';
		}
		else if(empty($_POST['enddate'])) {
			$error = 'End date is required';
		}
		
		else if((strtotime($_POST['startdate'])) >= (strtotime($_POST['enddate']))) {
			$error = 'End date should be greater than Start date';
		}
		else {
			if(isset($_POST['verified'])) {
				if($_POST['verified'] == 'Verified') {
				$email = mysql_fetch_assoc(mysql_query("SELECT email FROM qv_practitioner WHERE id=".$practitioner['id'].""));
				$message = "Dear User, \n You have been Verified by Admin. \n Thanks, \n Qova Team";
			    $subject = 'Qova - Blocked User';
			    mail($email['email'], $subject, $message);
				$verifiedStatus = 1;
				}
			}
			else {
				$verifiedStatus = 0;
			}
			
			if (!empty($_FILES["profilepic"]["name"])) {
				$file_name=$_FILES["profilepic"]["name"];
				$temp_name=$_FILES["profilepic"]["tmp_name"];
				$rand = rand();
				$imgname = 'qova-'.$rand.'.jpeg';
				$target = 'images/practitioner/'.$imgname;
				$status = move_uploaded_file($temp_name, '../'.$target);
			}
			else {
				$target = $practitioner['profile_image'];
			}
		
			$updatequery = mysql_query("UPDATE qv_practitioner SET firstname = '".$_POST['firstname']."', lastname = '".$_POST['lastname']."', phone_no = '".$_POST['contact']."', address = '".$_POST['address']."', city = '".$_POST['city']."', state = '".$_POST['state']."', zipcode = '".$_POST['zipcode']."', category = '".getCategoryID($_POST['category'])."', profile_image = '".$target."', hourly_rate = '".$_POST['hourlyrate']."', verified = '".$verifiedStatus."', dbs_number = '".$_POST['number']."', dbs_start_date = '".strtotime($_POST['startdate'])."', dbs_end_date = '".strtotime($_POST['enddate'])."' WHERE id = '".$practitioner['id']."'");
			
			if($updatequery) {
					$message = 'Practitioner details updated successfully.';
			}
			else {
					$error = 'Sorry, an unknown error occurs. Please try again.';
			}
		}
	}
?>

      <!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
        <!-- Content Header (Page header) -->
		   <section class="content-header">
				 <div class="row">
					<div class="col-md-6">
						<div class="content-header">
							<h1>
							Edit Practitioner
							</h1>
						</div> 
					</div>
				</div>
			 
			</section>
		<section class="content" id="edit-brand-page" style="background:#fff;">
			<div class="row">
				<div class="col-md-12">
				  <!-- Horizontal Form -->
					<div class="col-md-6">
						<div class="box box-info">
							<!-- /.box-header -->
							<!-- form start -->
							<?php
								if(isset($error)) {
									print '<p class="alert alert-danger alert-dismissable">'.$error.'</p>';
								}
								else if(isset($message)){
									print '<p class="alert alert-success alert-dismissable">'.$message.'</p>';
								}
							?>
							<form class="form-horizontal" enctype="multipart/form-data" name = "editPractitioner" method = "post" action = "">
							  <div class="box-body">
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-5 contl-label">First Name</label>
									<div class="col-sm-7">
										<input type="text" class="form-control" id="firstname" name="firstname" placeholder="First Name" value="<?php if(isset($_POST['firstname'])){echo $_POST['firstname'];}else{echo $practitioner['firstname'];}?>">
									</div>
								</div>
								<div class="form-group">
									<label for="inputPassword3" class="col-sm-5 contl-label">Last Name</label>
									<div class="col-sm-7">
										<input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last Name"  value="<?php if(isset($_POST['lastname'])) { echo $_POST['lastname']; } else { echo $practitioner['lastname']; } ?>">
									</div>
								</div>
								<div class="form-group">
									<label for="inputPassword3" class="col-sm-5 contl-label">Contact Number</label>
									<div class="col-sm-7">
										<input type="text" class="form-control" name="contact" id="contact" placeholder="Contact Number" value="<?php if(isset($_POST['contact'])) { echo $_POST['contact']; } else { echo $practitioner['phone_no']; } ?>">
									</div>
								</div>
								<div class="form-group">
									<label for="inputPassword3" class="col-sm-5 contl-label">Location</label>
									<div class="col-sm-7">
										<input type="text" class="form-control" name="address" id="address" placeholder="Location" value="<?php if(isset($_POST['address'])) { echo $_POST['address']; } else { echo $practitioner['address']; } ?>">
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-5 contl-label">City</label>
									<div class="col-sm-7">
										<input type="text" class="form-control" id="city" name="city" placeholder="City" value="<?php if(isset($_POST['city'])) { echo $_POST['city']; } else { echo $practitioner['city']; } ?>">
									</div>
								</div>
								<div class="form-group">
									<label for="inputPassword3" class="col-sm-5 contl-label">State</label>
									<div class="col-sm-7">
										<input type="text" class="form-control" name="state" id="state" placeholder="State" value="<?php if(isset($_POST['state'])) { echo $_POST['state']; } else { echo $practitioner['state']; } ?>">
									</div>
								</div>
								<div class="form-group">
									<label for="inputPassword3" class="col-sm-5 contl-label">Postal Code</label>
									<div class="col-sm-7">
										<input type="text" class="form-control" name="zipcode" id="zipcode" placeholder="Zip Code" value="<?php if(isset($_POST['zipcode'])) { echo $_POST['zipcode']; } else { echo $practitioner['zipcode']; } ?>">
									</div>
								</div>
								<div class="form-group">
									<label for="inputPassword3" class="col-sm-5 contl-label">Category</label>
									<div class="col-sm-7">
										<select class="form-control" id="category" name="category"> 
											<?php echo getCategorySelected($categoryName); ?>	  		
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="inputPassword3" class="col-sm-5 contl-label">Hourly Rate</label>
									<div class="col-sm-7">
										<input type="text" class="form-control" name="hourlyrate" id="hourlyrate" placeholder="Hourly Rate" value="<?php if(isset($_POST['hourlyrate'])) { echo $_POST['hourlyrate']; } else { echo $practitioner['hourly_rate']; } ?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-5 contl-label" for="inputEmail3">Upload Practitioner Picture</label>
									<div class="col-sm-7">
										<input type="file" id="profilepic" name="profilepic">
									</div>
								</div>
								<div class="form-group">
									<label for="inputPassword3" class="col-sm-5 contl-label">DBS Number</label>
									<div class="col-sm-7">
										<input type="text" class="form-control" name="number" id="number" placeholder="DBS Number"  value="<?php if(isset($_POST['number'])) { echo $_POST['number']; } else { echo $practitioner['dbs_number']; } ?>">
									</div>
								</div>
								<div class="form-group">
									<label for="inputPassword3" class="col-sm-5 contl-label">DBS start Date</label>
									<div class="col-sm-7">
										<input type="text" class="form-control" name="startdate" 
										id="datepicker1"  placeholder="DBS start Date" value="<?php if(isset($_POST['startdate'])) { echo $_POST['startdate']; } else { echo date('d-m-Y',$practitioner['dbs_start_date']);  } ?>">
										
									</div>
								</div>
								<div class="form-group">
									<label for="inputPassword3" class="col-sm-5 contl-label">DBS end Date</label>
									<div class="col-sm-7">
										<input type="text" class="form-control" name="enddate" 
										id="datepicker2" placeholder="DBS end Date" value="<?php if(isset($_POST['enddate'])) { echo $_POST['enddate']; } else { echo date('d-m-Y',$practitioner['dbs_end_date']);  } ?>">
									</div>
								</div>
								<div class="form-group">
									<label for="inputPassword3" class="col-sm-5 contl-label">Document</label>
									<div class="col-sm-7">
										<label id="label-verified">
											<?php $yesno = (bool)$practitioner['verified']; //1 = true, 0 = false
											$checked = ($yesno) ? 'checked="checked"' : ''; //see ternary operator ?>
											<input type="checkbox" id="verified" value="Verified" name="verified" <?php echo $checked; ?> >Verfied
										</label>
									</div>
								</div>
								<div class="col-md-7 pull-right">
									<div class="box-footer col-md-7">
									<a href="practitioners.php" class="btn btn-default">Cancel</a>
									<button class="btn btn-info pull-right" type="submit" id="save" name="save">Save</button>
									</div>
							  </div>
							  </div><!-- /.box-body -->
							  <!-- /.box-footer -->
							</form>
						</div><!-- /.box -->
					</div>
				  <!-- general form elements disabled -->
				  
				</div><!--/.col (right) -->
			</div>   <!-- /.row -->
        </section>
		</div><!-- /.content-wrapper -->

      <!-- Main Footer -->
      <footer class="main-footer">
        <!-- To the right -->
        <!-- Default to the left -->
        <strong>Copyright &copy; 2015 <a href="#">Qova</a>.</strong> All rights reserved.
      </footer>
      
     

    <!-- REQUIRED JS SCRIPTS -->
		
    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js" type="text/javascript"></script>
   <script src="admin_js/admin_marketpeek.js" type="text/javascript"></script>
		<script src="https://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
		<script src="https://cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.js"></script>

    <!-- Optionally, you can add Slimscroll and FastClick plugins.
          Both of these plugins are recommended to enhance the
          user experience. Slimscroll is required when using the
              <!-- jQuery -->
 <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css">
<script>
$(function() {
$( "#datepicker1" ).datepicker();
$( "#datepicker2" ).datepicker();
});
</script>
          fixed layout. -->
  </body>
</html>
