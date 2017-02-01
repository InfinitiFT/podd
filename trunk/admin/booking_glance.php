<?php
/**
 * Created by PhpStorm.
 * User: ankitsing
 * Date: 21/12/16
 * Time: 4:27 PM
 */
include_once('header.php');
/*$find_interval = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM restaurant_details WHERE restaurant_id = '".$_SESSION['restaurant_id']."' "));
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
}*/

?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Table Management</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <?php if ($_SESSION['restaurant_id'] == "") { ?>
                                <li><a href="restaurant_list.php">
                                        <button type="button" class="btn btn-round btn-success">Back</button>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <style>
                        .carousel-content {
                            color: black;
                            display: flex;
                            align-items: center;
                        }

                        #text-carousel {
                            width: 100%;
                            height: auto;
                            padding: 50px;
                        }
                    </style>
                    <nav class="navbar navbar-default">
                        <div class="container-fluid">
                            <ul class="nav navbar-nav nav-color-btn">
                                <li class="active"><a href="#" class="btn btn-round" id="day_first">Day</a></li>
                                <li><a href="#" class="btn btn-round" id="day_second">Day</a></li>
                                <li ><a href="#" class="btn btn-round" id="day_third">Day</a></li>
                                <li ><a href="#" class="btn btn-round btn-green" id="day_fourth">Day</a></li>
                                <li ><a href="#" class="btn btn-round" id="day_fifth">Day</a></li>
                                <li ><a href="#" class="btn btn-round" id="day_sixth">Day</a></li>
                                <li ><a href="#" class="btn btn-round" id="day_seventh">Day</a></li>
                            </ul>
                        </div>
                    </nav>
                    <div id="text-carousel" class="carousel slide" data-ride="carousel">
                        <!-- Wrapper for slides -->

                        <div class="carousel-inner">
                            <div class="item active">
                                <div class="carousel-content">
                                    <input type="hidden" id="cur_date">
                                    <input type="hidden" id="cur_date1">
                                    <p id="day_name"></p>
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

    //get Leap year
    function isLeapYear(year) {
        return (((year % 4 === 0) && (year % 100 !== 0)) || (year % 400 === 0));
    }

    //get getDaysInMonth
    function getDaysInMonth(year, month) {
        return new Date(year, month, 0).getDate();
    }

    //padding a number
    function pad(num, size) {
        return ( Math.pow(10, size) + ~~num ).toString().substring(1);
    }
    function GetDates(startDate, daysToAdd) {
        var aryDates = [];

        for (var i = 0; i <= daysToAdd; i++) {
            var currentDate = new Date();
            currentDate.setDate(startDate.getDate() + i);
            aryDates.push(get_day_name(currentDate.getDay()) + ", " + currentDate.getFullYear() + "-" + pad((currentDate.getMonth() + 1), 2) + "-" + pad(currentDate.getDate(),2));
        }

        return aryDates;
    }

