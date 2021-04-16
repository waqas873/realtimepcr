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

$('#datatable').DataTable();

function errors(arr = ''){
    $.each(arr, function( key, value ) {
        $('.'+key+'_error').html(value);
    });
    return false;
}

});