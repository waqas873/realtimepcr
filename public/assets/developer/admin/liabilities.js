$(document).ready(function(){

$(document).on('click', '#addButton', function (e) {
  $('#update_id').val('');
  $('#addForm').trigger("reset");
  $('#addModal').modal("show");
});

$(document).on('submit', '#addForm', function (e) {
  e.preventDefault();
  var obj = $(this);
  $('.all_errors').empty();
  var formData = obj.serializeArray();
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  formData.push({'name':'_token','value':CSRF_TOKEN});
  $.ajax({
      url: '/admin/add-liability',
      type: 'POST',
      data: formData,
      dataType: 'JSON',
      success: function (data) {
        if(data.response){
          obj.trigger("reset");
          $('#addModal').modal("hide");
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

$(document).on('click', '.update_id', function (e) {
  var update_id = $(this).attr('rel');
  $('.all_errors').empty();
  $.ajax({
      url: '/admin/update-liablility/'+update_id,
      type: 'GET',
      dataType: 'JSON',
      success: function (data) {
        if(data.response){
          $('#liability_id').val(data.result.id);
          $('.name').val(data.result.name);
          $('.value').val(data.result.value);
          $('.type').val(data.result.type).change();
          $('.sub_type').val(data.result.sub_type).change();
          $('#addModal').modal('show');
        }
      }
  });
});

$(document).on('click', '.delete', function (e) {
  e.preventDefault();
  var d_url = $(this).attr('href');
  swal({
    title: "Are you sure?",
    text: "If an asset/liability is deleted than all its data will be deleted.Are you sure to do this?",
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