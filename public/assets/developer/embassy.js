$(document).ready(function(){
$('#datatable').DataTable({
  "ordering": true,
  "lengthChange": true,
  "searching": true,
  "processing":true,
  "serverSide": true,
  "ajax": {
      url: base_url + '/embassy/get_patients',
      type: 'POST',
      "data": function (d) {
          return $.extend({}, d, {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            "airline": $('#airline').val(),
            "collection_point_id": $('#collection_point_id').val(),
            "test_status": $('#test_status').val(),
            "from_date": $('#from_date').val(),
            "to_date": $('#to_date').val()
          });
      } 
  },
  "order": [
      [0, 'asc']
  ],
  columnDefs: [
      {'targets': 0, 'orderable': false},
      {'targets': 1, 'orderable': false},
      {'targets': 3, 'orderable': false},
      {'targets': 4, 'orderable': false},
      {'targets': 5, 'orderable': false}
  ],
  "columns": [
      {"data": "unique_id"},
      {"data": "created_at"},
      {"data": "name"},
      {"data": "airline"},
      {"data": "cp_city"},
      {"data": "result"},
      {"data": "view_report"}
  ]
});

$(document).on('change', '#airline', function (e) {
 $('#datatable').DataTable().ajax.reload();  
});
$(document).on('change', '#collection_point_id', function (e) {
 $('#datatable').DataTable().ajax.reload();  
});
$(document).on('change', '#test_status', function (e) {
 $('#datatable').DataTable().ajax.reload();  
});
$(document).on('click', '#by_date', function (e) {
 $('#datatable').DataTable().ajax.reload();  
});

// $(document).on('click', '#by_date', function (e) {
//   var date = $('#date').val();
//   if(date!=''){
//     var url = base_url+"/embassy/all-reports/"+date;
//     location.replace(url);
//   }
// });

$('#datatable2').DataTable({});
$('#datatable3').DataTable({});

});