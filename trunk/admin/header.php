<?php 
  include('../functions/config.php');
   include('../functions/session.php');
  include('../functions/functions.php'); 
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
    <!-- iCheck -->
    <link href="../assets/vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- bootstrap-progressbar -->
    <link href="../assets/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="../assets/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>

    <!-- Custom Theme Style -->
    <link href="../assets/build/css/custom.min.css" rel="stylesheet">
    <link href="../assets/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendors/pnotify/dist/pnotify.css" rel="stylesheet">
    <link href="../assets/vendors/pnotify/dist/pnotify.buttons.css" rel="stylesheet">
    <link href="../assets/vendors/pnotify/dist/pnotify.nonblock.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/lobibox-master/font-awesome/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="../assets/lobibox-master/demo/demo.css"/>
    <link rel="stylesheet" href="../assets/lobibox-master/dist/css/lobibox.min.css"/>
     <link href="../assets/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Custom Theme Style -->
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
            <a href="index.html" class="site_title"><i class="fa fa-paw"></i> <span>PODD</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->

            <br />
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
              <?php if($_SESSION['role']=="1"){ ?>
            <!-- sidebar menu -->
          
                <ul class="nav side-menu ">
                   <li><a href = "service_management_list.php"><i class="fa fa-home"></i>Service</a></li>
                   <li><a href = "restaurant_list.php"><i class="fa fa-home"></i>Restaurant & Bars</a>
                   <ul class="nav child_menu">
                      <li><a href="restaurant_list.php">Manage Venue</a></li>
                      <li><a href="booking_list_restaurant.php">Manage bookings</a></li>
                      <li><a href="booking_history.php">History</a></li> 
                  </ul>
                   </li>
                   <li><a href = "restaurant_list.php"><i class="fa fa-home"></i>Delivery</a></li>
                   <li><a href = "restaurant_list.php"><i class="fa fa-home"></i>Taxi</a></li>
                  <!--  <li><a href = "user_list.php"><i class="fa fa-user"></i>User Management </a></li>
                   
                   <li><a href = "booking_list_restaurant.php"><i class="fa fa-user"></i>Booking Management</a></li>
                   <li><a href = "booking_history.php"><i class="fa fa-home"></i>Bookings History</a></li> -->
                </ul>
              
             <?php } elseif($_SESSION['role']=="2"){?>
                 <ul class="nav side-menu">
                  <li><a href = "booking_list_restaurant.php"><i class="fa fa-user"></i>Booking Management</a></li>
                   <!-- <li><a href = "restaurant_menu_management.php"><i class="fa fa-home"></i>Menu Management</a></li> -->
                   <li><a href = "booking_history.php"><i class="fa fa-home"></i>Bookings History</a></li>
                  <!--  <li><a href = "table_management.php"><i class="fa fa-table"></i>Table Management</a></li> -->
                  
                </ul>
             <?php }else{ ?>
                  <ul class="nav side-menu">
                  <li><a href = ""><i class="fa fa-home"></i>Booking Management</a></li>
                   <li><a href = ""><i class="fa fa-home"></i>Availability Management</a></li>
                </ul>
             <?php } ?>
            </div>
            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
          
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                   <?php echo $_SESSION['email'];?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="logout.php">Log Out</a></li>
                     <li><a href="change_password_admin.php">Change Password</a></li>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>

