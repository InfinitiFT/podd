<?php
	include('config/config.php');
	include('admin_functions.php');
	session_start();
	validate_session_admin($_SESSION['uid']);
	include('header.php');
	$company = getcompanyInfo($_REQUEST['companyid']);
?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
       <section class="content-header">
				 <div class="row">
					<div class="col-md-6">
						<div class="content-header">
							<h1>
							Company Details
							</h1>
						</div> 
					</div>
				</div>
         <input type="hidden" id="loggedin" value="<?php //echo $_SESSION['uid']; ?>">
          <input type="hidden" id="roleid" value="<?php //echo $_SESSION['roleID']; ?>">
					<div class="box" id="company-detail-page">
						<div class="box-body">
							<div class="dataTables_wrapper form-inline dt-bootstrap" id="example1_wrapper">
								<div class="row">
									<div class="col-md-4">
										<div class="main-strut">
											<div class="inner clearfix">
												<div class="image-detail"><img src="<?php echo url().$company['profile_image']; ?>"></div>
												<div class="box-body">
                  <div class="table-responsive">
                    <table class="table no-margin table-bordered">
                      
                      <tbody>
                        <tr>
                          <td>Company Name</td>
                          <td><?php echo $company['name']; ?></td>
                        </tr>
                        <tr>
                          <td>Contact Person</td>
                          <td><?php echo $company['contact_person']; ?></td>
                        </tr>
                         <tr>
                          <td>Email</td>
                          <td><?php echo $company['email']; ?></td>
                        </tr>
                        <tr>
                          <td>Registration Date</td>
                          <td><?php echo date('d/m/Y',$company['created_date']); ?></td>
                        </tr>
                        <tr>
                          <td>Contact Number</td>
                          <td><?php echo $company['phone']; ?></td>
                        </tr>
                        <tr>
                          <td>Location</td>
                          <td><?php echo $company['address']; ?></td>
                        </tr>
                        <tr>
                          <td>City</td>
                          <td><?php echo $company['city']; ?></td>
                        </tr>
                        <tr>
                          <td>State</td>
                          <td><?php echo $company['state']; ?></td>
                        </tr>
                        <tr>
                          <td>Postal Code</td>
                          <td><?php echo $company['zip']; ?></td>
                        </tr>
                      </tbody>
                    </table>
                  </div><!-- /.table-responsive -->
                </div>
                <div class="padd-l-r-10">
									<a class="btn btn-primary btn-md pull-right clearfix btn-sm" href="companies.php">Back</a>
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
