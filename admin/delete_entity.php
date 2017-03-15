<?php
include('../functions/functions.php');
$type = $_POST['pagetype'];
$id   = $_POST['id'];
if ($type == "service_management") {
    if (mysqli_query($GLOBALS['conn'], "DELETE FROM `service_management` WHERE `service_id` = '" . mysqli_real_escape_string($GLOBALS['conn'], $id) . "'")) {
        echo "success";
    } else {
        echo "error";
    }
} else if ($type == "users") {
    if (mysqli_query($GLOBALS['conn'], "DELETE FROM `users` WHERE `user_id` = '" . mysqli_real_escape_string($GLOBALS['conn'], $id) . "'")) {
        echo "success";
    } else {
        echo "error";
    }
} else if ($type == "booked_restaurant") {
    if (mysqli_query($GLOBALS['conn'], "DELETE FROM `booked_records_restaurant` WHERE `booking_id` = '" . mysqli_real_escape_string($GLOBALS['conn'], $id) . "'")) {
        echo "success";
    } else {
        echo "error";
    }
    
} else if ($type == "restaurant") {
    $user_id = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'], "SELECT * FROM `restaurant_details` WHERE `restaurant_id` = '" . mysqli_real_escape_string($GLOBALS['conn'], $id) . "'"));
    
    if (mysqli_query($GLOBALS['conn'], "DELETE FROM `restaurant_details` WHERE `restaurant_id` = '" . mysqli_real_escape_string($GLOBALS['conn'], $id) . "'")) {
        
        if (mysqli_query($GLOBALS['conn'], "DELETE FROM `users` WHERE `user_id` = '" . mysqli_real_escape_string($GLOBALS['conn'], $user_id['user_id']) . "'")) {
            echo "success";
            
        } else {
            echo "error";
        }
        
    } else {
        echo "error";
    }
} else if ($type == "menu_management") {
    if (mysqli_query($GLOBALS['conn'], "DELETE FROM `restaurant_menu_details` WHERE `id` = '" . mysqli_real_escape_string($GLOBALS['conn'], $id) . "'")) {
        echo "success";
    } else {
        echo "error";
    }
} else if ($type == "table_management") {
    if (mysqli_query($GLOBALS['conn'], "DELETE FROM `restaurant_menu_details` WHERE `id` = '" . mysqli_real_escape_string($GLOBALS['conn'], $id) . "'")) {
        echo "success";
    } else {
        echo "error";
    }
    
    
} else if ($type == "items") {
    if (mysqli_query($GLOBALS['conn'], "DELETE FROM `items` WHERE `id` = '" . mysqli_real_escape_string($GLOBALS['conn'], $id) . "'")) {
        echo "success";
    } else {
        echo "error";
    }
    
    
} else if ($type == "items_price") {
    if (mysqli_query($GLOBALS['conn'], "DELETE FROM `restaurant_item_price` WHERE `id` = '" . mysqli_real_escape_string($GLOBALS['conn'], $id) . "'")) {
        echo "success";
    } else {
        echo "error";
    }
} else {
    
}
?>

  
