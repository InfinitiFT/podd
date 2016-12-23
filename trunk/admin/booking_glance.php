<?php
/**
 * Created by PhpStorm.
 * User: ankitsing
 * Date: 21/12/16
 * Time: 4:27 PM
 */
  include_once('header.php');
$find_interval = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM restaurant_details WHERE restaurant_id = '".$_SESSION['restaurant_id']."' "));
$a = explode(':',$find_interval['opening_time']);
$b = explode(':',$find_interval['closing_time']);
$array = array();
for($hours=$a[0]; $hours<$b[0]; $hours++) { 
	// the interval for hours is '1'
    for ($mins = $a[1]; $mins < 60; $mins += 30) {
        // the interval for mins is '30'
        $array[] = str_pad($hours, 2, '0', STR_PAD_LEFT) . ':' . str_pad($mins, 2, '0', STR_PAD_LEFT);
        $i = $i + 1;
    }
}

 ?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Booking at Glance</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a href="booking_list_restaurant.php"><button type="button" class="btn btn-round btn-success">Back</button></a>
                            </li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>
<style>
    .carousel-content {
        color:black;
        display:flex;
        align-items:center;
    }

    #text-carousel {
        width: 100%;
        height: auto;
        padding: 50px;
    }
</style>
                    <div id="text-carousel" class="carousel slide" data-ride="carousel">
                        <!-- Wrapper for slides -->
                        <div class="row">
                            <div class="col-xs-offset-3 col-xs-6">
                                <div class="carousel-inner">
                                    <div class="item active">
                                        <div class="carousel-content">
                                            <div>
                                                <input type="hidden" id="cur_date">
                                                <p id="day_name"></p>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- Controls --> <a class="left carousel-control" href="#text-carousel" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left"></span>
                        </a>
                        <a class="right carousel-control" href="#text-carousel" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right"></span>
                        </a>

                    </div>


                    <div class="x_content">

                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Time Interval</th>
                                <th>Bookings</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i= 1;
                            foreach ($array as $value) {
                            
                                $find_booking = mysqli_query($conn,"SELECT * FROM booked_records_restaurant WHERE restaurant_id = '".$_SESSION['restaurant_id']."' AND booking_time = '".$value."' ");
                                $wholeArray = array();
                                while($no_of_booking = mysqli_fetch_assoc($find_booking)){
                                    $wholeArray[] = $no_of_booking['number_of_people'];
                                }
                               $bookings=  implode(' ',$wholeArray);
                                echo '<tr>
                                <th scope="row">'.$i.'</th>
                                <td>'.$value.'</td>
                                <td>'.$bookings.'</td>
                            </tr>';
                                $i++;
                            }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->

<?php include_once('footer.php'); ?>
<script>
    function get_day_name(day_no) {
        switch (day_no) {
            case 0:
                day = "Sunday";
                return day;
                break;
            case 1:
                day = "Monday";
                return day;
                break;
            case 2:
                day = "Tuesday";
                return day;
                break;
            case 3:
                day = "Wednesday";
                return day;
                break;
            case 4:
                day = "Thursday";
                return day;
                break;
            case 5:
                day = "Friday";
                return day;
                break;
            case 6:
                day = "Saturday";
                return day;
            break;
        }
    }
    
</script>
<script>
    $('document').ready(function () {

        var d = new Date();
        /*var strDate = d.getDate() + "/" + (d.getMonth()+1) + "/" + d.getFullYear();*/
        $("#day_name").html("<b>Today</b>");
        $("#cur_date").val(d.getDay());
        /*alert(month+'hello'+day+d.getDay());*/
    });
    var count = 1;
    $('.glyphicon-chevron-right').click(function () {
        var cur_date = $('#cur_date').val();
        var increase_day = parseInt(cur_date) + 1;
        if (count++ == 1){
            $("#day_name").html("<b>Tomorrow</b>");
            $("#cur_date").val(increase_day.toString());
        } else {
            var d = new Date();
            if (d.getDay() == increase_day){
                $("#day_name").html("<b>Today</b>");
                $("#cur_date").val(increase_day.toString());
            }else {
                if (increase_day > 6) {
                    increase_day = 0;
                }
                var name = get_day_name(increase_day);
                $("#cur_date").val(increase_day.toString());
                $("#day_name").html("<b>" + name + "</b>");
            }
        }


    });

    $('.glyphicon-chevron-left').click(function () {
        var cur_date = $('#cur_date').val();
        var increase_day = parseInt(cur_date) - 1;
        if (count++ == 1){
            $("#day_name").html("<b>Yesterday</b>");
            $("#cur_date").val(increase_day.toString());
        } else {
            var d = new Date();
            if (d.getDay() == increase_day){
                $("#day_name").html("<b>Today</b>");
                $("#cur_date").val(increase_day.toString());
            }else {
                if (increase_day < 0) {
                    increase_day = 6;
                }
                var name = get_day_name(increase_day);
                $("#cur_date").val(increase_day.toString());
                $("#day_name").html("<b>" + name + "</b>");
            }
        }
    });

</script>