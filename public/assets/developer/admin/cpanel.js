$(document).ready(function(){

$(document).on('click', '.sms_enable', function (e) {
  e.preventDefault();
  var obj = $(this);
  var check = obj.val();
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  // $.ajax({
  //     url: '/admin/add-lab',
  //     type: 'POST',
  //     data: formData,
  //     dataType: 'JSON',
  //     success: function (data) {
  //       if(data.response){
  //         obj.trigger("reset");
  //         $('#addLabModal').modal('hide');

  //         swal("Lab saved successfully.")
  //         .then((value) => {
  //           location.reload();
  //         });

  //       }
  //       else{
  //         $('#name_error').html(data.name);
  //         $('#type_error').html(data.type);
  //         $('#domain_error').html(data.domain);
  //         $('#focal_person_error').html(data.focal_person);
  //         $('#contact_no_error').html(data.contact_no);
  //         $('#address_error').html(data.address);
  //       }
  //     }
  // });
});

$(document).on('change', '.change_permission', function (e) {
  var obj = $(this);
  var id = obj.attr('name');
  var val = obj.val();
  $.LoadingOverlay("show");
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  $.ajax({
      url: '/admin/change-permission',
      type: 'POST',
      dataType: 'JSON',
      data: {id:id,'status':val,'_token':CSRF_TOKEN},
      success: function (data) {
        if(data.response){
          obj.val(data.status);
          swal({
            title: "Success",
            text: "Permission has been updated successfully.",
            icon: "success",
            button: "Ok",
          });
        }
      },
      complete: function(){
        $.LoadingOverlay("hide");
      }
  });
});

$(document).on('submit', '#accountCategoryForm', function (e) {
  e.preventDefault();
  var obj = $(this);
  $('.all_errors').empty();
  var formData = obj.serializeArray();
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  formData.push({'name':'_token','value':CSRF_TOKEN});
  $.ajax({
      url: '/admin/add-account-category',
      type: 'POST',
      data: formData,
      dataType: 'JSON',
      success: function (data) {
        if(data.response){
          obj.trigger("reset");
          $('#addAccountCategoryModal').modal('hide');
          swal("Category saved successfully.")
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

$(document).on('submit', '#testCategoryForm', function (e) {
  e.preventDefault();
  var obj = $(this);
  $('.all_errors').empty();
  var formData = obj.serializeArray();
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  formData.push({'name':'_token','value':CSRF_TOKEN});
  $.ajax({
      url: '/admin/add-test-category',
      type: 'POST',
      data: formData,
      dataType: 'JSON',
      success: function (data) {
        if(data.response){
          obj.trigger("reset");
          $('#addTestCategoryModal').modal('hide');
          swal("Category saved successfully.")
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

$(document).on('click', '#addParameter', function (e) {
  $('.all_errors').empty();
  $('#addParameterForm').trigger("reset");
  $('#addParameterModal').modal("show");
});
$(document).on('submit', '#addParameterForm', function (e) {
  e.preventDefault();
  var obj = $(this);
  $('.all_errors').empty();
  var formData = obj.serializeArray();
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  formData.push({'name':'_token','value':CSRF_TOKEN});
  $.ajax({
      url: '/admin/add-parameter',
      type: 'POST',
      data: formData,
      dataType: 'JSON',
      success: function (data) {
        if(data.response){
          obj.trigger("reset");
          $('#addParameterModal').modal('hide');
          swal("Parameter saved successfully.")
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
$(document).on('click', '.update_parameter_id', function (e) {
  var id = $(this).attr('rel');
  $('.all_errors').empty();
  $.ajax({
      url: '/admin/update-parameter/'+id,
      type: 'GET',
      dataType: 'JSON',
      success: function (data) {
        if(data.response){
          $('#addParameterForm').trigger("reset");
          $('#parameter_id').val(data.result.id);
          $('.name').val(data.result.name);
          $('.normal_value').val(data.result.normal_value);
          $('.units').val(data.result.units);
          $('.status').val(data.result.status).change();
          $('#addParameterModal').modal('show');
        }
      }
  });
});
$('#parametersListing').DataTable({
  "order": [
      [0, 'sesc']
  ],
});

$(document).on('click', '#addCategory', function (e) {
  $('.all_errors').empty();
  $('#addCategoryForm').trigger("reset");
  $('#addCategoryModal').modal("show");
});
$(document).on('submit', '#addCategoryForm', function (e) {
  e.preventDefault();
  var obj = $(this);
  $('.all_errors').empty();
  var formData = obj.serializeArray();
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  formData.push({'name':'_token','value':CSRF_TOKEN});
  $.ajax({
      url: '/admin/addCategory',
      type: 'POST',
      data: formData,
      dataType: 'JSON',
      success: function (data) {
        if(data.response){
          obj.trigger("reset");
          $('#addCategoryModal').modal('hide');
          swal("Category saved successfully.")
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

function errors(arr = ''){
    $.each(arr, function( key, value ) {
        $('.'+key+'_error').html(value);
    });
    return false;
}

});