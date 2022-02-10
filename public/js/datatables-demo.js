// Call the dataTables jQuery plugin
$(document).ready(function() {
    $('#dataTable2').DataTable({
        pageLength: 10,  
        order: [[ 1, 'desc' ]],
        language: {
            search: "Filtrer ",
            paginate: {
              next: '&#8594;', // or '→'
              previous: '&#8592;' // or '←' 
            }
          }
        
      });
  

      $('#dataTable3').DataTable({
        pageLength: 10,  
        order: [[ 0, 'asc' ]],
        language: {
            search: "Filtrer ",
            paginate: {
              next: '&#8594;', // or '→'
              previous: '&#8592;' // or '←' 
            }
          }
        
      });

      $('#dataTable').DataTable({
        pageLength: 300,
        order: [[ 1, 'asc' ]],

        language: {
            search: "Filtrer ",
            paginate: {
              next: '&#8594;', // or '→'
              previous: '&#8592;' // or '←' 
            }
          }
        
      });

});
  