<?php
/**
 * Created by Rahul Kumar Choudhary.
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
		
        $meal = mysqli_real_escape_string($conn,$_POST['meal_name']);
        $deliver_food = isset($_POST['deliver_food']) ? $_POST['deliver_food'] : '0';
        $deliver_food = mysqli_real_escape_string($conn,$deliver_food);
        $meal_data = mysqli_query($GLOBALS['conn'],"SELECT `id` FROM `meals` WHERE `meal_name` = '".trim($meal)."'");
        
        if(mysqli_num_rows($meal_data))
        {
          $meal_dataa = mysqli_fetch_assoc($meal_data);
          $meal_id = $meal_dataa['id'];
        }
        else{
            mysqli_query($GLOBALS['conn'],"INSERT INTO `meals`(`meal_name`) VALUES ('".$meal."')");
            $meal_id = mysqli_insert_id($GLOBALS['conn']);
        }
        	$restaurant_menu_id = restaurant_meal_insertion($restaurant_id,$meal_id,$deliver_food);
            $i = 0;
            foreach ($_POST['item'] as $value){
                
            	if(!empty($_POST['subtitle'][$i]))
            	{
                  $subtitle_data = mysqli_query($GLOBALS['conn'],"SELECT `subtitle_id` FROM `subtitle` WHERE `subtitle` = '".trim($_POST['subtitle'][$i])."'");
                 
                  if(mysqli_num_rows($subtitle_data))
                    {
                       $subtitle_dataa = mysqli_fetch_assoc($subtitle_data);
                       $subtitle_id = $subtitle_dataa['subtitle_id'];
                    }
            	  else
            	    {
                       mysqli_query($GLOBALS['conn'],"INSERT INTO `subtitle`(`subtitle`) VALUES ('".mysqli_real_escape_string($conn,$_POST['subtitle'][$i])."')");
                       $subtitle_id = mysqli_insert_id($GLOBALS['conn']);
                     }
                }
                 
                else
                {
                   $subtitleid = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'],"SELECT `subtitle` FROM `restaurant_item_price` ORDER BY id DESC LIMIT 1"));
                   $subtitle_id = $subtitleid['subtitle'];

                }
                $item_id = items_name($value);
                $price = mysqli_real_escape_string($conn,$_POST['price'][$i]);
                $user_id = mysqli_real_escape_string($conn,$_SESSION['user_id']);
                if(empty($item_id))
                {
                	$name = mysqli_real_escape_string($conn,trim($value));
                    mysqli_query($GLOBALS['conn'],"INSERT INTO `items`(`name`,`created_by`) VALUES ('".$name."','".$user_id."')");
                    $item_id = mysqli_insert_id($GLOBALS['conn']);
                	$add_item = mysqli_query($GLOBALS['conn'], "INSERT INTO `restaurant_item_price` (`restaurant_meal_id`,`subtitle`,`item_id`,`item_price`,`created_by`) VALUES ('".$restaurant_menu_id."','".$subtitle_id."','".$item_id."','".$price."','".$user_id."')");
                	
                }
                else
                {
                	$add_item = mysqli_query($GLOBALS['conn'], "INSERT INTO `restaurant_item_price` (`restaurant_meal_id`,`subtitle`,`item_id`,`item_price`,`created_by`) VALUES ('".$restaurant_menu_id."','".$subtitle_id."','".$item_id."','".$price."','".$user_id."')");
                }
                
                $i++;
            }

            $_SESSION["successmsg"] = "Service added successfully.";
            header('Location:venue_meal.php?id='.$restaurant_id);
        

       
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
                                    <input type="text" class="form-control" name="meal_name" id="meal_name" placeholder="Menu">
                                      
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-xs-4 form-group has-feedback">
                                        <label><input type="checkbox" name="deliver_food" class="form-control" id="inputSuccess3" value="1">Home delivery?</label>
                                    </div>
                                    <div class="col-md-5 col-sm-5 col-xs-10 form-group has-feedback">
                                    </div>
                               </div>
                              <div id="subMeal-1">
                                 <div class="row">
                                    <div class="col-md-1 col-sm-1 col-xs-2 form-group">
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-8 form-group ">
                                      <input type="text" class="form-control" name="subtitle[]" id="inputSuccess-1" placeholder="Sub Menu">
                                    </div>

                                 </div>
                                 <div class="add_item row" id="itemID-1">
                                    <div class="col-md-1 col-sm-1 col-xs-2 form-group has-feedback">
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-8 form-group">
                                    <input type="text" class="form-control" name="item[]" id="item_added-1" placeholder="Item">
                                    </div>
                                   
                                    <div class="col-md-2 col-sm-2 col-xs-4 form-group has-feedback">
                                        <input type="text" name="price[]" class="form-control"  placeholder="Price">
                                    </div>

                                </div>
                                <div id="dataAdd-1" class="add_subtitle-1"></div>
                                <input type="hidden" name="selected_item[]" id="selected_item" value= "">
                                <button type="button" name="add_more"  id="item-1" class="btn btn-success" onclick="addItem(this)">Add Item</button>
                             </div>
                              <div id="dataAddsubtitle"></div>
                                <button  name="add_more"  class="btn btn-success add_field_button_subtitle">Add Sub Menu</button>
                   
                                <input type= "hidden" name="restaurant_id" value="<?php echo $restaurant_id; ?>" id="restaurant_id">
                                <input type="hidden" id="selectedvalue" value=""> 
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


