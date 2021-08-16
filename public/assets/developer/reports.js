$(document).ready(function(){

$(document).on('click', '.pay_now', function (e) {
  e.preventDefault();
  var invoice_id = $(this).attr('rel');
  if(invoice_id==''){
    return false;
  }
  $('.all_errors').empty();
  $('#pay-now-form').trigger('reset');
  $('#invoice_id').val(invoice_id);
  $('.invoice_box1').html('');
  $('.invoice_box2').html('');
  $.ajax({
      url: '/pay_now/'+invoice_id,
      type: 'GET',
      dataType: 'JSON',
      success: function (data) {
        if(data.response){
          total_amount = parseInt(data.result.total_amount);
          amount_remaining = parseInt(data.result.amount_remaining);
          $('.invoice_box1').html("<h4>Rs: "+total_amount+"</h4><h6>Total Amount</h6>");
          $('.invoice_box2').html("<h4>Rs: "+amount_remaining+"</h4><h6>Amount Remaining</h6>");
          $('#payNowModel').modal('show');
        }
        else{
          $('#name_error').html(data.name);
        }
      },
      complete: function(){
        $('body').LoadingOverlay("hide");
      }
  });

});

$(document).on('submit', '#pay-now-form', function (e) {
  e.preventDefault();
  var obj = $(this);
  $('.all_errors').empty();

  $('body').LoadingOverlay("show");

  var formData = obj.serializeArray();
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  formData.push({'name':'_token','value':CSRF_TOKEN});
  $.ajax({
      url: '/pay-now',
      type: 'POST',
      data: formData,
      dataType: 'JSON',
      success: function (data) {
        if(data.response){
          swal("Invoice paid successfully.")
          .then((value) => {
            location.reload();
          });
        }
        else{
            swal({
            title: "Warning",
            text: "Invalid request or invalid amount entered.",
            icon: "error",
            button: "OK",
          });
        }
      },
      complete: function(){
        $('body').LoadingOverlay("hide");
      }
  });
});

$(document).on('click', '.allBoxes', function (e) {
    if($('.allBoxes').is(':checked')){
      $('.eachBox').prop('checked', true);
    }
    else{
      $('.eachBox').prop('checked', false);
    }
});

$('#datatable').DataTable({
  "ordering": true,
  "lengthChange": true,
  "searching": true,
  "processing":true,
  "serverSide": true,
  "ajax": {
      url: '/get-reports',
      type: 'POST',
      "data": function (d) {
          return $.extend({}, d, {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            "status_filter": $('#status_filter').val(),
            "test_type": $('#test_type').val(),
            "airline": $('#airline').val(),
            "test_id": $('#test_id').val(),
            "start_date": $('#start_date').val(),
            "end_date": $('#end_date').val(),
            "user_id": $('#user_id').val(),
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
      {"data": "check"},
      {"data": "unique_id"},
      {"data": "name"},
      {"data": "tests"},
      {"data": "amount_paid"},
      {"data": "amount_remaining"},
      {"data": "status"}
  ]
});

$(document).on('change', '#status_filter', function (e) {
 $('#datatable').DataTable().ajax.reload();  
});
$(document).on('change', '#test_type', function (e) {
 $('#datatable').DataTable().ajax.reload();  
});
$(document).on('change', '#airline', function (e) {
 $('#datatable').DataTable().ajax.reload();  
});
$(document).on('change', '#test_id', function (e) {
 $('#datatable').DataTable().ajax.reload();  
});
$(document).on('change', '#start_date', function (e) {
 $('#datatable').DataTable().ajax.reload();  
});
$(document).on('change', '#end_date', function (e) {
 $('#datatable').DataTable().ajax.reload();  
});
$(document).on('change', '#user_id', function (e) {
  $('#datatable').DataTable().ajax.reload();  
});

});