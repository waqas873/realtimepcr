$(document).ready(function(){

$(document).on('submit', '#update-form', function (e) {
  e.preventDefault();
  var obj = $(this);
  $('.all_errors').empty();

  var formData = obj.serializeArray();
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  formData.push({'name':'_token','value':CSRF_TOKEN});
  $.ajax({
      url: '/user-update',
      type: 'POST',
      data: formData,
      dataType: 'JSON',
      success: function (data) {
        if(data.response){
          obj.trigger("reset");
          swal({
            title: "Success",
            text: "Your password has been changed successfully.",
            icon: "success",
            button: "OK",
          });
        }
        else{
          if(data.oldpass){
            swal({
              title: "Old Password",
              text: "Please enter correct old password.",
              icon: "error",
              button: "OK",
            });
          }
          else{
            // $('#old_password_error').html(data.old_password);
            $('#password_error').html(data.password);
          }
        }
      }
  });
});

$(document).on('click', '#transfer_amount_btn', function (e) {
  $('#amount_transfer_form').trigger("reset");
  $('#transfer_amount_modal').modal("show");
});

$(document).on('submit', '#amount_transfer_form', function (e) {
  e.preventDefault();
  var obj = $(this);
  $('.all_errors').empty();

  var formData = obj.serializeArray();
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  formData.push({'name':'_token','value':CSRF_TOKEN});
  $.ajax({
      url: '/transfer-amount',
      type: 'POST',
      data: formData,
      dataType: 'JSON',
      success: function (data) {
        if(data.response){

          obj.trigger("reset");
          $('#transfer_amount_modal').modal("hide");

          swal("Amount transfered successfully.")
          .then((value) => {
            location.reload();
          });
          
        }
        else{
          if(data.insufficient){
            swal({
              title: "Insufficient Balance",
              text: "You have insufficient balance.",
              icon: "error",
              button: "OK",
            });
          }
          else{
            $('#user_id_error').html(data.user_id);
            $('#amount_transfer_error').html(data.amount_transfer);
          }
        }
      }
  });
});

$('#datatable').DataTable({
  "order": [
      [0, 'sesc']
  ],
});

});