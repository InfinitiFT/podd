<?php
	include('config/config.php');
	include('admin_functions.php');
	session_start();
	validate_session_admin($_SESSION['uid']);
	include('header.php');
	$practitioner = getpractitionerInfo($_REQUEST['practitionerid']);
	
?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
       <section class="content-header">
				 <div class="row">
					<div class="col-md-6">
						<div class="content-header">
							<h1>
							Practitioner Details
							</h1>
						</div> 
					</div>
					<div class="col-md-6">
						<a class="btn  btn-primary btn-md pull-right  btn-sm " href="reviews.php?practitionerid=<?php echo $_REQUEST['practitionerid']; ?>">Review and Rating</a>
						<a class="btn  btn-primary btn-md pull-right btn-sm m-r-10" href="myEarning.php?practitionerid=<?php echo $_REQUEST['practitionerid']; ?>">Earnings</a>
					</div>
				</div>
         <input type="hidden" id="loggedin" value="<?php //echo $_SESSION['uid']; ?>">
          <input type="hidden" id="roleid" value="<?php //echo $_SESSION['roleID']; ?>">
					<div class="box" id="practitioner-detail-page">
						<div class="box-body">
							<div class="dataTables_wrapper form-inline dt-bootstrap" id="example1_wrapper">
								<div class="row">
									<div class="col-md-6">
										<div class="main-strut">
											<div class="inner clearfix">
												<div class="image-detail"><img src="<?php echo url().$practitioner['profile_image']; ?>"></div>
												<div class="box-body">
                  <div class="table-responsive">
                    <table class="table no-margin table-bordered">
                      
                      <tbody>
                        <tr>
                          <td>First Name</td>
                          <td><?php echo $practitioner['firstname']; ?></td>
                         
                        </tr>
                        <tr>
                          <td>Last Name</td>
                          <td><?php echo $practitioner['lastname']; ?></td>
                          
                        </tr>
                        <tr>
                          <td>Email</td>
                          <td><?php echo $practitioner['email']; ?></td>
                        </tr>
                        <tr>
                          <td>Registration Date</td>
                          <td><?php echo date('d/m/Y',$practitioner['created_date']); ?></td>
                        </tr>
                        <tr>
                          <td>Contact Number</td>
                          <td><?php echo $practitioner['phone_no']; ?></td>
                          
                        </tr>
                        <tr>
                          <td>Location</td>
                          <td><?php echo $practitioner['address']; ?></td>
                          
                        </tr>
                        <tr>
                          <td>City</td>
                          <td><?php echo $practitioner['city']; ?></td>
                          
                        </tr>
                        <tr>
                          <td>State</td>
                          <td><?php echo $practitioner['state']; ?></td>
                          
                        </tr>
                        <tr>
                          <td>Postal Code</td>
                          <td><?php echo $practitioner['zipcode']; ?></td>
                          
                        </tr>
												<tr>
                          <td>Category</td>
                          <td><?php echo getCategoryName($practitioner['category']); ?></td>
                          
                        </tr>
												<tr>
                          <td>Hourly Rate</td>
                          <td><?php echo $practitioner['hourly_rate']; ?></td>
                          
                        </tr>
                         </tr>
												<tr>
                          <td>DBS Number</td>
                          <td><?php echo $practitioner['dbs_number']; ?></td>
                          
                        </tr>
                         </tr>
												<tr>
                          <td>DBS Start Date</td>
                          <td><?php if(!empty($practitioner['dbs_start_date'])) { echo date('d-m-Y',$practitioner['dbs_start_date']); } ?></td>
                          
                        </tr>
                         </tr>
												<tr>
                          <td>DBS End Date</td>
                          <td><?php if(!empty($practitioner['dbs_end_date'])) { echo date('d-m-Y',$practitioner['dbs_end_date']); } ?></td>
                          
                        </tr>
						
                      </tbody>
                    </table>
                  </div><!-- /.table-responsive -->
                </div>
                <div class="col-md-9 pull-right">
									<a class="btn btn-warning btn-md btn-sm" href="view_documents.php?practitionerid=<?php echo $_REQUEST['practitionerid'];?>">View Document</a>
									<a class="btn btn-primary btn-md clearfix btn-sm" href="practitioners.php">Back</a>
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
