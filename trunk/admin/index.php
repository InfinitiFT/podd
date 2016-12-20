<?php
include('../functions/functions.php');
ob_start();
session_start();
if(!empty($_SESSION['password']) && !empty($_SESSION['email']))
{
  if($_SESSION['role'] == "2")
  {
    header("Location:booking_list_restaurant.php");
  }
  else
  {
    header("Location:user_list.php");
  }

}
$error="";

if(isset($_POST["submit"]))
{ 
    $email = mysqli_real_escape_string($conn,trim($_POST["email"]));
    $password = mysqli_real_escape_string($conn,trim($_POST["password"]));
    $admin = user_authenticate($email, $password);
    if($admin['user_id'] != 0){
      if($admin['status'] != 0)
      { 
          if($admin['role'] == "2")
          {

            if($admin['first_time_login'] != 0){
               $_SESSION['user_id'] = $admin['user_id'];
               $_SESSION['email']= $email;
               $_SESSION['password']= $password;
               $_SESSION['role'] = $admin['role'];
               $_SESSION['last_login_timestamp'] = time();
               if(isset($_POST['remember'])){
                //if user check the remember me checkbox
                 $twoDays = 60 * 60 * 24 * 2 + time();
                  setcookie('email', $_POST['email'], $twoDays);
                  setcookie('password', $_POST['password'], $twoDays);
               } else { 
               //if user not check the remember me checkbox
                $twoDaysBack = time() - 60 * 60 * 24 * 2;
                setcookie('email', '', $twoDaysBack);
                setcookie('password', '', $twoDaysBack);
               } 
              $restaurant_id = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'],"SELECT restaurant_id FROM `restaurant_details` WHERE user_id = '".$admin['user_id']."'"));
              $_SESSION['restaurant_id'] = $restaurant_id['restaurant_id'];

              header("Location:booking_list_restaurant.php");
            }
            else{
                 $_SESSION['email']= $email;
                 header("Location:change_password.php");
            }

            
          }
          else
           {
              $_SESSION['user_id'] = $admin['user_id'];
              $_SESSION['email']= $email;
              $_SESSION['password']= $password;
              $_SESSION['role'] = $admin['role'];
              $_SESSION['last_login_timestamp'] = time();
               if(isset($_POST['remember'])){
                //if user check the remember me checkbox
                 $twoDays = 60 * 60 * 24 * 2 + time();
                  setcookie('email', $_POST['email'], $twoDays);
                  setcookie('password', $_POST['password'], $twoDays);
               } else { 
               //if user not check the remember me checkbox
                $twoDaysBack = time() - 60 * 60 * 24 * 2;
                setcookie('email', '', $twoDaysBack);
                setcookie('password', '', $twoDaysBack);
               } 
             header("Location:user_list.php");
           }

      }
      else{
           $_SESSION["errormsg"]="Your account has been blocked by admin.";
      }
     
     
    }
    else{
     $_SESSION["errormsg"]="Invalid Credentials.";
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
         
            <form action="" method="post" id="login_form">
              <h1>Login Form</h1>
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
                <input type="text" class="form-control" placeholder="Email"  id="email" name="email"  value="<?php if(isset($_COOKIE['email'])) echo $_COOKIE['email']; else '';?>"/>
              </div>
              <div>
                <input type="password" class="form-control" placeholder="Password" id="password" name="password"  value="<?php if(isset($_COOKIE['password'])) echo $_COOKIE['password']; else echo '';?>"/>
              </div>
              <div>
                <button class="btn btn-default submit" type="submit" value="Login" name="submit">Log In</button>
                 
              </div>

              <div class="clearfix"></div>

              <div class="separator">
				 <div class="row">
					<div class="col-xs-6" style="text-align: left;">
						<a href="forget_password.php" class="to_register">Forgot Password ?</a>
					  </div>
					<div class="col-xs-6" style="text-align: right;">
						<input type="checkbox" name="remember" value="Remember Me"  <?php if(isset($_COOKIE['password'])) echo 'checked'; else echo '';?>class="flat"> Remember Me
					</div>
			 	</div>
                <div class="clearfix"></div>
               

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
