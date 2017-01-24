 $('#reservation').daterangepicker(1, function(start, end, label) {
           var todate = end.toISOString();
           var fromdate = start.toISOString();
            $.ajax
                ({
                  type: "POST",
                  url: "filter_list.php",
                  dataType: "json",
                  data: {todate:todate,fromdate:fromdate},
                  cache: false,
                  success: function (data) {
                    oTable.clear();
                    var rowData = data.data1;
                    if(rowData.length > 0)
                    {
                      for(var i = 0; i < rowData.length; i++) {
                          oTable.row.add([ 
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
                      alert('empty');
                      rows.remove();
                      oTable.clear();
                      
                    }
                  }
                });
         // console.log(start.toISOString(), end.toISOString(), label);
        });
     

        
    </script>

    <script>
      var oTable =  $('#example-1').DataTable({
            "ordering": false
        }); 

      $('#single_cal1').daterangepicker({
          singleDatePicker: true,
          calender_style: "picker_1"
        }, function(start, end, label) {
           var todate = $("#single_cal2").val();
           var fromdate = $("#single_cal1").val();
          $.ajax
                ({
                  type: "POST",
                  url: "filter_list.php",
                  dataType: "json",
                  data: {todate:todate,fromdate:fromdate},
                  cache: false,
                  success: function (data) {
                    oTable.clear();
                    var rowData = data.data1;
                      for(var i = 0; i < rowData.length; i++) {
                          oTable.row.add([ 
                            rowData[i][0],
                            rowData[i][1],
                            rowData[i][2],
                            rowData[i][3],
                            rowData[i][4]
                          ]).draw( false ); 
                      }
                    }
                });
          console.log(start.toISOString(), end.toISOString(), label);
        });
        $('#single_cal2').daterangepicker({
          singleDatePicker: true,
          calender_style: "picker_1"
        }, function(start, end, label) {
           var todate = $("#single_cal2").val();
           var fromdate = $("#single_cal1").val();
          $.ajax
                ({
                  type: "POST",
                  url: "filter_list.php",
                  dataType: "json",
                  data: {todate:todate,fromdate:fromdate},
                  cache: false,
                  success: function (data) {
                    oTable.clear();
                    var rowData = data.data1;
                      for(var i = 0; i < rowData.length; i++) {
                          oTable.row.add([ 
                            rowData[i][0],
                            rowData[i][1],
                            rowData[i][2],
                            rowData[i][3],
                            rowData[i][4]
                          ]).draw( false ); 
                      }
                    }
                });
          console.log(start.toISOString(), end.toISOString(), label);
        });
        
           
              $('#status').change(function() {
                var status = $("#status").val();
               
                $.ajax
                ({
                  type: "POST",
                  url: "status_search.php",
                  dataType: "json",
                  data: {st:status},
                  cache: false,
                  success: function (data) {
                    oTable.clear();
                    var rowData = data.data1;
                      for(var i = 0; i < rowData.length; i++) {
                          oTable.row.add([ 
                            rowData[i][0],
                            rowData[i][1],
                            rowData[i][2],
                            rowData[i][3],
                            rowData[i][4]
                          ]).draw( false ); 
                      }
                    }
                });
              });                                    
          </script>