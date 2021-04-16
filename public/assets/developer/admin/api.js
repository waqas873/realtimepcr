$(document).ready(function(){

$(document).on('click', '.cancel_api_request', function (e) {
  e.preventDefault();
  var d_url = $(this).attr('href');
  swal({
    title: "Are you sure?",
    text: "Are you sure to do this?",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {
    if(willDelete){
    	window.location.replace(d_url);
    }
  });
});

$('#datatable1').DataTable({});

$('#datatable2').DataTable({});

$('#datatable3').DataTable({});

});