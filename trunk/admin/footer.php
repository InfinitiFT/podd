
        <!-- footer content -->
        <footer>
          <div class="pull-right">
            IOSAndroidAppDevelopment!
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="../assets/vendors/jquery/dist/jquery.min.js"></script>
        <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <!-- Bootstrap -->
    <script src="../assets/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    
    <script src="../assets/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    
    
    <!-- DateJS -->
    <script src="../assets/vendors/DateJS/build/date.js"></script>
   
    <!-- bootstrap-daterangepicker -->
    <script src="../assets/production/js/moment/moment.min.js"></script>
    <script src="../assets/production/js/datepicker/daterangepicker.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="../assets/build/js/custom.min.js"></script>

    <!-- Datatables -->
    <script src="../assets/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../assets/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="../assets/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../assets/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="../assets/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="../assets/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="../assets/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="../assets/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="../assets/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="../assets/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../assets/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="../assets/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="../assets/vendors/jszip/dist/jszip.min.js"></script>
    <script src="../assets/vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="../assets/vendors/pdfmake/build/vfs_fonts.js"></script>
    <script src="../assets/lobibox-master/js/lobibox.js"></script>
    <script src="../assets/lobibox-master/demo/demo.js"></script>
    <script src="../assets/vendors/raphael/raphael.min.js"></script>
    <script src="../assets/vendors/morris.js/morris.min.js"></script>
    <script src="../assets/plugins/ckeditor/ckeditor.js"></script>
    <script src="../assets/js/admin-common-validation.js"></script>
    <script src="../assets/js/jquery.validate.min.js"></script>
    <script src="validation.js"></script>
    <script src="admin.js"></script>
    <script src="../assets/plugins/select2/dist/js/select2.full.min.js"></script>
    <script src="../assets/plugins/autocomplete/jquery.auto-complete.js"></script>
    <script>
        $('#datatable-responsive').DataTable({
            "ordering": false
        });  
    </script>
    <script type="text/javascript">
     Lobibox.alert(
      'error|success|warning|info', // Any of the following
      {
  
       });

            </script>
  <script>
        $(function(){
            $('#test').autoComplete({
                minChars: 1,
                source: function(term, suggest){
                    term = term.toLowerCase();
                    var choices = ['ActionScript', 'AppleScript', 'Asp', 'Assembly', 'BASIC', 'Batch', 'C', 'C++', 'CSS', 'Clojure', 'COBOL', 'ColdFusion', 'Erlang', 'Fortran', 'Groovy', 'Haskell', 'HTML', 'Java', 'JavaScript', 'Lisp', 'Perl', 'PHP', 'PowerShell', 'Python', 'Ruby', 'Scala', 'Scheme', 'SQL', 'TeX', 'XML'];
                    var suggestions = [];
                    for (i=0;i<choices.length;i++)
                        if (~choices[i].toLowerCase().indexOf(term)) suggestions.push(choices[i]);
                    suggest(suggestions);
                }
            });
    });
           
       
    </script>
    <!-- <script src="script.js"></script> -->
    <!-- Flot -->
    
    <!-- /Datatables -->
  </body>
</html>
