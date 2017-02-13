 $(document).ready(function() {
 // validate the comment form when it is submitted
 $("#addQuestionForm").validate({
	ignore: [],  
                  rules: {
					subject: "required",
					paper: "required",
					uniqueId: "required",
                    thisQuestion: 
					{
						required: function() 
						{
							CKEDITOR.instances.thisQuestion.updateElement();
						}
					},
                    thisOption1: 
					{
						required: function() 
						{
							CKEDITOR.instances.thisOption1.updateElement();
						}
					},
                  },
                  messages: {
					subject: "Please select subject",
					paper: 'Please select paper type',
					uniqueId: 'Please enter question unique id',
					thisQuestion: "Please enter question",
					thisOption1: "Please enter option1"
					                   
                  }
                });
				
				
				//upload question
				$("#uploadForm").validate({
				    rules: {
					type: "required",
					file: "required",					
                  },
                  messages: {
					type: "Please select type",
					file: 'Please upload csv',										
                  },
				  errorPlacement: function(error, element) {
					 if (element.attr("name") == "type") {

					   // do whatever you need to place label where you want

						 // an example
						 error.insertAfter( $("#cError") );

						 // just another example
						 //$("#cError").html( error );  

					 } else {

						 // the default error placement for the rest
						 error.insertAfter(element);

					 }
				  }
                });
				
				// upload videos for students/schools
				$("#videoForm").validate({
				    rules: {
					type: "required",
					title: "required",
					description: 
					{
						required: function() 
						{
							CKEDITOR.instances.description.updateElement();
						}
					},	
					file: "required",	
									
                  },
                  messages: {
					type: "Please select video for",
					title: 'Please enter video title',		
					description: "Please enter video description",	
					file: 'Please upload video',
										
                  },
				  errorPlacement: function(error, element) {
					 if (element.attr("name") == "type") {

					   // do whatever you need to place label where you want

						 // an example
						 error.insertAfter( $("#cError") );

						 // just another example
						 //$("#cError").html( error );  

					 } else {

						 // the default error placement for the rest
						 error.insertAfter(element);

					 }
				  }
                });
				
				// upload videos for students/schools
				$("#categoryForm").validate({
				    rules: {
					name: "required",
				    image: "required",						
                  },
                  messages: {
					name: 'Please enter name',			
					image: 'Please upload image',					
                  }
				  
                });
				
				// upload videos for students/schools
				$("#couponForm").validate({
				    rules: {
					title: "required",
					code: "required",
					discount: "required",	
					frm: "required",
					to: "required",							
                  },
                  messages: {
					title: 'Please enter coupon title',		
					code: "Please enter coupon code",
					discount: "Please enter discount",	
					frm: "Please enter from date",		
					to: "Please enter to date",		
					
                  },
				  errorPlacement: function(error, element) {
					 if (element.attr("name") == "frm") {

					   // do whatever you need to place label where you want
						 // an example
						 error.insertAfter( $("#cError") );

						 // just another example
						// $("#cError").html( error );  

					 }else if (element.attr("name") == "to") {

					   // do whatever you need to place label where you want
						 // an example
						 error.insertAfter( $("#cError1") );

						 // just another example
						 //$("#cError").html( error );  

					 } else {

						 // the default error placement for the rest
						 error.insertAfter(element);

					 }
				  }
				  
                });
           $(document).on("click", "[id ^='removeMeal-']", function(event){
			   
				var req = $(this).attr('id');
				var requestData = req.split('-');
				var removeID = requestData[1]; 
				var del = $("#removeMeal-"+requestData[1]).val();
				var allMealling = $("#allMealling-"+removeID+" option:selected").val();
				var allMealSelected = $("#selected_meals").val();
				var arrayMeal = allMealSelected.split(',');
				if (jQuery.inArray(allMealling,arrayMeal)){
					var find = arrayMeal.indexOf(allMealling);
					if(find != -1) {
						arrayMeal.splice(find, 1);
					}
					$("#selected_meals").val(arrayMeal.join(","));
					
				}
				var ss =1;
				$("select[name ^= meal]").map(function(){
					var ids=$(this).attr('id');
					
					var sss = parseInt(removeID)+parseInt(ss);
					var request='';
					var request = ids.split('-');
					if(removeID < request[1]){
						var add =parseInt(request[1])-1;	
						$("#allMealling-"+sss).attr("id","allMealling-"+add);	
						$("#removeMeal-"+sss).attr("id","removeMeal-"+add);	
						$("#allMeal-"+sss).attr("id","allMeal-"+add);	
						sss++;
					}
				}).get();
				var addMeal = $(".glyphicon.glyphicon-plus").attr('id');
				var requestArr = addMeal.split('-');
				var count =  parseInt(requestArr[1]) -1;
				$(".glyphicon.glyphicon-plus").attr('id',requestArr[0]+'-'+count);
				$("#allMeal-"+removeID).remove();
				if(del)
				$("#deleteMeal").append('<input type="hidden" name="deleteMeal[]" value="'+del+'">');
				
			});  
                
                
//Decline booking 
$(document).on("click","[id ^='declines-']",function(e) {
	
	 var requestID  = $(this).attr('id');
	 var requestArr = requestID.split('-');
	 $('#booking_res_id').val(requestArr[1]);
	 //$("[id^='yes']").attr('id','yes-'+requestArr[1]);	
});

$("[id ^='yes']").on('click',function(e) {
	var requestID  = $(this).attr('id');
	var requestArr = requestID.split('-');
	var declined = $("#declined").val();
	var booking_res_id = $('#booking_res_id').val();	
	
		
		if(declined=='Other'){
			var declined = $("#reason").val();
			
		}
		// start ajax 
		$.ajax({	
				  url: "admin_ajax.php",
				  data: {'type': 'decline','bookingID': booking_res_id,'declined':declined},
				  success: function(data1) {
					  
					  if(data1){						  
						Lobibox.notify('success', {
							
							  msg: 'Entity decline Successfully.'
							 });
						location.reload();
					}
				}
			});//end ajax call
	
});	 
////Decline dilevery 

$(document).on("click","[id ^='declines-']",function(e) {
	
	 var requestID  = $(this).attr('id');
	 var requestArr = requestID.split('-');
	 $('#booking_res_idDev').val(requestArr[1]);
	 //$("[id^='yes']").attr('id','yes-'+requestArr[1]);	
});

$("[id ^='yesDev']").on('click',function(e) {	
	var requestID  = $(this).attr('id');
	var requestArr = requestID.split('-');
	var declinedDev = $("#declinedDev").val();
	var booking_res_idDev = $('#booking_res_idDev').val();
	
		if(declined=='Other'){
			var declined = $("#reasonDev").val();
			
		}
		
		// start ajax 
		$.ajax({	
				  url: "admin_ajax.php",
				  data: {'type': 'declineDev','bookingIDDev': booking_res_idDev,'declinedDev':declinedDev},

				  success: function(data1) {
					return false;
					  if(data1){						  
						Lobibox.notify('success', {
							
							  msg: 'Entity decline Successfully.'
							 });
						//location.reload();
					}
				}
			});//end ajax call
	
});	 
//if user select other option at the time of decline a booking 
$(document).on("click", "[id ='declined']", function(event){	
	var declined = $("#declined").val();
	if(declined=='Other'){
		$("#reason").css('display','block');
		return false;
	}
	else{
		$("#reason").css('display','none');
		return false;
	}
});

//if user select other option at the time of decline a booking 
$(document).on("click", "[id ='declinedDev']", function(event){	
	var declined = $("#declinedDev").val();
	if(declined=='Other'){
		$("#reasonDev").css('display','block');
		return false;
	}
	else{
		$("#reasonDev").css('display','none');
		return false;
	}
});

//when a user select other option at the time of  decline
 $("[id='declined']").click(function(){
	 var requestID  = $(this).attr('id');
	 var requestArr = requestID.split('-');
	 $("[id^='yes']").attr('id','yes-'+requestArr[1]);
	
});




$("#selectStatus").change(function(){
   var status = $(this).val();
   var session = $("#session").val();
	// start ajax 
	$.ajax({	
			  url: "admin_ajax.php",
			  data: {'type': 'bookingRecordStatus','status': status,'session':session},
			  success: function(result) {
				  //console.log(result);
				  $("#statusContent").html(result);
			}
		});//end ajax call
});






$(document).on("click", "[id ^='yes-']", function(event){
	var declined = $("#declined").val();
	if(declined==''){
		alert('Please select region');
		return false;
	}else{
		 var requestID  = $(this).attr('id');
		 var requestArr = requestID.split('-');
		// start ajax 
		$.ajax({	
				  url: "admin_ajax.php",
				  data: {'type': 'decline','bookingID': requestArr[1],'declined':declined},
				  success: function(data1) {
					  if(data1){
						Lobibox.notify('success', {
							  msg: 'Entity decline Successfully.'
							 });
						location.reload();
					}
				}
			});//end ajax call
	}
});
});

