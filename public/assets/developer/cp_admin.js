$(document).ready(function(){

$(document).on('click', '.cpAdmin', function (e) {
  e.preventDefault();
  var url = $(this).attr('href');
  swal("Please enter password here:", {
    content: "input",
  })
  .then((value) => {
    var password = value;
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url: '/process-cp-admin',
        type: 'POST',
        data: {'_token':CSRF_TOKEN,'password':password},
        dataType: 'JSON',
        success: function (data) {
          if(data.response){
            window.location.replace(url);
          }
          else{
            swal({
              title: "Warning",
              text: "Pleas enter valid password.",
              icon: "error",
              button: "Ok",
            });
          }
        }
    });
  });
  return false;
});

});