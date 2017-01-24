// Search for booking list restaurant 

var booking_managementable =  $('#booking_management_table').DataTable({
            "ordering": false,
             stateSave: true
        });   
     
 $('#booking_management_cal').daterangepicker(null, function(start, end, label) {
           var todate = end.toISOString();
           var fromdate = start.toISOString();
            $.ajax
                ({
                  type: "POST",
                  url: "filter_list.php",
                  dataType: "json",
                  data: {todate:todate,fromdate:fromdate,type:'booking_management_list'},
                  cache: false,
                  success: function (data) {
                   var rows = booking_managementable
                           .rows()
                           .remove()
                           .draw();
                    var rowData = data.data1;
                    if(rowData.length > 0)
                    {
                      for(var i = 0; i < rowData.length; i++) {
                          booking_managementable.row.add([ 
                            rowData[i][0],
                            rowData[i][1],
                            rowData[i][2],
                            rowData[i][3],
                            rowData[i][4],
                            rowData[i][5],
                            rowData[i][6],
                            rowData[i][7]
                          ]).draw( false ); 
                      }

                    }
                    else
                    {
                      var rows = booking_managementable
                           .rows()
                           .remove()
                           .draw();
                      
                    }
                  }
                });
         // console.log(start.toISOString(), end.toISOString(), label);
        });

 $('#booking_management_status').change(function() {
                var status = $("#booking_management_status").val();
                $.ajax
                ({
                  type: "POST",
                  url: "status_search.php",
                  dataType: "json",
                  data: {st:status,type:'booking_management_status'},
                  cache: false,
                  success: function (data) {
                     var rows = booking_managementable
                           .rows()
                           .remove()
                           .draw();
                    var rowData = data.data1;
                    if(rowData.length > 0)
                    {
                      for(var i = 0; i < rowData.length; i++) {
                          booking_managementable.row.add([ 
                            rowData[i][0],
                            rowData[i][1],
                            rowData[i][2],
                            rowData[i][3],
                            rowData[i][4],
                            rowData[i][5],
                            rowData[i][6],
                            rowData[i][7]
                          ]).draw( false ); 
                      }

                    }
                    else
                    {
                      var rows = booking_managementable
                           .rows()
                           .remove()
                           .draw();
                      
                    }
                    }
                });
              });

// Search for booking list restaurant history

var booking_history =  $('#booking_history').DataTable({
            "ordering": false,
             stateSave: true
        });
 $('#booking_history_range').daterangepicker(null, function(start, end, label) {
           var todate = end.toISOString();
           var fromdate = start.toISOString();
            $.ajax
                ({
                  type: "POST",
                  url: "filter_list.php",
                  dataType: "json",
                  data: {todate:todate,fromdate:fromdate,type:'booking_history'},
                  cache: false,
                  success: function (data) {
                    var rows = booking_history
                           .rows()
                           .remove()
                           .draw();
                    var rowData = data.data1;
                    if(rowData.length > 0)
                    {
                      for(var i = 0; i < rowData.length; i++) {
                          booking_history.row.add([ 
                            rowData[i][0],
                            rowData[i][1],
                            rowData[i][2],
                            rowData[i][3],
                            rowData[i][4]
                          ]).draw( false ); 
                      }

                    }
                    else
                    {
                      
                     var rows = booking_history
                           .rows()
                           .remove()
                           .draw();
                      
                    }
                  }
                });
         // console.log(start.toISOString(), end.toISOString(), label);
        });
 $('#booking_history_status').change(function() {
                var status = $("#booking_history_status").val();
               
                $.ajax
                ({
                  type: "POST",
                  url: "status_search.php",
                  dataType: "json",
                  data: {st:status,type:'booking_history_status'},
                  cache: false,
                  success: function (data) {
                     var rows = booking_history
                           .rows()
                           .remove()
                           .draw();
                    var rowData = data.data1;
                    if(rowData.length > 0)
                    {
                      for(var i = 0; i < rowData.length; i++) {
                          booking_history.row.add([ 
                            rowData[i][0],
                            rowData[i][1],
                            rowData[i][2],
                            rowData[i][3],
                            rowData[i][4]
                          ]).draw( false ); 
                      }
                    }
                    else
                    {
                      var rows = booking_history
                           .rows()
                           .remove()
                           .draw();
                      
                    }
                    }
                });
              });    
