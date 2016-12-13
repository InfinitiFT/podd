<?php
	include('config/config.php');
	include('admin_functions.php');
	session_start();
	validate_session_admin($_SESSION['uid']);
	include('header.php');
	$requestData = mysql_fetch_assoc(mysql_query("SELECT * FROM qv_requests WHERE id = '".$_REQUEST['appointmentid']."'"));
	$companyData = getID($requestData['user_id']);
	$company = getcompanyInfo($companyData['id']);
	if($requestData['status'] == 'Accepted') {
		$practitioners = explode(',', $requestData['practitioner_id']);
		$practitionerIDs = array_unique($practitioners);
		foreach($practitionerIDs as $ids) {
			$practitionerData = getID($ids);
			$practitioner = getpractitionerInfo($practitionerData['id']);
			if(empty($practitionerName)) {
				$practitionerName = $practitioner['firstname'];
			}
			else {
				$practitionerName = $practitionerName.', '.$practitioner['firstname'];
			}
		}
	}
	else if($requestData['status'] == 'Send') {
		$practitionerName = '';
	}
	else {
		$practitionerData = getID($requestData['practitioner_id']);
		$practitioner = getpractitionerInfo($practitionerData['id']);
		$practitionerName = $practitioner['firstname'];
	}
	$category = getCategoryName($requestData['category']);
	if($requestData['days']!=1 &&$requestData['hours']!=1)
		$howLong = $requestData['days'].' Days '.$requestData['hours'].' Hours';
	elseif($requestData['days']==1 &&$requestData['hours']==1)
		$howLong = $requestData['days'].' Day '.$requestData['hours'].' Hour';
	elseif($requestData['days']!=1 &&$requestData['hours']==1){
		$howLong = $requestData['days'].' Days '.$requestData['hours'].' Hour';
		}
	elseif($requestData['days']==1 &&$requestData['hours']!=1){
		$howLong = $requestData['days'].' Day '.$requestData['hours'].' Hours';
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
							Appointment Details
							</h1>
						</div> 
					</div>
				</div>
         <input type="hidden" id="loggedin" value="<?php //echo $_SESSION['uid']; ?>">
          <input type="hidden" id="roleid" value="<?php //echo $_SESSION['roleID']; ?>">
					<div class="box" id="appointment-detail-page">
						<div class="box-body">
							<div class="dataTables_wrapper form-inline dt-bootstrap" id="example1_wrapper">
								<div class="row">
									<div class="col-md-4">
										<div class="main-strut">
											<div class="inner clearfix">
												<div class="box-body">
                  <div class="table-responsive">
                    <table class="table no-margin table-bordered">
                      
                      <tbody>
                        <tr>
                          <td>Company Name</td>
                          <td><?php echo $company['name']; ?></td>
                        </tr>
                        <tr>
                          <td>Practitioner</td>
                          <td><?php echo $practitionerName; ?></td>
                        </tr>
                        <tr>
                          <td>Category</td>
                          <td><?php echo $category; ?></td>
                        </tr>
                        <tr>
                          <td>When</td>
                          <td><?php echo date("d/m/Y", $requestData['when']); ?></td>
                        </tr>
                        <tr>
                          <td>How Long</td>
                          <td><?php echo $howLong; ?></td>
                        </tr>
                        <tr>
                          <td>Status</td>
                          <td><?php echo $requestData['status']; ?></td>
                        </tr>
                      </tbody>
                    </table>
                  </div><!-- /.table-responsive -->
                </div>
                <div class="col-md-1 pull-right">
									<a class="btn btn-primary btn-md clearfix btn-sm" href="appointments.php">Back</a>
								</div>
												
								
                  
												
											</div>
										</div>
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
