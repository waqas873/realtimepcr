$(document).ready(function(){

$(document).on('click', '.transfer_cash', function (e) {
  $('#transferForm').trigger("reset");
  var action = $(this).attr('id');
  var id = $(this).attr('rel');
  $('.action').val(action);
  $('.user_id').val(id);
  $('#transferModal').modal("show");
});

$(document).on('submit', '#transferForm', function (e) {
  e.preventDefault();
  var obj = $(this);
  $('.all_errors').empty();
  var formData = obj.serializeArray();
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  formData.push({'name':'_token','value':CSRF_TOKEN});
  $.ajax({
      url: '/admin/cash-user-transfer',
      type: 'POST',
      data: formData,
      dataType: 'JSON',
      success: function (data) {
        if(data.response){
          obj.trigger("reset");
          $('#transferModal').modal("hide");
          swal("Transfer completed successfully.")
          .then((value) => {
            location.reload();
          });
        }
        else{
          if(data.insufficient){
            swal({
              title: "Insufficient Balance",
              text: "Insufficient balance for transfer.",
              icon: "error",
              button: "OK",
            });
          }
          else{
            errors(data.errors);
          }
        }
      }
  });
});

$(document).on('click', '#add_btn', function (e) {
  $('#addLabModal').modal("show");
});

$("#ledger_type").select2({
    placeholder: "Select Ledger Type",
    allowClear: true
});
$("#ledger_account").select2({
    placeholder: "Select Ledger Account",
    allowClear: true
});

$('#cashbook_datatable').DataTable({
  "order": [
      [0, 'desc']
  ],
});

$('#cash_payment_datatable').DataTable({
  "order": [
      [0, 'desc']
  ],
});

$('#cash_recieved_datatable').DataTable({
  "order": [
      [0, 'desc']
  ],
});

$('#journal_datatable').DataTable({
  "order": [
      [0, 'desc']
  ],
});

$('#cashUserWallets').DataTable({
  "order": [
      [0, 'asc']
  ],
});

function errors(arr = ''){
    $.each(arr, function( key, value ) {
        $('.'+key+'_error').html(value);
    });
    return false;
}

});