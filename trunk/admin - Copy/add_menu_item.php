<?php
/**
 * Created by PhpStorm.
 * User: ankitsing
 * Date: 30/12/16
 * Time: 5:16 PM
 */
ob_start();
include_once('header.php');
$restaurant_id = isset($_SESSION['restaurant_id']) ? $_SESSION['restaurant_id'] : $_GET['restaurant_id'];
$error="";
$sucess="";
try {

    if(isset($_POST["submit"]))
    {
       
        $deliver_food = isset($_REQUEST['deliver_food']) ? $_REQUEST['deliver_food'] : '0';
        $restaurant_id = isset($_SESSION['restaurant_id']) ? $_SESSION['restaurant_id'] : $_REQUEST['restaurant_id'];
        if(mysqli_query($GLOBALS['conn'],"INSERT INTO `restaurant_meal_details`(`restaurant_id`,`meal`,`deliver_food`) VALUES ('".$restaurant_id."','".$_REQUEST['meal']."','".$deliver_food."')")){
            $restaurant_menu_id = mysqli_insert_id($GLOBALS['conn']);
            $i = 0;
            foreach ($_POST['item'] as $value){
                $item_id = items_name($value);
                $add_item = mysqli_query($GLOBALS['conn'], "INSERT INTO `restaurant_item_price` (`restaurant_meal_id`,`item_id`,`quantity`,`item_price`,`created_by`) VALUES ('".$restaurant_menu_id."','".$item_id."','".$_POST['quantity'][$i]."','".$_POST['price'][$i]."','".$_SESSION['user_id']."')");
                $i++;
            }

            $_SESSION["successmsg"] = "Service added successfully.";
            header('Location:venue_meal.php?id='.$restaurant_id);
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

                            <form class="form-horizontal form-label-left" id="add_item_price" method="post">
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

                               <div class="row">
                                    <div class="col-md-1 col-sm-1 col-xs-2 form-group has-feedback">
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-8 form-group has-feedback">
                                       <select class="select2_multiple form-control" name="meal" id="allMealling">
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
                                    <div class="col-md-2 col-sm-2 col-xs-4 form-group has-feedback">
                                        <label><input type="checkbox" name="deliver_food" class="form-control" id="inputSuccess3" value="1">Home delivery?</label>
                                    </div>
                                    <div class="col-md-5 col-sm-5 col-xs-10 form-group has-feedback">
                                    </div>

                                </div>

                                <div class="add_item row" id="itemID-1">
                                    <div class="col-md-1 col-sm-1 col-xs-2 form-group has-feedback">
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-8 form-group has-feedback">
                                    <input type="text" class="form-control has-feedback-left auto" name="item[]" id="inputSuccess-1" placeholder="Select Item">
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-xs-4 form-group has-feedback">
                                        <input type="text" name="quantity[]" class="form-control" placeholder="Quantity">
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-xs-4 form-group has-feedback">
                                        <input type="text" name="price[]" class="form-control"  placeholder="Price">
                                    </div>

                                </div>
                                <div id="dataAdd"></div>
                                <input type="hidden" name="selected_item[]" id="selected_item" value= "">
                                <button  name="add_more"  class="btn btn-success add_field_button">Add More</button>
                                <input type= "hidden" name="restaurant_id" value="<?php echo $restaurant_id; ?>" id="restaurant_id">

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
<script>
/* $('input.auto').each(function() {
    $(this).autocomplete({
        source: "select_items.php",
        minLength: 1
    });
});*/
</script>


