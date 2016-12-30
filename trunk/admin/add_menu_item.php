<?php
/**
 * Created by PhpStorm.
 * User: ankitsing
 * Date: 30/12/16
 * Time: 5:16 PM
 */
ob_start();
include_once('header.php');
$error="";
$sucess="";
try {

    if(isset($_POST["submit"]))
    {
        $name = mysqli_real_escape_string($conn,trim($_POST['name']));
        if(mysqli_query($GLOBALS['conn'],"INSERT INTO `items`(`name`,`created_by`) VALUES ('".$name."','".$_SESSION['user_id']."')")){
            $_SESSION["successmsg"] = "Service added successfully.";
            header('Location:item_list.php');
        }
        else
        {
            $_SESSION["errormsg"] = "insertion error.";
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
                            <h2>Add Menu</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                            <form class="form-horizontal form-label-left" id="add_item" method="post">
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


                               <!-- <input type="hidden" name="selected_meals" id="selected_meals" value="" />-->
                                <input type="hidden" name="selected_meals" id="selected_meals" value="" />
                                <div class="item form-group" id="allMeal-1">
                                    <div class="item form-group col-sm-6">
                                        <label class="control-label col-md-6 col-sm-3 col-xs-12">Select Meal</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select class="select2_multiple form-control" name="meal[]" id="allMealling-1">
                                                <option value="">Select Meal</option>
                                                <?php
							  $meal = get_all_data('meals');
							  $i =1;
								while($mealData = mysqli_fetch_assoc($meal)){
								  echo '<option value="'.$mealData['id'].'">'.$mealData['meal_name'].'</option>';
								  $i = $i +1;
							    }
							?>
                                            </select>
                                        </div>
                                    </div>
                                    <input type="hidden" value="<?php /*echo $i-1;*/?>" id="totalMeal">
                                    <div class="item form-group col-sm-6">
                                        <label class="control-label col-md-2 col-sm-6 col-xs-6">Price</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input id="test" class="form-control col-md-7 col-xs-12"  name="price[]" type="text" >
                                        </div>

                                    </div>
                                </div>
                                <div id="addMeal"></div>
                                <div class="item form-group">
                                    <div class="col-md-6 col-sm-offset-3">
                                        <span class="glyphicon glyphicon-plus btn btn-success" id="meal-1" onclick="addMeal(this)">Add</span>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <label><input type="checkbox" name="deliever" value="1">Check for delivery</label>
                                        </div>
                                    </div>
                                <!--<div id="addMeal"></div>
                                <div class="item form-group">
                                    <div class="col-md-6 col-sm-offset-3">
                                        <span class="glyphicon glyphicon-plus btn btn-success" id="meal-1" onclick="addMeal(this)">Add</span>
                                    </div>
                                </div>-->

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