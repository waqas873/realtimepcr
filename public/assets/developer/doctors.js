$(document).ready(function(){

$(document).on('click', '#add_doctor', function (e) {
  $('#update_id').val('');
  $('#doctors-form').trigger("reset");
  $('#doctorsModal').modal("show");
});

$(document).on('submit', '#doctors-form', function (e) {
  e.preventDefault();
  var obj = $(this);
  $('.all_errors').empty();

  var formData = obj.serializeArray();
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  formData.push({'name':'_token','value':CSRF_TOKEN});
  $.ajax({
      url: '/admin/doctor-add',
      type: 'POST',
      data: formData,
      dataType: 'JSON',
      success: function (data) {
        if(data.response){

          obj.trigger("reset");
          $('#doctorsModal').modal("hide");

          swal("Doctor saved successfully.")
          .then((value) => {
            location.reload();
          });
          
        }
        else{
          $('#name_error').html(data.name);
          $('#email_error').html(data.email);
          $('#hospital_error').html(data.hospital);
          $('#affiliate_share_error').html(data.affiliate_share);
        }
      }
  });
});

$(document).on('click', '.update_id', function (e) {
  var update_id = $(this).attr('rel');
  $('.all_errors').empty();
  $.ajax({
      url: '/admin/update-doctor/'+update_id,
      type: 'GET',
      dataType: 'JSON',
      success: function (data) {
        if(data.response){
          $('#update_id').val(data.user.id);
          $('#name').val(data.user.name);
          $('#email').val(data.user.email);
          $('#hospital').val(data.doctor.hospital);
          $('#contact').val(data.doctor.contact);
          $('#bank_name').val(data.doctor.bank_name);
          $('#account_no').val(data.doctor.account_no);
          $('#affiliate_share').val(data.doctor.affiliate_share);
          $('#doctorsModal').modal('show');
        }
      }
  });
});

$(document).on('click', '.doctor_category_update_id', function (e) {
  var id = $(this).attr('rel');
  $('.all_errors').empty();
  $.ajax({
      url: '/admin/update-doctor-category/'+id,
      type: 'GET',
      dataType: 'JSON',
      success: function (data) {
        if(data.response){
          $('#doctor_category_id').val(data.result.id);
          $('.discount_percentage').val(data.result.discount_percentage);
          $('.custom_prizes').val(data.result.custom_prizes).change();
          $('#updateDoctorCategoryModal').modal('show');
        }
      }
  });
});

$(document).on('submit', '#updateDoctorCategoryForm', function (e) {
  e.preventDefault();
  var obj = $(this);
  $('.all_errors').empty();
  var formData = obj.serializeArray();
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  formData.push({'name':'_token','value':CSRF_TOKEN});
  $.ajax({
      url: '/admin/update-doctor-category',
      type: 'POST',
      data: formData,
      dataType: 'JSON',
      success: function (data) {
        if(data.response){
          obj.trigger("reset");
          $('#updateDoctorCategoryModal').modal('hide');
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

$(document).on('click', '.doctor_test_update_id', function (e) {
  var id = $(this).attr('rel');
  $('.all_errors').empty();
  $.ajax({
      url: '/admin/update-doctor-test/'+id,
      type: 'GET',
      dataType: 'JSON',
      success: function (data) {
        if(data.response){
          $('#doctor_test_id').val(data.result.id);
          $('.discounted_price').val(data.result.discounted_price);
          $('.test_id').val(data.result.test_id).change();
        }
      }
  });
});

$(document).on('submit', '#doctorTestForm', function (e) {
  e.preventDefault();
  var obj = $(this);
  $('.all_errors').empty();
  var formData = obj.serializeArray();
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  formData.push({'name':'_token','value':CSRF_TOKEN});
  $.ajax({
      url: '/admin/add-doctor-test',
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

$(document).on('click', '.delete-doctor-test', function (e) {
  e.preventDefault();
  var url = $(this).attr('href');
  swal({
    title: "Are you sure?",
    text: "If a doctor test is deleted than all its data will be deleted.Are you sure to do this?",
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

$('#datatable').DataTable({
  "order": [
      [0, 'sesc']
  ],
});

$('#datatable2').DataTable({
  "order": [
      [0, 'sesc']
  ],
});

function errors(arr = ''){
    $.each(arr, function( key, value ) {
        $('.'+key+'_error').html(value);
    });
    return false;
}

});