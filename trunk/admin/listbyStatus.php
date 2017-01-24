<?php
include('../functions/config.php');
include('../functions/functions.php');
if(isset($_POST['st']))
{
	
    $status=$_POST['st'];    
    $i = 1;
    $abc = getQueryByType($status);    
    echo "<thead>
	    <tr>
			<th>Date</th>
			<th>Time</th>
			<th>Name</th>
			<th>Number of people</th>
			<th>Booking Status</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>";                          

    while($query = mysqli_fetch_assoc($abc))
    {
    	echo "<tr><td>" ;
        echo $query['booking_date'];
        echo "</td><td>" ;
        echo $query['booking_time'];
        echo "</td><td>" ;
        echo $query['name'];
		echo "</td><td>" ;		 
        $record['number_of_people'];
        echo "</td><td>" ;
			if($query['booking_status']=="1"){
				 echo "Pending";
				}else if($query['booking_status']=="2"){
				  echo "Confirmed";
				}else{
				  echo "Declined";
				}
        echo "</td><td>" ;                
        echo '<a href="edit_booking.php?id='.$query['booking_id'].'class="btn btn-round btn-primary">Edit</a>';
        $change = bookingTimeChange($query['booking_date'],$query['booking_time']);
        if($change==1)
        {
		 echo '<button type="button" id="timeChange-'.$query['booking_id'].'-'.$query['opening_time'].'-'.$query['closing_time'].' class="btn btn-round btn-primary" data-toggle="modal" data-target="#myModal1">Modify</button>';
		}
		echo "</td></tr>";
    }
    echo "</tbody>";
}

if(isset($_POST['dt']))
{		
    $date = $_POST['dt'];
    
    $i = 1;
    $date = date('Y-m-d ',strtotime($date));
    
	$abc = getQueryByDate($date);
		
    echo "<thead>
	    <tr>
			<th>Date</th>
			<th>Time</th>
			<th>Name</th>
			<th>Number of people</th>
			<th>Booking Status</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>" ;
                          
              
   while($query = mysqli_fetch_assoc($abc))
    {
    	echo "<tr><td>" ;
        echo $query['booking_date'];
        echo "</td><td>" ;
        echo $query['booking_time'];
        echo "</td><td>" ;
        echo $query['name'];
		echo "</td><td>" ;		 
        $record['number_of_people'];
        echo "</td><td>" ;
			if($query['booking_status']=="1"){
				 echo "Pending";
				}else if($query['booking_status']=="2"){
				  echo "Confirmed";
				}else{
				  echo "Declined";
				}
        echo "</td><td>" ;                
        echo '<a href="edit_booking.php?id='.$query['booking_id'].'class="btn btn-round btn-primary">Edit</a>';
        $change = bookingTimeChange($query['booking_date'],$query['booking_time']);
        if($change==1)
        {
		 echo '<button type="button" id="timeChange-'.$query['booking_id'].'-'.$query['opening_time'].'-'.$query['closing_time'].' class="btn btn-round btn-primary" data-toggle="modal" data-target="#myModal1">Modify</button>';
		}
		echo "</td></tr>";
    }
    echo "</tbody>";
}

if(isset($_POST['fromdate']))
{	
	
    $fromdate = $_POST['fromdate'];
    $todate = $_POST['todate'];
    $i = 1;
    $fdate = date('Y-m-d ',strtotime($fromdate));
    $tdate = date('Y-m-d ',strtotime($todate));
	
	$abc = getQueryByBothDate($fdate,$tdate);
		
    echo "<thead>
	    <tr>
			<th>Date</th>
			<th>Time</th>
			<th>Name</th>
			<th>Number of people</th>
			<th>Booking Status</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>" ;
                          
              
   while($query = mysqli_fetch_assoc($abc))
    {
    	echo "<tr><td>" ;
        echo $query['booking_date'];
        echo "</td><td>" ;
        echo $query['booking_time'];
        echo "</td><td>" ;
        echo $query['name'];
		echo "</td><td>" ;		 
        $record['number_of_people'];
        echo "</td><td>" ;
			if($query['booking_status']=="1"){
			 echo "Pending";
			}else if($query['booking_status']=="2"){
			  echo "Confirmed";
			}else{
			  echo "Declined";
			}
        echo "</td><td>" ;                
        echo '<a href="edit_booking.php?id='.$query['booking_id'].'class="btn btn-round btn-primary">Edit</a>';
        $change = bookingTimeChange($query['booking_date'],$query['booking_time']);
        if($change==1)
        {
		 echo '<button type="button" id="timeChange-'.$query['booking_id'].'-'.$query['opening_time'].'-'.$query['closing_time'].' class="btn btn-round btn-primary" data-toggle="modal" data-target="#myModal1">Modify</button>';
		}
		echo "</td></tr>";
    }
    echo "</tbody>";
}
?>

