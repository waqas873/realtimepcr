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

});