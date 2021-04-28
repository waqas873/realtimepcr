$(document).ready(function(){

$(document).on('click', '.submit_reports', function (e) {
  e.preventDefault();
  var type = $(this).attr('rel');
  $('.allForms').trigger("reset");
  $('.all_errors').empty();
  if(type!=''){
    var patient_test_id = $(this).attr('href');
    $('.patient_test_id').val(patient_test_id);
    $('#addModal'+type).modal("show");
  }
  return false;
});

$(document).on('submit', '#addForm1,#addForm2,#addForm3,#addForm4,#addForm5,#addForm6', function (e) {
  e.preventDefault();
  var obj = $(this);
  $('.all_errors').empty();
  var formData = obj.serializeArray();
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  formData.push({'name':'_token','value':CSRF_TOKEN});
  $.ajax({
      url: '/lab/add-patient-test-result',
      type: 'POST',
      data: formData,
      dataType: 'JSON',
      success: function (data) {
        if(data.response){
          obj.trigger("reset");
          $('#addTestModal').modal('hide');
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

$(document).on('click', '.detected_or_not', function (e) {
  e.preventDefault();
  var url = $(this).attr('href');
  swal({
    title: "Are you sure?",
    text: "To perform this action",
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

$(document).on('click', '.revoke', function (e) {
  e.preventDefault();
  var url = $(this).attr('href');
  swal({
    title: "Are you sure?",
    text: "To perform this action",
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

$(document).on('click', '.repeat_test_id', function (e) {
  e.preventDefault();
  var url = $(this).attr('href');
  swal({
    title: "Are you sure?",
    text: "To perform this action",
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

$('#datatable').DataTable({
  "order": [
      [0, 'sesc']
  ],
});

$('#datatable2').DataTable({
  "ordering": true,
  "lengthChange": true,
  "searching": true,
  "processing":true,
  "serverSide": true,
  "ajax": {
      url:  '/lab/get_reports',
      type: 'POST',
      "data": function (d) {
          return $.extend({}, d, {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            //"airline": $('#airline').val(),
          });
      } 
  },
  "order": [
      [0, 'asc']
  ],
  columnDefs: [
      {'targets': 0, 'orderable': false},
      // {'targets': 1, 'orderable': false},
      // {'targets': 3, 'orderable': false},
      // {'targets': 4, 'orderable': false},
      // {'targets': 5, 'orderable': false}
  ],
  "columns": [
      {"data": "unique_id"},
      {"data": "patient_name"},
      {"data": "test_name"},
      {"data": "status"},
      {"data": "action"}
  ]
});

function errors(arr = ''){
    $.each(arr, function( key, value ) {
        $('.'+key+'_error').html(value);
    });
    return false;
}

});
