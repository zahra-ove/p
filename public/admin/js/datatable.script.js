(function ($) {
    "use strict";
var editor;
 $('#example').DataTable({
      "pageLength": 50,
    dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
     responsive: true
 });
 
  

})(jQuery);
