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
      url: '/admin/update-product/'+id,
      type: 'GET',
      dataType: 'JSON',
      success: function (data) {
        if(data.response){
          $('#product_id').val(data.result.id);
          // $('#name').val(data.result.name);
          // $('#email').val(data.result.email);
          // $('#shop_name').val(data.result.shop_name);
          // $('#contact').val(data.result.contact);
          // $('#city').val(data.result.city);
          // $('#bank_name').val(data.result.bank_name);
          // $('#account_no').val(data.result.account_no);
          $('#addModal').modal('show');
        }
      }
  });
});

$(document).on('click', '.delete_id', function (e) {
  e.preventDefault();
  var d_url = $(this).attr('href');
  swal({
    title: "Are you sure?",
    text: "If this record is deleted than all its data will be deleted.Are you sure to do this?",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {
    if(willDelete){
      location.replace(d_url);
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
      url: '/admin/add-product',
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

$('#datatable').DataTable({
  "ordering": true,
  "lengthChange": true,
  "searching": true,
  "processing":true,
  "serverSide": true,
  "ajax": {
      url: '/admin/get-products',
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
      {'targets': 0, 'orderable': false},
      {'targets': 1, 'orderable': false},
      {'targets': 3, 'orderable': false},
  ],
  "columns": [
      {"data": "name"},
      {"data": "assigned_test"},
      {"data": "quantity"},
      {"data": "remaining_quantity"},
      {"data": "expiry_date"},
      {"data": "action"},
  ]
});

function errors(arr = ''){
    $.each(arr, function( key, value ) {
        $('.'+key+'_error').html(value);
    });
    return false;
}

});