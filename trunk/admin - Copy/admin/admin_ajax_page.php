<?php

  include('admin_functions.php');
  //include('../config/function.php');
  include('config/config.php');
  
  switch($_REQUEST['type']) {
    case 'removePractitioner':
	   print deletePractitioner($_REQUEST['practitionerID']);
		break;
		
		case 'removeCompany':
	   print deleteCompany($_REQUEST['companyID']);
		break;
		case 'block':
	   print blockPractitioner($_REQUEST['practitionerID']);
		break;
		case 'unBlock':
	   print unBlockPractitioner($_REQUEST['practitionerID']);
		break;
		case 'blockCompany':
	   print blockCompany($_REQUEST['companyID']);
		break;
		case 'unBlockCompany':
	   print unBlockCompany($_REQUEST['companyID']);
		break;
		case 'transferPayment':
	   print transfer_payment($_REQUEST['practitionerID']);
	   break;
	   case 'completejob':
	   print completeadmin($_REQUEST['requestID']);
		break;
  }
  
?>
