$(document).ready(function(){

$(document).on('click', '.commission_test_update_id', function (e) {
  var id = $(this).attr('rel');
  $('.all_errors').empty();
  $.ajax({
      url: '/admin/update-commission-test/'+id,
      type: 'GET',
      dataType: 'JSON',
      success: function (data) {
        if(data.response){
          $('#commission_test_id').val(data.result.id);
          $('.commission_price').val(data.result.commission_price);
          $('.test_id').val(data.result.test_id).change();
          $('.lab_id').val(data.result.lab_id).change();
          $('.collection_point_id').val(data.result.collection_point_id).change();
        }
      }
  });
});

$(document).on('submit', '#commissionTestForm', function (e) {
  e.preventDefault();
  var obj = $(this);
  $('.all_errors').empty();
  var formData = obj.serializeArray();
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  formData.push({'name':'_token','value':CSRF_TOKEN});
  $.ajax({
      url: '/admin/add-commission-test',
      type: 'POST',
      data: formData,
      dataType: 'JSON',
      success: function (data) {
        if(data.response){
          obj.trigger("reset");
          swal("Data saved successfully.")
          .then((value) => {
            location.reload();
          });
        }
        else{
          errors(data.errors);
        }
      }
  });
});

$(document).on('click', '.delete-commission-test', function (e) {
  e.preventDefault();
  var url = $(this).attr('href');
  swal({
    title: "Are you sure?",
    text: "If this record is deleted than all its data will be deleted.Are you sure to do this?",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {
    if (willDelete) {
      location.replace(url);
    }
  });
});

$(document).on('click', '#addPaymentBtn', function (e) {
  $('#addPaymentForm').trigger("reset");
  $('.all_errors').empty();
  $('#addPaymentModal').modal("show");
});

$(document).on('click', '.system_invoice_update_id', function (e) {
  var id = $(this).attr('rel');
  $('.all_errors').empty();
  $.ajax({
      url: '/admin/get-system-invoice/'+id,
      type: 'GET',
      dataType: 'JSON',
      success: function (data) {
        if(data.response){
          $('.system_invocie_id').val(data.result.id);
          $('.date').val(data.result.date);
          $('.amount').val(data.result.amount);
          $('.payment_method').val(data.result.payment_method).change();
          $('.description').html(data.result.description);
          $('#addPaymentModal').modal('show');
        }
      }
  });
});

$(document).on('submit', '#addPaymentForm', function (e) {
  e.preventDefault();
  var obj = $(this);
  $('.all_errors').empty();
  var formData = obj.serializeArray();
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  formData.push({'name':'_token','value':CSRF_TOKEN});
  $.ajax({
      url: '/admin/add-system-invoice',
      type: 'POST',
      data: formData,
      dataType: 'JSON',
      success: function (data) {
        if(data.response){
          obj.trigger("reset");
          swal("Data saved successfully.")
          .then((value) => {
            location.reload();
          });
        }
        else{
          errors(data.errors);
        }
      }
  });
});

$(document).on('click', '.delete_system_invoice', function (e) {
  e.preventDefault();
  var url = $(this).attr('href');
  swal({
    title: "Are you sure?",
    text: "If this record is deleted than all its data will be deleted.Are you sure to do this?",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {
    if (willDelete) {
      location.replace(url);
    }
  });
});

$('#systemInvoices').DataTable({
  "ordering": true,
  "lengthChange": true,
  "searching": true,
  "processing":true,
  "serverSide": true,
  "ajax": {
      url: '/admin/get-system-invoices-datatable',
      type: 'POST',
      "data": function (d) {
          return $.extend({}, d, {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            "embassy_user_id": $('.embassy_user_id').val(),
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
      {"data": "date"},
      {"data": "unique_id"},
      {"data": "amount"},
      {"data": "description"},
      {"data": "payment_method"},
      {"data": "action"}
  ]
});

$('#airlineSystemInvoices').DataTable({
  "ordering": true,
  "lengthChange": true,
  "searching": true,
  "processing":true,
  "serverSide": true,
  "ajax": {
      url: '/admin/get-system-invoices-datatable',
      type: 'POST',
      "data": function (d) {
          return $.extend({}, d, {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            "airline_user_id": $('.airline_user_id').val(),
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
      {"data": "date"},
      {"data": "unique_id"},
      {"data": "amount"},
      {"data": "description"},
      {"data": "payment_method"},
      {"data": "action"}
  ]
});

$('#commission_tests').DataTable();

function errors(arr = ''){
    $.each(arr, function( key, value ) {
        $('.'+key+'_error').html(value);
    });
    return false;
}

});