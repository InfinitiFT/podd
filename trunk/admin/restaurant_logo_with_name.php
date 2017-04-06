<?php
ob_start();
include_once('header.php');
$error  = "";
$sucess = "";
try {
    if (isset($_POST["submit"])) {
		$restaurant_name = $_POST['restaurant_name'];
        if (!empty($_FILES["image"]['tmp_name'])) {
            if ((($_FILES["image"]["type"] == "image/gif") || ($_FILES["image"]["type"] == "image/jpeg") || ($_FILES["image"]["type"] == "image/pjpeg") || ($_FILES["image"]["type"] == "image/png") || ($_FILES["image"]["type"] == "image/jpg"))) {
               $ext = pathinfo($_FILES["image"]['name'],PATHINFO_EXTENSION);
	           $logo1 = time().rand(100,999).'.'.$ext;
		       $target_dir = "../uploads/restaurant_logo/";
               $target_path    = $target_dir . $logo1;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
                    if (mysqli_query($GLOBALS['conn'], "UPDATE `restaurant_logo` SET `restaurant_name`= '". $restaurant_name."',`logo`= '". 'uploads/restaurant_logo/'.$logo1 . "' WHERE `logo_id` = 1")) {
						
                        $_SESSION["successmsg"] = "Home page edited successfully.";
                        header('Location:restaurant_logo_with_name.php');
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
		else if (!empty($restaurant_name))
		{
			 if (mysqli_query($GLOBALS['conn'], "UPDATE `restaurant_logo` SET `restaurant_name`= '". $restaurant_name."' WHERE `logo_id` = 1")) {
						
                        $_SESSION["successmsg"] = "Home page edited successfully.";
                        header('Location:restaurant_logo_with_name.php');
                    } else {
                        $_SESSION["errormsg"] = "insertion error.";
                    }
		}
		else {
			 if (mysqli_query($GLOBALS['conn'], "UPDATE `restaurant_logo` SET `restaurant_name`= '".$restaurant_name."' WHERE `logo_id` = 1")) {
						
                        $_SESSION["successmsg"] = "Home page edited successfully.";
                        header('Location:restaurant_logo_with_name.php');
                    } else {
                        $_SESSION["errormsg"] = "insertion error.";
                    }
			
		}
		
		
            header('Location:restaurant_logo_with_name.php');

        
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
                    <h2>Small screen</h2>
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
                       $data = mysqli_query($GLOBALS['conn'],"select * from `restaurant_logo` where logo_id = 1");
					   //echo "select * from `home_page_image` where image_id = '".decrypt_var($_GET['id'])."'";exit;
					            	$row = mysqli_fetch_assoc($data);
                       //print_r($row);exit;									
                      ?>
                      <div class="item form-group">
                       
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="restaurant_name" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" value="<?php if(isset($_POST['submit'])){
                             print $_POST['restaurant_name'];} else { echo $row['restaurant_name']; } ?>" name="restaurant_name" placeholder="Name"  type="text">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="image">Image
                        </label>
                        <div class="col-md-3 col-sm-3 col-xs-6">
						  <div class="col-md-6 col-sm-6 col-xs-12 img-sel">
						  <?php if($row['logo']){?>
							
						  <div id="removeImg" ><figure class="resto_logo" style="position: relative; display: inline-block;"><i class="glyphicon glyphicon-remove" style="position: absolute; top:-2px; right:-16px; z-index: 22;" id="removeImgs" onclick ="removeImg1()"></i>
							<img src="<?php echo url1().$row['logo'] ?>"  height="80" width="80" id="imgName-1"></figure></div>
						  <?php } ?>
                                                  
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
