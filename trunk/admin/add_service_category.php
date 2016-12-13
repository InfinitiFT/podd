<?php 
ob_start();
include_once('header.php'); 
$error="";
$sucess="";
$name_err="";
$image_err="";
if(isset($_POST["submit"]))
{ 
  if (empty($_POST['name'])) {


    $error = "Name Field is required.";
  }
  else if(empty($_FILES['image'])){ 
    $error = "Image Field is required.";
  }
  else
  {

    $profile_image = $_FILES["image"]['name'];
    $profile_image1=time().$_FILES['image']['name'];
    $target_path = $_SERVER['DOCUMENT_ROOT']."/PROJECTS/IOSNativeAppDevelopment/trunk/uploads/service_image";

    $target_path = $target_path . $profile_image1; 
     /*if(move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) 
     {*/
    
       if(mysql_query("INSERT INTO `service_management`(`service_name`, `service_image`) VALUES ('".mysql_real_escape_string(trim($_POST['name']))."','".$profile_image1."')")){
         $_SESSION["successmsg"]="Service added successfully.";
         header('Location:add_service_category.php');
       }

   //  }
  }
  
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
                    <h2>Form validation</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <form class="form-horizontal form-label-left" method="post" enctype="multipart/form-data" novalidate>
                      <?php
                        if(isset($_SESSION["successmsg"])) {
                          $success = $_SESSION["successmsg"];
                          $_SESSION["successmsg"]="";
                        } else {
                          $success = "";
                        }
                        if(isset($_SESSION["errormsg"])) {
                          $error = $_SESSION["errormsg"];
                          $_SESSION["errormsg"]="";
                        } else {
                          $error1 = "";
                        }
                      ?>
            
            <?php  if($success!=""){ ?>
            <?php echo $success; ?>
           <div class="item form-group">
             <?php echo $success; ?>
                         <div class="alert alert-success alert-dismissible fade in" role="alert">
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                          </button>
                           <?php echo $success; ?>
                        </div>
                      </div> -->
            <?php }else{}?>
            <?php  if($error1!=""){ ?>
            <div class="item form-group">
              <div class="alert alert-danger alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <?php echo $error1; ?>
              </div>
              </div>
            </div>
            <?php }else{}?>
                      <span class="section">Service Info</span>
                      
                      <div class="item form-group">
                       
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="name" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="name" placeholder="both name(s) e.g Jon Doe" required="required" type="text">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="image">Image<span class="required">*</span>
                        </label>
                        <div class="col-md-3 col-sm-3 col-xs-6">

                          
                          <input id="file" class="form-control col-md-3 col-xs-5" data-validate-length-range="6" data-validate-words="2" name="image"  required="required" type="file">
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