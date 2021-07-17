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

$(document).on('click', '#addBankPaymentBtn', function (e) {
  $('#addBankPaymentForm').trigger("reset");
  $('.all_errors').empty();
  $('#addBankPaymentModal').modal("show");
});

$(document).on('submit', '#addBankPaymentForm', function (e) {
  e.preventDefault();
  var obj = $(this);
  $('.all_errors').empty();
  var formData = obj.serializeArray();
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  formData.push({'name':'_token','value':CSRF_TOKEN});
  $.ajax({
      url: '/admin/add-system-invoice-bank',
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
          if(data.insufficient){
            swal({
              title: "Insufficient Balance",
              text: "You have insufficient balance.",
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

$(document).on('click', '#addJournalBtn', function (e) {
  $('#addJournalForm').trigger("reset");
  $('.all_errors').empty();
  $('#addJournalModal').modal("show");
});

$(document).on('submit', '#addJournalForm', function (e) {
  e.preventDefault();
  var obj = $(this);
  $('.all_errors').empty();
  var formData = obj.serializeArray();
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  formData.push({'name':'_token','value':CSRF_TOKEN});
  $.ajax({
      url: '/admin/add-system-invoice-journal',
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
          if(data.insufficient){
            swal({
              title: "Insufficient Balance",
              text: "You have insufficient balance.",
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


$('#cash_payment_datatable').DataTable({
  "ordering": true,
  "lengthChange": true,
  "searching": true,
  "processing":true,
  "serverSide": true,
  "ajax": {
      url: '/admin/get-cash-payment',
      type: 'POST',
      "data": function (d) {
          return $.extend({}, d, {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            //"from_date": $('#from_date').val(),
          });
      } 
  },
  "order": [
      [0, 'asc']
  ],
  columnDefs: [
      // {'targets': 0, 'orderable': false},
      // {'targets': 1, 'orderable': false},
      // {'targets': 3, 'orderable': false},
      // {'targets': 4, 'orderable': false},
      // {'targets': 5, 'orderable': false}
  ],
  "columns": [
      {"data": "unique_id"},
      {"data": "category"},
      {"data": "description"},
      {"data": "amount"}
  ]
});

$('#bank_payment_datatable').DataTable({
  "ordering": true,
  "lengthChange": true,
  "searching": true,
  "processing":true,
  "serverSide": true,
  "ajax": {
      url: '/admin/get-bank-payment',
      type: 'POST',
      "data": function (d) {
          return $.extend({}, d, {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            //"from_date": $('#from_date').val(),
          });
      } 
  },
  "order": [
      [0, 'asc']
  ],
  columnDefs: [
      // {'targets': 0, 'orderable': false},
      // {'targets': 1, 'orderable': false},
      // {'targets': 3, 'orderable': false},
      // {'targets': 4, 'orderable': false},
      // {'targets': 5, 'orderable': false}
  ],
  "columns": [
      {"data": "unique_id"},
      {"data": "category"},
      {"data": "description"},
      {"data": "amount"}
  ]
});

$('#bank_recieved_datatable').DataTable({
  "ordering": true,
  "lengthChange": true,
  "searching": true,
  "processing":true,
  "serverSide": true,
  "ajax": {
      url: '/admin/get-bank-recieved',
      type: 'POST',
      "data": function (d) {
          return $.extend({}, d, {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            //"from_date": $('#from_date').val(),
          });
      } 
  },
  "order": [
      [0, 'asc']
  ],
  columnDefs: [
      // {'targets': 0, 'orderable': false},
      // {'targets': 1, 'orderable': false},
      // {'targets': 3, 'orderable': false},
      // {'targets': 4, 'orderable': false},
      // {'targets': 5, 'orderable': false}
  ],
  "columns": [
      {"data": "unique_id"},
      {"data": "category"},
      {"data": "description"},
      {"data": "amount"}
  ]
});

// $('#bank_payment_datatable').DataTable({
//   "ordering": true,
//   "lengthChange": true,
//   "searching": true,
//   "processing":true,
//   "serverSide": true,
//   "ajax": {
//       url: '/admin/get-bank-payment',
//       type: 'POST',
//       "data": function (d) {
//           return $.extend({}, d, {
//             "_token": $('meta[name="csrf-token"]').attr('content'),
//             //"from_date": $('#from_date').val(),
//           });
//       } 
//   },
//   "order": [
//       [0, 'asc']
//   ],
//   columnDefs: [
//       // {'targets': 0, 'orderable': false},
//       // {'targets': 1, 'orderable': false},
//       // {'targets': 3, 'orderable': false},
//       // {'targets': 4, 'orderable': false},
//       // {'targets': 5, 'orderable': false}
//   ],
//   "columns": [
//       {"data": "unique_id"},
//       {"data": "category"},
//       {"data": "description"},
//       {"data": "amount"}
//   ]
// });

$('#journal_datatable').DataTable({
  "ordering": true,
  "lengthChange": true,
  "searching": true,
  "processing":true,
  "serverSide": true,
  "ajax": {
      url: '/admin/get-journal',
      type: 'POST',
      "data": function (d) {
          return $.extend({}, d, {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            //"from_date": $('#from_date').val(),
          });
      } 
  },
  "order": [
      [0, 'asc']
  ],
  columnDefs: [
      // {'targets': 0, 'orderable': false},
      // {'targets': 1, 'orderable': false},
      // {'targets': 3, 'orderable': false},
      // {'targets': 4, 'orderable': false},
      // {'targets': 5, 'orderable': false}
  ],
  "columns": [
      {"data": "unique_id"},
      {"data": "category"},
      {"data": "description"},
      {"data": "is_recieved"},
      {"data": "amount"}
  ]
});

$('#cash_recieved_datatable').DataTable({
  "ordering": true,
  "lengthChange": true,
  "searching": true,
  "processing":true,
  "serverSide": true,
  "ajax": {
      url: '/admin/get-cash-recieved',
      type: 'POST',
      "data": function (d) {
          return $.extend({}, d, {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            //"from_date": $('#from_date').val(),
          });
      } 
  },
  "order": [
      [0, 'asc']
  ],
  columnDefs: [
      // {'targets': 0, 'orderable': false},
      // {'targets': 1, 'orderable': false},
      // {'targets': 3, 'orderable': false},
      // {'targets': 4, 'orderable': false},
      // {'targets': 5, 'orderable': false}
  ],
  "columns": [
      {"data": "unique_id"},
      {"data": "category"},
      {"data": "description"},
      {"data": "amount"}
  ]
});

$('#cashbook_datatable').DataTable({
  "ordering": true,
  "lengthChange": true,
  "searching": true,
  "processing":true,
  "serverSide": true,
  "ajax": {
      url: '/admin/get-cashbook',
      type: 'POST',
      "data": function (d) {
          return $.extend({}, d, {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            "from_date": $('#from_date').val(),
            "to_date": $('#to_date').val(),
            //"collection_point_id": $('#collection_point_id').val(),
          });
      } 
  },
  "order": [
      [0, 'asc']
  ],
  columnDefs: [
      {'targets': 0, 'orderable': false},
      {'targets': 1, 'orderable': false},
      {'targets': 2, 'orderable': false},
      {'targets': 3, 'orderable': false},
      {'targets': 4, 'orderable': false},
      {'targets': 5, 'orderable': false},
      {'targets': 6, 'orderable': false},
  ],
  "columns": [
      {"data": "created_at"},
      {"data": "unique_id"},
      {"data": "description"},
      {"data": "previous"},
      {"data": "debit"},
      {"data": "credit"},
      {"data": "balance"},
  ]
});
$(document).on('click', '#by_date', function (e) {
  $('#cashbook_datatable').DataTable().ajax.reload();  
});
// $(document).on('change', '#collection_point_id', function (e) {
//   $('#cashbook_datatable').DataTable().ajax.reload();  
// });

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