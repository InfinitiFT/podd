<?php
	include('config/config.php');
	include('admin_functions.php');
	session_start();
	validate_session_admin($_SESSION['uid']);
	include('header.php');
	
?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
       <section class="content-header">
				  <div class="row">
					<div class="col-md-6">
						<div class="content-header">
							<h1>
							Review List
							</h1>
						</div> 
					</div>
					<div class="col-md-6 pull-right">
						<a class="btn  btn-primary btn-md pull-right clearfix btn-sm" href="practitioner_detail.php?practitionerid=<?php echo $_REQUEST['practitionerid'];?>" >Back</a>
					</div>
				</div>
				
					<div class="box">
						<div class="box-body">
							<div class="dataTables_wrapper form-inline dt-bootstrap" id="example1_wrapper">
								<div class="row" id="reviewlistsction">
									<div class="col-sm-12">
										<table class="table " id="reviewtab">
											<thead>
												<tr>
													<th>Company Name</th>
													<th>Ratings</th>
													<th>Reviews</th>
													<th>Date</th>
												</tr>
											</thead>
											<tbody>
												<?php echo reviews($_REQUEST['practitionerid']); ?>
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

		<script>
			$(document).ready(function() {
				$('#reviewtab').dataTable();
			} );

		</script>
    <!-- Optionally, you can add Slimscroll and FastClick plugins.
          Both of these plugins are recommended to enhance the
          user experience. Slimscroll is required when using the
          fixed layout. -->
  </body>
</html>
