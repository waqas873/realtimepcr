$(document).ready(function(){

var total_test;
var available_kits;
var modal_type;

$('#srSr').hide();
$('#srSr_multi').hide();

$(document).on('click', '.assign_kit', function (e) {
  e.preventDefault();
  $.LoadingOverlay("show");
  $('#kitsBody').empty();
  $('#srSr').hide();
  $('#srSr_multi').hide();
  $('#sr_type').val(1);
  var test_id = $(this).attr('rel');
  var id = $(this).attr('id');
  var rut = $(this).attr('rut');
  total_test = 1;
  $.ajax({
      url: '/lab/get-kits/'+test_id,
      type: 'GET',
      dataType: 'JSON',
      success: function (data) {
        if(data.response){
          //$(this).hide();
          //$('#submit_report_'+id).fadeIn();
          $('#srSr').attr('href', id);
          $('#srSr').attr('rel', rut);
          //$('#srSr').fadeIn();
          $('#kitsBody').html(data.kits);
          $('#kitViewModal').modal('show');
        }
        else{
          swal({
            title: "Warning",
            text: "Kits are not available",
            icon: "warning",
            button: "Ok",
          });
        }
      },
      complete: function () {
        $.LoadingOverlay("hide");
      }
  });
  return false;
});

$(document).on('click', '.ph_id', function (e) {
  var ph_id = $(this).val();
  var obj = $(this);
  $('#srSr').hide();
  $('#srSr_multi').hide();
  if($(this).is(':checked')){
    $.LoadingOverlay("show");
    $('.all_checkboxes').prop('checked', false);
    var sr_type = $('#sr_type').val();
    $.ajax({
        url: '/lab/set-ph-id/'+ph_id,
        type: 'GET',
        dataType: 'JSON',
        success: function (data) {
          if(data.response){
            available_kits = data.available_kits;
            // alert('total test '+total_test);
            // alert('available kits '+available_kits);
            if(available_kits >= total_test){
              obj.prop('checked', true);
              if(sr_type==1){
                $('#srSr').fadeIn();
              }
              else{
                $('#srSr_multi').fadeIn();
              }
            }
            else{
              swal({
                title: "Warning",
                text: "The tests you have selected are greater than the available kits.Please decrease the number of tests or select other kits.",
                icon: "warning",
                button: "Ok",
              });
            }
          }
        },
        complete: function () {
          $.LoadingOverlay("hide");
        }
    });
  }
});

$(document).on('click', '.submit_reports', function (e) {
  e.preventDefault();
  var type = $(this).attr('rel');
  $('.allForms').trigger("reset");
  $('.all_errors').empty();
  if(type!=''){
    $('#kitViewModal').modal('hide');
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
  $('#srSr').hide();
  $('#srSr_multi').hide();
  var type = $('#test_type').val();
  var test_id = $('#test_id').val();
  if(type==''){
    swal({
      title: "Warning",
      text: "Please select a test type!",
      icon: "warning",
      button: "Ok",
    });
    return false;
  }
  if(test_id==''){
    swal({
      title: "Warning",
      text: "Please select a test from filter by test dropdown",
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
      text: "Please select a patient test to process!",
      icon: "warning",
      button: "Ok",
    });
    return false;
  }
  $('#sr_type').val(2);
  $('.patient_test_ids').val(patient_test_ids);
  
  $.LoadingOverlay("show");
  $.ajax({
      url: '/lab/get-kits/'+test_id,
      type: 'GET',
      dataType: 'JSON',
      success: function (data) {
        if(data.response){
          //$('#srSr_multi').fadeIn();
          $('#kitsBody').html(data.kits);
          $('#kitViewModal').modal('show');
        }
        else{
          swal({
            title: "Warning",
            text: "Kits are not available",
            icon: "warning",
            button: "Ok",
          });
        }
      },
      complete: function () {
        $.LoadingOverlay("hide");
      }
  });
  
  var tests = 0;
  patient_test_ids.forEach(function(item){
    tests++;
  });
  total_test = tests;
  modal_type = type;
  //$('#addModal'+type).modal("show");
  console.log(patient_test_ids);
  return false;
});

$(document).on('click', '#srSr_multi', function (e) {
  e.preventDefault();
  $('#kitViewModal').modal('hide');
  $('#addModal'+modal_type).modal("show");
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
