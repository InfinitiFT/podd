<?php
include('../functions/functions.php');
ob_start();
session_start();
$error = "";
if(!isset($_SESSION['email']))
{
  header("Location:index.php");
}
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
            $admin_data = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'],"SELECT * FROM `users` WHERE email= '".$email."'"));
            $_SESSION['user_id'] = $admin_data['user_id'];
            $_SESSION['email']= $email;
            $_SESSION['password']= $password;
            $_SESSION['role'] = $admin_data['role'];
            $_SESSION['last_login_timestamp'] = time();
            $restaurant_id = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'],"SELECT restaurant_id FROM `restaurant_details` WHERE user_id = '".$admin_data['user_id']."'"));
              $_SESSION['restaurant_id'] = $restaurant_id['restaurant_id'];
           
           header("Location:booking_list_restaurant.php");

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
 <!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>IOSAndroidAppDevelopment! | </title>

    <!-- Bootstrap -->
    <link href="../assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../assets/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="../assets/vendors/animate.css/animate.min.css" rel="stylesheet">
     <link href="../assets/vendors/pnotify/dist/pnotify.css" rel="stylesheet">
    <link href="../assets/vendors/pnotify/dist/pnotify.buttons.css" rel="stylesheet">
    <link href="../assets/vendors/pnotify/dist/pnotify.nonblock.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../assets/build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
         
            <form action="" method="post" id="change_password">
              <h1>Change Password</h1>
              <ul class="nav navbar-right panel_toolbox">
				<li><a href="restaurant_list.phps"><button type="button" class="btn btn-round btn-success">Back</button></a>
				</li>
			 </ul>
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
                  <strong><?php echo $error1; ?></strong>
                </div>
                <?php }else{}?>
                <?php if($error){?>
            <font color="red"><?php echo $error;?></font>
            <?php  } ?>
              <div>
                <input type="password" class="form-control" placeholder="Old Password"  id="old_password" name="old_password"  value=""/>
              </div>
              <div>
                 <input type="password" class="form-control" placeholder="New Password"  id="new_password" name="new_password" value=""/>
              </div>
              <div>
                 <input type="password" class="form-control" placeholder="Confirm Password"  id="confirm_password" name="confirm_password" value=""/>
              </div>
              <div>
              <button class="btn btn-default submit" type="submit" value="Login" name="submit">Save</button>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                
                <div class="clearfix"></div>
                <br />

                <div>
                   <h1><i class="fa fa-paw"></i>PODD</h1>
                  <p>©2016 All Rights Reserved.</p>
                </div>
              </div>
             
            </form>
          </section>
        </div>
      </div>
    </div>
  </body>
  <!-- <script src="../assets/vendors/pnotify/dist/pnotify.js"></script>
    <script src="../assets/vendors/pnotify/dist/pnotify.buttons.js"></script>
    <script src="../assets/vendors/pnotify/dist/pnotify.nonblock.js"></script> -->
    <script src="../assets/vendors/jquery/dist/jquery.min.js"></script>
    <script src="../assets/js/jquery.validate.min.js"></script>
    <script src="validation.js"></script>
</html>
