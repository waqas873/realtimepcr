$(document).ready(function(){

$(document).on('click', '#by_date', function (e) {
  var date = $('#date').val();
  if(date!=''){
    var url = base_url+"/admin/reports/"+date;
    location.replace(url);
  }
});

$('#datatable').DataTable({
  
});

$('#datatable2').DataTable({
  
});

});