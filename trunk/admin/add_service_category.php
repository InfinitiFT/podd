<?php 
ob_start();
include_once('header.php'); 
$error="";
$sucess="";
try {
      if(isset($_POST["submit"]))
      { 
        if((($_FILES["image"]["type"] == "image/gif") || ($_FILES["image"]["type"] == "image/jpeg")|| ($_FILES["image"]["type"] == "image/pjpeg")|| ($_FILES["image"]["type"] == "image/png")|| ($_FILES["image"]["type"] == "image/jpg"))){ 
          $profile_image = $_FILES["image"]['name'];
          $profile_image1=time().$_FILES['image']['name'];
          $target_path = $_SERVER['DOCUMENT_ROOT']."/PROJECTS/IOSNativeAppDevelopment/trunk/uploads/service_image/";
          $target_path = $target_path . $profile_image1; 
          //echo $target_path;exit;
          if(move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) 
          {
            if(mysqli_query($GLOBALS['conn'],"INSERT INTO `service_management`(`service_name`, `service_image`) VALUES ('".trim($_POST['name'])."','".$profile_image1."')")){
              $_SESSION["successmsg"] = "Service added successfully.";
              header('Location:service_management_list.php');
             }
            else
            {
               $_SESSION["errormsg"] = "insertion error.";
            }
          }
          else
          {
            $_SESSION["errormsg"] = "File uploading error.";
          }
          
        }
        else
        {
          $_SESSION["errormsg"] = "Only Image are allowed.";
        }
      }
    }

//catch exception
catch(Exception $e) {
  echo 'Message: ' .$e->getMessage();
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
                    <h2>Add Service Category</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <form class="form-horizontal form-label-left" id="add_category" method="post" enctype="multipart/form-data" novalidate>
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
                     
                      
                      <div class="item form-group">
                       
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="name" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" value="<?php if(isset($_POST['submit'])){
                             print $_POST['name'];} ?>" name="name" placeholder="Name"  type="text">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="image">Image<span class="required">*</span>
                        </label>
                        <div class="col-md-3 col-sm-3 col-xs-6">

                          
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