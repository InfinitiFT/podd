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
							Transaction Error
							</h1>
						</div>
						</div>						
						<div class="col-md-6 pull-right">
						<a class="btn  btn-primary btn-md pull-right clearfix btn-sm" href="notTransferd.php" >Back</a>
					</div>
				</div>
					<div class="box">
						<div class="box-body">
							<div class="dataTables_wrapper form-inline dt-bootstrap" id="example1_wrapper">
								<div class="row" id="practitionerlistsction">
									<div class="col-sm-12">
										<p>Something Went Wrong with transfer ! Please Try Again.</p>
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
      
      <!-- Confirmation Popup -->
      <div class="modal" id="confirm">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
							<h4 class="modal-title">Confirmation</h4>
						</div>
						<div class="modal-body">
							<p>Are you sure want to remove it?</p>
						</div>
						<div class="modal-footer">
							<button data-dismiss="modal" class="btn btn-default pull-left" type="button">No</button>
							<button class="btn btn-primary" type="button" id="adminRemovePractitioner">Yes</button>
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
    <script src="admin_js/block_unblock.js" type="text/javascript"></script>
		<script src="https://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
		<script src="https://cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.js"></script>

		<script>
			$(document).ready(function() {
				$('#practitionertab').dataTable();
			} );

		</script>
    <!-- Optionally, you can add Slimscroll and FastClick plugins.
          Both of these plugins are recommended to enhance the
          user experience. Slimscroll is required when using the
          fixed layout. -->
  </body>
</html>
