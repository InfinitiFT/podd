<?php 
ob_start();

include_once('header.php'); 
$error="";
$sucess="";
try {
      if(isset($_POST["submit"]))
      { 
      	$name = mysqli_real_escape_string($conn,trim($_POST['name_p']));
        $content = mysqli_real_escape_string($conn,trim($_POST['content']));
        if(mysqli_query($GLOBALS['conn'],"UPDATE `static_page` SET `name`='".$name."',`content`= '".$content."' WHERE id = 3")){
              $_SESSION["successmsg"] = "Message edited successfully.";
        }
        else{
               $_SESSION["errormsg"] = "Updat error.";
        }
          
        }
        $static_data = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'],"SELECT * FROM `static_page` WHERE id = 3"));
       // print_r($static_data);exit;
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
                    <h2>Taxi Terms & Conditions</h2>
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
                       
                      ?>
            
                    <?php  if($success!=""){ ?>
                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                       <strong><?php echo $success; ?></strong>
                    </div>
          
                   <?php }else{}?>
                 
                     <div class="item form-group">
                       
                        <label class="control-label col-md-1 col-sm-1 col-xs-4" for="name">
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                         <input type="textbox" name="name_p" value="<?php if(isset($_POST['name_p'])){
                                    print $_POST['name_p'];
                                 }else{
                                    echo $static_data['name'];
                                 } 
                           ?>" class="form-control col-md-4 col-xs-8"> 
                        </div>
                      </div>
                      
                      <div class="item form-group">
                       
                        <label class="control-label col-md-1 col-sm-1 col-xs-4" for="name">
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <textarea id="content" class="form-control col-md-7 col-xs-12 ckeditor" data-validate-length-range="6" data-validate-words="2" name="content" >
                           <?php if(isset($_POST['submit'])){
                                    print $_POST['content'];
                                 }else{
                                    echo $static_data['content'];
                                 } 
                           ?>
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