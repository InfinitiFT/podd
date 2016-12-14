<?php
	include('config/config.php');
	include('admin_functions.php');
	session_start();
	validate_session_admin($_SESSION['uid']);
	include('header.php');
	$company = getcompanyInfo($_REQUEST['companyid']);
  if(isset($_POST['save'])) {
		
		if(empty($_POST['companyname'])){
			$error = 'Company Name is required';
		}
		else if(!is_numeric($_POST['contact'])) {
			$error = 'Contact number must be numeric';
		}
		else {
			if (!empty($_FILES["profilepic"]["name"])) {
				$file_name=$_FILES["profilepic"]["name"];
				$temp_name=$_FILES["profilepic"]["tmp_name"];
				$rand = rand();
				$imgname = 'qova-'.$rand.'.jpeg';
				$target = 'images/company/'.$imgname;
				$status = move_uploaded_file($temp_name, '../'.$target);
			}
			else {
				$target = $company['profile_image'];
			}
			
			$updatequery = mysql_query("UPDATE qv_company SET name = '".$_POST['companyname']."', contact_person = '".$_POST['contactperson']."', phone = '".$_POST['contact']."', address = '".$_POST['address']."', city = '".$_POST['city']."', state = '".$_POST['state']."', zip = '".$_POST['zipcode']."', profile_image = '".$target."' WHERE id = '".$company['id']."'");
			
			if($updatequery) {
					$message = 'Company details updated successfully.';
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
							Edit Company
							</h1>
						</div> 
					</div>
				</div>
			 
			</section>
		<section class="content" id="edit-company-page" style="background:#fff;">
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
							<form class="form-horizontal" enctype="multipart/form-data" name = "editCompany" method = "post" action = "">
							  <div class="box-body">
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-5 contl-label">Company Name</label>
									<div class="col-sm-7">
										<input type="text" class="form-control" id="companyname" name="companyname" placeholder="Company Name" value="<?php if(isset($_POST['companyname'])) { echo $_POST['companyname']; } else { echo $company['name']; } ?>">
									</div>
								</div>
								<div class="form-group">
									<label for="inputPassword3" class="col-sm-5 contl-label">Contact Person</label>
									<div class="col-sm-7">
										<input type="text" class="form-control" id="contactperson" name="contactperson" placeholder="Contact Person"  value="<?php if(isset($_POST['contactperson'])) { echo $_POST['contactperson']; } else { echo $company['contact_person']; } ?>">
									</div>
								</div>
								<div class="form-group">
									<label for="inputPassword3" class="col-sm-5 contl-label">Contact Number</label>
									<div class="col-sm-7">
										<input type="text" class="form-control" name="contact" id="contact" placeholder="Contact Number" value="<?php if(isset($_POST['contact'])) { echo $_POST['contact']; } else { echo $company['phone']; } ?>">
									</div>
								</div>
								<div class="form-group">
									<label for="inputPassword3" class="col-sm-5 contl-label">Location</label>
									<div class="col-sm-7">
										<input type="text" class="form-control" name="address" id="address" placeholder="Location" value="<?php if(isset($_POST['address'])) { echo $_POST['address']; } else { echo $company['address']; } ?>">
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-5 contl-label">City</label>
									<div class="col-sm-7">
										<input type="text" class="form-control" id="city" name="city" placeholder="City" value="<?php if(isset($_POST['city'])) { echo $_POST['city']; } else { echo $company['city']; } ?>">
									</div>
								</div>
								<div class="form-group">
									<label for="inputPassword3" class="col-sm-5 contl-label">State</label>
									<div class="col-sm-7">
										<input type="text" class="form-control" name="state" id="state" placeholder="State" value="<?php if(isset($_POST['state'])) { echo $_POST['state']; } else { echo $company['state']; } ?>">
									</div>
								</div>
								<div class="form-group">
									<label for="inputPassword3" class="col-sm-5 contl-label">Postal Code</label>
									<div class="col-sm-7">
										<input type="text" class="form-control" name="zipcode" id="zipcode" placeholder="Zip Code" value="<?php if(isset($_POST['zipcode'])) { echo $_POST['zipcode']; } else { echo $company['zip']; } ?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-5 contl-label" for="inputEmail3">Upload Company Picture</label>
									<div class="col-sm-7">
										<input type="file" id="profilepic" name="profilepic">
									</div>
								</div>
								<div class="col-md-4 pull-right">
									<div class="box-footer">
									<a href="companies.php" class="btn btn-default">Cancel</a>
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
          fixed layout. -->
  </body>
</html>
