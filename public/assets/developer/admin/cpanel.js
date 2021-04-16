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

function errors(arr = ''){
    $.each(arr, function( key, value ) {
        $('.'+key+'_error').html(value);
    });
    return false;
}

});