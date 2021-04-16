$(document).ready(function(){

$(document).on('click', '#add_btn', function (e) {
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

$('#datatable').DataTable({
  "order": [
      [0, 'desc']
  ],
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

});