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
		 
    	$password = rand(11111111,99999999);
		$mail_data['to']= $email;
		        $mail_data['subject']= "Password Recovery";
		        $mail_data['html']= '
                    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                      <html xmlns="http://www.w3.org/1999/xhtml">
                     <head>
                     <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                    
                     </head>
                      <body>
                        <tbody>
                          <tr>
                            <td style="padding-left:0px;font-size:14px;font-family:Helvetica,Arial,sans-serif" valign="top">
                              <div style="line-height:1.3em">
                                <div>Hello <b>User</b>,</div>
                                  <div class="m_-7807612712962067148paragraph_break"><br></div>
                                  <div>Your new password :'.$password.' 
                                  <div class="m_-7807612712962067148paragraph_break"><br></div></div>
                                  <div class="m_-7807612712962067148paragraph_break"><br></div>
                                  <div>Best regards,</div>
                                  <div>The podd Team</div>
                             </div>
                          </td>
                        </tr>
                      </tbody>              
                    </body>
                 </html>';
		        // Always set content-type when sending HTML email
		        $mail_data['from']= "podd";
				$email_issue = send_email($mail_data);
				if(json_decode($email_issue)->message == 'success'){  
				 if(mysqli_query($GLOBALS['conn'],"UPDATE `users` SET `password`='".md5($password)."',`first_time_login`='0' WHERE `email`='".$email."'"))
                {
        	      $_SESSION["successmsg"] = "password sent to your email.";
                }
               else
                {
                  $_SESSION["successmsg"] = "error.";
                }
		      } else{ 
			   $_SESSION["errormsg"] = "Error in sending email.";
		       }
		        
               
       
       
     } 
      else{
       $_SESSION["errormsg"] = "Email doesnot exists in database.";
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

    <title>podd </title>

    <!-- Bootstrap -->
    <link href="assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="assets/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="assets/vendors/animate.css/animate.min.css" rel="stylesheet">
     <link href="assets/vendors/pnotify/dist/pnotify.css" rel="stylesheet">
    <link href="assets/vendors/pnotify/dist/pnotify.buttons.css" rel="stylesheet">
    <link href="assets/vendors/pnotify/dist/pnotify.nonblock.css" rel="stylesheet">\
    <link href="assets/css/style.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="assets/build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
         
            <form action="" method="post" id="forgot-form"  class="form-horizontal" role="form">
              <h1><h1 class="logo"><img src="logo.png" alt="logo" /></h1>
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
              <div class="input-group forgotpass-s">
                <input type="text" class="form-control" type="email" placeholder="Email" id="email" name="email" value="<?php if(isset($_POST['email'])){echo $_POST['email'];} ?>"/>
              </div>
              <div>
                <button class="btn btn-black submit" type="submit" value="submit" name="submit">Submit</button>
               <a href="index.php" class="btn btn-black nomar-btn">Login</a>   
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                
              

                <div class="clearfix"></div>
                <br />

                <div>
                   <!-- <h1><i class="fa fa-paw"></i>PODD</h1> -->
                    <h5 class="contct_in">Contact us with any queries with comments on<a href="javascript:void()">hello@poddapp.com</a></h5>
                  <p  style="color:black">©2017 All Rights Reserved.</p>
                </div>
              </div>
             
            </form>
          </section>
        </div>

      </div>
    </div>
  </body>
  
    <script src="assets/vendors/jquery/dist/jquery.min.js"></script>
    <script src="assets/js/jquery.validate.min.js"></script>
    <script src="validation.js"></script>
</html>