// booking time change
$(document).on("click", "[id^='timeChange-']", function(event){	
	 var requestID  = $(this).attr('id');
	 var requestArr = requestID.split('-');
	  // start ajax 
	  var options ='';
		$.ajax({	
				  url: "admin_ajax.php",
				  data: {'type': 'timeInterval','start': requestArr[2],'end':requestArr[3]},
				  success: function(data1) {
					  if(data1){
						obj = JSON.parse(data1); 
						options ='<select name ="time" id="timeSelected" class="form-control"><option value="">Select Time</option>'; 
						$.each(obj, function(){
							options+='<option value="'+this+'">'+this+'</option>';
							});
						options+='</select>';	
						$("#timeData").html(options);
					}
				}
			});//end ajax call
	$("[id^='timeYes']").attr('id','timeYes-'+requestArr[1]);
	
});
		
$(document).on("click", "[id ^='timeYes-']", function(event){		
		var timeSelected = $("#timeSelected").val();
		if(timeSelected == ''){
			alert('Please select time');
			return false;
		}else{
			var requestID = $(this).attr('id');
			var requestArr = requestID.split('-');
			// start ajax 
			$.ajax({	
				  url: "admin_ajax.php",
				  data: {'type': 'bookingTimeChange','time': timeSelected,'bookingID':requestArr[1]},
				  success: function(data1) {
					  if(data1 ==1){
						Lobibox.notify('success', {
							  msg: 'Booking time successfully changed.'
							 });
						location.reload();
					}
				}
			});//end ajax call


			
		}
		
		
	});	
		
		
		
		
		
		
		
		
	// For add meal	
	function addMeal(id)
	{

		var requestID = $(id).attr('id');
		var requestArr = requestID.split('-');
		var totalMeal = $("#totalMeal").val();
		
			var meal = [];
			for (i = 1; i <= requestArr[1]; i++) {
				// do something with `substr[i]`
				var mealID ='';
				
				mealID = $("#allMealling-"+i+" option:selected").val();
					if((mealID =='')||(mealID == undefined)){
						alert('Please select meal');
						return false;
					}else{
						if (jQuery.inArray(mealID,meal)){
							meal.push(mealID);
						}
					}
			}
			if(totalMeal >= requestArr[1]){
				var count = parseInt(requestArr[1]) +1;
				var data =' <div class="item form-group" id="allMeal-'+count+'"><div class="item  col-sm-6"><label class="control-label col-md-6 col-sm-3 col-xs-12">Select Meal</label><div class="col-md-6 col-sm-6 col-xs-12"><select class="select2_multiple form-control" name="meal[]" id="allMealling-'+count+'"></select></div></div><div class="item  col-sm-6"><label class="control-label col-md-2 col-sm-6 col-xs-6">Menu</label><div class="col-md-6 col-sm-6 col-xs-12"><input id="name" class="form-control col-md-7 col-xs-12"  name="document[]" type="file"></div><spam class="glyphicon glyphicon-remove btn btn-danger" id="removeMeal-'+count+'" onclick="removeMeal(this)"></spam></div></div>';
				
				$("#addMeal").append(data);
				var baseUrl = $("#urlData").val();
				var  option ='';
				$.ajax({
					type: "POST",
					url: "admin_ajax.php",
					data: {'type': 'allMeal','meal': meal},
					async: false,
					success: function(result) 
					{
					  obj = JSON.parse(result);
					   option += '<option value="">Select Meal</option>';
					  $.each( obj, function() {
						  option += '<option value="'+this['id']+'">'+this['name']+'</option>';
					  });
				  }			
				});	
				$("#allMealling-"+count).html(option);
				
				$("#meal-"+requestArr[1]).attr('id',"meal-"+count);
				console.log(meal);
			}
			else{
			
				alert("Not added");
				
			}	
	}
	
	/*function mealChange(id){
		var requestID = $(id).attr('id');
		alert(requestID);
		var select ='';
		var addMeal = $(".glyphicon.glyphicon-plus").attr('id');
		var requestArr = addMeal.split('-');
		var totalMeal = $("#totalMeal").val();
		var meal = [];
		$("select[name ^= meal]").map(function(){
		//for (i = 1; i <= requestArr[1]; i++) {
			var mealID ='';
			mealID = $(this).val();
			alert(mealID);
			if((mealID =='')||(mealID == undefined)){
				alert('Please select meal');
				return false;
			}else{

				  if (jQuery.inArray(mealID,meal)){
					  meal.push(mealID);
					  				console.log(meal);
				    }else{
						alert('You are already selected this meal');
						select = 1;
						$("#"+requestID).prop('selectedIndex',0);
						
					}
			}
		//}
		}).get();

		$("#mealAdded").html('<input type="hidden" value="'+meal+'" id="allMealSelected">');
	}*/
	 $(document).on("change", "[id ^='allMealling-']", function(event){
		var mealID = $(this).val();
		var requestID = $(this).attr('id');
		var requestArr = requestID.split('-');
		
		var selected_meals = $("#selected_meals").val();
		if((selected_meals =='')||(selected_meals == undefined)){
			$("#selected_meals").val(mealID);
		}
		else {
			var selectcount = $("[id ^='allMealling-']").length;
			var split_str = selected_meals.split(",");
			if(selectcount == 1) {
				$("#selected_meals").val(mealID);
			}
			else {
				var i = split_str.indexOf(mealID);
				if (i !== -1) {
					alert('You are already selected this meal');
					if(i != -1) {
						split_str.splice(i, 1);
					}
					$("#selected_meals").val(split_str.join(","));
					$("#"+requestID).prop('selectedIndex',0);
				}
				else {
					selected_meals += ','+mealID;
					$("#selected_meals").val(selected_meals);
				}
			}
		}
		//alert($("#selected_meals").val());
	 });
	
		
		

	
	
	
		
	// For remove meal
	
	
	
	//Image remove Code
	function removeImg(id){
		
		var requestID = $(id).attr('id');
		var requestArr = requestID.split('-');
		var name = $("#imgName-"+requestArr[1]).val();
		var count = $("#countImg").val();
		$("#allRemoveImg").append('<input type="hidden" value="'+name+'" name="remImg[]">');
		$("#removeImg-"+requestArr[1]).remove(); 
		var addMore = $("[id^='meal-']").val();
		var imageCount = $("#imageCount").val();
		$("#countImg").val(count-1);
		 $("#imageCount").val(imageCount -1);
	}
	
	

	function fileCount(id){
		 var fileCount = id.files.length;
		$("#imageCount").val(fileCount);
		
	}
