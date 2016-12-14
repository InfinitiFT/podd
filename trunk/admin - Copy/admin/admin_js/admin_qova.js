(function ($) {
  $(document).ready(function(){    
	var actionurl = 'admin_ajax_page.php';
					
	// Remove Appointement
	$("[id ^='deleteappointment-']").click(function(e) {
		var appID  = $(this).attr('id');
		var appArr = appID.split('-');
		$("#matchappointment").attr("id","matchappointment-"+appArr[1]);
		$("#appid").val(appArr[1]) ;		
	});


	// Cancel Appointement
	$("[id ^='cancelapp-']").click(function(e) {
		var appID  = $(this).attr('id');
		var appArr = appID.split('-');
		$("#cancelappointment").attr("id","cancelappointment-"+appArr[1]);
		$("#requestID").val(appArr[1]) ;		
	});

	// Complete Appointement
	$("[id ^='completeapp-']").click(function(e) {
		var appID  = $(this).attr('id');
		var appArr = appID.split('-');
		$("#completeService").attr("id","completeService-"+appArr[1]);	
	});

	
	$("[id ^='completeService']").click(function(e) {
		var appID  = $(this).attr('id');
		
		var appArr = appID.split('-');
		
		var buttonText = $(this).html();
		var type = 'completejob';
		
		$.ajax({
			type: "POST",
			async: false,
			url: actionurl,
			data: "type="+type+"&requestID="+appArr[1],
			success: function(result) {
				alert(result)
			/*	if(result == 1) {
					alert('Service Completed');
					location.reload(); 
				}
				else if(result == 3) {
					alert('Cost must be greater than 0');
					return false;
				}
				else if(result == 0) {
					alert('Something went wrong with payment processing');
					return false;
				}*/
			}
		});
	});
	

	// Remove Practitioner
	$("[id ^='deletepractitioner-']").click(function(e) {
		var practitionerID  = $(this).attr('id');
		var practitionerArr = practitionerID.split('-');
		$("#adminRemovePractitioner").attr("id","adminRemovePractitioner-"+practitionerArr[1]);		
	});
	
	$("[id ^='adminRemovePractitioner']").click(function(e) {
		var practitionerID  = $(this).attr('id');
		var practitionerArr = practitionerID.split('-');
		var buttonText = $(this).html();
		var type = 'removePractitioner';
		e.preventDefault();
		$.ajax({
			type: "POST",
			async: false,
			url: actionurl,
			data: "type="+type+"&practitionerID="+practitionerArr[1],
			success: function(result) {
				if(result == 1) {
					location.reload(); 
				}
			}
		});
	});
	
	
	// Remove Company
	$("[id ^='deletecompany-']").click(function(e) {
		var companyID  = $(this).attr('id');
		var companyArr = companyID.split('-');
		$("#adminRemoveCompany").attr("id","adminRemoveCompany-"+companyArr[1]);		
	});
	
	$("[id ^='adminRemoveCompany']").click(function(e) {
		var companyID  = $(this).attr('id');
		var companyArr = companyID.split('-');
		var buttonText = $(this).html();
		var type = 'removeCompany';
		e.preventDefault();
		$.ajax({
			type: "POST",
			async: false,
			url: actionurl,
			data: "type="+type+"&companyID="+companyArr[1],
			success: function(result) {
				if(result == 1) {
					location.reload(); 
				}
			}
		});
	});
	
		
  });
})(jQuery);
