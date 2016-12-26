<?php 
ob_start();
include_once('header.php'); 
$error="";
$sucess="";
try {
      if(isset($_POST["submit"]))
      { 
        $message = mysqli_real_escape_string($conn,trim($_POST['message']));
        if(mysqli_query($GLOBALS['conn'],"UPDATE `service_management` SET `message`='".$message."' WHERE 1")){
              $_SESSION["successmsg"] = "Message edited successfully.";
             }
            else
            {
               $_SESSION["errormsg"] = "Updat error.";
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
                    <h2>Edit Message</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <form class="form-horizontal form-label-left" id="add_category" method="post" enctype="multipart/form-data" novalidate>
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
                       
                        <label class="control-label col-md-1 col-sm-1 col-xs-4" for="name">
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <textarea id="message" class="form-control col-md-7 col-xs-12 ckeditor" data-validate-length-range="6" data-validate-words="2" name="message" >
                            <?php if(isset($_POST['submit'])){
                             print $_POST['message'];}else{
                              $message = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'],"SELECT message FROM service_management WHERE 1"));
                              echo $message['message'];
                              } ?>
                          </textarea>
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