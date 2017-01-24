$(document).ready(function() {
  //Login form validation
  $.validator.addMethod("email1", function(value, element) 
  { 
    return this.optional(element) || /^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/i.test(value); 
   }, "Please enter a valid email address.");
  $.validator.addMethod("phone_no", function(value, element) 
  { 
    return this.optional(element) || /^(\+44\s?7\d{3}|\(?07\d{3}\)?)\s?\d{3}\s?\d{3}$/i.test(value); 
   }, "Please enter a valid phone number.");
  $("#login_form").validate({
    rules: {
     email: {
        required: true,
        email: true,
        email1 : true
            },
      password: "required"
     
    },
    messages: {
      email: {
            required:"Please enter email.",
            email: "Please enter a valid email address."
          },
      password: {
            required:"Please enter your password."
           
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
        email: true,
        email1 : true
            },
          },
          messages: {
            required:"Please enter email.",
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
      name: {
        required: true,
        maxlength : 30
      },
      image: "required",
    },
    messages: {
      name: {
            required:"Please enter name",
            maxlength: "Name maximum 30 charecters"
          },
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

  /*Custom validation for space is not allowed*/
$.validator.methods.locationValid = function(value, element) {
   $.ajax({
                method: "post",
                url: "admin_ajax.php",
                data: { type:"locationValid",location:value},
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
		name: {
        required: true,
        maxlength: 256
      },
		email: {
				required: true,
				email: true,
        email1 : true,
				alreadyEmail:true
			},
		phone: {
				required: true,
				phone_no:true		
		},
    about: {
        maxlength: 500 
    },
    people: {
        maxlength: 6
        
    },
    location: {
        required: true
    },
    locationTest: {
        required: true,
        locationValid: true   
    },
		"resturant_images[]":{
			 required: true
		
    },
    imageCount: {
			max: 6
			},
    countTime: {
				max: 1
				
		}
    
},

    messages: {
		name: {
            required:"Please enter name",
            maxlength: "Name maximum 256 charecters"
          },
		email:{
            required:"Please enter email",
            email: "Please enter a valid email address.",
            alreadyEmail: "email already exits."
          },
    phone: {
				required: "Please enter phone number"	
		},
    about: {
        maxlength: "Discription should not be more than 500 characters."   
    },
    people: {
        maxlength: "Discription should not be more than 6 digits."    
    },
    location: {
        required: "Please enter location."
    },
    locationTest: {
        required: "Please enter location.",
        locationValid: "Location is not valid please enter correct location."   
    },
		"resturant_images[]" :{
			required: "Venue images required"
		},
		imageCount: {
			max: "Venue images not greater than 6"
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
		name: {
        required: true,
        maxlength: 256
      },
		email: {
				required: true,
				email: true,
        email1 : true,
				alreadyEmail:true
			},
		phone: {
				required: true,				
				phone_no: true
				
		},
    location: {
        required: true
    },
    locationTest: {
        required: true,
        locationValid: true   
    },
		countImgs: {
				min: 1
				
		},
		countTime: {
				max: 1
				
		},
		imageCount: {
			max: 6,
			min:1
			}
		
		
},

    messages: {
		name: {
            required:"Please enter name",
            maxlength: "Name maximum 256 charecters"
          },
		email: {
                  required:"Please enter email",
                   email: "Please enter a valid email address.",
                   alreadyEmail: "email already exits."
                },
    phone: {
				required: "Please enter phone number"				
		},
		countImgs: {
				min: "Venue images required"
				
		},
    location: {
        required: "Please enter location."
    },
    locationTest: {
        required: "Please enter location.",
        locationValid: "Location is not valid please enter correct location."   
    },
		countTime: {
				max: "Close time should be greater than open time"
				
		},
		imageCount: {
			max: "Venue images not greater than 6",
			min: "Venue images required"
			}
		
      
    }
  });
  
  //Add resturant validation
  $("#change_password").validate({
    rules: {
    old_password: "required",
    new_password: {
        required: true,
        minlength: 8,
        maxlength: 15  
    },
    confirm_password: {
        required: true,
        minlength: 8,
        maxlength: 15  
    }
    
  },

    messages: {
    old_password: "Please enter old password",
    new_password: {
                   required:"Please enter new password",
                   minlength: "New password atleast 8 digits",
                   maxlength: "New password not more than 15 digits"
                },
    confirm_password: {
                  required: "Please enter confirm password",
                  minlength: "Confirm password atleast 8 digits",
                  maxlength: "New password not more than 15 digits"    
    }
     
    }
  });

//Edit resturant booking
$("#edit_booking").validate({
    rules: {
        name: {
			required:true,
			minlength: 2,
			maxlength: 100
			},
        email: {
			required:true,
			email: true,
      email1 : true,
			maxlength: 256
			},
     
     booking_date: {
			required:true,
			},
        booking_time: {
			required:true,
			},
        people: {
			required:true,
			minlength: 1
			}

    },

    messages: {
        name: {
			required:"Please enter the name",
			minlength:"Please enter atleast 2 characters",
			maxlength:"Please enter only 100 characters"
			},
        email: {
			required:"Please enter the email",
			minlength:"Please enter atleast 2 characters",
			maxlength:"Please enter only 256 characters"
			},
       
        booking_date: {required:"Please enter the booking date"},
        booking_time: {required:"Please enter the booking time"},
        people: {
			required:"Please enter the number of people",
			minlength:"Please enter atleast 1 people"
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
   /*Custom validation for space is not allowed*/
$.validator.methods.alreadyitem = function(value) {
   $.ajax({
                method: "post",
                url: "admin_ajax.php",
                data: { type: "val_item",item:value},
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
  /*Custom validation for space is not allowed*/
$.validator.methods.alreadyitemedit = function(value, element) {
  var item_id = $("#item_id").val();
   $.ajax({
                method: "post",
                url: "admin_ajax.php",
                data: { type: "alreadyitemedit",item:value,item_id:item_id},
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


  //Add Category Validation
  $("#add_item").validate({
    ignore: [],
    rules: {
    name: {
      required:true,
      minlength:2,
      alreadyitem:true,
      }
    },
    messages: {
    name: {
      required: "Please enter your item.",
      alreadyitem: "Item already added in database .",
      minlength:"Please enter atleast 2 characters"
      }
      
     
    }
  });
  
 

  //Add Category Validation
  $("#edit_item").validate({
    rules: {
    name: {
      required:true,
      minlength:2,
      alreadyitemedit:true,
      

      }
    },
    messages: {
    name: {
      required: "Please enter your item.",
      minlength:"Please enter atleast 2 characters",
      alreadyitemedit: "Item already added in database ."
      
      }
      
     
    }
  });

   /*Custom validation for space is not allowed*/
$.validator.methods.alreadyadd_item_price = function(value, element) {
  var restaurant_id = $('#restaurant_id').val();
  var meal_id = $("#allMealling option:selected").val();
   $.ajax({
                method: "post",
                url: "admin_ajax.php",
                data: { type: "alreadyadd_item_price",item:value,restaurant_id:restaurant_id,meal_id:meal_id},
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

$.validator.methods.alreadyadd_exists_or_not = function(value, element) {
      $('#selectedvalue').val($("input[name='item[]']")
              .map(function(){return $(this).val();}).get());
      var str = $('#selectedvalue').val();
      console.log(str);
      //var str = 'a,2,c';

      var temp = new Array();
      temp = str.split(",");
      alert(temp);
};


  //Add Category Validation
  $("#add_item_price").validate({
	 ignore: [],
    rules: {
    meal_name: {
      required:true
      },
    "subtitle[]": {
      required:true
      },
    "item[]": {
      required:true,
      //alreadyadd_exists_or_not:true,
      //alreadyadd_item_price:true
      },
     "quantity[]": {
      required:true
      }
     
    },
    messages: {
   
    meal_name: {
      required: "Please enter meal name."
      
      },
    "subtitle[]": {
      required: "Please enter subtitle."
      
      },
      "item[]": {
      required: "Please enter your item.",
   
      },
      "quantity[]": {
      required: "Please enter quantity."
      }
     
    }
  });

  //Add Category Validation
  $("#edit_item_price").validate({
   ignore: [],
    rules: {
    meal_name: {
      required:true
      },
    subtitle: {
      required:true
      },
    item: {
      required:true,
      alreadyadd_exists_or_not:true,
      alreadyadd_item_price:true
      },
     quantity: {
      required:true
      }
    },
    messages: {
   
    meal_name: {
      required: "Please select meal name."
      
      },
    subtitle: {
      required: "Please enter subtitle."
      
      },
      item: {
      required: "Please enter your item.",
      alreadyadd_item_price: "Item already added for this restaurant.",
      alreadyadd_exists_or_not:"Item name doesnot exists in database."
      },
      quantity: {
      required: "Please enter quantity."
      }
     
    }
  });
 
