$(document).ready(function(){

$(document).on('click', '.cancel_api_request', function (e) {
  e.preventDefault();
  action_url = $(this).attr('href');
  swal({
    title: "Are you sure?",
    text: "Are you sure to do this?",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {
    if(willDelete){
      $.ajax({
        url: action_url,
        type: 'GET',
        dataType: 'JSON',
        success: function (data) {
          if(data.response){
            swal({
              title: "Success",
              text: "Patient test has been cancelled for sending to Api.",
              icon: "success",
              button: "Ok",
            });
            $('#datatable1').DataTable().ajax.reload();
          }
        }
      });
    }
  });
});

$(document).on('click', '.send_api_request', function (e) {
  e.preventDefault();
  action_url = $(this).attr('href');
  swal({
    title: "Are you sure?",
    text: "Are you sure to do this?",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {
    if(willDelete){
      $.ajax({
        url: action_url,
        type: 'GET',
        dataType: 'JSON',
        success: function (data) {
          if(data.response){
            swal({
              title: "Success",
              text: "Patient test has been enabled for sending to Api.",
              icon: "success",
              button: "Ok",
            });
            $('#datatable1').DataTable().ajax.reload();
          }
        }
      });
    }
  });
});

$('#datatable1').DataTable({
  "ordering": true,
  "lengthChange": true,
  "searching": true,
  "processing":true,
  "serverSide": true,
  "ajax": {
      url: '/admin/api-get-patients',
      type: 'POST',
      "data": function (d) {
          return $.extend({}, d, {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            "from_date": $('#from_date').val(),
            "to_date": $('#to_date').val(),
            //"lab_id": $('#lab_id').val(),
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
      {'targets': 2, 'orderable': false}
  ],
  "columns": [
      {"data": "created_at"},
      {"data": "id"},
      {"data": "invoice_id"},
      {"data": "name"},
      {"data": "action"},
  ]
});

$(document).on('click', '#by_date', function (e) {
  $('#datatable1').DataTable().ajax.reload();  
});
$(document).on('change', '#lab_id', function (e) {
  $('#datatable1').DataTable().ajax.reload();  
});

$('#datatable2').DataTable({});

$('#datatable3').DataTable({});

});