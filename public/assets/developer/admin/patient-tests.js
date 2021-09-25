$(document).ready(function(){

var contact_no_exist = false;
var delete_url = '';

$(document).on('click', '.update_btn', function (e) {
  $('#update-form').submit();
});

$(document).on('submit', '#update-form', function (e) {
  e.preventDefault();
  var obj = $(this);
  $('.all_errors').empty();

  var formData = new FormData(this);
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  formData.append('_token',CSRF_TOKEN);
  formData.append('avatar',image_file);
  
  $.ajax({
      url: '/admin/process-patient-update',
      type: 'POST',
      data: formData,
      dataType: 'JSON',
      processData: false,
      contentType: false,
      success: function (data) {
        if(data.response){

          swal({
            title: "Success",
            text: "Patient has been registered successfully.",
            icon: "success",
            button: "OK",
          });

          image_file = '';
          
        }
        else{
          if(data.reason){
            $('#reasonModel').modal("show");
          }
          else{
            $('#name_error').html(data.name);
            $('#cnic_error').html(data.cnic);
            $('#contact_no_error').html(data.contact_no);
            $('#email_error').html(data.email);
            $('#passport_no_error').html(data.passport_no);
            $('#airline_error').html(data.airline);
            $('#country_id_error').html(data.country_id);
            $('#flight_date_error').html(data.flight_date);
            $('#flight_time_error').html(data.flight_time);
          }
        }
      }
  });
});

$(document).on('submit', '#reason-form', function (e) {
  e.preventDefault();
  var obj = $(this);
  $('.all_errors').empty();

  var formData = obj.serializeArray();
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  formData.push({'name':'_token','value':CSRF_TOKEN});
  $.ajax({
      url: '/admin/process-patient-reason',
      type: 'POST',
      data: formData,
      dataType: 'JSON',
      success: function (data) {
        if(data.response){
          $('#reasonModel').modal("hide");
          if(delete_url==''){
            $('#update-form').submit();
          }
          else{
            location.replace(delete_url);
          }
        }
        else{
          $('#reason_error').html(data.reason);
        }
      }
  });
});

$(document).on('keyup', '#contact_no', function (e) {
  var contact_no = $(this).val();
  $('#contact_no_error').empty();
  $.ajax({
      url: '/contact_no_exist/'+contact_no,
      type: 'GET',
      dataType: 'JSON',
      success: function (data) {
        if(data.response){
          $('#contact_no_error').html("This contact no is already registered.");
          contact_no_exist = true;
        }
        else{
          contact_no_exist = false;
        }
      }
  });
});

$(document).on('change', '.invoice_id', function (e) {
  var invoice_id = $(this).val();
  if(invoice_id==''){
    return false;
  }
  $('.times').empty();
  $.ajax({
      url: '/admin/reporting_time/'+invoice_id,
      type: 'GET',
      dataType: 'JSON',
      success: function (data) {
        if(data.response){
          $('#created_at').val(data.created_at);
          $('#reporting_time').val(data.updated_at);
        }
      }
  });
});

$(document).on('click', '.delete_patient', function (e) {
  e.preventDefault();
  var d_url = $(this).attr('href');
  delete_url = d_url;
  swal({
    title: "Are you sure?",
    text: "If a patient is deleted than all its data will be deleted.Are you sure to do this?",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {
    if(willDelete){
      $.ajax({
        url: '/admin/delete-reason',
        type: 'GET',
        dataType: 'JSON',
        success: function (data) {
          if(data.reason){
            $('#reasonModel').modal("show");
          }
          else{
            location.replace(d_url);
          }
        }
      });
    }
  });
});

$(document).on('click', '.delete_patient_parmanently', function (e) {
  e.preventDefault();
  var d_url = $(this).attr('href');
  swal({
    title: "Are you sure?",
    text: "If a patient is deleted than all its data will be deleted.Are you sure to do this?",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {
    if(willDelete){
      location.replace(d_url);
    }
  });
});

$('#datatable').DataTable({
  "ordering": true,
  "lengthChange": true,
  "searching": true,
  "processing":true,
  "serverSide": true,
  "ajax": {
      url: '/admin/get-patient-tests',
      type: 'POST',
      "data": function (d) {
          return $.extend({}, d, {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            "from_date": $('#from_date').val(),
            "to_date": $('#to_date').val(),
            "lab_id": $('#lab_id').val(),
            "collection_point_id": $('#collection_point_id').val(),
            "test_id": $('#test_id').val(),
            "doctor_id": $('#doctor_id').val(),
            "user_id": $('#user_id').val(),
            "payment_filter": $('#payment_filter').val(),
            "lab_user": $('#lab_user').val(),
            "local_overseas": $('#local_overseas').val(),
            "airline": $('#airline').val(),
            "country_id": $('#country_id').val(),
            "test_result": $('#test_result').val(),
          });
      } 
  },
  "order": [
      [0, 'asc']
  ],
  columnDefs: [
      {'targets': 0, 'orderable': false},
      {'targets': 1, 'orderable': false},
      {'targets': 3, 'orderable': false},
      {'targets': 4, 'orderable': false},
      {'targets': 5, 'orderable': false}
  ],
  "columns": [
      {"data": "id"},
      {"data": "name"},
      {"data": "reffered_by"},
      {"data": "tests"},
      {"data": "invoice_id"},
      {"data": "amount_paid"},
      {"data": "amount_remaining"},
      {"data": "added_by"},
      {"data": "action"},
  ]
});

$(document).on('click', '#by_date', function (e) {
  $('#datatable').DataTable().ajax.reload();  
});

$(document).on('change', '#lab_id', function (e) {
  //$('#collection_point_id').val('').change();
  $('#datatable').DataTable().ajax.reload();  
});
$(document).on('change', '#collection_point_id', function (e) {
  $('#lab_id').val('').change();
  $('#datatable').DataTable().ajax.reload();  
});

$(document).on('change', '#test_id', function (e) {
  $('#datatable').DataTable().ajax.reload();  
});
$(document).on('change', '#doctor_id', function (e) {
  $('#datatable').DataTable().ajax.reload();  
});
$(document).on('change', '#user_id', function (e) {
  $('#datatable').DataTable().ajax.reload();  
});
$(document).on('change', '#payment_filter', function (e) {
  $('#datatable').DataTable().ajax.reload();  
});
$(document).on('change', '#lab_user', function (e) {
  $('#datatable').DataTable().ajax.reload();  
});
$(document).on('change', '#local_overseas', function (e) {
  $('#datatable').DataTable().ajax.reload();  
});
$(document).on('change', '#airline', function (e) {
  $('#datatable').DataTable().ajax.reload();  
});
$(document).on('change', '#country_id', function (e) {
  $('#datatable').DataTable().ajax.reload();  
});
$(document).on('change', '#test_result', function (e) {
  $('#datatable').DataTable().ajax.reload();  
});


$('#deleted_patients').DataTable({
  "ordering": true,
  "lengthChange": true,
  "searching": true,
  "processing":true,
  "serverSide": true,
  "ajax": {
      url: '/admin/get-deleted-patients',
      type: 'POST',
      "data": function (d) {
          return $.extend({}, d, {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            //"from_date": $('#from_date').val(),
            //"to_date": $('#to_date').val(),
          });
      } 
  },
  "order": [
      [0, 'asc']
  ],
  columnDefs: [
      {'targets': 0, 'orderable': false},
      {'targets': 1, 'orderable': false},
  ],
  "columns": [
      {"data": "name"},
      {"data": "created_at"},
      {"data": "reason"},
      {"data": "deleted_by"},
      {"data": "action"},
  ]
});

});