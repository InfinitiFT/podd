<?php
	ob_start();
	include('config/config.php');
	include('admin_functions.php');
	session_start();
	validate_session_admin($_SESSION['admin_uid']);
	include('header.php');
	
	if(isset($_REQUEST['page'])) {
		$pagelist = getPageListSelected($_REQUEST['page']);
	}
	else {
		$pagelist = getPageList();
	}
	
	if(isset($_POST['save'])) {
		if(empty($_POST['copyright'])){
		    $error = 'Copyright message required';
	    }
	    else {
	        // Updating Copyright						
			mysql_query("UPDATE copyright SET message = '".$_POST['copyright']."' WHERE ID = 1 ");
			header('Location: '.$_REQUEST['page']);
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
							Add copyright
							</h1>
						</div> 
					</div>
					<div class="col-md-1 pull-right">
						<a class="btn  btn-primary btn-md pull-right clearfix btn-sm" href="add_risks.php?page=risks.php">Add Risk</a>
					</div>
				</div>
			</section>
		<section class="content" style="background:#fff;">
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
							
							<form class="form-horizontal" name="addCopyright" method="post" action="">
							    <div class="box-body">
																
									<div class="form-group">
										<label class="col-sm-4 contl-label">Add Copyright Message</label>
										<div class="col-sm-8">
											<input type="text" name="copyright" value="" class="form-control">
										</div>
									</div>
								
									<div class="col-md-4 pull-right">
										<div class="box-footer">
										    <a href="<?php echo $_REQUEST['page']; ?>" class="btn btn-default">Cancel</a>
										    <button class="btn btn-info pull-right" type="submit" id="save" name="save">Save</button>
										</div>
								    </div>
							    </div>
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
        <strong>Copyright &copy; 2015 <a href="#">marketPeek</a>.</strong> All rights reserved.
      </footer>
      
     

    <!-- REQUIRED JS SCRIPTS -->
		
    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js" type="text/javascript"></script>
		<script src="https://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
		<script src="https://cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.js"></script>

		<script>
			$(document).ready(function() {
				$('#brandtab').dataTable();
			} );

		</script>
    <!-- Optionally, you can add Slimscroll and FastClick plugins.
          Both of these plugins are recommended to enhance the
          user experience. Slimscroll is required when using the
          fixed layout. -->
  </body>
</html>
