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
   $item_data = mysqli_query($GLOBALS['conn'],"SELECT rip.*,rip.id as edit_id,rmd.meal as meal,rmd.deliver_food as deliver_food,i.*,st.subtitle as sname FROM `restaurant_item_price` rip join restaurant_meal_details rmd on rip.restaurant_meal_id = rmd.id join items i on rip.item_id = i.id join subtitle st on st.subtitle_id = rip.subtitle WHERE rmd.meal = '".decrypt_var($_GET['id'])."' And rmd.restaurant_id = '".decrypt_var($_GET['restaurant_id'])."'");
   $deliver_food = mysqli_fetch_assoc($item_data);
  

    if(isset($_POST["submit"]))
    {
		// check meal name is exist or not 
        $meal = mysqli_real_escape_string($conn,$_POST['meal_name']);
        $deliver_food = $_POST['deliver_food'];
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
		// check subtitle name is exist or not 
		
		if(!empty($_POST['restaurant_copy_menu']))
		{
			foreach($_POST['restaurant_copy_menu'] as $restaurant_idd)
			{
				    $restaurant_menu_id1 = restaurant_meal_insertion($restaurant_idd,$meal_id,$deliver_food);
					$i = 0;
					foreach($_POST['subtitle'] as $subtitle)
					{
					  $subtitle_data = mysqli_query($GLOBALS['conn'],"SELECT `subtitle_id` FROM `subtitle` WHERE `subtitle` = '".trim($subtitle)."'");
					if(mysqli_num_rows($subtitle_data))
						{
							$subtitle_dataa = mysqli_fetch_assoc($subtitle_data);
							$subtitle = $subtitle_dataa['subtitle_id'];
						}
					else
					   {
							mysqli_query($GLOBALS['conn'],"INSERT INTO `subtitle` (`subtitle`) VALUES ('".mysqli_real_escape_string($conn,$subtitle)."')");
							$subtitle = mysqli_insert_id($GLOBALS['conn']);
					   }
					
					

					// check item name is exist or not 
					$chk_item = items_name($_POST['item'][$i]);
					
					if($chk_item != '')
					{
						$item = $chk_item;
					}
					else
					{
						$name = mysqli_real_escape_string($conn,trim($_POST['item'][$i]));			
						$query  = mysqli_query($GLOBALS['conn'],"INSERT INTO `items`(`name`,`created_by`) VALUES ('".$name."','".$_SESSION['user_id']."')");
						$item = mysqli_insert_id($GLOBALS['conn']);
					}
					$add_item = mysqli_query($GLOBALS['conn'], "INSERT INTO `restaurant_item_price` (`restaurant_meal_id`,`subtitle`,`item_id`,`item_price`,`created_by`) VALUES ('".$restaurant_menu_id1."','".$subtitle."','".$item."','".$_POST['price'][$i]."','".$_SESSION['user_id']."')");
					
					
					
					$i++;
					
				 }
				
			}
			
			
			
			
			
		}
		$i = 0;
		// check subtitle name is exist or not 
		$restaurant_menu_id = restaurant_meal_insertion(decrypt_var($_GET['restaurant_id']),$meal_id,$deliver_food);
		
		foreach($_POST['subtitle'] as $subtitle)
		{
			  $subtitle_data = mysqli_query($GLOBALS['conn'],"SELECT `subtitle_id` FROM `subtitle` WHERE `subtitle` = '".trim($subtitle)."'");
			if(mysqli_num_rows($subtitle_data))
				{
					$subtitle_dataa = mysqli_fetch_assoc($subtitle_data);
					$subtitle = $subtitle_dataa['subtitle_id'];
				}
			else
			   {
					mysqli_query($GLOBALS['conn'],"INSERT INTO `subtitle` (`subtitle`) VALUES ('".mysqli_real_escape_string($conn,$subtitle)."')");
					$subtitle = mysqli_insert_id($GLOBALS['conn']);
			   }
			
			

			// check item name is exist or not 
			$chk_item = items_name($_POST['item'][$i]);
			
			if($chk_item != '')
			{
				$item = $chk_item;
			}
			else
			{
				$name = mysqli_real_escape_string($conn,trim($_POST['item'][$i]));			
				$query  = mysqli_query($GLOBALS['conn'],"INSERT INTO `items`(`name`,`created_by`) VALUES ('".$name."','".$_SESSION['user_id']."')");
				$item = mysqli_insert_id($GLOBALS['conn']);
			}
			
			// condition to check if menu is changed or not
			if($_POST['restaurant_meal_id']== $restaurant_menu_id)
			{
				
				mysqli_query($GLOBALS['conn'],"UPDATE `restaurant_item_price` SET `subtitle`= '".$subtitle."',`item_id`= '".$item."',`item_price`= '".$_POST['price'][$i]."' WHERE id = '".$_POST['item1'][$i]."'");
				
			}
			else{
				
				 mysqli_query($GLOBALS['conn'],"DELETE FROM `restaurant_meal_details` WHERE id = '".$_POST['restaurant_meal_id']."'");
				 mysqli_query($GLOBALS['conn'], "INSERT INTO `restaurant_item_price` (`restaurant_meal_id`,`subtitle`,`item_id`,`item_price`,`created_by`) VALUES ('".$restaurant_menu_id."','".$subtitle."','".$item."','".$_POST['price'][$i]."','".$_SESSION['user_id']."')");
			}
			$i++;
			
		}
		header('Location:venue_meal.php?id='.$_GET['restaurant_id']);
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
                            <h2>Edit Menu</h2>
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
                                    <?php $meal_name = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'],"SELECT `meal_name` FROM `meals` WHERE `id` = '".decrypt_var($_GET['id'])."'"));
                                    
                                    ?>
                                    <input type="text" class="form-control" name="meal_name" id="meal_name" placeholder="Meal Name" value = "<?php echo $meal_name['meal_name']; ?>">
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-xs-4 form-group has-feedback">
                                        <label><input type="checkbox" name="deliver_food" class="form-control" id="inputSuccess3" value="1" <?php echo $deliver_food['deliver_food']=='1'?' checked="checked" ':''; ?>>Home delivery?</label>
                                    </div>
                                   
									<?php if($_SESSION['restaurant_id'] == ""){?>
									 <div class="col-md-5 col-sm-5 col-xs-10 form-group has-feedback">
									 <select class="form-control" name="restaurant_copy_menu[]" placeholder="Restaurant Name" id="select_restaurant" value = "" multiple>
									<?php $restaurant_data = mysqli_query($GLOBALS['conn'],"SELECT rd.restaurant_name,rd.restaurant_id FROM `restaurant_details` rd left join restaurant_meal_details rmd on rd.restaurant_id = rmd.restaurant_id where (rmd.meal !=  '".decrypt_var($_GET['id'])."' OR rmd.meal IS NULL) group by rd.restaurant_id");
								
									while($restaurant = mysqli_fetch_assoc($restaurant_data)){?>
										  <option value="<?php echo $restaurant['restaurant_id']; ?>"><?php echo $restaurant['restaurant_name']; ?></option>
								    <?php }?>
                                    </select>
									  </div>
									<?php }else{?>
									<div class="col-md-5 col-sm-5 col-xs-10 form-group has-feedback">
									</div>
                                     <?php }?>

                                </div>
								<?php $edit_id = array();while($record = mysqli_fetch_assoc($item_data)){
									//$edit_id[] = $record['id'];
									
									
									?>
                                 <div class="row">
                                    <div class="col-md-1 col-sm-1 col-xs-2 form-group has-feedback">
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-8 form-group has-feedback">
                                     <input type="text" class="form-control" value="<?php echo isset($record['sname']) ? $record['sname'] : '';?>" name="subtitle[]" id="inputSuccess-1" placeholder="Subtitle">
                                    </div>
                                 
                                </div>
                                <div class="add_item row" id="itemID-1">
                                    <div class="col-md-1 col-sm-1 col-xs-2 form-group has-feedback">
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-8 form-group has-feedback">
                                        <input type= "hidden" name="item1[]" value="<?php echo $record['edit_id'];?>">
                                        <input type="text" class="form-control  auto" name="item[]" value="<?php echo isset($record['name']) ? $record['name'] : '';?>" id="inputSuccess-1" placeholder="Select Item">
										
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-xs-4 form-group has-feedback">
                                        <input type="text" name="price[]" class="form-control"  value="<?php echo isset($record['item_price']) ? $record['item_price'] : '';?>" placeholder="Price">
                                    </div>

                                </div>
							    <?php } ?>
								<input type="hidden" name="restaurant_meal_id" value="<?php echo $deliver_food['restaurant_meal_id']; ?>">
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