</script>
<script>
    var restaurant_id = "<?php echo decrypt_var($_REQUEST['restaurant_id']);?>";
    $("[id ^='day_']").click(function(e) {
        var dayID  = $(this).html();
        var abc = dayID.split(",");
        var xyz = abc[1].split(" ");
        console.log(xyz[1]);
        $.ajax({
            type: 'POST',
            url: 'booking_glance_details.php',
            data: {"date1": xyz[1], "restaurant_id": restaurant_id},
            success: function (response) {
                $(".x_content").html(response);
            }
        });

        //$("#adminRemovestudent").attr("id","adminRemovestudent-"+studentArr[1]);
    });

    $('document').ready(function () {
        var d = new Date();
        var strDate = d.getFullYear() + "-" + pad((d.getMonth() + 1), 2) + "-" + pad(d.getDate(), 2);
        $("#day_name").html("<b><strong>" + strDate + ":- </strong> Today</b>");

       var allDates = GetDates(d,6);
        console.log(allDates);
        var myArray = new Array();
        var i,j,temparray,chunk = 1;
        for (i=0,j=allDates.length; i<j; i+=chunk) {
            temparray = allDates.slice(i,i+chunk);
            myArray.push(temparray);
        }


        $("#day_first").html("<b><strong>" + myArray[0] + " </strong></b>");
        $("#day_second").html("<b><strong>" + myArray[1] + " </strong></b>");
        $("#day_third").html("<b><strong>" + myArray[2] + " </strong></b>");
        $("#day_fourth").html("<b><strong>" + myArray[3] + " </strong></b>");
        $("#day_fifth").html("<b><strong>" + myArray[4] + " </strong></b>");
        $("#day_sixth").html("<b><strong>" + myArray[5] + " </strong></b>");
        $("#day_seventh").html("<b><strong>" + myArray[6] + " </strong></b>");

        $("#cur_date").val(d.getDay());
        $("#cur_date1").val(strDate);

        $.ajax({
            type: 'POST',
            url: 'booking_glance_details.php',
            data: {"date1": strDate, "restaurant_id": restaurant_id},
            success: function (response) {
               
                $(".x_content").html(response);
            }
        });
        /*alert(month+'hello'+day+d.getDay());*/
    });
    var count = 1;
    $('.glyphicon-chevron-right').click(function () {
        var cur_date = $('#cur_date').val();
        var cur_date1 = $('#cur_date1').val();
        var splitArr = cur_date1.split('-');


        //console.log(isLeapYear(splitArr[0])+"leapyear "+getDaysInMonth(splitArr[0], splitArr[1]));
        if (splitArr[2] == getDaysInMonth(splitArr[0], splitArr[1])) {
            if (splitArr[1] == 12) {
                var increase_year = parseInt(splitArr[0]) + 1;
                var increase_month = pad(1, 2);
                var increase_dayDate = pad(1, 2);
                var strDate = increase_year + "-" + pad(increase_month, 2) + "-" + pad(increase_dayDate, 2);
            } else {
                if (parseInt(splitArr[1]) + 1 < 10) {
                    var increase_month = pad(parseInt(splitArr[1]) + 1, 2);
                } else {
                    var increase_month = parseInt(splitArr[1]) + 1;
                }
                var increase_dayDate = pad(1, 2);
                var strDate = splitArr[0] + "-" + pad(increase_month, 2) + "-" + pad(increase_dayDate, 2);
            }
        } else {
            if (parseInt(splitArr[2]) + 1 < 10) {
                var increase_dayDate = pad(parseInt(splitArr[2]) + 1, 2);
            } else {
                var increase_dayDate = parseInt(splitArr[2]) + 1;
            }
            var strDate = splitArr[0] + "-" + pad(splitArr[1], 2) + "-" + pad(increase_dayDate, 2);
        }
        console.log(strDate);
        /*var strDate = splitArr[0] + "-" + splitArr[1] + "-" + increase_dayDate;*/
        var increase_day = parseInt(cur_date) + 1;
        var currentDate = new Date(new Date().getTime() + 24 * 60 * 60 * 1000);
        var day = currentDate.getDate()
        var previous_day = currentDate.getDate() - 2
        var month = currentDate.getMonth() + 1
        var year = currentDate.getFullYear()
        var checkTomorrowDate = year + "-" + pad(month, 2) + "-" + pad(day, 2);
        var checkYesterdayDate = year + "-" + pad(month, 2) + "-" + pad(previous_day, 2);

        console.log(checkTomorrowDate + "   " + checkYesterdayDate);
        if (count++ == 1 || checkTomorrowDate == strDate) {
            $("#day_name").html("<b><strong>" + strDate + ":- </strong>Tomorrow</b>");
            $("#cur_date").val(increase_day.toString());
            $("#cur_date1").val(strDate);
        } else if (checkYesterdayDate == strDate) {
            $("#day_name").html("<b><strong>" + strDate + ":- </strong>Yesterday</b>");
            $("#cur_date").val(increase_day.toString());
            $("#cur_date1").val(strDate);
        } else {
            var d = new Date();
            var checkTodayDate = d.getFullYear() + "-" + pad((d.getMonth() + 1), 2) + "-" + pad(d.getDate(), 2);
            if (checkTodayDate == strDate) {
                $("#day_name").html("<b><strong>" + strDate + ":- </strong>Today</b>");
                $("#cur_date").val(increase_day.toString());
                $("#cur_date1").val(strDate);
            } else {
                if (increase_day > 6) {
                    increase_day = 0;
                }
                var name = get_day_name(increase_day);
                $("#cur_date").val(increase_day.toString());
                $("#cur_date1").val(strDate);
                $("#day_name").html("<b><strong>" + strDate + ":- </strong>" + name + "</b>");
            }
        }

        $.ajax({
            type: 'POST',
            url: 'booking_glance_details.php',
            data: {"date1": strDate, "restaurant_id": restaurant_id},
            success: function (response) {
                $(".x_content").html(response);
            }
        });


    });

    $('.glyphicon-chevron-left').click(function () {
        var cur_date = $('#cur_date').val();
        var cur_date1 = $('#cur_date1').val();
        var splitArr = cur_date1.split('-');

        if (splitArr[2] == 01) {
            if (splitArr[1] == 01) {
                var decrease_year = parseInt(splitArr[0]) - 1;
                var decrease_month = 12;
                var decrease_dayDate = 31;
                var strDate = decrease_year + "-" + pad(decrease_month, 2) + "-" + pad(decrease_dayDate, 2);
            } else {
                if (parseInt(splitArr[1]) - 1 < 10) {
                    var decrease_month = pad(parseInt(splitArr[1]) - 1, 2);
                } else {
                    var decrease_month = parseInt(splitArr[1]) - 1;
                }
                var decrease_dayDate = getDaysInMonth(splitArr[0], splitArr[1] - 1);
                var strDate = splitArr[0] + "-" + pad(decrease_month, 2) + "-" + pad(decrease_dayDate, 2);
            }
        } else {
            if (parseInt(splitArr[2]) - 1 < 10) {
                var decrease_dayDate = pad(parseInt(splitArr[2]) - 1, 2);
            } else {
                var decrease_dayDate = parseInt(splitArr[2]) - 1;
            }
            var strDate = splitArr[0] + "-" + pad(splitArr[1], 2) + "-" + pad(decrease_dayDate, 2);
        }
        console.log(strDate);
        //var increase_dayDate = parseInt(splitArr[2]) - 1;
        //var strDate = splitArr[0] + "-" + splitArr[1] + "-" + increase_dayDate;
        var decrease_day = parseInt(cur_date) - 1;
        var yesterday = new Date(new Date() - 24 * 60 * 60 * 1000);
        var day = yesterday.getDate()
        var next_day = yesterday.getDate() + 2
        var month = yesterday.getMonth() + 1
        var year = yesterday.getFullYear()
        var checkYesterdayDate = year + "-" + pad(month, 2) + "-" + pad(day, 2);
        var checkTomorrowDate = year + "-" + pad(month, 2) + "-" + pad(next_day, 2);
        console.log(checkYesterdayDate + '   ' + checkTomorrowDate);
        if (count++ == 1 || checkYesterdayDate == strDate) {
            $("#day_name").html("<b><strong>" + strDate + ":- </strong>Yesterday</b>");
            $("#cur_date").val(decrease_day.toString());
            $("#cur_date1").val(strDate);
        } else if (checkTomorrowDate == strDate) {
            $("#day_name").html("<b><strong>" + strDate + ":- </strong>Tomorrow</b>");
            $("#cur_date").val(decrease_day.toString());
            $("#cur_date1").val(strDate);
        } else {
            var d = new Date();
            var checkTodayDate = d.getFullYear() + "-" + pad((d.getMonth() + 1), 2) + "-" + pad(d.getDate(), 2);
            if (checkTodayDate == strDate) {
                $("#day_name").html("<b><strong>" + strDate + ":- </strong>Today</b>");
                $("#cur_date").val(decrease_day.toString());
                $("#cur_date1").val(strDate);
            } else {
                if (decrease_day < 0) {
                    decrease_day = 6;
                }
                var name = get_day_name(decrease_day);
                $("#cur_date").val(decrease_day.toString());
                $("#cur_date1").val(strDate);
                $("#day_name").html("<b><strong>" + strDate + ":- </strong>" + name + "</b>");
            }
        }
        $.ajax({
            type: 'POST',
            url: 'booking_glance_details.php',
            data: {"date1": strDate, "restaurant_id": restaurant_id},
            success: function (response) {
                $(".x_content").html(response);
            }
        });
    });
</script>