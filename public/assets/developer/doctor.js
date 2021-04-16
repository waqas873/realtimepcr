$(document).ready(function(){

$(document).on('click', '#addWithdraw', function (e) {
    $('.all_errors').empty();
    $('#addWithdrawForm').trigger("reset");
    $('#addWithdrawModal').modal("show");
});

$(document).on('submit', '#addWithdrawForm', function (e) {
    e.preventDefault();
    $.LoadingOverlay("show");
    var obj = $(this);
    $('.all_errors').empty();
    var formData = obj.serializeArray();
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    formData.push({'name':'_token','value':CSRF_TOKEN});
    $.ajax({
        url: '/doctor/request-withdraw',
        type: "POST",
        dataType: 'json',
        data: formData,
        success: function (data) {
            if(data.response){
                obj.trigger("reset");
                swal("Withdraw request has been saved successfully.",{
                	icon: "success"
                })
                .then((value) => {
                  location.reload(); 
                });
            }
            else if(data.insufficient){
                swal("You have low amount in your account.",{
                	icon: "warning"
                });
            }
            else if(data.withdraw_exist){
                swal("Your previous request is pending.",{
                	icon: "warning"
                });
            }
            else{
                errors(data.errors);
            }
        },
        complete: function(){
          $.LoadingOverlay("hide");
        }
    });
    return false;
});

$(document).on('click', '.withdrawCancel', function (e) {
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