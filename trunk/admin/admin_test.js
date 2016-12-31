/* Edit Functionality */
// Add item functionality
   var max_fields      = 10;
    var additem      = $(".add_item"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
     
    
     //initlal text box count
    var count = 2;
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
       //text box increment
        if(count < max_fields){ //max input box allowed
        
            count++; 
            $(additem).append(  '<div class="add_item">'+
                                   '<div class="col-md-1 col-sm-1 col-xs-2 form-group has-feedback">'+
                                   '</div>'+
                                   '<div class="col-md-4 col-sm-4 col-xs-8 form-group has-feedback">'+
                                      '<input type="text" class="form-control has-feedback-left ui-autocomplete-input auto" placeholder="Select Item" name="item[]" id="inputSuccess-'+count+'">'+
                                   '</div>'+
                                   '<div class="col-md-2 col-sm-2 col-xs-4 form-group has-feedback">'+
                                      '<input type="text" class="form-control" name="price[]" id="inputSuccess3" placeholder="Price">'+
                                  '</div>'+
                               '<button type="button" class="btn btn-danger remove_field">✖</button></div>'); //add input box
        
    
    $(additem).on("click",".remove_field", function(e){
      e.preventDefault(); $(this).parent('div').remove();count--; 
    })
     
  }
});

/*$("#inputSuccess-"+count).autocomplete({
                source: "select_items.php"

            })*/


    $(function() {

      $(document).bind('DOMNodeInserted', function(e) {
            $("[id ^='inputSuccess-']").autocomplete({
                source: "select_items.php"

            });
      });
   });

   
    var edit_item= $("#edit_item_val").val();

    var wrapper_edit         = $("#pro"+edit_item_obj_id); //Fields wrapper
    var add_button_edit      = $(".add_field_button"); //Add button ID
    
    var x = pro_obj_id; //initlal text box count
    $(add_button_edit).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper_edit).after('<div class="form-group" id="pro'+pro_obj_id+'>'+
                                            '<label for="comment">Project Objectives</label>'+
                                            
                                            '<textarea name="pro_obj[]" id="comment" rows="4" cols="40" class="form-control"></textarea></br>'+
                                        '<a href="" class="btn btn-danger remove_field_edit">Remove</a></div>'); //add input box
        $("#pro_val").val(pro_obj_id++);
      
        }
    });
    
    $(document).on("click",".remove_field_edit", function(e){ //user click on remove text
        
        $(this).parent('div').remove();
        e.preventDefault(); 
        $("#pro_val").val(pro_obj_id--);  x--;
    })
    



     var exp_id= $("#exp_val").val();

    var wrapper_edit1         = $("#exp"+exp_id); //Fields wrapper
    var add_button_edit1     = $(".add_button_edit1"); //Add button ID
    
    var x = exp_id; //initlal text box count
    $(add_button_edit1).click(function(e){ //on add input button click
        e.preventDefault();

        if(x < max_fields){ //max input box allowed
            x++; //text box increment

            $(wrapper_edit1).after('<div class="form-group" id="pro'+exp_id+'>'+
                                            '<label for="comment">Exposure</label>'+
                                            
                                           '<input type="text" name="exp[]" class="form-control" value=""></br>'+
                                        '<a href="" class="btn btn-danger remove_field_edit1">Remove</a></div>'); //add input box
        $("#pro_val").val(exp_id++);
      
        }
    });
    
    $(document).on("click",".remove_field_edit1", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove();
        $("#pro_val").val(exp_id--); x--;
    })
    