// booking history delivery
 var booking_history_delivery =  $('#booking_history_delivery').DataTable({
            "ordering": false,
             stateSave: true
        });  
 $('#booking_history_delivery_cal').daterangepicker(1, function(start, end, label) {
           var todate = end.toISOString();
           var fromdate = start.toISOString();
            $.ajax
                ({
                  type: "POST",
                  url: "filter_list.php",
                  dataType: "json",
                  data: {todate:todate,fromdate:fromdate,type:'booking_history_delivery_cal'},
                  cache: false,
                  success: function (data) {
                    var rows = booking_history_delivery
                           .rows()
                           .remove()
                           .draw();
                    var rowData = data.data1;
                    if(rowData.length > 0)
                    {
                      for(var i = 0; i < rowData.length; i++) {
                          booking_history_delivery.row.add([ 
                            rowData[i][0],
                            rowData[i][1],
                            rowData[i][2],
                            rowData[i][3]
                            
                          ]).draw( false ); 
                      }

                    }
                    else
                    {
                      var rows = booking_history_delivery
                           .rows()
                           .remove()
                           .draw();
                      
                    }
                  }
                });
         // console.log(start.toISOString(), end.toISOString(), label);
        });
     $('#booking_history_delivery_status').change(function() {
                var status = $("#booking_history_delivery_status").val();

               
                $.ajax
                ({
                  type: "POST",
                  url: "status_search.php",
                  dataType: "json",
                  data: {st:status,type:'booking_history_delivery_status'},
                  cache: false,
                  success: function (data) {
                     var rows = booking_history_delivery
                           .rows()
                           .remove()
                           .draw();
                    var rowData = data.data1;
                    if(rowData.length > 0)
                    {
                      for(var i = 0; i < rowData.length; i++) {
                          booking_history_delivery.row.add([ 
                            rowData[i][0],
                            rowData[i][1],
                            rowData[i][2],
                            rowData[i][3]
                          ]).draw( false ); 
                      }
                     }
                    else
                    {
                      var rows = booking_history_delivery
                           .rows()
                           .remove()
                           .draw();
                      
                    }
                    }
                });
              });
//booking delivery table
     var booking_deliverytable =  $('#booking_deliverytable').DataTable({
            "ordering": false,
             stateSave: true
        });   
     
 $('#booking_deliverytable_cal').daterangepicker(1, function(start, end, label) {
           var todate = end.toISOString();
           var fromdate = start.toISOString();
            $.ajax
                ({
                  type: "POST",
                  url: "filter_list.php",
                  dataType: "json",
                  data: {todate:todate,fromdate:fromdate,type:'booking_deliverytable_cal'},
                  cache: false,
                  success: function (data) {
                   var rows = booking_deliverytable
                           .rows()
                           .remove()
                           .draw();
                    var rowData = data.data1;
                    if(rowData.length > 0)
                    {
                      for(var i = 0; i < rowData.length; i++) {
                          booking_deliverytable.row.add([ 
                            rowData[i][0],
                            rowData[i][1],
                            rowData[i][2],
                            rowData[i][3],
                            rowData[i][4],
                            rowData[i][5],
                            rowData[i][6]
                            
                          ]).draw( false ); 
                      }

                    }
                    else
                    {
                      var rows = booking_deliverytable
                           .rows()
                           .remove()
                           .draw();
                      
                    }
                  }
                });
         // console.log(start.toISOString(), end.toISOString(), label);
        });

 $('#booking_delivery_status').change(function() {
                var status = $("#booking_delivery_status").val();
                $.ajax
                ({
                  type: "POST",
                  url: "status_search.php",
                  dataType: "json",
                  data: {st:status,type:'booking_delivery_status'},
                  cache: false,
                  success: function (data) {
                     var rows = booking_deliverytable
                           .rows()
                           .remove()
                           .draw();
                    var rowData = data.data1;
                    if(rowData.length > 0)
                    {
                      for(var i = 0; i < rowData.length; i++) {
                          booking_deliverytable.row.add([ 
                            rowData[i][0],
                            rowData[i][1],
                            rowData[i][2],
                            rowData[i][3],
                            rowData[i][4],
                            rowData[i][5],
                            rowData[i][6]
                          ]).draw( false ); 
                      }

                    }
                    else
                    {
                      var rows = booking_deliverytable
                           .rows()
                           .remove()
                           .draw();
                      
                    }
                    }
                });
              });

   