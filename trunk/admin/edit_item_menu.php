<?php
/**
 * Created by PhpStorm.
 * User: ankitsing
 * Date: 3/1/17
 * Time: 8:04 PM
 */
ob_start();
include_once('header.php');
$error="";
$sucess="";
try {
   
    $item_data = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'],"SELECT rip.*,rmd.meal as meal FROM `restaurant_item_price` rip join restaurant_meal_details rmd on rip.restaurant_meal_id = rmd.id  WHERE rip.id ='".$_GET['id']."'"));

    
    $deliver_food_details = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'],"SELECT * FROM `restaurant_meal_details` WHERE `id` ='".$item_data['restaurant_meal_id']."'"));
    $item_details = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'],"SELECT * FROM `items` WHERE `id` ='".$item_data['item_id']."'"));
    if(isset($_POST["submit"]))
    {
        $deliver_food = isset($_REQUEST['deliver_food']) ? $_REQUEST['deliver_food'] : '0';
        $update_menu = mysqli_query($GLOBALS['conn'],"UPDATE `restaurant_meal_details` SET `deliver_food`= '".$deliver_food."' WHERE id = '".$item_data['restaurant_meal_id']."'");
        /*print_r("UPDATE `restaurant_item_price` SET `item_id`= '".$_POST['item1']."',`quantity`='".$_POST['quantity']."', `item_price`= '".$_POST['price']."' WHERE id = '".$_GET['id']."'");exit;*/
        if(mysqli_query($GLOBALS['conn'],"UPDATE `restaurant_item_price` SET `item_id`= '".$_POST['item1']."',`quantity`='".$_POST['quantity']."', `item_price`= '".$_POST['price']."' WHERE id = '".$_GET['id']."'")){
            $_SESSION["successmsg"] = "Item updated successfully.";
            header('Location:venue_meal.php?id='.$deliver_food_details['restaurant_id']);
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
                            <h2>Edit Item</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                            <form class="form-horizontal form-label-left" id="edit_item_price" method="post">
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
                                    <?php //$meal_name = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'],"SELECT meal_name FROM meals WHERE id = '".$item_data['meal']."'"));
                                       //echo  $meal_name['meal_name']; ?>
                                         <select class="select2_multiple form-control" name="meal" id="allMealling" disabled>
                                            <option value="">Select Meal</option>
                                            <?php
                                            $meal = get_all_data('meals');
                                            
                                            while($mealData = mysqli_fetch_assoc($meal)){ ?>
                                            <option value ="<?php echo $mealData['id']; ?>" <?php if($mealData['id'] == $item_data['meal']){echo "selected";} ?> ><?php echo $mealData['meal_name']; ?></option>
                                            <?php }
                                            ?>
                                        </select> 
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-xs-4 form-group has-feedback">
                                        <label><input type="checkbox" name="deliver_food" class="form-control" id="inputSuccess3" value="1" <?php echo $deliver_food_details['deliver_food']=='1'?' checked="checked" ':''; ?>>Home delivery?</label>
                                    </div>
                                    <div class="col-md-5 col-sm-5 col-xs-10 form-group has-feedback">
                                    </div>

                                </div>

                                <div class="add_item row" id="itemID-1">
                                    <div class="col-md-1 col-sm-1 col-xs-2 form-group has-feedback">
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-8 form-group has-feedback">
                                        <input type= "hidden" name="item1" value="<?php echo isset($item_details['id']) ? $item_details['id'] : '';?>" id="restaurant_id">
                                        <input type="text" class="form-control has-feedback-left auto" name="item" value="<?php echo isset($item_details['name']) ? $item_details['name'] : '';?>" id="inputSuccess-1" placeholder="Select Item">
                                    </div>
                                    <input type="hidden" id="txtAllowSearchID[]">
                                    <div class="col-md-2 col-sm-2 col-xs-4 form-group has-feedback">
                                        <input type="text" name="quantity" value="<?php echo isset($item_data['quantity']) ? $item_data['quantity'] : '';?>" class="form-control" placeholder="Quantity">
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-xs-4 form-group has-feedback">
                                        <input type="text" name="price" class="form-control"  value="<?php echo isset($item_data['item_price']) ? $item_data['item_price'] : '';?>" placeholder="Price">
                                    </div>

                                </div>
                                <div id="dataAdd"></div>
                                <input type="hidden" name="selected_item[]" id="selected_item" value= "">
                                <!--<button  name="add_more"  class="btn btn-success add_field_button">Add More</button>-->
                                <input type= "hidden" name="restaurant_id" value="<?php echo $restaurant_id; ?>" id="restaurant_id">

                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <button type="submit" name="submit" value="submit" class="btn btn-success">Update</button>
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