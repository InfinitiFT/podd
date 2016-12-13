<?php
error_reporting(0);
	include('config/config.php');
	include('admin_functions.php');
	session_start();
	validate_session_admin($_SESSION['uid']);
	include('header.php');
	/*$practitioner = getpractitionerInfo($_REQUEST['practitionerid']);
  $categoryName = getCategoryName($practitioner['category']);*/

  $selectfields =mysql_fetch_assoc(mysql_query("SELECT 'when',days,hours,category FROM qv_requests WHERE id = '".$_REQUEST['appointmentid']."'"));

  print_r($selectfields) ;

/*  print "SELECT when,days,hour,category FROM qv_requests WHERE id = '".$_REQUEST['appointmentid'];*/
  if(isset($_POST['save'])) {
	
			$updatequery = mysql_query("UPDATE qv_requests SET `when` = '".strtotime($_POST['when'])."', `days` = '".$_POST['day']."', `hours` = '".$_POST['hour']."', `category` = '".$_POST['category']."' WHERE `id` = '".$_REQUEST['appointmentid']."'");

			//print_r($_REQUEST['appointmentid']); exit;
			if($updatequery) {
					$message = 'Practitioner details updated successfully.';
			}
			else {
					$error = 'Sorry, an unknown error occurs. Please try again.';
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
							Edit Appointment
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
							<form class="form-horizontal edit-app" name = "editAppointment" method = "post" action = "">
							  <div class="box-body">
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-5 contl-label">When :</label>
									<div class="col-sm-7 date-filed input-append date input-group date">
										<input type="text" class="form-control"id="datetimepicker" name="when" placeholder="">
									</div>
								</div>
								<div class="form-group">
									<label for="inputPassword3" class="col-sm-5 contl-label">How Long :</label>
									<div class="col-sm-7 date-filed2">
									<div>
								<input type="hidden" name="userID" id= "userID" value="<?php echo $_SESSION['LoginUserId']; ?>">
							  <input type="text" class="form-control us-name" id="day" value ="<?php if(isset($_POST['day'])){echo $_POST['day'];}else{echo $selectfields['days'];}?>" name="day">
							</div>
							<div>
							  <input type="text" class="form-control" id="hour" value ="<?php if(isset($_POST['hour'])){echo $_POST['hour'];}else{echo $selectfields['hours'];}?>" name="hour">
							</div>
								</div>
						  </div>
								<div class="form-group">
									<label for="inputPassword3" class="col-sm-5 contl-label">Select Category  :</label>
									<div class="col-sm-7">
										<select class="form-control" name="category" id="category">
								  		<?php echo getCategories(); ?>
										</select>
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
      
     


    
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css">
 <script src="../js/jquery.datetimepicker.js"></script>

 <script type="text/javascript">
	 
 jQuery(document).ready(function () {
jQuery('#datetimepicker').datetimepicker({
dayOfWeekStart : 1,
lang:'en',
disabledDates:['1986/01/08','1986/01/09','1986/01/10'],
//startDate:	'2015/09/01'
});
jQuery('#datetimepicker').datetimepicker({value:'yyyy/MM/dd HH:mm',minDate:0});
            });
        </script>
          fixed layout. -->
  </body>
</html>
