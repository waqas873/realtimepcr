$(document).ready(function(){

$(document).on('click', '#addBtn', function (e) {
  $('.all_errors').empty();
  $('#addForm').trigger("reset");
  $('#addModal').modal("show");
});

$(document).on('click', '.update_id', function (e) {
  var id = $(this).attr('rel');
  $('.all_errors').empty();
  $.ajax({
      url: '/admin/update-supplier/'+id,
      type: 'GET',
      dataType: 'JSON',
      success: function (data) {
        if(data.response){
          $('#supplier_id').val(data.result.id);
          $('#name').val(data.result.name);
          $('#email').val(data.result.email);
          $('#shop_name').val(data.result.shop_name);
          $('#contact').val(data.result.contact);
          $('#city').val(data.result.city);
          $('#bank_name').val(data.result.bank_name);
          $('#account_no').val(data.result.account_no);
          $('#addModal').modal('show');
        }
      }
  });
});

$(document).on('submit', '#addForm', function (e) {
  e.preventDefault();
  var obj = $(this);
  $('.all_errors').empty();
  var formData = obj.serializeArray();
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  formData.push({'name':'_token','value':CSRF_TOKEN});
  $.ajax({
      url: '/admin/add-supplier',
      type: 'POST',
      data: formData,
      dataType: 'JSON',
      success: function (data) {
        if(data.response){
          obj.trigger("reset");
          $('#addModal').modal('hide');
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

$(document).on('click', '#addPurchaseBtn', function (e) {
  $('#addPurchaseForm').trigger("reset");
  $('.all_errors').empty();
  $('#addPurchaseModal').modal("show");
});

// $(document).on('click', '.purchase_update_id', function (e) {
//   var id = $(this).attr('rel');
//   $('.all_errors').empty();
//   $.ajax({
//       url: '/admin/get-purchase/'+id,
//       type: 'GET',
//       dataType: 'JSON',
//       success: function (data) {
//         if(data.response){
//           $('#addPurchaseForm').trigger("reset");
//           $('.purchase_id').val(data.result.id);
//           $('.date').val(data.result.date);
//           $('.price').val(data.result.price);
//           $('.purchase_type').val(data.result.purchase_type).change();
//           $('.description').html(data.result.description);
//           $('#addPaymentModal').modal('show');
//         }
//       }
//   });
// });

$(document).on('submit', '#addPurchaseForm', function (e) {
  e.preventDefault();
  var obj = $(this);
  $('.all_errors').empty();
  var formData = obj.serializeArray();
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  formData.push({'name':'_token','value':CSRF_TOKEN});
  $.ajax({
      url: '/admin/add-purchase',
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

$(document).on('click', '.delete_purchase', function (e) {
  e.preventDefault();
  var url = $(this).attr('href');
  swal({
    title: "Are you sure?",
    text: "If a purchase is deleted than all its data will be deleted.Are you sure to do this?",
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

$(document).on('click', '.purchase_pay', function (e) {
  var purchase_id = $(this).attr('rel');
  $('.all_errors').empty();
  $('#addPurchasePayForm').trigger("reset");
  $('.purchase_id').val(purchase_id);
  $('#addPurchasePayModal').modal("show");
});

$(document).on('submit', '#addPurchasePayForm', function (e) {
  e.preventDefault();
  var obj = $(this);
  $('.all_errors').empty();
  var formData = obj.serializeArray();
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  formData.push({'name':'_token','value':CSRF_TOKEN});
  $.ajax({
      url: '/admin/add-purchase-pay',
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

$('#purchases_datatable').DataTable({
  "ordering": true,
  "lengthChange": true,
  "searching": true,
  "processing":true,
  "serverSide": true,
  "ajax": {
      url: '/admin/get-purchases-datatable',
      type: 'POST',
      "data": function (d) {
          return $.extend({}, d, {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            "supplier_id": $('.supplier_id').val(),
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
      {"data": "purchase_type"},
      {"data": "description"},
      {"data": "price"},
      {"data": "advance_payment"},
      {"data": "remaining_balance"},
      {"data": "action"}
  ]
});

$('#datatable').DataTable();

function errors(arr = ''){
    $.each(arr, function( key, value ) {
        $('.'+key+'_error').html(value);
    });
    return false;
}

});