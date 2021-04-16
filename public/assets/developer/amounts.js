$(document).ready(function(){

$(document).on('click', '#add_expense', function (e) {
  $('#expense-form').trigger("reset");
  $('#expenseModal').modal("show");
});

$(document).on('submit', '#expense-form', function (e) {
  e.preventDefault();
  var obj = $(this);
  $('.all_errors').empty();

  var formData = obj.serializeArray();
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  formData.push({'name':'_token','value':CSRF_TOKEN});
  $.ajax({
      url: '/add-expense',
      type: 'POST',
      data: formData,
      dataType: 'JSON',
      success: function (data) {
        if(data.response){

          obj.trigger("reset");
          $('#expenseModal').modal("hide");

          swal("Expense saved successfully.")
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
            $('#title_error').html(data.title);
            $('#amount_error').html(data.amount);
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

          swal("Amount transfer submitted successfully.Now it is pending from reciever side.")
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

$(document).on('click', '.transfer_action', function (e) {
  e.preventDefault();
  var url = $(this).attr('href');
  swal({
    title: "Warning",
    text: "Are you sure to perform this action?",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {
    if(willDelete){
      location.replace(url);
    }
  });
});

$('#datatable').DataTable({
  "order": [
      [0, 'sesc']
  ],
});

});