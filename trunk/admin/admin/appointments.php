<?php
    error_reporting(0);
	 include('config/config.php');
	 include('admin_functions.php');
	session_start();
	validate_session_admin($_SESSION['uid']);
	include('header.php');
	
	 if(isset($_POST['submit'])) {
		
	 	$password = mysql_fetch_assoc(mysql_query("SELECT password as delpass from qv_password"));
	 	
	 	//echo $password['delpass'].' ==='.md5($_POST['password']);

	 	if( $password['delpass'] == md5($_POST['password']) ){
	 		$deletequery = mysql_query("DELETE FROM qv_requests  WHERE id ='". $_POST['appid']."'");
	 			if($deletequery){
	 				$message= "Record Deleted succesfully";
	 			}
	 			else{
	 				$error= "Error in deletion";
	 			}
	 	}
	 	else{
	 		$error = "Password donot match";
	 	}
		//$deletequery = mysql_query(");

			
	}
	
	if(isset($_POST['cancel'])) {
		
	 	$password = mysql_fetch_assoc(mysql_query("SELECT password as delpass from qv_password"));

	 	if( $password['delpass'] == md5($_POST['password']) ){
			
		mysql_query("DELETE FROM qv_notifications WHERE request_id = '".$_POST['appid']."'");
		mysql_query("DELETE FROM qv_verification WHERE request_id = '".$_POST['appid']."'");
		mysql_query("DELETE FROM qv_transactions WHERE request_id = '".$_POST['appid']."'");
		mysql_query("UPDATE qv_requests SET status = 'Cancelled' WHERE id = '".$_POST['appid']."'");
		
		
	 		//$deletequery = mysql_query("DELETE FROM qv_requests  WHERE id ='". $_POST['appid']."'");
	 			
	 				$message= "Appointment Cancelled succesfully";

	 	}
	 	else{
	 		$error = "Password donot match";
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
							Appointments
							</h1>
						</div> 
					</div>
				</div>
					<div class="box">
							<?php
								if(isset($error)) {
									print '<p class="alert alert-danger alert-dismissable">'.$error.'</p>';
								}
								else if(isset($message)){
									print '<p class="alert alert-success alert-dismissable">'.$message.'</p>';
								}
							?>
						<div class="box-body">
							<div class="dataTables_wrapper form-inline dt-bootstrap" id="example1_wrapper">
								<div class="row" id="appointmentlistsection">
									<div class="col-sm-12">
										<table class="table " id="appointmenttab">
											<thead>
												<tr>
													<th>Company Name</th>
													<th>Practitioner</th>
													<th>Category</th>
													<th>When</th>
													<th>How Long</th>
													<th>Created Date</th>
													<th>Status</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<?php echo appointments(); ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						 </div><!-- /.box-body -->
            </div>
        </section>
      </div><!-- /.content-wrapper -->

       <!-- Main Footer -->
      <footer class="main-footer">
        <!-- To the right -->
        <!-- Default to the left -->
        <strong>Copyright &copy; 2015 <a href="#">Qova</a>.</strong> All rights reserved.
      </footer>
      
      <!-- Delete Popup -->
      <div class="modal" id="confirm">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
							<h4 class="modal-title">Confirmation</h4>
						</div>
						<form class="form-horizontal" name = "deleteAppoint" method = "post" action ="" >
						<div class="modal-body">
							<p>Enter Password : </p>
							<input type="password" class="form-control" id="pass" name="password" placeholder="">
							<input type="hidden" class="form-control" id="appid" name="appid" >
						</div>
						<div class="modal-footer">
							<button data-dismiss="modal" class="btn btn-default pull-left" type="button">No</button>
							<button class="btn btn-primary" type="submit" id="matchappointment" name="submit" >Submit</button>
						</div>
						</form>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div>
			
			  <!-- Cancel Popup -->
      <div class="modal" id="cancel">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
							<h4 class="modal-title">Confirmation</h4>
						</div>
						<form class="form-horizontal" name = "cancelAppoint" method = "post" action ="" >
						<div class="modal-body">
							<p>Enter Password : </p>
							<input type="password" class="form-control" id="pass" name="password" placeholder="">
							<input type="hidden" class="form-control" id="requestID" name="appid" >
						</div>
						<div class="modal-footer">
							<button data-dismiss="modal" class="btn btn-default pull-left" type="button">No</button>
							<button class="btn btn-primary" type="submit" id="cancelappointment" name="cancel" >Submit</button>
						</div>
						</form>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div>
			
		<!-- Confirmation Popup for complete -->
      <div class="modal" id="confirm1">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
							<h4 class="modal-title">Confirmation</h4>
						</div>
						
						<div class="modal-body">
							<p>Do you want to Complete this Service ? </p>
						</div>
						<div class="modal-footer">
							<button data-dismiss="modal" class="btn btn-default pull-left" type="button">No</button>
							<button class="btn btn-primary" type="button" id="completeService" name="complete" >Yes</button>
						</div>
						
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div>

    <!-- REQUIRED JS SCRIPTS -->
		
    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js" type="text/javascript"></script>
    <script src="admin_js/admin_qova.js" type="text/javascript"></script>
		<script src="https://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
		<script src="https://cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.js"></script>

		<script>
			$(document).ready(function() {
				$('#appointmenttab').dataTable();
			} );

		</script>
    <!-- Optionally, you can add Slimscroll and FastClick plugins.
          Both of these plugins are recommended to enhance the
          user experience. Slimscroll is required when using the
          fixed layout. -->
  </body>
</html>
