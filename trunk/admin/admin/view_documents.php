<?php
	include('config/config.php');
	include('admin_functions.php');
	//include('timthumb.php');
	session_start();
	validate_session_admin($_SESSION['uid']);
	include('header.php');
	$document = array();
	$practitioner = getpractitionerInfo($_REQUEST['practitionerid']);
	$document = explode(',',$practitioner['document']);
	$i = 0;
	$content = '';
	foreach($document as $doc) {
		$url = url().$doc;
		$content .= ' <tr>
										<td><img src="timthumb.php?src='.$url.'&h=80&w=80"></td>
										<td><a href="'.url().$doc.'" download>Download</a></td>
                  </tr>';
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
							View Documents
							</h1>
						</div> 
					</div>
				</div>
         <input type="hidden" id="loggedin" value="<?php //echo $_SESSION['uid']; ?>">
          <input type="hidden" id="roleid" value="<?php //echo $_SESSION['roleID']; ?>">
					<div class="box" id="practitioner-detail-page">
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
                        <?php echo $content; ?>
                      </tbody>
                    </table>
                  </div><!-- /.table-responsive -->
                </div>
                <div class="col-md-12">
									<a class="btn btn-primary btn-md pull-right clearfix btn-sm" href="practitioner_detail.php?practitionerid=<?php echo $_REQUEST['practitionerid']; ?>">Back</a>
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
