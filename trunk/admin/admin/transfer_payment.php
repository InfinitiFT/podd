<?php
include('config/config.php');
include('admin_functions.php');
session_start();
validate_session_admin($_SESSION['uid']);

	$captured=mysql_fetch_assoc(mysql_query("SELECT sum(total_cost) as total FROM qv_transactions WHERE transfer_status='0' AND status = 'captured' AND practitioner_id = '".$_REQUEST['practitionerID']."' group by practitioner_id"));
	$practionerID=mysql_fetch_assoc(mysql_query("SELECT id FROM `qv_users` WHERE role_id=3 and user_id='".$_REQUEST['practitionerID']."'"));
	$practitionerInfo = mysql_fetch_assoc(mysql_query("SELECT * FROM `qv_practitioner` WHERE id='".$practionerID['id']."'"));
	// eMail subject to receivers
	$vEmailSubject = 'Qova';
	$environment = 'sandbox'; // or 'beta-sandbox' or 'live'.

function PPHttpPost($methodName_, $nvpStr_)
{
	global $environment;

	$API_UserName = urlencode('prashant.dwivedi-facilitator_api1.mobiloitte.com');
	$API_Password = urlencode('965ZNT59L9JKEZ5N');
	$API_Signature = urlencode('AiPC9BjkCyDFQXbSkoZcgqH3hpacAv24ACqokwcC-LOvDidqgZgRZ8rS');
	$API_Endpoint = "https://api-3t.paypal.com/nvp";
	if("sandbox" === $environment || "beta-sandbox" === $environment)
	{
		$API_Endpoint = "https://api-3t.$environment.paypal.com/nvp";
	} 
	$version = urlencode('51.0');
	// Set the curl parameters.
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
	curl_setopt($ch, CURLOPT_VERBOSE, 1);
	// Turn off the server and peer verification (TrustManager Concept).
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	// Set the API operation, version, and API signature in the request.
	$nvpreq = "METHOD=$methodName_&VERSION=$version&PWD=$API_Password&USER=$API_UserName&SIGNATURE=$API_Signature$nvpStr_";
	// Set the request as a POST FIELD for curl.
	curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq."&".$nvpStr_);
	// Get response from the server.
	$httpResponse = curl_exec($ch);
	if(!$httpResponse)
	{
		echo $methodName_ . ' failed: ' . curl_error($ch) . '(' . curl_errno($ch) .')';
	}
	// Extract the response details.
	$httpResponseAr = explode("&", $httpResponse);
	$httpParsedResponseAr = array();
	foreach ($httpResponseAr as $i => $value)
	{
		$tmpAr = explode("=", $value);
		if(sizeof($tmpAr) > 1)
		{
			$httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
		}
	}
	if((0 == sizeof($httpParsedResponseAr)) || !array_key_exists('ACK', $httpParsedResponseAr))
	{
		exit("Invalid HTTP Response for POST request($nvpreq) to $API_Endpoint.");
	}
	//print'<pre>';print_r($httpParsedResponseAr);
	return $httpParsedResponseAr;
}

	// Set request-specific fields.
	$emailSubject = urlencode($vEmailSubject);
	$receiverType = urlencode('EmailAddress');
	$currency = urlencode('GBP'); // or other currency ('GBP', 'EUR', 'JPY', 'CAD', 'AUD')
	// Receivers
	// Use '0' for a single receiver. In order to add new ones: (0, 1, 2, 3...)
	// Here you can modify to obtain array data from database.
	$receivers = array(
		0 => array(
			'receiverEmail' => $practitionerInfo['paypal_id'], 
			'amount' => $captured['total'],
			'uniqueID' => "id_001", // 13 chars max
			'note' => " Qova"), // I recommend use of space at beginning of string.
	);
	//return json_encode($receivers);
	$receiversLenght = count($receivers);

	// Add request-specific fields to the request string.
	$nvpStr="&EMAILSUBJECT=$emailSubject&RECEIVERTYPE=$receiverType&CURRENCYCODE=$currency";
	$receiversArray = array();
	for($i = 0; $i < $receiversLenght; $i++)
	{
		$receiversArray[$i] = $receivers[$i];
	}
	foreach($receiversArray as $i => $receiverData)
	{
		$receiverEmail = urlencode($receiverData['receiverEmail']);
		$amount = urlencode($receiverData['amount']);
		$uniqueID = urlencode($receiverData['uniqueID']);
		$note = urlencode($receiverData['note']);
		$nvpStr .= "&L_EMAIL$i=$receiverEmail&L_Amt$i=$amount&L_UNIQUEID$i=$uniqueID&L_NOTE$i=$note";
	}
	// Execute the API operation; see the PPHttpPost function above.
	$httpParsedResponseAr = PPHttpPost('MassPay', $nvpStr);

	if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"]))
	{
		mysql_query("UPDATE qv_transactions SET transfer_status = 1, transfer_date = '".time()."' WHERE transfer_status='0' AND status = 'captured' AND practitioner_id = '".$_REQUEST['practitionerID']."'");
		//print_r($httpParsedResponseAr);exit;
		header('Location:notTransferd.php');
	}
	else
	{
		header('Location:errorPage.php');
	}
	
?>
