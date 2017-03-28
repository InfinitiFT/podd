<?php
ob_start();
include_once('header.php');
$error  = "";
$sucess = "";
try {
    if (isset($_POST["submit"])) {
        if (!empty($_FILES["image"]['tmp_name'])) {
            if ((($_FILES["image"]["type"] == "image/gif") || ($_FILES["image"]["type"] == "image/jpeg") || ($_FILES["image"]["type"] == "image/pjpeg") || ($_FILES["image"]["type"] == "image/png") || ($_FILES["image"]["type"] == "image/jpg"))) {
                 $ext = pathinfo($_FILES["image"]['name'],PATHINFO_EXTENSION);
                 $home_page_image1 = time().rand(100,999).'.'.$ext;
                 $target_dir = $target_dir = "../uploads/airport_image/";
                 $target_path    = $target_dir . $home_page_image1;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
                    if (mysqli_query($GLOBALS['conn'], "UPDATE `airport_section_data` SET `airport_image`= '". 'uploads/airport_image/'.$home_page_image1 . "' WHERE `id` = '" . decrypt_var($_GET['id']) . "'")) {
						
                        $_SESSION["successmsg"] = "Airport page edited successfully.";
                        header('Location:airport_page_listing.php');
                    } else {
                        $_SESSION["errormsg"] = "insertion error.";
                    }
                } else {
                    $_SESSION["errormsg"] = "File uploading error.";
                }
                
            } else {
                $_SESSION["errormsg"] = "Only Image are allowed.";
            }
            
        }
		 
		else {
            header('Location:airport_page_listing.php');
        }
        
        
    }
}

//catch exception
catch (Exception $e) {
    echo 'Message: ' . $e->getMessage();
}

?>
<!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
            </div>
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Edit Image</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <form class="form-horizontal form-label-left" id="edit_category" method="post" enctype="multipart/form-data" novalidate>
                      <?php
                        if(isset($_SESSION["successmsg"])) {
                          $success = $_SESSION["successmsg"];
                          $_SESSION["successmsg"]="";
                        } else {
                          $success = "";
                        }
                        if(isset($_SESSION["errormsg"])) {
                          $error1 = $_SESSION["errormsg"];
                          $_SESSION["errormsg"]="";
                        } else {
                          $error1 = "";
                        }
                      ?>
            
                    <?php  if($success!=""){ ?>
                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                       <strong><?php echo $success; ?></strong>
                    </div>
          
                   <?php }else{}?>
                  <?php  if($error1!=""){ ?>
                   <div class="alert alert-danger alert-dismissible fade in" role="alert">
                     </button><?php echo $error1; ?>
                   </div>
                  <?php }else{}?>
                      
                      <?php                      
                       $data = mysqli_query($GLOBALS['conn'],"select * from `airport_section_data` where id = '".decrypt_var($_GET['id'])."'");
					   //echo "select * from `home_page_image` where image_id = '".decrypt_var($_GET['id'])."'";exit;
					            	$row = mysqli_fetch_assoc($data);
                       //print_r($row);exit;									
                      ?>
                     
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="image">Image<span class="required">*</span>
                        </label>
                        <div class="col-md-3 col-sm-3 col-xs-6">
						  <div class="col-md-6 col-sm-6 col-xs-12">
							<img src="<?php echo url1().$row['airport_image'] ?>"  height="80" width="80" >
                        </label>                          
                        </div>
                          <input id="image" class="form-control col-md-3 col-xs-5" data-validate-length-range="6" data-validate-words="2" name="image"   type="file">
                        </div>
                      </div>
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                          <button type="submit" name="submit" value="submit" class="btn btn-success">Submit</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->

    <?php include_once('footer.php'); ?>
