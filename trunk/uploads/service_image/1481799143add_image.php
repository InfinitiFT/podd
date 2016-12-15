<?php
session_start();
if(!isset($_SESSION['LoginUserId']))
header('location:index.php');
include('config/config.php');
include('include/extender.php');
include('header.php');

if(isset($_REQUEST['addGallery'])){
	if(!empty($_FILES["image"]["name"])){
           foreach ($_FILES["image"]["name"] as $key =>$e) {
           	
            	$upload_img = $obj->cwUploada('image','upload/gallery/', $e,$key,TRUE,'upload/gallery/thumbs/','460','345');
                 $target_file ='upload/gallery/'.$upload_img;
               $Trg[] = $target_file;
           }
           $trgt = implode(',',$Trg);
               
	 }
	 	$img = explode(',', $trgt); 
	 	$altt = $_POST['alt']; 
 		
	 	
	 $date = date("Y-m-d H:i:s");
		$addgallery = "INSERT INTO `tbl_gallery`( `vedio_link`,`title`, `desc`, `caption`, `date`) VALUES ('".$_POST['video']."','".$_POST['title']."','".$_POST['content']."','".$_POST['caption']."','".$date."') ";
		mysql_query($addgallery);
		$id=mysql_insert_id();
		
		for($i=0;$i<count($img);$i++)
		{
			$sql = "INSERT INTO tbl_album(gallery_id,image,title)
		VALUES ('".$id."','".$img[$i]."','".$altt[$i]. "' )";
		mysql_query($sql);
		}
			
	
	
	$msg="";
	$error="";
	if($id){
	$msg="Successfully  Added  Image ";
		
		 echo '<script type="text/javascript">';
         echo 'window.location.href="gallery_list.php"';
         echo '</script>';
         echo '<noscript>';
         echo '<meta http-equiv="refresh" content="0;url=gallery_list" />';
         echo '</noscript>'; 
	}
	
}

?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
		<section class="content-header">
			<div class="row">
				<div class="col-md-12">
					<div class="content-header">
						<h1>Add Gallery
							<span class="pull-right">
								<a href="gallery_list.php" class="btn btn-default"><i class="fa fa-angle-left"></i> Back</a>
							</span>
						</h1>
						<?php if(!empty($msg)){ ?>
						<div id="msgalert" class="alert alert-<?php echo ($error == 1 ? 'danger':'success'); ?> alert-dismissable col-sm-6">
		                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		                    <?php echo $msg ?>
	                  	</div>
	                  	<?php } ?>						
					</div> 
				</div>
			</div>
		</section>
		<section class="content" id="add-generic-product-page" style="background:#fff; margin-top:15px">
			<div class="row">
				<div class="col-md-12">
					<div class="col-md-12">
						<div class="box box-info">					
							<form class="form-horizontal" name="genresForm" method = "post" enctype="multipart/form-data">
							    <div class="box-body">
								 <div class="form-group">
                                          <label>Image</label>
                                         <input type="file" name="image[]" required class="form-control" value="" multiple />
                                         </div>
                                        <div class="form-group"> 
                                         <label>Alt Image</label>
                                         <input type="text" name="alt[]	" required class="form-control" value="" placeholder = "Alt image" multiple />  </div>

                                         <div class="field_wrapper">
											</div>
									
										<div>
									        <a href="javascript:void(0);" class="btn btn-info add_button" title="Add field">Add More</a>
									    </div>                      
                                    
                                    
                                    <div class="form-group">
                                          <label>Video Link</label>
                                         <input type="text" name="video"  class="form-control" value="" placeholder = "Paste Your Video"/>                      
                                    </div>
									<div class="form-group">
										 <label>Title</label>
							        	<input type="text" class="form-control" id="bannerArticle" name="title" placeholder="Enter Image Title " value="" required>
										
									</div>
									 
									<div class="form-group">
								        <label>Description</label>
											<textarea class="form-control "  name="content" placeholder="Enter Page Description" required> </textarea>
									</div>
									<div class="form-group">
								        <label>Image Caption</label>
										<input type="text" class="form-control" id="bannerArticle" name="caption" placeholder="Enter Image Title " value="" required>
									</div>
									<div class="box-footer">
											<button type="submit" class="btn btn-success" name="addGallery" id="addbanner">Save</button>	
											<a href="gallery_list.php" class="btn btn-default"> Cancel</a>
																	
									</div>
									
							    </div>
							</form>
						</div>
					</div>				  
				</div>
			</div>
        </section>
    </div>
    <!-- /.content-wrapper -->
    <?php include('footer.php'); ?>
	 <script>
   			$(document).ready (function(){
            	$("#msgalert").fadeTo(2000, 500).slideUp(500, function(){
    				$("#msgalert").alert('close');
				});       
            });
            
$(function() {
    $( "#bannerArticle" ).autocomplete({
        source: 'article_autosuggetion.php'
    });
});



//function to adding more images
$(document).ready(function(){
	var maxField = 10; //Input fields increment limitation
	var addButton = $('.add_button'); //Add button selector
	var wrapper = $('.field_wrapper'); //Input field wrapper
	var fieldHTML = '<div><input type="file" name="image[]" multiple required/><input type="text" name="alt[]" required class="form-control" value="" placeholder = "Alt image" /> <a href="javascript:void(0);" class="remove_button" title="Remove field"><img src="remove-icon.png"/></a></div>'; //New input field html 
	var x = 1; //Initial field counter is 1
	$(addButton).click(function(){ //Once add button is clicked
		if(x < maxField){ //Check maximum number of input fields
			x++; //Increment field counter
			$(wrapper).append(fieldHTML); // Add field html
		}
	});
	$(wrapper).on('click', '.remove_button', function(e){ //Once remove button is clicked
		e.preventDefault();
		$(this).parent('div').remove(); //Remove field html
		x--; //Decrement field counter
	});
});


</script>   
	 

