$(document).ready(function() {
  //Login form validation
  $("#login_form").validate({
    rules: {
      email: "required",
      password: "required"
    },
    messages: {
      email: "Please enter your username.",
      password: "Please enter your password."
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

 //Login form validation
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

  /*Custom validation for space is not allowed*/
$.validator.methods.alreadyEmail = function(value, element) {

	 $.ajax({
                method: "post",
                url: "admin_ajax.php",
                data: { type: "email_validation",email:value},
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
