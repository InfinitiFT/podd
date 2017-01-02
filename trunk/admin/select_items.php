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
if(!empty($_GET['restaurant_id']) && !empty($_GET['meal_id'])){
	$query = mysqli_query($GLOBALS['conn'],"SELECT * FROM items WHERE id NOT IN (SELECT item_id FROM restaurant_item_price JOIN restaurant_meal_details ON restaurant_item_price.restaurant_meal_id = restaurant_meal_details.id WHERE restaurant_meal_details.restaurant_id =  '".$_GET['restaurant_id']."' AND restaurant_meal_details.meal =  '".$_GET['meal_id']."'
         ) AND status =  '1' AND name LIKE  '%".$searchTerm."%' ORDER BY name ASC ");
	 
	
}
else if(!empty($_GET['restaurant_id']))
{
	$query = mysqli_query($GLOBALS['conn'],"SELECT * FROM items WHERE id NOT IN (SELECT item_id FROM restaurant_item_price JOIN restaurant_meal_details ON restaurant_item_price.restaurant_meal_id = restaurant_meal_details.id WHERE restaurant_meal_details.restaurant_id =  '".$_GET['restaurant_id']."' ) AND status =  '1' AND name LIKE  '%".$searchTerm."%' ORDER BY name ASC ");

}
else
{
	
	$query = mysqli_query($GLOBALS['conn'],"SELECT * FROM items WHERE status = '1' AND name LIKE '%".$searchTerm."%' ORDER BY name ASC");
	 

}
   if(mysqli_num_rows($query)>0){
   	 while ($row = mysqli_fetch_assoc($query)) {
    	if(!empty($_GET['selected_item']))
    	{
          $array  = explode(",",$_GET['selected_item']);
          if ( ! in_array($row['name'], $array ) )
           {
               $data[] = $row['name'];
           }
    	}
          
        else
        {
        	$data[] = $row['name'];
        }
    }

   }
   else
   {
   	$data = array();
   }

   

    //return json data
    echo json_encode($data);

?>
