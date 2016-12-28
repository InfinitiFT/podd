// Popup for delete functionality
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

      