function fileCountEdit(id){
		 var fileCount = id.files.length;
		 var countImg = $("#countImg").val();
		 var total = parseInt(fileCount) + parseInt(countImg);
		$("#imageCount").val(total);
		
	}

// For add meal	
	function add_item_price(id)
	{

		var requestID = $(id).attr('id');
		var requestArr = requestID.split('-');
		var totalMeal = $("#totalMeal").val();
		
			var meal = [];
			for (i = 1; i <= requestArr[1]; i++) {
				// do something with `substr[i]`
				var mealID ='';
				
				mealID = $("#allMealling-"+i+" option:selected").val();
					if((mealID =='')||(mealID == undefined)){
						alert('Please select meal');
						return false;
					}else{
						if (jQuery.inArray(mealID,meal)){
							meal.push(mealID);
						}
					}
			}
			if(totalMeal >= requestArr[1]){
				var count = parseInt(requestArr[1]) +1;
				var data =' <div class="item form-group" id="allMeal-'+count+'"><div class="item  col-sm-6"><label class="control-label col-md-6 col-sm-3 col-xs-12">Select Meal</label><div class="col-md-6 col-sm-6 col-xs-12"><select class="select2_multiple form-control" name="meal[]" id="allMealling-'+count+'"></select></div></div><div class="item  col-sm-6"><label class="control-label col-md-2 col-sm-6 col-xs-6">Menu</label><div class="col-md-6 col-sm-6 col-xs-12"><input id="name" class="form-control col-md-7 col-xs-12"  name="document[]" type="file"></div><spam class="glyphicon glyphicon-remove btn btn-danger" id="removeMeal-'+count+'" onclick="removeMeal(this)"></spam></div></div>';
				
				$("#addMeal").append(data);
				var baseUrl = $("#urlData").val();
				var  option ='';
				$.ajax({
					type: "POST",
					url: "admin_ajax.php",
					data: {'type': 'allMeal','meal': meal},
					async: false,
					success: function(result) 
					{
					  obj = JSON.parse(result);
					   option += '<option value="">Select Meal</option>';
					  $.each( obj, function() {
						  option += '<option value="'+this['id']+'">'+this['name']+'</option>';
					  });
				  }			
				});	
				$("#allMealling-"+count).html(option);
				
				$("#meal-"+requestArr[1]).attr('id',"meal-"+count);
				console.log(meal);
			}
			else{
			
				alert("Not added");
				
			}	
	}

	$(".check_day").click(function(e){
		var id = $(this).val();
		//alert(id);
		if(id==7){
			if($("#check_day"+id).is(':checked')){
				$('.day-'+id).prop('disabled', false);
				$('.rday-'+id).prop('disabled', false);
			}
			else{
				
				document.getElementById("opentime-Sun").value = "";
				document.getElementById("closetime-Sun").value = "";
				$('.day-'+id).prop('disabled', true);
				$('.rday-'+id).prop('disabled', true);
			}
		}
		if(id==1){
			if($("#check_day"+id).is(':checked')){
				$('.day-'+id).prop('disabled', false);
				$('.rday-'+id).prop('disabled', false);
			}
			else{
				//alert(id);
				document.getElementById("opentime-Mon").value = "";
				document.getElementById("closetime-Mon").value = "";
				$('.day-'+id).prop('disabled', true);
				$('.rday-'+id).prop('disabled', true);
			}
		}
		if(id==2){
			if($("#check_day"+id).is(':checked')){
				$('.day-'+id).prop('disabled', false);
				$('.rday-'+id).prop('disabled', false);
			}
			else{
				//alert(id);
				document.getElementById("opentime-Tue").value = "";
				document.getElementById("closetime-Tue").value = "";
				$('.day-'+id).prop('disabled', true);
				$('.rday-'+id).prop('disabled', true);
			}
		}
		if(id==3){
			if($("#check_day"+id).is(':checked')){
				$('.day-'+id).prop('disabled', false);
				$('.rday-'+id).prop('disabled', false);
			}
			else{
				//alert(id);
				document.getElementById("opentime-Wed").value = "";
				document.getElementById("closetime-Wed").value = "";
				$('.day-'+id).prop('disabled', true);
				$('.rday-'+id).prop('disabled', true);
			}
		}
		if(id==4){
			if($("#check_day"+id).is(':checked')){
				$('.day-'+id).prop('disabled', false);
				$('.rday-'+id).prop('disabled', false);
			}
			else{
				//alert(id);
				document.getElementById("opentime-Thu").value = "";
				document.getElementById("closetime-Thu").value = "";
				$('.day-'+id).prop('disabled', true);
				$('.rday-'+id).prop('disabled', true);
			}
		}
		if(id==5){
			if($("#check_day"+id).is(':checked')){
				$('.day-'+id).prop('disabled', false);
				$('.rday-'+id).prop('disabled', false);
			}
			else{
				//alert(id);
				document.getElementById("opentime-Fri").value = "";
				document.getElementById("closetime-Fri").value = "";
				$('.day-'+id).prop('disabled', true);
				$('.rday-'+id).prop('disabled', true);
			}
		}
		if(id==6){
			if($("#check_day"+id).is(':checked')){
				$('.day-'+id).prop('disabled', false);
				$('.rday-'+id).prop('disabled', false);
			}
			else{
				//alert(id);
				document.getElementById("opentime-Sat").value = "";
				document.getElementById("closetime-Sat").value = "";
				$('.day-'+id).prop('disabled', true);
				$('.rday-'+id).prop('disabled', true);
			}
		}
		
	});
	$("#send").click(function(e){
		var openSun = $('#opentime-Sun :selected').text();
		var closeSun = $('#closetime-Sun :selected').text();
		var openMon = $('#opentime-Mon :selected').text();
		var closeMon = $('#closetime-Mon :selected').text();
		var openTue = $('#opentime-Tue :selected').text();
		var closeTue = $('#closetime-Tue :selected').text();
		var openWed = $('#opentime-Wed :selected').text();
		var closeWed = $('#closetime-Wed :selected').text();
		var openThu = $('#opentime-Thu :selected').text();
		var closeThu = $('#closetime-Thu :selected').text();
		var openFri = $('#opentime-Fri :selected').text();
		var closeFri = $('#closetime-Fri :selected').text();
		var openSat = $('#opentime-Sat :selected').text();
		var closeSat = $('#closetime-Sat :selected').text();
		var error = 0;
		if(openSun>closeSun){
			Lobibox.notify('warning', {
                              size: 'normal',
                              rounded: true,
                              //delay: false,
                              position: 'center top', //or 'center bottom'
                              msg: 'Sunday open time must be greater than close time'
                             });
			//alert('Sunday open time must be greater than close time');
			return false;
		}else if(openMon>closeMon){
			Lobibox.notify('warning', {
                              size: 'normal',
                              rounded: true,
                              //delay: false,
                              position: 'center top', //or 'center bottom'
                              msg: 'Monday open time must be greater than close time'
                             });
			//alert('Monday open time must be greater than close time');
			return false;
		}else if(openTue>closeTue){
			Lobibox.notify('warning', {
                              size: 'normal',
                              rounded: true,
                              //delay: false,
                              position: 'center top', //or 'center bottom'
                              msg: 'Tuesday open time must be greater than close time'
                             });
			//alert('Tuesday open time must be greater than close time');
			return false;
		}else if(openWed>closeWed){
			Lobibox.notify('warning', {
                              size: 'normal',
                              rounded: true,
                              //delay: false,
                              position: 'center top', //or 'center bottom'
                              msg: 'Wednesday open time must be greater than close time'
                             });
			//alert('Wednesday open time must be greater than close time');
			return false;
		}else if(openThu>closeThu){
			Lobibox.notify('warning', {
                              size: 'normal',
                              rounded: true,
                              //delay: false,
                              position: 'center top', //or 'center bottom'
                              msg: 'Thursday open time must be greater than close time'
                             });
			//alert('Thursday open time must be greater than close time');
			return false;
		}else if(openFri>closeFri){
			Lobibox.notify('warning', {
                              size: 'normal',
                              rounded: true,
                              //delay: false,
                              position: 'center top', //or 'center bottom'
                              msg: 'Friday open time must be greater than close time'
                             });
			//alert('Friday open time must be greater than close time');
			return false;
		}else if(openSat>closeSat){
			Lobibox.notify('warning', {
                              size: 'normal',
                              rounded: true,
                              //delay: false,
                              position: 'center top', //or 'center bottom'
                              msg: 'Saturday open time must be greater than close time'
                             });
			//alert('Saturday open time must be greater than close time');
			return false;
		}
		/*if(error = 1){
			
		}*/
		
	});
	
