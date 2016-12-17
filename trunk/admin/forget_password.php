<?php
include('../functions/functions.php');
ob_start();
$error="";
if(isset($_POST["submit"]))
{ 
    if(filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) === false){
      $error="Please enter valid  email address";
    }
    else{
      $email = mysqli_real_escape_string($conn,trim($_POST["email"]));
    $admin_valid_email = validate_email_admin($email);
    if($admin_valid_email){
                   $to = $email;
                   $subject = "Forget password";
                   $message = '
                    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                      <html xmlns="http://www.w3.org/1999/xhtml">
                     <head>
                     <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                     <title>Password Recovery</title>
                   </head>
                   <body>
                    <table cellpadding="0" cellspacing="0"  width="80%"  align="center">
                      <tr>
                        <td width="48%" valign="top" style="border:solid 2px #303030;" colspan="3">
                          <table cellpadding="0" cellspacing="0"  width="100%"  >
                            <TR>
                              <TD height="40" align="center" bgcolor="#272727" style="border:solid 2px #303030;">
                                <strong style="color:#fff;">Wait Chek User Registration</strong>
                              </TD>
                            </TR>
                            <TR>
                              <TD style="padding:5px; background-color:#fff;">
                                <table cellpadding="0" cellspacing="0" border="0" width="100%"  style="padding:5px;"> 
                                  <tr>
                                    <td width="2" align="center"  valign="bottom" style="padding-top:5px;"> </td>
                                    <td colspan="2" width="394" >
                                  <strong>Hello User ,</strong><br/>
                                  We recently added you as a new user to our app, WaitChek. Please open the app and use the following email address and password to access your account.
                                    </td>
                                  </tr>
                                  <tr>
                                    <td colspan="3" height="6px"> </td>
                                    <td width="1" height="6px"> </td>
                                  </tr>
                                  <tr>
                                    <td width="2" align="center" valign="bottom" style="padding-top:5px;"> </td>
                                    <td width="91" class="warea" >
                                    <strong style="color:#1d7210;">Email : </strong>
                                    </td> 
                                    <td width="510">"'.$email.'"</td>
                                  </tr>
                                  <tr>
                                    <td width="2" align="center" valign="bottom" style="padding-top:5px;"> </td>
                                    <td width="91" class="warea" >
                                    <strong style="color:#1d7210;">Password : </strong>
                                    </td> 
                                    <td width="510">"'.$password.'"</td>
                                  </tr>
                                  <tr>
                                    <td colspan="3" height="6px"> </td>
                                    <td width="1" height="6px"> </td>
                                  </tr>
                                  <tr>
                                    <td colspan="3" height="6px"> </td>
                                    <td width="1" height="6px"> </td>
                                  </tr>
                                  <tr>
                                    <td width="2" align="center"  valign="bottom" style="padding-top:5px;"> </td>
                                    <td colspan="2" width="394" >
                                       Thank you for your interest in our app!</br>
                                       The WaitChek Team
                                    </td>
                                  </tr>

                                  <tr>
                                    <td colspan="3" height="6px"> </td>
                                  </tr>
                                </table>
                              </TD>
                            </TR>
                          </table>
                        </td> 
                      </tr>
                    </table>
                  </body>
                </html>';

      // Always set content-type when sending HTML email
      $headers = "MIME-Version: 1.0" . "\r\n";
      $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

      // More headers
      $headers .= 'From: ippodDevlopment@gmail.com' . "\r\n";
      if(mail($to,$subject,$message,$headers)){  
       $_SESSION["successmsg"] = "Password Send to your email.";
       } else{ 
       $_SESSION["errormsg"] = "Error in sending email.";
       }  
     } 
      else{
       $_SESSION["errormsg"] = "Invalid Email.";
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
         
            <form action="" method="post" id="forgot-form">
              <h1>Forgot Password</h1>
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
                 <?php echo $error1; ?>
                </div>
                <?php }else{}?>
                <?php if($error){?>
                     <font color="red"><?php echo $error;?></font>
                <?php  } ?>
              <div>
                <input type="text" class="form-control" type="email" placeholder="Email" id="email" name="email" value="<?php if(isset($_POST['email'])){echo $_POST['email'];} ?>"/>
              </div>
              <div>
                <button class="btn btn-default submit" type="submit" value="submit" name="submit">Submit</button>
               <a href="index.php" class="to_register"><h2>Login</h2></a>   
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
