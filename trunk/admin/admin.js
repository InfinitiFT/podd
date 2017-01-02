// Popup for delete functionality
var a = [];

$("[id ^='deletepopup-']").click(function () {
  var pagetype =  $("#delete_type").val();
  var serviceID  = $(this).attr('id');
  var serviceArr = serviceID.split('-');
  Lobibox.confirm({
      msg: "Are you sure you want to delete ?",
      callback: function ($this, type) {
      if (type === 'yes') {
           $.ajax({
            url:'delete_entity.php',
            type: 'post',
            data: {pagetype:pagetype,id:serviceArr[1]},
            success: function(data, status) { 
				
             location.reload();  
             Lobibox.notify('success', {
              msg: 'Entity deleted Successfully.'
             });
            },
            error: function(xhr, desc, err) {
                 console.log(xhr);
             }
          }); 
      } else if (type === 'no') {
        Lobibox.notify('info', {
          msg: 'You have clicked "No" button.'
        });
      }
    }
  });
});

// Popup for activate deactivate functionality
$("[id ^='activatedeactivate1-']").click(function () {
    var pagetype =  $("#delete_type").val();
    var serviceID  = $(this).attr('id');
    var serviceArr = serviceID.split('-');
    var buttonText = $(this).html();
    if(buttonText == 'Deactivate Venue') {
        var status = '0'; 
    }
    else {
        var status = '1'; 
    }
    Lobibox.confirm({
      msg: "Are you sure you want to " + buttonText + "?",
      callback: function ($this, type) {
      if (type === 'yes') {
         $.ajax({
          url:'activate_deactivate_entity.php',
          type: 'post',
          data: {pagetype:pagetype,id:serviceArr[1],status:status},
          success: function(data, status) { 
             location.reload();  
             Lobibox.notify('success', {
              msg: 'Entity Successfully '+ buttonText +'d.'
             });
            },
            error: function(xhr, desc, err) {
                 console.log(xhr);
             }
          });
      } else if (type === 'no') {
        Lobibox.notify('info', {
          msg: 'You have clicked "No" button.'
        });
      }
    }
  });
});
$("[id ^='activatedeactivate-']").click(function () {
    var pagetype =  $("#delete_type").val();
    var serviceID  = $(this).attr('id');
    var serviceArr = serviceID.split('-');
    var buttonText = $(this).html();
    if(buttonText == 'Deactivate') {
        var status = '0'; 
    }
    else {
        var status = '1'; 
    }
    Lobibox.confirm({
      msg: "Are you sure you want to " + buttonText + "?",
      callback: function ($this, type) {
      if (type === 'yes') {
         $.ajax({
          url:'activate_deactivate_entity.php',
          type: 'post',
          data: {pagetype:pagetype,id:serviceArr[1],status:status},
          success: function(data, status) { 
             location.reload();  
             Lobibox.notify('success', {
              msg: 'Entity Successfully '+ buttonText +'d.'
             });
            },
            error: function(xhr, desc, err) {
                 console.log(xhr);
             }
          });
      } else if (type === 'no') {
        Lobibox.notify('info', {
          msg: 'You have clicked "No" button.'
        });
      }
    }
  });
});
// Popup for Confirm functionality

  $(document).on("click", "[id ^='confirm-']", function(event){
  var pagetype =  $("#delete_type").val();
  var serviceID  = $(this).attr('id');
  var serviceArr = serviceID.split('-');
  $.ajax({
    url:'confirm_decline.php',
    type: 'post',
    data: {pagetype:pagetype,id:serviceArr[1],status:'2'},
          success: function(data, status) {
            location.reload();  
            Lobibox.notify('success', {
              msg: 'Entity Accept Successfully.'
             });
          },
          error: function(xhr, desc, err) {
            console.log(xhr);
          }
          }); 
     });
  

// Popup for Decline functionality
$("[id ^='decline-']").click(function () {
  var pagetype =  $("#delete_type").val();
  var serviceID  = $(this).attr('id');
  var serviceArr = serviceID.split('-');
  Lobibox.confirm({
      msg: "Are you sure you want to decline?",
      callback: function ($this, type) {
      if (type === 'yes') {
           $.ajax({
            url:'confirm_decline.php',
            type: 'post',
            data: {pagetype:pagetype,id:serviceArr[1],status:'0'},
            success: function(data, status) { 
             location.reload();  
             Lobibox.notify('success', {
              msg: 'Entity decline Successfully.'
             });
            },
            error: function(xhr, desc, err) {
                 console.log(xhr);
             }
          }); 
      } else if (type === 'no') {
        Lobibox.notify('info', {
          msg: 'You have clicked "No" button.'
        });
      }
    }
  });
});

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
        
           
            $("#dataAdd").append(  '<div class="add_item row" id= "remove_del-'+count+'">'+
                                   '<div class="col-md-1 col-sm-1 col-xs-2 form-group has-feedback">'+
                                   '</div>'+
                                   '<div class="col-md-4 col-sm-4 col-xs-8 form-group has-feedback">'+
                                      '<input type="text" class="form-control has-feedback-left ui-autocomplete-input auto" placeholder="Select Item" name="item[]" id="inputSuccess-'+count+'">'+
                                   '</div>'+
                                   '<input type="hidden" id="txtAllowSearchID[]"><div class="col-md-2 col-sm-2 col-xs-4 form-group has-feedback">'+
                                    '<input type="text" name="quantity[]" class="form-control" placeholder="Quantity">'+
                                    '</div>'+
                                   '<div class="col-md-2 col-sm-2 col-xs-4 form-group has-feedback">'+
                                      '<input type="text" class="form-control" name="price[]" id="inputSuccess3" placeholder="Price">'+
                                  '</div>'+
                               '<button type="button" id ="remove_field-'+count+'" class="btn btn-danger remove_field">✖</button></div>'); //add input box
        
  
     
  }
   count++; 
});

$(document).on("click", "[id ^='remove_field-']", function(event){
        var serviceID  = $(this).attr('id');
        var serviceArr =serviceID.split('-');
      $('#remove_del-'+serviceArr[1]+'').remove();count--;
    });
$(document).on("change", "[id ^='inputSuccess-']", function(event){
    a.push($(this).val());
});  
    $("#inputSuccess-1").autocomplete({
        source: "select_items.php?selected_item="+a+"&restaurant_id="+$('#restaurant_id').val()+"&meal_id="+$("#allMealling option:selected").val()+"&",
        select: function (event, ui) {
            $("#txtAllowSearch").val(ui.item.label); // display the selected text
            $("#txtAllowSearchID").val(ui.item.value); // save selected id to hidden input
        }

            });
   
       
    $(function() {
      
      $(document).bind('DOMNodeInserted', function(e) {
            $("[id ^='inputSuccess-']").autocomplete({
                source: "select_items.php?selected_item="+a+"&restaurant_id="+$('#restaurant_id').val()+"&meal_id="+$("#allMealling option:selected").val()+"&",
                select: function (event, ui) {
                    $(".ui-menu-item").val(ui.item.label); // display the selected text
                    $("#txtAllowSearchID").val(ui.item.value); // save selected id to hidden input
                }

            });
           
      });
   });


   


      
