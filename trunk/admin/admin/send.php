<?php

if(isset($_POST['check']) == true)
{
	//print_r($_POST);
	$subject = trim($_POST['subject']);
	$message = trim($_POST['message']);
	foreach($_POST['check'] as $k => $v)
	{
		//This will open to send mail
		//print_r($v);echo $subject;echo $message;
 		if(mail($v,$subject,$message,'From:admin@quova.in'))
		{
			echo 'Mail send to '.$v.'</br>';
		} 
	}
	header("Location:user_mail.php?type=0");
}
else
{
	echo 'Please select email address';
	header("Location:user_mail.php?type=0");
}
?>