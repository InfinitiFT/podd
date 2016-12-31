<?php
/**
 * Created by PhpStorm.
 * User: ankitsing
 * Date: 31/12/16
 * Time: 3:02 PM
 */
include('../functions/config.php');
$searchTerm = $_GET['term'];

    //get matched data from skills table
    $query = mysqli_query($GLOBALS['conn'],"SELECT * FROM items WHERE status = '1' AND name LIKE '%".$searchTerm."%' ORDER BY name ASC");
    while ($row = mysqli_fetch_assoc($query)) {
        $data[] = $row['id'];
    }

    //return json data
    echo json_encode($data);

?>
