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
				$("#testimonialForm").validate({
				    rules: {
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
					title: 'Please enter name',		
					description: "Please enter description",	
					file: 'Please upload image',					
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
		});
		