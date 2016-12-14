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
							Users
							</h1>
						</div> 
					<form name="form1" method="post" action="send.php">
					</div>
					<div class="pull-right">
							<button class="btn btn-warning" data-toggle="modal" data-target="#confirm" type="button" id="sendmail">Send Mail</button>
					</div>
				</div>
					<div class="box">
						<div class="box-body">
							<div class="dataTables_wrapper form-inline dt-bootstrap" id="example1_wrapper">
								<div class="row" id="practitionerlistsction">
									<div class="col-sm-12">
										<table id="usertab" class="table" cellspacing="0" width="100%">
											<thead>
												<tr>
												<div class="col-sm-6">
												<label>Select Type </label>
												<select class="form-control" id="type">
												
												<option <?php if(isset($_REQUEST['type'])){if($_REQUEST['type'] == 0) echo "selected"; }?> value="0" >All</option>
												<option <?php if(isset($_REQUEST['type'])){if($_REQUEST['type'] == 1) echo "selected"; }?> value="1">Practioners</option>
												<option <?php if(isset($_REQUEST['type'])){if($_REQUEST['type'] == 2) echo "selected"; }?> value="2">Company</option>
												</select>
												</div>
												<?php if(isset($_REQUEST['type']) &&  $_REQUEST['type'] == 1) { ?>
												<div id="sel-prac">
												<label>Select Practioners Category </label>
												<select class="form-control" id="category">
												<option value="">-Select-</option>
												<option <?php if(isset($_REQUEST['catID'])){if( $_REQUEST['catID'] == 0) echo "selected"; }?> value="0">All Practioners</option>
												<option <?php if(isset($_REQUEST['catID'])){if($_REQUEST['catID'] == 1) echo "selected"; }?> value="1">Nursery</option>
												<option <?php if(isset($_REQUEST['catID'])){if($_REQUEST['catID'] == 2) echo "selected"; }?> value="2">CareHome</option>
												</select>
												</div>
												<?php } ?>
												<br>
												 <th><input type='checkbox' onchange='checkAll(this)' name='chk'/></th>
													<th>Name (Company/Practioners)</th>
													<th>Contact Number</th>
													<th>Location</th>
													<th>Registered Date</th>
												</tr>
											</thead>
											<tbody>
												<?php echo usermail(); ?>
											</tbody>
										</table>
										<input type="hidden" id="baseurl" value="<?php echo url(); ?>">
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
							<h4 class="modal-title">Send Mail</h4>
						</div>
						<div class="modal-body">
						<p>Subject : <input type="text" name="subject" value="" /></p>
						<p>Message : <textarea name="message" cols="80" rows="4"></textarea></p>
							
						</div>
						<div class="modal-footer">
							<button data-dismiss="modal" class="btn btn-default pull-left" type="button">No</button>
								<input type='submit' class="btn btn-default" name='submit' value='SUBMIT'/>
						</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div>
		</form>	
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
	<script>// <![CDATA[

	function checkAll(ele) {
		var checkboxes = document.getElementsByTagName('input');
		if (ele.checked) {
			 for (var i = 0; i < checkboxes.length; i++) {
				 if (checkboxes[i].type == 'checkbox') {
					 checkboxes[i].checked = true;
				 }
			 }
		} else {
			 for (var i = 0; i < checkboxes.length; i++) {
				 console.log(i)
				 if (checkboxes[i].type == 'checkbox') {
					 checkboxes[i].checked = false;
				 }
			 }
		}
	}

	/*$(document).ready(function() {
		$('#usertab').dataTable({
     "order": []
    });
	} );*/


	$("#type").change(function () {
        var end = this.value;
        var firstDropVal = $('#type').val();
        var baseurl = $('#baseurl').val();
        var option = $(this).find('option:selected').val();
        window.location.replace(baseurl+"admin/user_mail.php?type="+firstDropVal);

    });

	 $("#category").change(function () {
	        var end = this.value;
	        var DropVal = $('#category').val();
	        var baseurl = $('#baseurl').val();
	        window.location.replace(baseurl+"admin/user_mail.php?type=1&catID="+DropVal);
	    });
	


	</script>
   
  </body>
</html>
