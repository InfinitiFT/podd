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
      msg: "Are you sure you want to decline11?",
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
   var max_fields      = 30;
    var additem      = $(".add_item"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
    var add_field_button_subtitle      = $(".add_field_button_subtitle"); //Add button ID 
  // Add subtitle functionality
   
    var additem_subtitle     = $(".add_subtitle"); //Fields wrapper
    var add_button_subtitle      = $(".add_field_button_subtitle"); //Add button ID
    var add_field_button_subtitle      = $(".add_field_button_subtitle"); //Add button ID 
    
     //initlal text box count
    var count_subtitle = 2;
    $(add_button_subtitle).click(function(e){ //on add input button click
      e.preventDefault();
      var i=1;
      $('input[name^="item[]"]').each(function() {
       // alert($(this).val());
      if($(this).val()==""){   
         i++;
      }
      
      });
       if(i >=2)
       {
        //text box increment
        Lobibox.notify('warning', {
                              size: 'normal',
                              rounded: true,
                              //delay: false,
                              position: 'center top', //or 'center bottom'
                              msg: 'Please enter item name'
                             });
              

       }
       else
       {
           $("#dataAddsubtitle").append(  '<div id="subMeal-'+count_subtitle+'">'+
                                           '<div class="row">'+
                                           '<div class="col-md-1 col-sm-1 col-xs-2 form-group">'+
                                           '</div>'+
                                           '<div class="col-md-4 col-sm-4 col-xs-8 form-group ">'+
                                              '<input type="text" class="form-control" name="subtitle[]" id="inputSuccess-'+count_subtitle+'" placeholder="Sub Menu">'+
                                           '</div>'+

                                           '</div>'+
                                           '<div class="add_item row" id="itemID-'+count_subtitle+'">'+
                                           '<div class="col-md-1 col-sm-1 col-xs-2 form-group has-feedback">'+
                                           '</div>'+
                                           '<div class="col-md-4 col-sm-4 col-xs-8 form-group">'+
                                             '<input type="text" class="form-control" name="item[]" id="item_added-'+count_subtitle+'" placeholder="Item">'+
                                           '</div>'+
                                   
                                           '<div class="col-md-2 col-sm-2 col-xs-4 form-group has-feedback">'+
                                           '<input type="text" name="price[]" class="form-control"  placeholder="Price">'+
                                            '</div>'+
                                           '</div>'+
                                           '<div id="dataAdd-'+count_subtitle+'"></div>'+
                                              '<input type="hidden" name="selected_item[]" id="selected_item" value= "">'+
                                               '<button type="button" name="add_more"  class="btn btn-success"  id="item-'+count_subtitle+'" onclick="addItem(this)">Add Item</button>'+
                                           '</div>'); //add input box 
          count_subtitle++;   
         

       }
           
});
$(document).on("click", "[id ^='remove_field_subtitle-']", function(event){
        var serviceID  = $(this).attr('id');
        var serviceArr =serviceID.split('-');
      $('#remove_del_subtitle-'+serviceArr[1]+'').remove();count--;
    });
$(document).on("click", "[id ^='remove_field-']", function(event){
        var serviceID  = $(this).attr('id');
        var serviceArr =serviceID.split('-');
      $('#itemID-'+serviceArr[1]+'').remove();count--;
    });

$(document).on("change", "[id ^='inputSuccess-']", function(event){
    a.push($(this).val());
});  
var count = 2;
function addItem(id){
  var item_val = new Array();
  var flag = 0;
  var str = [];

 $( "[id ^='item_added-']" ).each(function() { 

    if($(this).val().length ==0)
    {
      flag = 0;
       Lobibox.notify('warning', {
                              size: 'normal',
                              rounded: true,
                              //delay: false,
                              position: 'center top', //or 'center bottom'
                              msg: 'Please enter item name'
                             });
     // alert('Please enter item name');
    }
    else
    {
            
        if((jQuery.inArray($(this).val(),str)) != -1) {
          flag = 0;
          Lobibox.notify('warning', {
                              size: 'normal',
                              rounded: true,
                              //delay: false,
                              position: 'center top', //or 'center bottom'
                              msg: 'This item may already exist.'
                             });
           // alert('Please enter another one.');
         } else {
            flag = 1;
            str.push($(this).val());   
         }
        
      }   
  });

  if(flag == 1){
    var serviceID  = $(id).attr('id');
  var serviceArr =serviceID.split('-');
   //max input box allowed
        
           
            $("#dataAdd-"+serviceArr[1]).append(  '<div class="add_item row" id= "itemID-'+count+'">'+
                                   '<input type="hidden" name="subtitle[]" value="">'+
                                   '<div class="col-md-1 col-sm-1 col-xs-2 form-group has-feedback">'+
                                   '</div>'+
                                   '<div class="col-md-4 col-sm-4 col-xs-8 form-group has-feedback">'+
                                      '<input type="text" class="form-control ui-autocomplete-input auto" placeholder="Item" name="item[]" id="item_added-'+count+'">'+
                                   '</div>'+

                                   '<div class="col-md-2 col-sm-2 col-xs-4 form-group has-feedback">'+
                                      '<input type="text" class="form-control" name="price[]" placeholder="Price" id="inputprice-'+count+'">'+
                                  '</div>'+
                               '<button type="button" id ="remove_field-'+count+'" class="btn btn-danger remove_field">✖</button></div>'); //add input box
        
           
     
 
 count++;
    }
   

 

}



   

      
