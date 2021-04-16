$(document).ready(function(){

$(document).on('click', '#add_btn', function (e) {
  $('#addLabModal').modal("show");
});

$(document).on('submit', '#add-form', function (e) {
  e.preventDefault();
  var obj = $(this);
  $('.all_errors').empty();
  var formData = obj.serializeArray();
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  formData.push({'name':'_token','value':CSRF_TOKEN});
  $.ajax({
      url: '/admin/add-lab',
      type: 'POST',
      data: formData,
      dataType: 'JSON',
      success: function (data) {
        if(data.response){
          obj.trigger("reset");
          $('#addLabModal').modal('hide');

          swal("Lab saved successfully.")
          .then((value) => {
            location.reload();
          });

        }
        else{
          $('#name_error').html(data.name);
          $('#type_error').html(data.type);
          $('#domain_error').html(data.domain);
          $('#city_error').html(data.city);
          $('#focal_person_error').html(data.focal_person);
          $('#contact_no_error').html(data.contact_no);
          $('#address_error').html(data.address);
        }
      }
  });
});

$('#datatable').DataTable({
  "order": [
      [0, 'desc']
  ],
});

});