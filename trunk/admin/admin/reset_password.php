<?php
	ob_start();
	include('config/config.php');
	include('admin_functions.php');
	global $_SERVER;
	
	if(isset($_POST['forgot_password'])) {
    if(validate_email_admin($_POST['email']) != 0) {
	   $pass = rand();
	   $sql = mysql_query("UPDATE qv_admin SET password = '".md5($pass)."' WHERE email = '".$_POST['email']."'");
	   $message = "Dear User, \n You have reset your password. \n Please find your new password here ".$pass." \n Thanks \n Qova Team";
	   $subject = 'Qova - Reset Paasword';
	   $emailid = $_POST['email'];
	   mail($emailid, $subject, $message);
	   $message = 'Password reset successfully. Please check your mail.';
	}
	else {
	   $error = 'Sorry, this email does not exist in the system.';
	}
}

?>

<html>
	<head>
    <meta content="text/html; charset=UTF-8" http-equiv="Content-Type">

    <title>Qova - Admin</title>

    <!-- social network metas -->
    <meta content="http://almsaeedstudio.com/adminlte2.png" property="image">
    <meta content="http://almsaeedstudio.com/adminlte2.png" property="og:image">
    <meta content="Almsaeed Studio" property="site_name">
    <meta content="Preview of AdminLTE control panel and dashboard theme. AdminLTE is based on Bootstrap 3." property="description">
    <meta content="Preview of AdminLTE control panel and dashboard theme. AdminLTE is based on Bootstrap 3." name="description">

    <link href="http://almsaeedstudio.com/logo.png" type="image/png" rel="icon">

    <!-- Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font-Awesome -->
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
	<link type="text/css" rel="stylesheet" href="dist/css/AdminLTE.min.css">

    <style>
        html, body {
            min-height: 100%;
            padding: 0;
            margin: 0;
            font-family: 'Source Sans Pro', "Helvetica Neue", Helvetica, Arial, sans-serif;
        }
        iframe {
            display: block;
            overflow: auto;
            border: 0;
            margin: 0;
            padding: 0;
            margin: 0 auto;
        }
        .frame {
            height: 49px;
            margin: 0;
            padding: 0;
            border-bottom: 1px solid #ddd;
        }
        .frame a {
            color: #666;
        }
        .frame a:hover {
            color: #222;
        }
        .frame .buttons a {
            height: 49px;
            line-height: 49px;
            display: inline-block;
            text-align: center;
            width: 50px;
            border-left: 1px solid #ddd;
        }
        .frame .brand {
            color: #444;
            font-size: 20px;
            line-height: 49px;
            display: inline-block;
            padding-left: 10px;
        }
        .frame .brand small {
            font-size: 14px;
        }
        a,a:hover {
            text-decoration: none;
        }
        .container-fluid {
            padding: 0;
            margin: 0;
        }
        .text-muted {
            color: #999;
        }
        .ad {
            text-align: center;
            position: fixed;
            bottom: 0;
            left: 0;
            background: #222;
            background: rgba(0,0,0,0.8);
            width: 100%;
            color: #fff;
            display: none;
        }
        #close-ad {
            float: left;
            margin-left: 10px;
            margin-top: 10px;
            cursor: pointer;
        }
    </style>
    
</head>
<body class="login-page">


		
			
<div class="login-box">
  <div class="login-logo">
	<a href="../../index2.html"><b>Qova</b></a>
  </div><!-- /.login-logo -->
  <div class="login-box-body">
		<?php
			if(isset($error)) { 
			   print '<div class="alert alert-danger msg-error">'.$error.'</div>';
			}
			else if(isset($message)) {
			   print '<div class=" alert alert-success msg-error">'.$message.'</div>';
			}
			?>
	<form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
	  <div class="form-group has-feedback">
		<input type="email" placeholder="Email" name="email" class="form-control" required>
	  </div>
	  <div class="row">
		<div class="col-xs-6">
		 <button type="submit" class="btn btn-primary btn-block btn-flat" name="forgot_password">Forgot Password</button>
		</div>
		<div class="col-xs-6">
		    <a href="index.php" class="btn btn-primary btn-block btn-flat pull-right">Login</a>
		</div>	
		<!-- /.col -->
	  </div>
	  
	</form>

  </div><!-- /.login-box-body -->
</div><!-- /.login-box -->

		
	


<script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script>
    $(function() {
        function _fix() {
            var h = $(window).height();
            var w = $(window).width();
            $("#preview-iframe").css({
                width: w + "px",
                height: (h - 50) + "px"
            });
        }
        _fix();
        $(window).resize(function() {
            _fix();
        });
        $('[data-toggle="tooltip"]').tooltip();

        function iframe_width(width) {
            $("#preview-iframe").animate({width: width}, 500);
        }

        $("#display-full").click(function(e){
            e.preventDefault();
            iframe_width("100%");
        });

        $("#display-940").click(function(e){
            e.preventDefault();
            iframe_width("940px");
        });

        $("#display-480").click(function(e){
            e.preventDefault();
            iframe_width("480px");
        });

        $("#remove-frame").click(function(e){
            e.preventDefault();
            window.location.href = "http://almsaeedstudio.com/themes/AdminLTE/index2.html";
        });

    });

</script>

</body></html>
