$(document).ready(function() {
  //Login form validation
  $("#login_form").validate({
    rules: {
     email: {
        required: true,
        email: true
            },

      password: "required"
},
    messages: {
      email: {
            required:"Please enter email",
            email: "Please enter valid email"
          },
      password: {
            required:"Please enter your password" 
          }
    }
  });
 //login form ajax submit
  $("#login_form").submit(function() {
    if (!$(this).valid()) {
      return false;
    } else {
            
    }
  });

  // forgot form validation
  $("#forgot-form").validate({
    rules: {
      email: {
        required: true,
        email: true
            },
          },
          messages: {
            required:"Please enter email",
            email: "Please enter a valid email address."
          },      
        });
        // forget form ajax submit
        $('#forgot-form').submit(function() {
          if (!$(this).valid()) {
            return false;
          } else {
           
          }
        });
      });
//Add Category form Validate

 //Add Category Validation
  $("#add_category").validate({
    rules: {
      name: "required",
      image: "required"
    },
    messages: {
      name: "Please enter your name.",
      image: "Please select your image."
    }
  });
  //Add Menu Validation
  $("#add_menu").validate({
    rules: {
      name: "required",
      menu: "required"
    },
    messages: {
      name: "Please select meal name .",
      menu: "Please select your menu."
    }
  });

  /*Custom validation for space is not allowed*/
$.validator.methods.alreadyEmail = function(value, element) {
	var userID = $("#userID").val();
	 $.ajax({
                method: "post",
                url: "admin_ajax.php",
                data: { type: "email_validation",email:value,userID:userID},
                async: false,
                success: function(data) {
                    if(data == 1) {
                        ab = false;             
                    }
                    else {
                        ab = true;
                    }
                },
                error: function(err){
                    console.log(err)
                }
            });
            return ab;
};






  //Add resturant validation
  $("#addResturant").validate({
	  ignore: "",
    rules: {
		name: "required",
		email: {
				required: true,
				email: true,
				alreadyEmail:true
			},
		phone: {
				required: true,
				number: true,
				minlength: 10,
				maxlength: 15
				
		},
		"resturant_images[]":{
			 required: true
		
    },
    countTime: {
				max: 1
				
		}
    
},

    messages: {
		name: "Please enter name.",
		email: {
                  required:"Please enter email",
                   email: "Please enter valid email",
                   alreadyEmail: "Email already exits"
                },
        phone: {
				required: "Please enter phone number",
				number: "Phone number should be number",
				minlength: "Phone number atleast 10 digits",
				maxlength: "Phone number maximum 15 digits"
				
		},
		"resturant_images[]" :{
			required: "Resturant images required"
		},
		countTime: {
				max: "Close time should be greater than open time"
				
		}
		
      
    }
  });
  
  
  
  //Edit resturant validation
  $("#editResturant").validate({
	  ignore: "",
    rules: {
		name: "required",
		email: {
				required: true,
				email: true,
				alreadyEmail:true
			},
		phone: {
				required: true,
				number: true,
				minlength: 10,
				maxlength: 15
				
		},
		countImgs: {
				min: 1
				
		},
		countTime: {
				max: 1
				
		}
		
		
},

    messages: {
		name: "Please enter name.",
		email: {
                  required:"Please enter email",
                   email: "Please enter valid email",
                   alreadyEmail: "Email already exits"
                },
        phone: {
				required: "Please enter phone number",
				number: "Phone number should be number",
				minlength: "Phone number atleast 10 digits",
				maxlength: "Phone number maximum 15 digits"
				
		},
		countImgs: {
				min: "Resturant images required"
				
		},
		countTime: {
				max: "Close time should be greater than open time"
				
		}
		
      
    }
  });

  

function timeValidate(data){
	var add ='';
	var openTime = $("#opentime").val();
	var closeTime = $("#closetime").val();
	if(openTime==''){
		alert('Please select open time');
	}else{
		var open = openTime.split(':');
		var close = closeTime.split(':');
		if((open[0] == close[0])&& (open[1] != close[1])){
			if(open[1] > close[1]){
					add = 2;
			}
		}
		if((open[0] != close[0]) &&(open[1] == close[1])){
			if(open[0] > close[0]){
					add = 2;
			}
		}if((open[0] != close[0]) &&(open[1] != close[1])){
			if(open[0] > close[0]){
					add = 2;
			}else{
				if((open[0] == close[0])&&(open[1] >close[1]))
					add = 2;
			    }
			}
		}
		if(add ==2){
			$("#countTime").val(2);
			
		}else{
			$("#countTime").val(0);
			
		}
	}



function timeValidateClose(data){
	var add ='';
	var openTime = $("#opentime").val();
	var closeTime = $("#closetime").val();
	if(closeTime==''){
		alert('Please select close time');
	}else{
		var open = openTime.split(':');
		var close = closeTime.split(':');
		if((open[0] == close[0])&& (open[1] != close[1])){
			if(open[1] > close[1]){
				add = 2;
				//$("#countTime").val(2);
				//return false;
			}
		}
		if((open[0] != close[0]) &&(open[1] == close[1])){
			if(open[0] > close[0]){
				add = 2;
			}
		}if((open[0] != close[0]) &&(open[1] != close[1])){
			if(open[0] > close[0]){
				add = 2;
			}else{
				if((open[0] == close[0])&&(open[1] >close[1])){
				   add = 2;
			   }
			}
		}
	}
	
	if(add ==2){
			$("#countTime").val(2);
			
		}else{
			$("#countTime").val(0);
			
		}
}
function myFunction22(data){
var fileCount = data.files.length;
var imgCount = $("#countImgs").val();
$("#countImgs").val(parseInt(imgCount) + fileCount);

}
  
  
  //Add resturant validation
  $("#change_password").validate({
    rules: {
    old_password: "required",
    new_password: {
        required: true,
        minlength: 8  
    },
    confirm_password: {
        required: true,
        minlength: 8  
    }
    
  },

    messages: {
    old_password: "Please enter your password.",
    new_password: {
                   required:"Please enter new password",
                   minlength: "New password atleast 8 digits"
                },
    confirm_password: {
                  required: "Please enter confirm password",
                  minlength: "Confirm password atleast 8 digits"    
    }
     
    }
  });
  
  
  
 //login form ajax submit
  $("#add_category").submit(function() {
    if (!$(this).valid()) {
      return false;

    } else {
            
    }
  });
