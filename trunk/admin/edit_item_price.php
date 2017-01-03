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
            header('Location:venue_meal.php?restaurant_id='.$restaurant_id);
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
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
            </div>
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2> Edit Booking</h2>
                    <?php echo $mes; ?>
					<div class="clearfix"></div>
                  </div>
                  <div class="x_content">
					<form class="form-horizontal form-label-left" method="post" id="edit_booking" novalidate>
					 
                     <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="name" class="form-control col-md-7 col-xs-12" value="<?php if($_POST['name']){ echo $_POST['name'];}else{ echo $bookingData['name'];} ?>" data-validate-length-range="6" data-validate-words="2" name="name"  type="text">
                        </div>
                        <div id="mealAdded"></div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="email" id="email" name="email"  value="<?php if($_POST['email']){ echo $_POST['email'];}else{ echo $bookingData['email'];} ?>" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone">Phone
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="phone" name="phone"  value="<?php if($_POST['phone']){ echo $_POST['phone'];}else{ echo $bookingData['contact_no'];} ?>" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                     <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="booking_date">Booking Date </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="booking_date" name="booking_date"  value="<?php if($_POST['booking_date']){ echo $_POST['booking_date'];}else{ echo $bookingData['booking_date'];} ?>" data-validate-length-range="8,20" class="form-control col-md-7 col-xs-12" aria-describedby="inputSuccess2Status" >
                        </div>
                      </div>
                      <div class="item form-group">
                        <label for="booking_time" class="control-label col-md-3">Booking Time</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
							<select class="form-control col-md-7 col-xs-12" name="booking_time" id="booking_time">
							<?php 
              $all_data = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'],"SELECT * FROM booked_records_restaurant brr join restaurant_details rd on brr.restaurant_id = rd.restaurant_id where brr.booking_id = '".$_GET['id']."'" ));
              
              $time_interval = findtimeIntervalweb($all_data['opening_time'],$all_data['closing_time']);
              
                foreach($time_interval as $record){
               
              ?>
              <option value= "<?php echo $record;?>"><?php echo $record;?></option>>
              <?php } ?>
							</select>
                          
                        </div>
                      </div>
                     
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="people">Max number of people </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="people" name="people"  value="<?php if($_POST['people']){ echo $_POST['people'];}else{ echo $bookingData['number_of_people'];} ?>" data-validate-length-range="8,20" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                    <input type="hidden" value="<?php echo url();?>" id="urlData">
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                          <button id="send" type="submit" name="submit" class="btn btn-success">Save</button>
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

