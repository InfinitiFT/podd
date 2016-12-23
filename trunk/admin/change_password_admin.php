<?php
include_once('header.php');
if(isset($_POST["submit"]))

{
    $password = $_POST["new_password"];
    /*$uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number    = preg_match('@[0-9]@', $password);*/
   if($_POST["old_password"] == $_POST["new_password"])
    {
      $_SESSION["errormsg"]="Old password or new password cann't be same.";
    }
    else if(!($_POST["new_password"] == $_POST["confirm_password"]))
     {
       $_SESSION["errormsg"] ="Password and confirm password does not matched";
     }
    else
    {
     $email =  mysqli_real_escape_string($conn,$_SESSION["email"]);
     $new_password = mysqli_real_escape_string($conn,$_POST["new_password"]);
     $old_password = mysqli_real_escape_string($conn,$_POST["old_password"]);
     $checkQry = mysqli_query($conn,"SELECT * FROM users WHERE email = '".$email."' AND password = '".md5($old_password)."'");
    
     
      if($checkQry->num_rows!= 0){

         $update_password = mysqli_query($conn,"UPDATE users SET `password` = '".md5($new_password)."',`first_time_login` = 1 WHERE email= '".$email."'");
         if($update_password)
         {
           $_SESSION["successmsg"] = 'Password changed successfully.';

         }
         else
         {
            $_SESSION["errormsg"] = 'Error.';
         }
          
        }
      else {
          $_SESSION["errormsg"] = 'Old password not matched.';
      }
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
                    <h2>Change Password</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <form class="form-horizontal form-label-left" id="change_password" method="post">
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
                       
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name"> Old Password<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="old_password" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" value="" name="old_password" type="password">
                        </div>
                      </div>
                      <div class="item form-group">
                       
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">New Password <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="new_password" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" value="" name="new_password" type="password">
                        </div>
                      </div>
                       <div class="item form-group">
                       
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Confirm Password <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="confirm_password" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" value="" name="confirm_password" type="password">
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