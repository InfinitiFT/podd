<?php
	include('config/config.php');
	include('admin_functions.php');
	session_start();
	validate_session_admin($_SESSION['uid']);
	
?>

<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<script type="text/javascript" language="javascript">// <![CDATA[
	function checkAll(ele) {
		var checkboxes = document.getElementsByTagName('input');
		if (ele.checked) {
			 for (var i = 0; i < checkboxes.length; i++) {
				 if (checkboxes[i].type == 'checkbox') {
					 checkboxes[i].checked = true;
				 }
			 }
		} else {
			 for (var i = 0; i < checkboxes.length; i++) {
				 console.log(i)
				 if (checkboxes[i].type == 'checkbox') {
					 checkboxes[i].checked = false;
				 }
			 }
		}
	}
	</script>
</head>
<body>
	<form name="form1" method="post" action="send.php">
	<?php
	// fetch email
	$query = "SELECT u.user_id, p . * FROM `qv_users` u JOIN qv_practitioner p ON u.id = p.id order by`created_date` desc";
	$result = mysql_query($query);
	if (!$result) die('mySQL error: ' . mysql_error());
	echo "<style>	
	table { border:1px solid #ccc; border-collapse:collapse; padding:5px; }	
	th { background:#eff5fc; padding:10px; text-align:center; }	
	td { padding:10px; }	
	</style>";
	echo "<table>";
	echo "<th><input type='checkbox' onchange='checkAll(this)' name='chk'/></th><th>ID</th><th>Email</th>";
		
	if (mysql_num_rows($result) == 0) {    
	echo "<tr><td colspan='3'>No emails in database.</td></tr>";    
	} 
 
	while ($row = mysql_fetch_assoc($result)) {     
		echo "<tr><td><input value='".$row['email']."' type='checkbox' name='check[]'/></td>";	
		echo "<td>".$row['id']."</td>";
		echo "<td>".$row['email']."</td></tr>";
	} 
	echo "</table>";
	?>
	<p>Subject:<input type="text" name="subject" value="" /></p>
	<p>Message:<textarea name="message" cols="40" rows="6"></textarea></p>
	<input type='submit' name='submit' value='SUBMIT'/>
	<?php
	mysql_close(); 
	?>
	</form>
</body>
</html>