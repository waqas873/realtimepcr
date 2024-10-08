$(document).ready(function(){

$(document).on('click', '#add_btn', function (e) {
  $('#add-form').trigger("reset");
  $('.all_errors').empty();
  $('#addCollectionPointModal').modal("show");
});

$(document).on('submit', '#add-form', function (e) {
  e.preventDefault();
  var obj = $(this);
  $('.all_errors').empty();
  var formData = obj.serializeArray();
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  formData.push({'name':'_token','value':CSRF_TOKEN});
  $.ajax({
      url: '/admin/add-collection-point',
      type: 'POST',
      data: formData,
      dataType: 'JSON',
      success: function (data) {
        if(data.response){
          obj.trigger("reset");
          $('#addCollectionPointModal').modal('hide');

          swal("Collection point added successfully.")
          .then((value) => {
            location.reload();
          });

        }
        else{
          $('#name_error').html(data.name);
          $('#city_error').html(data.city);
          $('#domain_error').html(data.domain);
          $('#focal_person_error').html(data.focal_person);
          $('#contact_no_error').html(data.contact_no);
          $('#address_error').html(data.address);
        }
      }
  });
});

$(document).on('click', '.update_id', function (e) {
  var id = $(this).attr('rel');
  $('.all_errors').empty();
  $.ajax({
      url: '/admin/update-collection-point/'+id,
      type: 'GET',
      dataType: 'JSON',
      success: function (data) {
        if(data.response){
          $('#cp_id').val(data.result.id);
          $('#name').val(data.result.name);
          $('#domain').val(data.result.domain);
          $('#focal_person').val(data.result.focal_person);
          $('#contact_no').val(data.result.contact_no);
          $('#city').val(data.result.city);
          $('#address').val(data.result.address);
          $('#addCollectionPointModal').modal('show');
        }
      }
  });
});

$('#datatable').DataTable({
  "order": [
      [0, 'desc']
  ],
});

$(document).on('click', '.cp_category_update_id', function (e) {
  var id = $(this).attr('rel');
  $('.all_errors').empty();
  $.ajax({
      url: '/admin/update-cp-category/'+id,
      type: 'GET',
      dataType: 'JSON',
      success: function (data) {
        if(data.response){
          $('#cp_category_id').val(data.result.id);
          $('.discount_percentage').val(data.result.discount_percentage);
          $('.custom_prizes').val(data.result.custom_prizes).change();
          $('#updateCpCategoryModal').modal('show');
        }
      }
  });
});

$(document).on('submit', '#updateCpCategoryForm', function (e) {
  e.preventDefault();
  var obj = $(this);
  $('.all_errors').empty();
  var formData = obj.serializeArray();
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  formData.push({'name':'_token','value':CSRF_TOKEN});
  $.ajax({
      url: '/admin/update-cp-category',
      type: 'POST',
      data: formData,
      dataType: 'JSON',
      success: function (data) {
        if(data.response){
          obj.trigger("reset");
          $('#updateCpCategoryModal').modal('hide');
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

$(document).on('click', '.cp_test_update_id', function (e) {
  var id = $(this).attr('rel');
  $('.all_errors').empty();
  $.ajax({
      url: '/admin/update-cp-test/'+id,
      type: 'GET',
      dataType: 'JSON',
      success: function (data) {
        if(data.response){
          $('#cp_test_id').val(data.result.id);
          $('.discounted_price').val(data.result.discounted_price);
          $('.test_id').val(data.result.test_id).change();
        }
      }
  });
});

$(document).on('submit', '#cpTestForm', function (e) {
  e.preventDefault();
  var obj = $(this);
  $('.all_errors').empty();
  var formData = obj.serializeArray();
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  formData.push({'name':'_token','value':CSRF_TOKEN});
  $.ajax({
      url: '/admin/add-cp-test',
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

$(document).on('click', '.delete_cp', function (e) {
  e.preventDefault();
  var url = $(this).attr('href');
  swal({
    title: "Are you sure?",
    text: "If a collection point is deleted than all its inactive users data will be deleted.Are you sure to do this?",
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

$(document).on('click', '.delete-cp-test', function (e) {
  e.preventDefault();
  var url = $(this).attr('href');
  swal({
    title: "Are you sure?",
    text: "If a collection point test is deleted than all its data will be deleted.Are you sure to do this?",
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
    text: "If a system invoice is deleted than all its data will be deleted.Are you sure to do this?",
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

$('#collection_point_categories').DataTable({});
$('#cpTestsDatatable').DataTable({});

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
            "collection_point_id": $('.collection_point_id').val(),
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

function errors(arr = ''){
    $.each(arr, function( key, value ) {
        $('.'+key+'_error').html(value);
    });
    return false;
}

});