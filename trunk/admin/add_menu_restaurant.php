<?php 
ob_start();
include_once('header.php'); 
$error="";
$sucess="";
try {
      if(isset($_POST["submit"]))
      { 
        $file_type=mime_content_type($_FILES['menu']['tmp_name']);
        if(($file_type == "application/pdf")){ 
          $menu_file = $_FILES["menu"]['name'];
          $menu_file1=time().$_FILES['menu']['name'];
          $target_path = $_SERVER['DOCUMENT_ROOT']."/PROJECTS/IOSNativeAppDevelopment/trunk/uploads/menu_file/";
          $target_path = $target_path . $menu_file1; 
         
            if(move_uploaded_file($_FILES['menu']['tmp_name'], $target_path)) 
            {
              $restaurant_id = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'],"SELECT * FROM restaurant_details WHERE `user_id` = '".$_SESSION['user_id']."'"));
              $name = mysqli_real_escape_string($conn,trim($_POST["name"]));
              $menu_file = mysqli_real_escape_string($conn,$menu_file1);
              if(mysqli_query($GLOBALS['conn'],"INSERT INTO `restaurant_menu_details` (`restaurant_id`,`meal`, `menu_url`) VALUES ('".$restaurant_id['restaurant_id']."','".$name."','".$menu_file."')")){
                 header('Location:restaurant_menu_management.php');
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
          $_SESSION["errormsg"] = "Only Pdf are allowed.";
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
                   
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <form class="form-horizontal form-label-left" id="add_menu" method="post" enctype="multipart/form-data" novalidate>
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
                      <span class="section">Add Menu</span>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Meal Name</label>
                        <div class="col-md-4 col-sm-4 col-xs-8">
                          <select class="form-control" id="name" name="name" >
                           <option value="">Choose Meal</option>
                            <?php $meals_name = get_all_data('restaurant_menu'); 
                            while($meal_name = mysqli_fetch_assoc($meals_name)){?>
                              <option value="<?php echo $meal_name['id']; ?>" ><?php echo $meal_name['menu_name']; ?></option>
                            <?php }?>
                          </select>
                        </div>
                      </div>
                     
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="image">Menu File<span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-4 col-xs-8">
                          
                          <input id="menu" class="form-control col-md-3 col-xs-5" data-validate-length-range="6" data-validate-words="2" name="menu" type="file">
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
