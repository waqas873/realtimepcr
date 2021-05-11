$(document).ready(function(){

$('#cp_ledger').DataTable({
  "ordering": true,
  "lengthChange": true,
  "searching": true,
  "processing":true,
  "serverSide": true,
  "ajax": {
      url: '/admin/get-cp-ledger',
      type: 'POST',
      "data": function (d) {
          return $.extend({}, d, {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            "from_date": $('#from_date').val(),
            "to_date": $('#to_date').val(),
            "collection_point_id": $('#collection_point_id').val(),
          });
      } 
  },
  "order": [
      [0, 'desc']
  ],
  columnDefs: [
      {'targets': 0, 'orderable': false},
      {'targets': 1, 'orderable': false},
      {'targets': 2, 'orderable': false},
      {'targets': 3, 'orderable': false},
      {'targets': 4, 'orderable': false},
      {'targets': 5, 'orderable': false},
  ],
  "columns": [
      {"data": "unique_id"},
      {"data": "created_at"},
      {"data": "description"},
      {"data": "debit"},
      {"data": "credit"},
      {"data": "balance"}
  ]
});

$(document).on('click', '#by_date', function (e) {
  $('#cp_ledger').DataTable().ajax.reload();  
});
$(document).on('change', '#collection_point_id', function (e) {
  $('#cp_ledger').DataTable().ajax.reload();  
});

});