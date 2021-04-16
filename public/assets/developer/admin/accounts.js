$(document).ready(function(){

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

});