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
		countImg: {
				min: 1
				
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
		countImg: {
				min: "Resturant images required"
				
		}
		
      
    }
  });

  
 
  //$("input[name='file']").on("change", function(){  
	//  //var name = $(this).attr("name");
	// alert(name);
 // var numFiles = $(name).get(0).files.length
  // alert(numFiles);
//});
function myFunction22(data){
var fileCount = data.files.length;
var imgCount = $("#countImg").val();
$("#countImg").val(parseInt(imgCount) + fileCount);
//alert(fileCount);
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
                   minlength: "Password atleast 8 digits"
                },
    confirm_password: {
                  required: "Please enter confirm password",
                  minlength: "Confirm Password atleast 8 digits"    
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
