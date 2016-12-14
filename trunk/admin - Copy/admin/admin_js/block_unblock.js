(function ($) {
  $(document).ready(function(){    
	var actionurl = 'admin_ajax_page.php';
	//block unblock Practitioner
	$("[id ^='blockpractitioner-']").click(function(e) {
	var practitionerID  = $(this).attr('id');
	var practitionerArr = practitionerID.split('-');
	var buttonText = $(this).html();
	if(buttonText == 'UnBlock') {
		var type = 'block'; 
	}
	else {
		var type = 'unBlock'; 
	}

		$.ajax({
			type: "POST",
			async: false,
			url: actionurl,
			data: "type="+type+"&practitionerID="+practitionerArr[1],
			success: function(result) {
				if(result == 1) {
				//alert('dfff');
					$("#blockpractitioner-"+practitionerArr[1]).html('Block');
					$("#blockpractitioner-"+practitionerArr[1]).removeClass('btn-success');
					$("#blockpractitioner-"+practitionerArr[1]).addClass('btn-danger');
					e.preventDefault();
				}
				else if(result == 0) {
					$("#blockpractitioner-"+practitionerArr[1]).html('UnBlock');
					$("#blockpractitioner-"+practitionerArr[1]).removeClass('btn-danger');
					$("#blockpractitioner-"+practitionerArr[1]).addClass('btn-success');
					e.preventDefault();
				}
				else {
					alert('Sorry, unknown error occurred.');
				}
			}
		});
	});
	//block unblock Company
	$("[id ^='blockcompany-']").click(function(e) {
	var companyID  = $(this).attr('id');
	var companyArr = companyID.split('-');
	var buttonText = $(this).html();
	//alert(buttonText);
	if(buttonText == 'UnBlock') {
		var type = 'blockCompany'; 
	}
	else {
		var type = 'unBlockCompany'; 
	}

		$.ajax({
			type: "POST",
			async: false,
			url: actionurl,
			data: "type="+type+"&companyID="+companyArr[1],
			success: function(result) {
				if(result == 1) {
					$("#blockcompany-"+companyArr[1]).html('Block');
					$("#blockcompany-"+companyArr[1]).removeClass('btn-success');
					$("#blockcompany-"+companyArr[1]).addClass('btn-danger');
					e.preventDefault();
				}
				else if(result == 0) {
					$("#blockcompany-"+companyArr[1]).html('UnBlock');
					$("#blockcompany-"+companyArr[1]).removeClass('btn-danger');
					$("#blockcompany-"+companyArr[1]).addClass('btn-success');
					e.preventDefault();
				}
				else {
					alert('Sorry, unknown error occurred.');
				}
			}
		});
	});
		
  });
})(jQuery);
