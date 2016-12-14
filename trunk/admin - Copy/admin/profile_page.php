<?php
	 include('config/config.php');
	 include('admin_functions.php');
	 session_start();
	 validate_session_admin($_SESSION['uid']);
	 include('header.php');
	 $user = user_load($_SESSION['uid']);
	 $categoryQuery = mysql_query("SELECT * FROM promoteruser WHERE promoterid = '".$_SESSION['uid']."'");
	$category = mysql_fetch_assoc($categoryQuery);
?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
       <section class="content-header">
				 <div class="row">
					<div class="col-md-6">
						<div class="content-header">
							<h1>
							Profile Details & Permissions
							</h1>
						</div> 
					</div>
					<div class="col-md-1 pull-right">
						<a class="btn  btn-primary btn-md pull-right clearfix btn-sm" href="add_risks.php?page=profile_page.php?userid=<?php echo $user['userid']; ?>">Add Risk</a>
					</div>
				</div>
         
					<div class="box">
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
                          <td>First Name</td>
                          <td><?php echo $user['firstname']; ?></td>
                         
                        </tr>
                        <tr>
                          <td>Last Name</td>
                          <td><?php echo $user['lastname']; ?></td>
                          
                        </tr>
                        <tr>
                          <td>Email Address</td>
                          <td><?php echo $user['email']; ?></td>
                          
                        </tr>
                      </tbody>
                    </table>
                    
                  </div><!-- /.table-responsive -->
                </div>
		
											</div>
										</div>	
									</div>
								</div>
								<div class="box-body col-md-6">		
									<div class="col-md-12">
										<div class="col-sm-8 pull-right">
											<div class="form-group">
												<label>
													<?php $yesno = (bool)$category['brand_view']; //1 = true, 0 = false
													$checked = ($yesno) ? 'checked="checked"' : ''; //see ternary operator ?>
													<input type="checkbox" id="brandview" value="Brand View"  name="promoterRights[]" <?php echo $checked; ?> >Brand View
												</label>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="col-sm-8 pull-right">
											<div class="form-group">
												<label>
													<?php $yesno = (bool)$category['brand_edit']; //1 = true, 0 = false
													$checked = ($yesno) ? 'checked="checked"' : ''; //see ternary operator ?>
													<input type="checkbox" id="brandedit" value="Brand Edit" name="promoterRights[]" <?php echo $checked; ?> >Brand Edit
												</label>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="col-sm-8 pull-right">
											<div class="form-group">
												<label>
													<?php $yesno = (bool)$category['brand_publish']; //1 = true, 0 = false
													$checked = ($yesno) ? 'checked="checked"' : ''; //see ternary operator ?>
													<input type="checkbox" id="brandpublish" value="Brand Publish"  name="promoterRights[]" <?php echo $checked; ?> >Brand Publish
												</label>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="col-sm-8 pull-right">
											<div class="form-group">
												<label>
													<?php $yesno = (bool)$category['brand_delete']; //1 = true, 0 = false
													$checked = ($yesno) ? 'checked="checked"' : ''; //see ternary operator ?>
													<input type="checkbox" id="branddelete" value="Brand Delete" name="promoterRights[]" <?php echo $checked; ?> >Brand Delete
												</label>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="col-sm-8 pull-right">
											<div class="form-group">
												<label>
													<?php $yesno = (bool)$category['product_view']; //1 = true, 0 = false
													$checked = ($yesno) ? 'checked="checked"' : ''; //see ternary operator ?>
													<input type="checkbox" id="productview" value="Product View"  name="promoterRights[]" <?php echo $checked; ?> >Product View
												</label>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="col-sm-8 pull-right">
											<div class="form-group">
												<label>
													<?php $yesno = (bool)$category['product_edit']; //1 = true, 0 = false
													$checked = ($yesno) ? 'checked="checked"' : ''; //see ternary operator ?>
													<input type="checkbox" id="productedit" value="Product Edit" name="promoterRights[]" <?php echo $checked; ?> >Product Edit
												</label>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="col-sm-8 pull-right">
											<div class="form-group">
												<label>
													<?php $yesno = (bool)$category['product_publish']; //1 = true, 0 = false
													$checked = ($yesno) ? 'checked="checked"' : ''; //see ternary operator ?>
													<input type="checkbox" id="productpublish" value="Product Publish"  name="promoterRights[]" <?php echo $checked; ?> >Product Publish
												</label>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="col-sm-8 pull-right">
											<div class="form-group">
												<label>
													<?php $yesno = (bool)$category['product_delete']; //1 = true, 0 = false
													$checked = ($yesno) ? 'checked="checked"' : ''; //see ternary operator ?>
													<input type="checkbox" id="productdelete" value="Product Delete" name="promoterRights[]" <?php echo $checked; ?> >Product Delete
												</label>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="col-sm-8 pull-right">
											<div class="form-group">
												<label>
													<?php $yesno = (bool)$category['service_view']; //1 = true, 0 = false
													$checked = ($yesno) ? 'checked="checked"' : ''; //see ternary operator ?>
													<input type="checkbox" id="serviceview" value="Service View"  name="promoterRights[]" <?php echo $checked; ?> >Service View
												</label>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="col-sm-8 pull-right">
											<div class="form-group">
												<label>
													<?php $yesno = (bool)$category['service_edit']; //1 = true, 0 = false
													$checked = ($yesno) ? 'checked="checked"' : ''; //see ternary operator ?>
													<input type="checkbox" id="serviceedit" value="Service Edit" name="promoterRights[]" <?php echo $checked; ?> >Service Edit
												</label>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="col-sm-8 pull-right">
											<div class="form-group">
												<label>
													<?php $yesno = (bool)$category['service_publish']; //1 = true, 0 = false
													$checked = ($yesno) ? 'checked="checked"' : ''; //see ternary operator ?>
													<input type="checkbox" id="servicepublish" value="Service Publish"  name="promoterRights[]" <?php echo $checked; ?> >Service Publish
												</label>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="col-sm-8 pull-right">
											<div class="form-group">
												<label>
													<?php $yesno = (bool)$category['service_delete']; //1 = true, 0 = false
													$checked = ($yesno) ? 'checked="checked"' : ''; //see ternary operator ?>
													<input type="checkbox" id="servicedelete" value="Service Delete" name="promoterRights[]" <?php echo $checked; ?> >Service Delete
												</label>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="col-sm-8 pull-right">
											<div class="form-group">
												<label>
													<?php $yesno = (bool)$category['store_view']; //1 = true, 0 = false
													$checked = ($yesno) ? 'checked="checked"' : ''; //see ternary operator ?>
													<input type="checkbox" id="storeview" value="Store View"  name="promoterRights[]" <?php echo $checked; ?> >Store View
												</label>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="col-sm-8 pull-right">
											<div class="form-group">
												<label>
													<?php $yesno = (bool)$category['store_edit']; //1 = true, 0 = false
													$checked = ($yesno) ? 'checked="checked"' : ''; //see ternary operator ?>
													<input type="checkbox" id="storeedit" value="Store Edit" name="promoterRights[]" <?php echo $checked; ?> >Store Edit
												</label>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="col-sm-8 pull-right">
											<div class="form-group">
												<label>
													<?php $yesno = (bool)$category['store_publish']; //1 = true, 0 = false
													$checked = ($yesno) ? 'checked="checked"' : ''; //see ternary operator ?>
													<input type="checkbox" id="storepublish" value="Store Publish"  name="promoterRights[]" <?php echo $checked; ?> >Store Publish
												</label>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="col-sm-8 pull-right">
											<div class="form-group">
												<label>
													<?php $yesno = (bool)$category['newproduct_view']; //1 = true, 0 = false
													$checked = ($yesno) ? 'checked="checked"' : ''; //see ternary operator ?>
													<input type="checkbox" id="newproductview" value="New Product View" name="promoterRights[]" <?php echo $checked; ?> >New Product View
												</label>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="col-sm-8 pull-right">
											<div class="form-group">
												<label>
													<?php $yesno = (bool)$category['newproduct_edit']; //1 = true, 0 = false
													$checked = ($yesno) ? 'checked="checked"' : ''; //see ternary operator ?>
													<input type="checkbox" id="newproductedit" value="New Product Edit"  name="promoterRights[]" <?php echo $checked; ?> >New Product Edit
												</label>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="col-sm-8 pull-right">
											<div class="form-group">
												<label>
													<?php $yesno = (bool)$category['newproduct_publish']; //1 = true, 0 = false
													$checked = ($yesno) ? 'checked="checked"' : ''; //see ternary operator ?>
													<input type="checkbox" id="newproductpublish" value="New Product Publish" name="promoterRights[]" <?php echo $checked; ?> >New Product Publish
												</label>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="col-sm-8 pull-right">
											<div class="form-group">
												<label>
													<?php $yesno = (bool)$category['newproduct_delete']; //1 = true, 0 = false
													$checked = ($yesno) ? 'checked="checked"' : ''; //see ternary operator ?>
													<input type="checkbox" id="newproductdelete" value="New Product Delete"  name="promoterRights[]" <?php echo $checked; ?> >New Product Delete
												</label>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="col-sm-8 pull-right">
											<div class="form-group">
												<label>
													<?php $yesno = (bool)$category['newservice_view']; //1 = true, 0 = false
													$checked = ($yesno) ? 'checked="checked"' : ''; //see ternary operator ?>
													<input type="checkbox" id="newserviceview" value="New Service View" name="promoterRights[]" <?php echo $checked; ?> >New Service View
												</label>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="col-sm-8 pull-right">
											<div class="form-group">
												<label>
													<?php $yesno = (bool)$category['newservice_edit']; //1 = true, 0 = false
													$checked = ($yesno) ? 'checked="checked"' : ''; //see ternary operator ?>
													<input type="checkbox" id="newserviceedit" value="New Service Edit"  name="promoterRights[]" <?php echo $checked; ?> >New Service Edit
												</label>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="col-sm-8 pull-right">
											<div class="form-group">
												<label>
													<?php $yesno = (bool)$category['newservice_publish']; //1 = true, 0 = false
													$checked = ($yesno) ? 'checked="checked"' : ''; //see ternary operator ?>
													<input type="checkbox" id="newservicepublish" value="New Service Publish" name="promoterRights[]" <?php echo $checked; ?> >New Service Publish
												</label>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="col-sm-8 pull-right">
											<div class="form-group">
												<label>
													<?php $yesno = (bool)$category['newservice_delete']; //1 = true, 0 = false
													$checked = ($yesno) ? 'checked="checked"' : ''; //see ternary operator ?>
													<input type="checkbox" id="newservicedelete" value="New Service Delete" name="promoterRights[]" <?php echo $checked; ?> >New Service Delete
												</label>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="col-sm-8 pull-right">
											<div class="form-group">
												<label>
													<?php $yesno = (bool)$category['newbrand_view']; //1 = true, 0 = false
													$checked = ($yesno) ? 'checked="checked"' : ''; //see ternary operator ?>
													<input type="checkbox" id="newbrandview" value="New Brand View"  name="promoterRights[]" <?php echo $checked; ?> >New Brand View
												</label>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="col-sm-8 pull-right">
											<div class="form-group">
												<label>
													<?php $yesno = (bool)$category['newbrand_edit']; //1 = true, 0 = false
													$checked = ($yesno) ? 'checked="checked"' : ''; //see ternary operator ?>
													<input type="checkbox" id="newbrandedit" value="New Brand Edit" name="promoterRights[]" <?php echo $checked; ?> >New Brand Edit
												</label>
											</div>
										</div>
									</div>
							  </div><!-- /.box-body -->
							   <div class="box-body col-md-6">		
									<div class="col-md-12">
										<div class="col-sm-8 pull-right">
											<div class="form-group">
												<label>
													<?php $yesno = (bool)$category['newbrand_publish']; //1 = true, 0 = false
													$checked = ($yesno) ? 'checked="checked"' : ''; //see ternary operator ?>
													<input type="checkbox" id="newbrandpublish" value="New Brand Publish"  name="promoterRights[]" <?php echo $checked; ?> >New Brand Publish
												</label>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="col-sm-8 pull-right">
											<div class="form-group">
												<label>
													<?php $yesno = (bool)$category['newbrand_delete']; //1 = true, 0 = false
													$checked = ($yesno) ? 'checked="checked"' : ''; //see ternary operator ?>
													<input type="checkbox" id="newbranddelete" value="New Brand Delete" name="promoterRights[]" <?php echo $checked; ?> >New Brand Delete
												</label>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="col-sm-8 pull-right">
											<div class="form-group">
												<label>
													<?php $yesno = (bool)$category['risk_view']; //1 = true, 0 = false
													$checked = ($yesno) ? 'checked="checked"' : ''; //see ternary operator ?>
													<input type="checkbox" id="riskview" value="Risk View"  name="promoterRights[]" <?php echo $checked; ?> >Risk View
												</label>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="col-sm-8 pull-right">
											<div class="form-group">
												<label>
													<?php $yesno = (bool)$category['risk_close']; //1 = true, 0 = false
													$checked = ($yesno) ? 'checked="checked"' : ''; //see ternary operator ?>
													<input type="checkbox" id="riskclose" value="Risk Close" name="promoterRights[]" <?php echo $checked; ?> >Risk Close
												</label>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="col-sm-8 pull-right">
											<div class="form-group">
												<label>
													<?php $yesno = (bool)$category['message_view']; //1 = true, 0 = false
													$checked = ($yesno) ? 'checked="checked"' : ''; //see ternary operator ?>
													<input type="checkbox" id="messageview" value="Message View"  name="promoterRights[]" <?php echo $checked; ?> >Message View
												</label>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="col-sm-8 pull-right">
											<div class="form-group">
												<label>
													<?php $yesno = (bool)$category['message_delete']; //1 = true, 0 = false
													$checked = ($yesno) ? 'checked="checked"' : ''; //see ternary operator ?>
													<input type="checkbox" id="messagedelete" value="Message Delete" name="promoterRights[]" <?php echo $checked; ?> >Message Delete
												</label>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="col-sm-8 pull-right">
											<div class="form-group">
												<label>
													<?php $yesno = (bool)$category['user_view']; //1 = true, 0 = false
													$checked = ($yesno) ? 'checked="checked"' : ''; //see ternary operator ?>
													<input type="checkbox" id="userview" value="User View"  name="promoterRights[]" <?php echo $checked; ?> >User View
												</label>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="col-sm-8 pull-right">
											<div class="form-group">
												<label>
													<?php $yesno = (bool)$category['user_edit']; //1 = true, 0 = false
													$checked = ($yesno) ? 'checked="checked"' : ''; //see ternary operator ?>
													<input type="checkbox" id="useredit" value="User Edit" name="promoterRights[]" <?php echo $checked; ?> >User Edit
												</label>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="col-sm-8 pull-right">
											<div class="form-group">
												<label>
													<?php $yesno = (bool)$category['user_block']; //1 = true, 0 = false
													$checked = ($yesno) ? 'checked="checked"' : ''; //see ternary operator ?>
													<input type="checkbox" id="userblock" value="User Block" name="promoterRights[]" <?php echo $checked; ?> >User Block
												</label>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="col-sm-8 pull-right">
											<div class="form-group">
												<label>
													<?php $yesno = (bool)$category['user_delete']; //1 = true, 0 = false
													$checked = ($yesno) ? 'checked="checked"' : ''; //see ternary operator ?>
													<input type="checkbox" id="userdelete" value="User Delete" name="promoterRights[]" <?php echo $checked; ?> >User Delete
												</label>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="col-sm-8 pull-right">
											<div class="form-group">
												<label>
													<?php $yesno = (bool)$category['promoter_add']; //1 = true, 0 = false
													$checked = ($yesno) ? 'checked="checked"' : ''; //see ternary operator ?>
													<input type="checkbox" id="promoteradd" value="Promoter Add" name="promoterRights[]" <?php echo $checked; ?> >Promoter Add
												</label>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="col-sm-8 pull-right">
											<div class="form-group">
												<label>
													<?php $yesno = (bool)$category['promoter_view']; //1 = true, 0 = false
													$checked = ($yesno) ? 'checked="checked"' : ''; //see ternary operator ?>
													<input type="checkbox" id="promoterview" value="Promoter View" name="promoterRights[]" <?php echo $checked; ?> >Promoter View
												</label>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="col-sm-8 pull-right">
											<div class="form-group">
												<label>
													<?php $yesno = (bool)$category['promoter_edit']; //1 = true, 0 = false
													$checked = ($yesno) ? 'checked="checked"' : ''; //see ternary operator ?>
													<input type="checkbox" id="promoteredit" value="Promoter Edit"  name="promoterRights[]" <?php echo $checked; ?> >Promoter Edit
												</label>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="col-sm-8 pull-right">
											<div class="form-group">
												<label>
													<?php $yesno = (bool)$category['promoter_delete']; //1 = true, 0 = false
													$checked = ($yesno) ? 'checked="checked"' : ''; //see ternary operator ?>
													<input type="checkbox" id="promoterdelete" value="Promoter Delete" name="promoterRights[]" <?php echo $checked; ?> >Promoter Delete
												</label>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="col-sm-8 pull-right">
											<div class="form-group">
												<label>
													<?php $yesno = (bool)$category['genericproduct_add']; //1 = true, 0 = false
													$checked = ($yesno) ? 'checked="checked"' : ''; //see ternary operator ?>
													<input type="checkbox" id="genericproductadd" value="Generic Product Add"  name="promoterRights[]" <?php echo $checked; ?> >Generic Product Add
												</label>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="col-sm-8 pull-right">
											<div class="form-group">
												<label>
													<?php $yesno = (bool)$category['genericproduct_view']; //1 = true, 0 = false
													$checked = ($yesno) ? 'checked="checked"' : ''; //see ternary operator ?>
													<input type="checkbox" id="genericproductview" value="Generic Product View"  name="promoterRights[]" <?php echo $checked; ?> >Generic Product View
												</label>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="col-sm-8 pull-right">
											<div class="form-group">
												<label>
													<?php $yesno = (bool)$category['genericproduct_edit']; //1 = true, 0 = false
													$checked = ($yesno) ? 'checked="checked"' : ''; //see ternary operator ?>
													<input type="checkbox" id="genericproductedit" value="Generic Product Edit" name="promoterRights[]" <?php echo $checked; ?> >Generic Product Edit
												</label>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="col-sm-8 pull-right">
											<div class="form-group">
												<label>
													<?php $yesno = (bool)$category['genericproduct_unpublish']; //1 = true, 0 = false
													$checked = ($yesno) ? 'checked="checked"' : ''; //see ternary operator ?>
													<input type="checkbox" id="genericproductunublish" value="Generic Product Unpublish"  name="promoterRights[]" <?php echo $checked; ?> >Generic Product Unpublish
												</label>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="col-sm-8 pull-right">
											<div class="form-group">
												<label>
													<?php $yesno = (bool)$category['genericproduct_delete']; //1 = true, 0 = false
													$checked = ($yesno) ? 'checked="checked"' : ''; //see ternary operator ?>
													<input type="checkbox" id="genericproductdelete" value="Generic Product Delete" name="promoterRights[]" <?php echo $checked; ?> >Generic Product Delete
												</label>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="col-sm-8 pull-right">
											<div class="form-group">
												<label>
													<?php $yesno = (bool)$category['genericservice_add']; //1 = true, 0 = false
													$checked = ($yesno) ? 'checked="checked"' : ''; //see ternary operator ?>
													<input type="checkbox" id="genericserviceadd" value="Generic Service Add"  name="promoterRights[]" <?php echo $checked; ?> >Generic Service Add
												</label>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="col-sm-8 pull-right">
											<div class="form-group">
												<label>
													<?php $yesno = (bool)$category['genericservice_view']; //1 = true, 0 = false
													$checked = ($yesno) ? 'checked="checked"' : ''; //see ternary operator ?>
													<input type="checkbox" id="genericserviceview" value="Generic Service View"  name="promoterRights[]" <?php echo $checked; ?> >Generic Service View
												</label>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="col-sm-8 pull-right">
											<div class="form-group">
												<label>
													<?php $yesno = (bool)$category['genericservice_edit']; //1 = true, 0 = false
													$checked = ($yesno) ? 'checked="checked"' : ''; //see ternary operator ?>
													<input type="checkbox" id="genericserviceedit" value="Generic Service Edit" name="promoterRights[]" <?php echo $checked; ?> >Generic Service Edit
												</label>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="col-sm-8 pull-right">
											<div class="form-group">
												<label>
													<?php $yesno = (bool)$category['genericservice_unpublish']; //1 = true, 0 = false
													$checked = ($yesno) ? 'checked="checked"' : ''; //see ternary operator ?>
													<input type="checkbox" id="genericserviceunpublish" value="Generic Service Unpublish"  name="promoterRights[]" <?php echo $checked; ?> >Generic Service Unpublish
												</label>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="col-sm-8 pull-right">
											<div class="form-group">
												<label>
													<?php $yesno = (bool)$category['genericservice_delete']; //1 = true, 0 = false
													$checked = ($yesno) ? 'checked="checked"' : ''; //see ternary operator ?>
													<input type="checkbox" id="genericservicedelete" value="Generic Service Delete" name="promoterRights[]" <?php echo $checked; ?> >Generic Service Delete
												</label>
											</div>
										</div>
									</div>
							  </div><!-- /.box-body -->
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
