$(document).ready(function(){

// var contactNum = '03008988873';
// //var xContact = x.toString();
// //Getting Invoice ID Here
// var invoiceID = 811811+'waqas';
// //Pre Encoded URDU Text with API username & Passsword and
// //Highly Confidential.....  
// var smsApiUrl = "https://connect.jazzcmt.com/sendsms_url.html?Username=03081577883&Password=Jazz@123&From=RTPCRLabPsh&To=" + contactNum + "&Message=%D8%A7%D9%84%D8%B3%D9%84%D8%A7%D9%85%20%D9%88%D8%B9%D9%84%DB%8C%DA%A9%D9%85%20%0A.%D8%A2%D9%BE%20%DA%A9%DB%92%20%D9%B9%DB%8C%D8%B3%D9%B9%20%DA%A9%DB%8C%20%D8%B1%D9%BE%D9%88%D8%B1%D9%B9%20%D8%AC%D8%A7%D8%B1%DB%8C%20%DA%A9%D8%B1%20%D8%AF%DB%8C%20%DA%AF%D8%A6%DB%8C%20%DB%81%DB%92%20%0A%0Ahttp%3A%2F%2Fpcr.realtimepcr.pk%2Ftrack%2Fcovid%2F" + invoiceID;

// $.ajax({
//     type: "GET",
//     url: smsApiUrl,
//     crossDomain: true,
//     success: function (data) {
//     },
//     error: function (err) {
//     }
// });


var contact_no_exist = false;

var patient_invoice = false;

var delete_url = '';

$('#passenger_details').hide();

$(document).on('click', '.patient_save_btn', function (e) {
  patient_invoice = false;
  $('#add-form').submit();
});

$(document).on('click', '#invoice_btn', function (e) {
  patient_invoice = true;
  $('#add-form').submit();
});

var wo;

$(document).on('submit', '#add-form', function (e) {
  e.preventDefault();
  var obj = $(this);
  $('.all_errors').empty();

  //window.open("/invoice-detail");

  $('body').LoadingOverlay("show");

  var total_amount = $('#total_amount').val();
  var paid_amount = $('#paid_amount').val();
  if(total_amount!='' && paid_amount==''){
    $('body').LoadingOverlay("hide");
    swal({
      title: "Warning",
      text: "Please add paid amount to proceed.",
      icon: "error",
      button: "OK",
    });
    return false;
  }

  var formData = new FormData(this);
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  formData.append('_token',CSRF_TOKEN);

  // var form_data = obj.serializeArray();
  // formData.append('form_data',form_data);
  formData.append('avatar',image_file);

  $.ajax({
      url: 'patient-add',
      type: 'POST',
      data: formData,
      dataType: 'JSON',
      processData: false,
      contentType: false,
      success: function (data) {
        $('body').LoadingOverlay("hide");
        if(data.response){

          swal({
            title: "Success",
            text: "Patient has been registered successfully.",
            icon: "success",
            button: "OK",
          });

          obj.trigger("reset");
          $('#total_amount').val('');
          $('#discount_amount').val('');
          $('#paid_amount').val('');
          $('#reporting_hrs').val('');
          $('.invoice_box1').html('');
          $('.invoice_box2').html('');
          $('#paid_amount').val('');
          $('#discount').val('');
          $('#amount_paid').val('');
          $('#delivery_time').val('');

          // $("select").each(function () {
          //     $(this).select2('val', '');
          // });

          //$('#reffered_by').select2('val', '');
          //$('#tests').select2('val', '');
          
          //$('#test_profiles').select2('val', '');

          image_file = '';
          
          if(patient_invoice==true){
            if(data.invoice_id!=''){
              wo = window.open("/invoice-detail/"+data.invoice_id , "_blank" , "width=1300, height=800"); 
            }
          }
          
        }
        else{
          if(data.redirect_to){
            swal({
              title: "Already Taken",
              text: "This patient is already taken.Please click on OK button to see its profile.",
              icon: "warning",
              buttons: true,
              dangerMode: true,
            })
            .then((goto) => {
              if (goto) {
                window.location.replace(data.redirect_url); 
              }
            });
          }
          else{
            $('#name_error').html(data.name);
            $('#cnic_error').html(data.cnic);
            $('#contact_no_error').html(data.contact_no);
            $('#email_error').html(data.email);
            $('#passport_no_error').html(data.passport_no);
            $('#airline_error').html(data.airline);
            //$('#collection_point_error').html(data.collection_point);
            $('#country_id_error').html(data.country_id);
            $('#flight_date_error').html(data.flight_date);
            $('#flight_time_error').html(data.flight_time);
            
          }
        }
      },
      complete: function(){
        $('body').LoadingOverlay("hide");
      }
  });
});

var total_amount;

$(document).on('change', '.select_tests , .select_tests_profile', function (e) {
  e.preventDefault();
  
  $('.psngr_err').empty(); 
  $('#passenger_details').hide();


  $('.invoice_box1').html('');
  $('.invoice_box2').html('');
  $('#discount_amount').val('');
  $('#paid_amount').val('');
  $('#discount').val('');
  $('#amount_paid').val('');
  $('#delivery_time').val('');
  $('#total_amount').val('');

  var tests = $('#tests').val();
  var test_profiles = $('#test_profiles').val();
  if(jQuery.isEmptyObject(tests) && jQuery.isEmptyObject(test_profiles)){
     
  }
  else{
    var formData = $('#add-form').serializeArray();
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    formData.push({'name':'_token','value':CSRF_TOKEN});
    $.ajax({
        url: 'get-invoice',
        type: 'POST',
        data: formData,
        dataType: 'JSON',
        success: function (data) {
          if(data.response){
            if(data.covid){
              $('#passenger_details').show();
            }
            total_amount = parseInt(data.total);
            $('#total_amount').val(total_amount);
            $('#reporting_hrs').val(data.reporting_time);
            total = '<h4>Rs: '+data.total+'</h4><h6>Total Amount</h6>';
            $('.invoice_box1').html(total);
            $('#delivery_time').val(data.reporting_time);
          }
        }
    });
    //$('#generateInvoice').modal("show");
  }

});

$(document).on('change', '.reffered_by', function (e) {
  var obj = $(this);
  var id = obj.val();
  $('#tests').empty();
  $.ajax({
    url: '/get-tests/'+id,
    type: 'GET',
    dataType: 'JSON',
    success: function (data) {
      if(data.response){
        $('#tests').html(data.all_tests);
      }
    }
  });
});

$(document).on('keyup', '#discount', function (e) {
  var obj = $(this);
  var discount_amount = parseInt(obj.val());
  $('#discount_amount').val(discount_amount);
  if(discount_amount <= parseInt(total_amount)){
    discounted_amount = parseFloat(total_amount)-parseFloat(discount_amount);
    var total_discount = '<h4>Rs: '+discounted_amount+'</h4><h6>Discounted Amount</h6>';
    $('.invoice_box2').html(total_discount);
  }
  else{
    $('.invoice_box2').html('');
  }
});

$(document).on('keyup', '#amount_paid', function (e) {
  var obj = $(this).val();
  $('#paid_amount').val(obj);
});
$(document).on('keyup', '#delivery_time', function (e) {
  var obj = $(this).val();
  $('#reporting_hrs').val(obj);
});

$(document).on('click', '.detail-addTest-btn', function (e) {
  
  $('#total_amount').val('');
  $('#discount_amount').val('');
  $('#paid_amount').val('');
  $('#reporting_hrs').val('');

  $("select").each(function () {
    $('.select2').select2('val', '');
  });
  $('#detail-addTests').modal("show");
});

$(document).on('click', '#detail-save-tests', function (e) {
  e.preventDefault();

  $('#passenger_details').hide();

  $('.invoice_box1').html('');
  $('.invoice_box2').html('');
  $('#discount_amount').val('');
  $('#paid_amount').val('');
  $('#discount').val('');
  $('#amount_paid').val('');
  $('#pdf').val('');

  var tests = $('#tests').val();
  var test_profiles = $('#test_profiles').val();
  if(jQuery.isEmptyObject(tests) && jQuery.isEmptyObject(test_profiles)){
     
  }
  else{
    var formData = $('#add-test-form').serializeArray();
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    formData.push({'name':'_token','value':CSRF_TOKEN});
    $.ajax({
        url: '/get-invoice',
        type: 'POST',
        data: formData,
        dataType: 'JSON',
        success: function (data) {
          if(data.response){
            if(data.covid==true){
              $('#pdf').val('pdf');
              $('#passenger_details').show();
            }
            total_amount = parseInt(data.total);
            $('#total_amount').val(total_amount);
            $('#reporting_hrs').val(data.reporting_time);
            total = '<h4>Rs: '+data.total+'</h4><h6>Total Amount</h6>';
            $('.invoice_box1').html(total);
            $('#delivery_time').val(data.reporting_time);
          }
        }
    });
    $('#detail-generateInvoice').modal("show");
  }

});

$(document).on('click', '#detail-invoice_btn', function (e) {
  e.preventDefault();
///////////
  var total_amount = $('#total_amount').val();
  var paid_amount = $('#paid_amount').val();
  if(total_amount!='' && paid_amount==''){
    swal({
      title: "Warning",
      text: "Please add paid amount to proceed.",
      icon: "error",
      button: "OK",
    });
    return false;
  }

  var formData = $('#passenger_details_form').serializeArray();
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  formData.push({'name':'_token','value':CSRF_TOKEN});
  $.ajax({
      url: '/check-passenger',
      type: 'POST',
      data: formData,
      dataType: 'JSON',
      success: function (data) {
        if(data.response){
          var formData = $('#add-test-form').serializeArray();
          var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
          formData.push({'name':'_token','value':CSRF_TOKEN});
          
          formData.push({'name':'passport_no','value':$('#passport_no').val()});
          formData.push({'name':'airline','value':$('#airline').val()});
          formData.push({'name':'country_id','value':$('#country_id').val()});
          formData.push({'name':'flight_no','value':$('#flight_no').val()});
          formData.push({'name':'flight_date','value':$('#flight_date').val()});
          formData.push({'name':'flight_time','value':$('#flight_time').val()});
          formData.push({'name':'booking_ref_no','value':$('#booking_ref_no').val()});
          formData.push({'name':'ticket_no','value':$('#ticket_no').val()});

          $.ajax({
              url: '/add-patient-tests',
              type: 'POST',
              data: formData,
              dataType: 'JSON',
              success: function (data) {
                if(data.response){
                  $('#detail-generateInvoice').modal("hide");
                  swal({
                    title: "Success",
                    text: "Test has been added successfully.",
                    icon: "success",
                    button: "OK",
                  });
                }
              }
          });
        }
        else{
          if(data.passenger){
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

$(document).on('click', '.invoice_id', function (e) {
  var invoice_id = $(this).attr('rel');
  $('.all_errors').empty();
  $.ajax({
      url: '/invoice_detail/'+invoice_id,
      type: 'GET',
      dataType: 'JSON',
      success: function (data) {
        if(data.response){
          $('#inv_id').html(data.inv_id);
          $('#inv_date').html(data.date);
          $('#tests_detail').html(data.tests);
          $('#total_details').html(data.total_details);
          $('#patient_name').html(data.patient_name);
          // $('#inv_id').html(data.inv_id);
          $('#invoiceModal').modal('show');
        }
      }
  });
});

$(document).on('click', '.pay_now', function (e) {
  var invoice_id = $(this).attr('rel');
  $.ajax({
      url: '/pay_now/'+invoice_id,
      type: 'GET',
      dataType: 'JSON',
      success: function (data) {
        if(data.response){
          $('#invoice_id').val(data.result.id);
          total = '<h4>Rs: '+data.result.total_amount+'</h4><h6>Total Amount</h6>';
          $('.pay_invoice_box1').html(total);
          var balance = '<h4>Rs: '+data.result.amount_remaining+'</h4><h6>Balance</h6>';
          $('.pay_invoice_box2').html(balance);
          $('#payInvoiceModal').modal('show');
        }
      }
  });
});

$(document).on('click', '#collect_amount_btn', function (e) {
  e.preventDefault();

  var balance = $('#amount_pay').val();
  if($("#balance_discount").prop('checked') != true && balance < 1){
    swal({
      title: "Warning",
      text: "Please add paid amount to proceed.",
      icon: "error",
      button: "OK",
    });
    return false;
  }

  var formData = $('#pay_invoice_form').serializeArray();
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  formData.push({'name':'_token','value':CSRF_TOKEN});
  $.ajax({
      url: '/process_pay_now',
      type: 'POST',
      data: formData,
      dataType: 'JSON',
      success: function (data) {
        if(data.response){
          $('#pay_invoice_form').trigger("reset");
          $('#payInvoiceModal').modal("hide");
          swal({
            title: "Success",
            text: "Invoice has been updated successfully.",
            icon: "success",
            button: "OK",
          });
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

$(document).on('submit', '#reason-form', function (e) {
  e.preventDefault();
  var obj = $(this);
  $('.all_errors').empty();

  var formData = obj.serializeArray();
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  formData.push({'name':'_token','value':CSRF_TOKEN});
  $.ajax({
      url: '/process-patient-reason',
      type: 'POST',
      data: formData,
      dataType: 'JSON',
      success: function (data) {
        if(data.response){
          $('#reasonModel').modal("hide");
          location.replace(delete_url);
        }
        else{
          $('#reason_error').html(data.reason);
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
        url: '/delete-reason',
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

$(document).on('click', '#by_date', function (e) {
  var from_date = $('#from_date').val();
  var to_date = $('#to_date').val();
  if(from_date=='' || to_date==''){
    return false;
  }
  window.location.replace('/patients/'+from_date+'/'+to_date);
});

$('#datatable').DataTable({
  "order": [
      [0, 'sesc']
  ],
});

$(document).on('click', '#print_cntnt', function (e) {
    var mywindow = window.open('', 'PRINT', 'height=1350,width=700');

    mywindow.document.write('<html><head><title></title>');
    mywindow.document.write('<link rel="stylesheet" href="http://pcr.realtimepcr.pk/assets/css/bootstrap.min.css">');
    mywindow.document.write('<link rel="stylesheet" href="http://pcr.realtimepcr.pk/assets/css/developer.css">');
    mywindow.document.write('</head><body >');
    mywindow.document.write(document.getElementById("print_section").innerHTML);
    mywindow.document.write('</body></html>');

    mywindow.document.close(); // necessary for IE >= 10
    //mywindow.focus(); // necessary for IE >= 10*/

    mywindow.print();
    //mywindow.close();

    return true;
});

});