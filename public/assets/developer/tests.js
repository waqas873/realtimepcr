$(document).ready(function(){

$(document).on('click', '#addTest', function (e) {
  $('#addTestModal').modal("show");
});

$(document).on('click', '.test_id', function (e) {
  var test_id = $(this).attr('rel');
  $('.all_errors').empty();
  $.ajax({
      url: '/admin/update-test/'+test_id,
      type: 'GET',
      dataType: 'JSON',
      success: function (data) {
        if(data.response){
          $('#test_id').val(data.test.id);
          $('#name').val(data.test.name);
          $('#category_id').val(data.test.category_id).change();
          $('#reporting_hrs').val(data.test.reporting_hrs);
          $('#sample_id').val(data.test.sample_id).change();
          $('#reporting_unit_id').val(data.test.reporting_unit_id).change();
          $('#normal_value').val(data.test.normal_value);
          $('#price').val(data.test.price);
          $('#addTestModal').modal('show');
        }
      }
  });
});

$(document).on('submit', '#test-form', function (e) {
  e.preventDefault();
  var obj = $(this);
  $('.all_errors').empty();
  var formData = obj.serializeArray();
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  formData.push({'name':'_token','value':CSRF_TOKEN});
  $.ajax({
      url: '/admin/add-test',
      type: 'POST',
      data: formData,
      dataType: 'JSON',
      success: function (data) {
        if(data.response){
          obj.trigger("reset");
          $('#addTestModal').modal('hide');

          swal("Test saved successfully.")
          .then((value) => {
            location.reload();
          });

        }
        else{
          $('#name_error').html(data.name);
          $('#category_id_error').html(data.category_id);
          $('#reporting_hrs_error').html(data.reporting_hrs);
          $('#sample_id_error').html(data.sample_id);
          $('#reporting_unit_id_error').html(data.reporting_unit_id);
          $('#normal_value_error').html(data.normal_value);
          $('#price_error').html(data.price);
        }
      }
  });
});

$(document).on('click', '#add_profile_test', function (e) {
  $('#addProfileTestModal').modal("show");
});

$(document).on('submit', '#profile-test-form', function (e) {
  e.preventDefault();
  var obj = $(this);
  $('.all_errors').empty();
  var formData = obj.serializeArray();
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  formData.push({'name':'_token','value':CSRF_TOKEN});
  $.ajax({
      url: '/admin/add-profile-test',
      type: 'POST',
      data: formData,
      dataType: 'JSON',
      success: function (data) {
        if(data.response){
          obj.trigger("reset");
          $('#addProfileTestModal').modal('hide');

          swal("Profile saved successfully.")
          .then((value) => {
            location.reload();
          });

        }
        else{
          $('#profile_name_error').html(data.name);
          $('#profile_price_error').html(data.price);
          $('#tests_error').html(data.tests);
        }
      }
  });
});

$(document).on('submit', '#update-profile-test-form', function (e) {
  e.preventDefault();
  var obj = $(this);
  $('.all_errors').empty();
  var formData = obj.serializeArray();
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  formData.push({'name':'_token','value':CSRF_TOKEN});
  $.ajax({
      url: '/admin/add-profile-test',
      type: 'POST',
      data: formData,
      dataType: 'JSON',
      success: function (data) {
        if(data.response){
          $('#updateProfileTestModal').modal('hide');
           location.replace('/admin/cpanel');
        }
        else{
          $('#update_profile_name_error').html(data.name);
          $('#update_profile_price_error').html(data.price);
          $('#update_tests_error').html(data.tests);
        }
      }
  });
});

// $(document).on('click', '.profile_id', function (e) {
//   var profile_id = $(this).attr('rel');
//   var url = '/admin/cpanel/'+profile_id;
//   window.replace(url);
// });

$(document).on('click', '.delete_test', function (e) {

  e.preventDefault();
  var loc = $(this).attr("href");

  swal({
    title: "Are you sure?",
    text: "Once deleted, you will not be able to recover this data!",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {
    if (willDelete) {
      window.location.replace(loc);
    }
  });

});

$(document).on('click', '.delete_test_profile', function (e) {

  e.preventDefault();
  var loc = $(this).attr("href");

  swal({
    title: "Are you sure?",
    text: "Once deleted, you will not be able to recover this data!",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {
    if (willDelete) {
      window.location.replace(loc);
    }
  });

});

$('#datatable').DataTable({
  "order": [
      [0, 'sesc']
  ],
});

$('#profile_test_datatable').DataTable({
  "order": [
      [0, 'sesc']
  ],
});

});