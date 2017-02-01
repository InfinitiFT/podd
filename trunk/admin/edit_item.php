<?php
ob_start();
include_once('header.php');
$error  = "";
$sucess = "";
try {
    $item_data = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'], "SELECT * FROM `items` WHERE `id` ='" . $_GET['id'] . "'"));
    if (isset($_POST["submit"])) {
        $name = mysqli_real_escape_string($conn, trim($_POST['name']));
        if (mysqli_query($GLOBALS['conn'], "UPDATE `items` SET `name`= '" . $name . "',`created_by`='" . $_SESSION['user_id'] . "' WHERE id = '" . $_GET['id'] . "'")) {
            $_SESSION["successmsg"] = "Service added successfully.";
            header('Location:item_list.php');
        } else {
            $_SESSION["errormsg"] = "insertion error.";
        }
    }
}
//catch exception
catch (Exception $e) {
    echo 'Message: ' . $e->getMessage();
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
                    <h2>Edit Item</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <form class="form-horizontal form-label-left" id="edit_item" method="post">
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
                     
                      <input type="hidden" id = "item_id" value = "<?php echo $_GET['id'];?>">
                      <div class="item form-group">
                       
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="name" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" value="<?php 
                             print $item_data['name'];?>" name="name" placeholder="Name"  type="text">
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