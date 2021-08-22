$(document).ready(function(){

$(document).on('click', '.submit_reports', function (e) {
  e.preventDefault();
  var type = $(this).attr('rel');
  $('.allForms').trigger("reset");
  $('.all_errors').empty();
  if(type!=''){
    var patient_test_id = $(this).attr('href');
    $('.patient_test_ids').val('');
    $('.patient_test_id').val(patient_test_id);
    $('#addModal'+type).modal("show");
  }
  return false;
});

$(document).on('click', '.multiple_reports', function (e) {
  e.preventDefault();
  $('.allForms').trigger("reset");
  var type = $('#test_type').val();
  if(type==''){
    swal({
      title: "Warning",
      text: "Please select a test type!",
      icon: "warning",
      button: "Ok",
    });
    return false;
  }
  var patient_test_ids = $("input:checked").map(function(){
      return $(this).val();
  }).get();
  if(patient_test_ids==''){
    swal({
      title: "Warning",
      text: "Please select a test to process!",
      icon: "warning",
      button: "Ok",
    });
    return false;
  }
  $('.patient_test_ids').val(patient_test_ids);
  $('#addModal'+type).modal("show");
  console.log(patient_test_ids);
  return false;
});

$(document).on('submit', '#addForm1,#addForm2,#addForm3,#addForm4,#addForm5,#addForm6', function (e) {
  e.preventDefault();
  $.LoadingOverlay("show");
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
      },
      complete: function () {
        $.LoadingOverlay("hide");
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

$(document).on('submit', '#manualReportForm', function (e) {
  e.preventDefault();
  var obj = $(this);
  $('.all_errors').empty();
  var formData = obj.serializeArray();
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  formData.push({'name':'_token','value':CSRF_TOKEN});
  $.ajax({
      url: '/lab/process-manual',
      type: 'POST',
      data: formData,
      dataType: 'JSON',
      success: function (data) {
        if(data.response){
          obj.trigger("reset");
          swal("Data saved successfully.")
          .then((value) => {
            window.location.replace(base_url+'/lab/open-cases');
          });
        }
        else{
          errors(data.errors);
        }
      }
  });
});

// $('#datatable').DataTable({
//   "order": [
//       [0, 'sesc']
//   ],
// });

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

$(document).on('click', '.allBoxes', function (e) {
    if($('.allBoxes').is(':checked')){
      $('.eachBox').prop('checked', true);
    }
    else{
      $('.eachBox').prop('checked', false);
    }
});

$('#datatable3').DataTable({
  "ordering": true,
  "lengthChange": true,
  "searching": true,
  "processing":true,
  "serverSide": true,
  "ajax": {
      url: '/lab/get-open-cases',
      type: 'POST',
      "data": function (d) {
          return $.extend({}, d, {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            "test_type": $('#test_type').val(),
            "airline": $('#airline').val(),
            "test_id": $('#test_id').val(),
            "start_date": $('#start_date').val(),
            "end_date": $('#end_date').val(),
            "user_id": $('#user_id').val(),
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
      {"data": "check"},
      {"data": "unique_id"},
      {"data": "name"},
      {"data": "test"},
      {"data": "created_at"},
      {"data": "kits"},
      {"data": "action"}
  ]
});

$(document).on('change', '#test_type', function (e) {
 $('#datatable3').DataTable().ajax.reload();  
});
$(document).on('change', '#airline', function (e) {
 $('#datatable3').DataTable().ajax.reload();  
});
$(document).on('change', '#test_id', function (e) {
 $('#datatable3').DataTable().ajax.reload();  
});
$(document).on('change', '#start_date', function (e) {
 $('#datatable3').DataTable().ajax.reload();  
});
$(document).on('change', '#end_date', function (e) {
 $('#datatable3').DataTable().ajax.reload();  
});
$(document).on('change', '#user_id', function (e) {
  $('#datatable3').DataTable().ajax.reload();  
});

function errors(arr = ''){
    $.each(arr, function( key, value ) {
        $('.'+key+'_error').html(value);
    });
    return false;
}

});
