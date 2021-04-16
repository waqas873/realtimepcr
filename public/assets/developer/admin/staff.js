$(document).ready(function(){

$(document).on('click', '#add_lab_user', function (e) {
  //$('#add-lab-user-form').trigger("reset");
  $('#addLabUserModal').modal("show");
});

$(document).on('click', '#add_cp_user', function (e) {
  //$('#add-lab-user-form').trigger("reset");
  $('#addCpUserModal').modal("show");
});

$('#cp_row').hide();
$('#airline_row').hide();
$('#countries_row').hide();
$('#tests_row').hide();
$('#domain_row').hide();

$(document).on('click', '.cp_role', function (e) {
  var obj = $(this);
  $('#cp_row').hide();
  $('#domain_row').hide();
  $('#airline_row').hide();
  $('#countries_row').hide();
  $('#tests_row').hide();
  var cp_role = obj.val();
  if(cp_role==5){
    $('#cp_row').fadeIn();
  }
  if(cp_role==6){
    $('#airline_row').fadeIn();
    $('#domain_row').fadeIn();
  }
  if(cp_role==3){
    $('#countries_row').fadeIn();
    $('#tests_row').fadeIn();
    $('#domain_row').fadeIn();
  }

});

$(document).on('submit', '#add-lab-user-form', function (e) {
  e.preventDefault();
  var obj = $(this);
  $('.all_errors').empty();
  var formData = obj.serializeArray();
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  formData.push({'name':'_token','value':CSRF_TOKEN});
  $.ajax({
      url: '/admin/add-lab-user',
      type: 'POST',
      data: formData,
      dataType: 'JSON',
      success: function (data) {
        if(data.response){
          obj.trigger("reset");
          $('#addLabUserModal').modal('hide');

          swal("Lab employee added successfully.")
          .then((value) => {
            location.reload();
          });

        }
        else{
          if(data.username_exist){
            swal({
              title: "Warning",
              text: "This username has been already taken.Please try another one.",
              icon: "error",
              button: "OK",
            });
          }
          else{
            $('#lab_id_error').html(data.lab_id);
            $('#role_error').html(data.role);
            $('#name_error').html(data.name);
            $('#cnic_error').html(data.cnic);
            $('#contact_no_error').html(data.contact_no);
            $('#username_error').html(data.username);
            $('#password_error').html(data.password);
            $('#pay_error').html(data.pay);
          }
        }
      }
  });
});

$(document).on('submit', '#add-user-form', function (e) {
  e.preventDefault();
  var obj = $(this);
  $('.all_errors').empty();
  var formData = obj.serializeArray();
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  formData.push({'name':'_token','value':CSRF_TOKEN});
  $.ajax({
      url: '/admin/add-cp-user',
      type: 'POST',
      data: formData,
      dataType: 'JSON',
      success: function (data) {
        if(data.response){
          obj.trigger("reset");
          $('#addCpUserModal').modal('hide');

          swal("User has been added successfully.")
          .then((value) => {
            location.reload();
          });

        }
        else{
          if(data.username_exist){
            swal({
              title: "Warning",
              text: "This username has been already taken.Please try another one.",
              icon: "error",
              button: "OK",
            });
          }
          else{
            $('#cp_role_error').html(data.cp_role);
            $('#cp_collection_point_id_error').html(data.cp_collection_point_id);
            $('#cp_name_error').html(data.cp_name);
            $('#cp_contact_no_error').html(data.cp_contact_no);
            $('#cp_username_error').html(data.cp_username);
            $('#cp_password_error').html(data.cp_password);
          }
        }
      }
  });
});

$('#datatable').DataTable({
  
});

$('#datatable2').DataTable({
  
});

$('#datatable3').DataTable({
  
});

$('#datatable4').DataTable({
  
});

var patients_datatable = $('#patients_datatable').DataTable({
  "ordering": true,
  "lengthChange": true,
  //"buttons": ['copy', 'excel', 'pdf', 'colvis'],
  "searching": true,
  "processing":true,
  "serverSide": true,
  "ajax": {
      url: base_url + '/admin/staff-patients',
      type: 'POST',
      "data": function (d) {
          return $.extend({}, d, {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            "collection_point_id": $('#collection_point_id').val(),
            "lab_id": $('#lab_id').val(),
            "user_id": $('#user_id').val(),
            "from_date": $('#from_date').val(),
            "to_date": $('#to_date').val()
          });
      } 
  },
  "order": [
      [0, 'asc']
  ],
  columnDefs: [
    {'targets': 0, 'orderable': false},
    {'targets': 1, 'orderable': false},
    {'targets': 2, 'orderable': false},
    {'targets': 3, 'orderable': false},
    {'targets': 4, 'orderable': false}
  ],
  "columns": [
    {"data": "created_at"},
    {"data": "id"},
    {"data": "name"},
    {"data": "cnic"},
    {"data": "contact_no"},
    {"data": "username"},
    {"data": "invoices"}
  ],
  "dom": 'Blfrtip',
  "buttons": [
      {
          "extend": 'excel',
          "text": '<button class="btn export_to_excel"><i class="fa fa-file-excel-o" style="color: green;"></i> Export to Excel</button>',
          "titleAttr": 'Excel',
          "action": newexportaction
      },
  ],
});
//patients_datatable.buttons().container().appendTo('#patients_datatable_wrapper .col-md-6:eq(0)');


function newexportaction(e, dt, button, config) {
var self = this;
var oldStart = dt.settings()[0]._iDisplayStart;
dt.one('preXhr', function (e, s, data) {
   // Just this once, load all data from the server...
   data.start = 0;
   data.length = 2147483647;
   dt.one('preDraw', function (e, settings) {
       // Call the original action function
       if (button[0].className.indexOf('buttons-copy') >= 0) {
           $.fn.dataTable.ext.buttons.copyHtml5.action.call(self, e, dt, button, config);
       } else if (button[0].className.indexOf('buttons-excel') >= 0) {
           $.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
               $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config) :
               $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
       } else if (button[0].className.indexOf('buttons-csv') >= 0) {
           $.fn.dataTable.ext.buttons.csvHtml5.available(dt, config) ?
               $.fn.dataTable.ext.buttons.csvHtml5.action.call(self, e, dt, button, config) :
               $.fn.dataTable.ext.buttons.csvFlash.action.call(self, e, dt, button, config);
       } else if (button[0].className.indexOf('buttons-pdf') >= 0) {
           $.fn.dataTable.ext.buttons.pdfHtml5.available(dt, config) ?
               $.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, button, config) :
               $.fn.dataTable.ext.buttons.pdfFlash.action.call(self, e, dt, button, config);
       } else if (button[0].className.indexOf('buttons-print') >= 0) {
           $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
       }
       dt.one('preXhr', function (e, s, data) {
           // DataTables thinks the first item displayed is index 0, but we're not drawing that.
           // Set the property to what it was before exporting.
           settings._iDisplayStart = oldStart;
           data.start = oldStart;
       });
       // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
       setTimeout(dt.ajax.reload, 0);
       // Prevent rendering of the full data to the DOM
       return false;
   });
});
// Requery the server with the new one-time export settings
dt.ajax.reload();
}



$(document).on('click', '#by_date', function (e) {
 $('#patients_datatable').DataTable().ajax.reload();  
});
$(document).on('change', '#user_id', function (e) {
 $('#patients_datatable').DataTable().ajax.reload();  
});

$(document).on('click', '.delete_user', function (e) {
  e.preventDefault();
  var url = $(this).attr('href');
  swal({
    title: "Are you sure?",
    text: "If a user is deleted than all its data will be deleted.Are you sure to do this?",
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

});