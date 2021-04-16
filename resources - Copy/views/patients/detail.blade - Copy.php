@extends('layouts.pcr')
@section('content')

@if(session('success_message'))
    <script type="text/javascript">
        swal({
          title: "Success",
          text: "{{session('success_message')}}",
          icon: "success",
          button: "OK",
        });
    </script>
@endif

<style type="text/css">
    .invoice-inputs{
        margin-top: 0px !important;
        margin-bottom: 0px !important;
    }
</style>

<link rel="stylesheet" href="{{asset('assets/webcam/assets/css/layout.css')}}">
<link rel="stylesheet" href="{{asset('assets/webcam/cropper/cropper.css')}}">

<script src="{{asset('assets/webcam/assets/js/dropzone.js')}}"></script>
<script src="{{asset('assets/webcam/webcamjs/webcam.min.js')}}"></script>
<script src="{{asset('assets/webcam/cropper/cropper.js')}}"></script>

<div class="container-fluid">

<div class="row patient-detail">
<div class="col-sm-9">
    <h1><?php echo (!empty($patient))?ucwords($patient->name):''; ?></h1>
    <div class="row">
        <div class="col-sm-2">
            <p>CNIC</p>
        </div>
        <div class="col-sm-6"><p><?php echo (!empty($patient))?$patient->cnic:''; ?></p></div>
    </div>
    <div class="row">
        <div class="col-sm-2">
            <p>CONTACT</p>
        </div>
        <div class="col-sm-6"><p><?php echo (!empty($patient))?$patient->contact_no:''; ?></p></div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <a href="javascript::" class="btn btn-info detail-addTest-btn"><i class="fa fa-plus-square" aria-hidden="true"></i>
            Add Test</a>
            <!--
            &nbsp;
            <a href="{{url('/patient-delete/'.$patient->id)}}" class="btn btn-danger delete_patient"><i class="fa fa-minus-square" aria-hidden="true"></i>
            Delete Patient</a>&nbsp; -->
            
            
            <!-- <a href="javascript::" class="btn btn-info"><i class="fa fa-plus-square" aria-hidden="true"></i>
            Generate Invoice</a> -->
        </div>
    </div>

</div>
<div class="col-sm-3">
    <div class="card bg-primary mini-stat text-white">
        <div class="p-3 mini-stat-desc">
            <div class="clearfix">
                <h6 class="text-uppercase mt-0 float-left text-white-50">Patient</h6>
                <h4 class="mb-3 mt-0 float-right">Rs: <?php echo (!empty($amount_paid))?$amount_paid:'0'; ?></h4>
            </div>
            <div>
                <span class="ml-2">Amount Paid</span>
            </div>
        </div>
    </div>
    <div class="card bg-primary mini-stat text-white">
        <div class="p-3 mini-stat-desc">
            <div class="clearfix">
                <h6 class="text-uppercase mt-0 float-left text-white-50">Patient</h6>
                <h4 class="mb-3 mt-0 float-right">Rs: <?php echo (!empty($amount_remaining))?$amount_remaining:'0'; ?></h4>
            </div>
            <div>
                <span class="ml-2">Pending Balance</span>
            </div>
        </div>
    </div>
</div>
</div> 

<div class="row">
<div class="col-xl-12">
<div class="card">
<div class="card-body">
    <h4 class="mt-0 header-title mb-4">Open Cases</h4>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Invoice ID</th>
                    <th scope="col">Test</th>
                    <th scope="col">Amount Paid</th>
                    <th scope="col">Balance</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                @if(!empty($open_cases))
                <?php $counter = count($open_cases) ; ?>
                @foreach($open_cases as $key => $value)
                <tr>
                    <th scope="row">#{{$value->id}}</th>
                    <td>
                        <?php 
                            if(!empty($value->patient_tests[0]->test->name)){
                                $tooltip = '';
                                $cc = count($value->patient_tests);
                                foreach($value->patient_tests as $key2 => $test){
                                    $i = $key2+1;
                                    $tooltip .= $test->test->name;
                                    ($i<$cc)?$tooltip .= ' , ':'';
                                }
                                echo '<a href="javascript::" data-toggle="tooltip" title="'.$tooltip.'">'.$value->patient_tests[0]->test->name.'</a>';
                            }
                        ?>
                    </td>
                    <td>Rs: {{$value->amount_paid}}</td>
                    <td>Rs: {{$value->amount_remaining}}</td>
                    <td>
                        <?php
                          $status = '';
                          if($value->status=='0'){
                            $status = 'Pending';
                          }
                          if($value->status==1){
                            $status = 'Awaiting Results';
                          }
                          if($value->status==2 && $value->amount_remaining > 0){
                            $status = '<a class="btn btn-danger pay_now" rel="'.$value->id.'">Pay Now</a>';
                          }
                          if($value->status==3 && $value->amount_remaining < 1){
                            $status = '<a class="btn btn-success invoice_id" rel="'.$value->id.'">Print Report</a>';
                          }
                          echo $status;
                        ?>
                    </td>
                </tr>
                <?php $counter--; ?>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>

</div>
</div>
</div>
</div>
<!-- end row -->

<div class="row">
<div class="col-xl-12">
<div class="card">
<div class="card-body">
    <h4 class="mt-0 header-title mb-4">Delivered Reports</h4>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Invoice ID</th>
                    <th scope="col">Test</th>
                    <th scope="col">Amount Paid</th>
                    <th scope="col">Balance</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                @if(!empty($delivered_reports))
                <?php $counter = count($delivered_reports) ; ?>
                @foreach($delivered_reports as $key => $value)
                <tr>
                    <th scope="row">#{{$value->id}}</th>
                    <td>
                        <?php 
                            if(!empty($value->patient_tests)){
                                $tooltip = '';
                                $cc = count($value->patient_tests);
                                foreach($value->patient_tests as $key2 => $test){
                                    $i = $key2+1;
                                    $tooltip .= $test->test->name;
                                    ($i<$cc)?$tooltip .= ' , ':'';
                                }
                                echo '<a href="javascript::" data-toggle="tooltip" title="'.$tooltip.'">'.$value->patient_tests[0]->test->name.'</a>';
                            }
                        ?>
                    </td>
                    <td>Rs: {{$value->amount_paid}}</td>
                    <td>Rs: {{$value->amount_remaining}}</td>
                    <td>Delivered</td>
                </tr>
                <?php $counter--; ?>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>

</div>
</div>
</div>
</div>
<!-- end row -->

<div class="row">
<div class="col-xl-12">
<div class="card">
<div class="card-body">
    <h4 class="mt-0 header-title mb-4">Invoices</h4>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Invoice ID</th>
                    <th scope="col">Date Generated</th>
                    <th scope="col">Test Name</th>
                    <th scope="col">Total Amount</th>
                    <th scope="col">Paid</th>
                    <th scope="col">Balance</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @if(!empty($invoices))
                <?php $counter = count($invoices) ; ?>
                @foreach($invoices as $key => $value)
                <tr>
                    <th scope="row">#{{$value->id}}</th>
                    <td>
                        <?php 
                            $date = explode(' ', $value->created_at);
                            echo $date[0];
                        ?>
                    </td>
                    <td>
                        <?php 
                            if(!empty($value->patient_tests)){
                                $tooltip = '';
                                $cc = count($value->patient_tests);
                                foreach($value->patient_tests as $key2 => $test){
                                    $i = $key2+1;
                                    $tooltip .= $test->test->name;
                                    ($i<$cc)?$tooltip .= ' , ':'';
                                }
                                echo '<a href="javascript::" data-toggle="tooltip" title="'.$tooltip.'">'.$value->patient_tests[0]->test->name.'</a>';
                            }
                        ?>
                    </td>
                    <td>Rs: {{$value->total_amount}}</td>
                    <td>Rs: {{$value->amount_paid}}</td>
                    <td>Rs: {{$value->amount_remaining}}</td>
                    <!-- <td><a href="javascript::" rel="{{$value->id}}" class="invoice_id">View</a></td> -->
                    <td><a href="{{url('/invoice-detail/'.$value->unique_id)}}" target="_blank">View</a></td>
                </tr>
                <?php $counter--; ?>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>

</div>
</div>
</div>
</div>
<!-- end row -->

</div><!-- container fluid -->

<!-- Modal -->
<div class="modal fade" id="detail-addTests" tabindex="-1" role="dialog" aria-labelledby="detail-addTestsLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detail-addTestsLabel">Add Tests</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

    <form action="" method="post" id="add-test-form">
    @csrf

    <input type="hidden" id="patient_id" name="patient_id" value="<?php echo (!empty($patient))?$patient->id:''; ?>">

    <input type="hidden" name="total_amount" id="total_amount">
    <input type="hidden" name="discount_amount" id="discount_amount">
    <input type="hidden" name="paid_amount" id="paid_amount">
    <input type="hidden" name="reporting_hrs" id="reporting_hrs">

      <div class="modal-body" style="height: 260px;">
          <p>Select Tests</p>
          <select class="form-control inputs_with_bottom_border select2" id="tests" name="tests[]" multiple="">
            @if(!empty($tests))
            @foreach($tests as $record)
            <option value="{{$record->id}}">{{$record->name}} &nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size: 11px !important;"> (Rs: {{$record->price}})</span></option>
            @endforeach
            @endif
          </select>

          <p style="margin-top: 17px;">Select Test Profile</p>
          <select class="form-control inputs_with_bottom_border select2" id="test_profiles" name="test_profiles[]" multiple="">
            @if(!empty($test_profiles))
            @foreach($test_profiles as $record)
            <option value="{{$record->id}}">{{$record->name}} &nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size: 11px !important;"> (Rs: {{$record->price}})</span></option>
            @endforeach
            @endif
          </select>

          <div class="form-group row" style="margin-top: 25px;">
            <label for="image" class="col-sm-2 col-form-label pformlabel">Image</label>
            <div class="col-sm-8">
              <label class="btn upload"> <i class="fa fa-upload"></i> &nbsp; Upload<input type="file" class="sr-only" id="input" name="image" accept="image/*"></label>
              <button type="button" class="btn camera" data-backdrop="static" data-toggle="modal" data-target="#cameraModal"><i class="fa fa-camera"></i> &nbsp;  Capture Image</button>
            </div>
          </div>


      </div>
      </form>

      <div class="modal-footer">
        <button type="button" class="btn btn-primary detail-save-tests" data-dismiss="modal" id="detail-save-tests">Save & Continue</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="invoiceModal" tabindex="-1" role="dialog" aria-labelledby="invoiceModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content invoice-content">
      <div class="modal-header">
        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button> -->
        <button type="button" class="btn btn-primary" id="print_cntnt">
          Print
        </button>
      </div>
      <div class="modal-body" id="print_section">
        <div class="row invr1">
            <div class="col-sm-4 invr11">
                <img src="{{asset('assets/images/pcr-logo.png')}}" height="170" alt="logo">
            </div>
            <div class="col-sm-4 invr12">
                <h1>INVOICE</h1>
                <h3>ID &nbsp;&nbsp;&nbsp;&nbsp;<span id="inv_id">#32132434</span></h3>
                <h3>DATE &nbsp;&nbsp;&nbsp;&nbsp;<span id="inv_date">2020-07-23</span></h3>
            </div>
            <div class="col-sm-4 invr13">
                <div class="invoice_code">
                    
                </div>
                <h6>https://www.realtimepcr.pk/track</h6>
            </div>
        </div>
        <div class="invr2">

            <div class="row">
                <div class="col-sm-3 invr21">
                    <h6>Patient Name</h6>
                </div>
                <div class="col-sm-9 invr22">
                    <div class="invr-pname" id="patient_name">
                        
                    </div>
                </div>
            </div>

            <div class="row" style="margin-top: 30px;">
                <div class="col-sm-12">
                    <table class="table table-hover">
                        <thead style="background: #DADADA;">
                            <tr>
                                <th scope="col">Case ID</th>
                                <th scope="col">Test Name</th>
                                <th scope="col" style="text-align: right;">Amount</th>
                            </tr>
                        </thead>
                        <tbody id="tests_detail">

                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-sm-4 offset-sm-8" id="total_details">

                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row invr3">
            <div class="col-sm-12">
                <ul>
                    <li>
                     <a href=""><i class="fa fa-facebook-official" aria-hidden="true"></i>realtimepcr.pk</a>
                    </li>
                    <li>
                        <a href="">
                        <i class="fa fa-location-arrow" aria-hidden="true"></i>
                        realtimepcr.pk@gmail.com</a></li>
                    <li>
                        <a href="">
                            <i class="fa fa-globe" aria-hidden="true"></i>
                        https://www.realtimepcr.pk</a></li>
                </ul>
            </div>
        </div>
      </div>
      <div class="row invr-footer">
            <div class="col-sm-9">
                <p>Address: Realtime PCR Lab , Auqaf Plaza Peshawar Saddar</p>
            </div>
            <div class="col-sm-3">
                <div class="inv_no">
                    +923003004001
                </div>
            </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="payInvoiceModal" tabindex="-1" role="dialog" aria-labelledby="payInvoiceLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="payInvoiceLabel">Collect Amount</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="" method="post" id="pay_invoice_form">
      @csrf

      <input type="hidden" name="invoice_id" id="invoice_id">

      <div class="modal-body">
        <div class="row">
          <div class="col-sm-10 offset-sm-1">
            <div class="row">
              <div class="col-sm-6">
                <div class="pay_invoice_box1">
                  
                </div>
              </div>
              <div class="col-sm-6">
                <div class="pay_invoice_box2">

                </div>
              </div>
            </div>
            <div class="form-group row invoice-inputs">
              <label for="amount_pay" class="col-sm-3 col-form-label pformlabel">Collect Amount</label>
              <div class="col-sm-9">
                <input type="number" class="form-control inputs_with_bottom_border" name="amount_pay" id="amount_pay">
              </div>
            </div>
            <div class="form-group row invoice-inputs">
                <div class="col-sm-12" style="padding-left: 28px !important;">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="balance_discount" name="discount">
                  <label class="form-check-label" for="balance_discount">
                    Convert pending balance to discount
                  </label>
                </div>
                </div>
            </div>

          </div>
          </div>
        </div>
        </form>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary collect_amount" id="collect_amount_btn">Collect Amount</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="detail-generateInvoice" tabindex="-1" role="dialog" aria-labelledby="detail-generateInvoiceLabel" aria-hidden="true">
  <div class="modal-dialog" style="margin-top: 0px!important;" role="document">
    <div class="modal-content">
      <div class="modal-header" style="padding-top: 0px !important;padding-bottom: 3px !important;">
        <h5 class="modal-title" id="detail-generateInvoiceLabel">Generate Invoice</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="height: 267px;">
        <div class="row">
          <div class="col-sm-10 offset-sm-1">
            <div class="row">
              <div class="col-sm-6">
                <div class="invoice_box1">
                  
                </div>
              </div>
              <div class="col-sm-6">
                <div class="invoice_box2">

                </div>
              </div>
            </div>
            <div class="form-group row invoice-inputs">
              <label for="discount" class="col-sm-3 col-form-label pformlabel">Discount</label>
              <div class="col-sm-9">
                <input type="number" class="form-control inputs_with_bottom_border" id="discount">
              </div>
            </div>
            <div class="form-group row invoice-inputs">
              <label for="amount_paid" class="col-sm-3 col-form-label pformlabel">Amount Paid</label>
              <div class="col-sm-9">
                <input type="number" class="form-control inputs_with_bottom_border" id="amount_paid">
              </div>
            </div>
            <div class="form-group row invoice-inputs">
              <label for="delivery_time" class="col-sm-3 col-form-label pformlabel">Delivery time (days)</label>
              <div class="col-sm-9">
                <input type="number" class="form-control inputs_with_bottom_border" id="delivery_time">
              </div>
            </div>
            
            <form id="passenger_details_form">
            @csrf

            <div id="passenger_details">

                <input type="hidden" id="pdf" name="pdf" value="">

                <div class="form-group row invoice-inputs">
                  <label for="passport_no" class="col-sm-3 col-form-label pformlabel">Passport#</label>
                  <div class="col-sm-9">
                    <input type="text" name="passport_no" class="form-control inputs_with_bottom_border" id="passport_no">
                    <div class="all_errors psngr_err" id="passport_no_error"></div>
                  </div>
                </div>
                <div class="form-group row invoice-inputs">
                  <label for="airline" class="col-sm-3 col-form-label pformlabel">Airline</label>
                  <div class="col-sm-9">
                    <select class="form-control inputs_with_bottom_border select2" id="airline" name="airline">
                      <option value="">Select Airline</option>
                      <?php
                        foreach($airlines as $key => $value){
                      ?>
                      <option value="{{$value->name}}">{{$value->name}}</option>
                      <?php } ?>
                    </select>
                    <div class="all_errors psngr_err" id="airline_error"></div>
                  </div>
                </div>
                <div class="form-group row invoice-inputs">
                  <label for="country_id" class="col-sm-3 col-form-label pformlabel">Travelling To</label>
                  <div class="col-sm-9">
                    <select class="form-control inputs_with_bottom_border select2" id="country_id" name="country_id">
                      <option value="">Select Country</option>
                      <?php
                        foreach($countries as $key => $value){
                      ?>
                      <option value="{{$value->id}}">{{$value->name}}</option>
                      <?php } ?>
                    </select>
                    <div class="all_errors psngr_err" id="country_id_error"></div>
                  </div>
                </div>
                <div class="form-group row invoice-inputs">
                  <label for="flight_date" class="col-sm-3 col-form-label pformlabel">Flight Date</label>
                  <div class="col-sm-9">
                    <input type="date" name="flight_date" class="form-control inputs_with_bottom_border" id="flight_date">
                    <div class="all_errors psngr_err" id="flight_date_error"></div>
                  </div>
                </div>
                <div class="form-group row invoice-inputs">
                  <label for="flight_time" class="col-sm-3 col-form-label pformlabel">Flight Time</label>
                  <div class="col-sm-9">
                    <input type="text" name="flight_time" class="form-control inputs_with_bottom_border" id="flight_time">
                    <div class="all_errors psngr_err" id="flight_time_error"></div>
                  </div>
                </div>
                <div class="form-group row invoice-inputs">
                  <label for="flight_no" class="col-sm-3 col-form-label pformlabel">Flight No</label>
                  <div class="col-sm-9">
                    <input type="text" name="flight_no" class="form-control inputs_with_bottom_border" id="flight_no">
                    <div class="all_errors psngr_err" id="flight_no_error"></div>
                  </div>
                </div>
                <div class="form-group row invoice-inputs">
                  <label for="booking_ref_no" class="col-sm-3 col-form-label pformlabel">Booking Ref No</label>
                  <div class="col-sm-9">
                    <input type="text" name="booking_ref_no" class="form-control inputs_with_bottom_border" id="booking_ref_no">
                    <div class="all_errors psngr_err" id="booking_ref_no_error"></div>
                  </div>
                </div>
                <div class="form-group row invoice-inputs">
                  <label for="ticket_no" class="col-sm-3 col-form-label pformlabel">Ticket No</label>
                  <div class="col-sm-9">
                    <input type="text" name="ticket_no" class="form-control inputs_with_bottom_border" id="ticket_no">
                    <div class="all_errors psngr_err" id="ticket_no_error"></div>
                  </div>
                </div>
            </div>

            </form>

          </div>
          </div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary save-tests" id="detail-invoice_btn">Save & Continue</button>
      </div>
    </div>
  </div>
</div>

<!-- Reason Modal -->
<div class="modal fade" id="reasonModel" tabindex="-1" role="dialog" aria-labelledby="reasonLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="reasonLabel">What is the reason of update?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="reason-form" method="post">
          @csrf
          <div class="form-group">
            <label for="reason">Describe Reason</label>
            <textarea name="reason" class="form-control"></textarea>
            <div class="all_errors" id="reason_error"></div>
          </div>
          <button type="submit" class="btn btn-primary">Save Reason</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- The Make Selection Modal -->
<div class="modal" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Make a selection</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div id="cropimage">
                    <img id="imageprev" src="assets/img/bg.png" />
                </div>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <div class="btngroup">
                    <button type="button" class="btn upload1 float-left" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btnsmall" id="rotateL" title="Rotate Left"><i class="fa fa-undo"></i></button>
                    <button type="button" class="btn btnsmall" id="rotateR" title="Rotate Right"><i class="fa fa-repeat"></i></button>
                    <button type="button" class="btn btnsmall" id="scaleX" title="Flip Horizontal"><i class="fa fa-arrows-h"></i></button>
                    <button type="button" class="btn btnsmall" id="scaleY" title="Flip Vertical"><i class="fa fa-arrows-v"></i></button>
                    <button type="button" class="btn btnsmall" id="reset" title="Reset"><i class="fa fa-refresh"></i></button>
                    <button type="button" class="btn camera1 float-right" id="saveAvatar">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- The Camera Modal -->
<div class="modal" id="cameraModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Take a picture</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div id="my_camera"></div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn upload" data-dismiss="modal">Close</button>
                <button type="button" class="btn camera" onclick="take_snapshot()">Take a picture</button>
            </div>
        </div>
    </div>
</div>

<script language="JavaScript">
// Configure a few settings and attach camera

var image_file;

function configure() {
    Webcam.set({
        width: 640,
        height: 480,
        image_format: 'jpeg',
        jpeg_quality: 100
    });
    Webcam.attach('#my_camera');
}
// A button for taking snaps

function take_snapshot() {
    // take snapshot and get image data
    Webcam.snap(function(data_uri) {
        // display results in page
        $("#cameraModal").modal('hide');
        $("#myModal").modal({
            backdrop: "static"
        });
        $("#cropimage").html('<img id="imageprev" src="' + data_uri + '"/>');
        cropImage();
        //document.getElementById('cropimage').innerHTML = ;
    });
    Webcam.reset();
}

function saveSnap() {
    // Get base64 value from <img id='imageprev'> source
    var base64image = document.getElementById("imageprev").src;
    Webcam.upload(base64image, 'upload.php', function(code, text) {
        console.log('Save successfully');
    });
}

$('#cameraModal').on('show.bs.modal', function() {
    configure();
})

$('#cameraModal').on('hide.bs.modal', function() {
    Webcam.reset();
    $("#cropimage").html("");
})

$('#myModal').on('hide.bs.modal', function() {
    $("#cropimage").html('<img id="imageprev" src="assets/img/bg.png"/>');
})

/* UPLOAD Image */
var input = document.getElementById('input');
var $alert = $('.alert');


/* DRAG and DROP File */
$("#drop-area").on('dragenter', function(e) {
    e.preventDefault();
});

$("#drop-area").on('dragover', function(e) {
    e.preventDefault();
});

$("#drop-area").on('drop', function(e) {
    var image = document.querySelector('#imageprev');
    var files = e.originalEvent.dataTransfer.files;

    var done = function(url) {
        input.value = '';
        image.src = url;
        $alert.hide();
        $("#myModal").modal({
            backdrop: "static"
        });
        cropImage();
    };

    var reader;
    var file;
    var url;

    if (files && files.length > 0) {
        file = files[0];

        if (URL) {
            done(URL.createObjectURL(file));
        } else if (FileReader) {
            reader = new FileReader();
            reader.onload = function(e) {
                done(reader.result);
            };
            reader.readAsDataURL(file);
        }
    }

    e.preventDefault();

});

/* INPUT UPLOAD FILE */
input.addEventListener('change', function(e) {
    var image = document.querySelector('#imageprev');
    var files = e.target.files;
    var done = function(url) {
        input.value = '';
        image.src = url;
        $alert.hide();
        $("#myModal").modal({
            backdrop: "static"
        });
        cropImage();

    };
    var reader;
    var file;
    var url;

    if (files && files.length > 0) {
        file = files[0];

        if (URL) {
            done(URL.createObjectURL(file));
        } else if (FileReader) {
            reader = new FileReader();
            reader.onload = function(e) {
                done(reader.result);
            };
            reader.readAsDataURL(file);
        }
    }
});
/* CROP IMAGE AFTER UPLOAD */
function cropImage() {
    var image = document.querySelector('#imageprev');
    var minAspectRatio = 0.5;
    var maxAspectRatio = 1.5;

    var cropper = new Cropper(image, {
        aspectRatio: 10 / 10,
        minCropBoxWidth: 25,
        minCropBoxHeight: 25,

        ready: function() {
            var cropper = this.cropper;
            var containerData = cropper.getContainerData();
            var cropBoxData = cropper.getCropBoxData();
            var aspectRatio = cropBoxData.width / cropBoxData.height;
            //var aspectRatio = 4 / 3;
            var newCropBoxWidth;
            cropper.setDragMode("move");
            if (aspectRatio < minAspectRatio || aspectRatio > maxAspectRatio) {
                newCropBoxWidth = cropBoxData.height * ((minAspectRatio + maxAspectRatio) / 2);

                cropper.setCropBoxData({
                    left: (containerData.width - newCropBoxWidth) / 2,
                    width: newCropBoxWidth
                });
            }
        },

        cropmove: function() {
            var cropper = this.cropper;
            var cropBoxData = cropper.getCropBoxData();
            var aspectRatio = cropBoxData.width / cropBoxData.height;

            if (aspectRatio < minAspectRatio) {
                cropper.setCropBoxData({
                    width: cropBoxData.height * minAspectRatio
                });
            } else if (aspectRatio > maxAspectRatio) {
                cropper.setCropBoxData({
                    width: cropBoxData.height * maxAspectRatio
                });
            }
        },


    });

    $("#scaleY").click(function() {
        var Yscale = cropper.imageData.scaleY;
        if (Yscale == 1) {
            cropper.scaleY(-1);
        } else {
            cropper.scaleY(1);
        };
    });

    $("#scaleX").click(function() {
        var Xscale = cropper.imageData.scaleX;
        if (Xscale == 1) {
            cropper.scaleX(-1);
        } else {
            cropper.scaleX(1);
        };
    });

    $("#rotateR").click(function() {
        cropper.rotate(45);
    });
    $("#rotateL").click(function() {
        cropper.rotate(-45);
    });
    $("#reset").click(function() {
        cropper.reset();
    });


$("#saveAvatar").click(function() {
    var $progress = $('.progress');
    var $progressBar = $('.progress-bar');
    var avatar = document.getElementById('avatarimage');
    var $alert = $('.alert');
    canvas = cropper.getCroppedCanvas({
        width: 220,
        height: 240,
    });

    $progress.show();
    $alert.removeClass('alert-success alert-warning');
    canvas.toBlob(function(blob) {
        var formData = new FormData();

        image_file = blob;
        console.log(image_file);

        $("#myModal").modal('hide');
        $progress.hide();
        initialAvatarURL = avatar.src;
        avatar.src = canvas.toDataURL();
        return false;

        // formData.append('avatar', blob, 'avatar.jpg');
        // $.ajax('upload.php', {
        //     method: 'POST',
        //     data: formData,
        //     processData: false,
        //     contentType: false,

        //     xhr: function() {
        //         var xhr = new XMLHttpRequest();

        //         xhr.upload.onprogress = function(e) {
        //             var percent = '0';
        //             var percentage = '0%';

        //             if (e.lengthComputable) {
        //                 percent = Math.round((e.loaded / e.total) * 100);
        //                 percentage = percent + '%';
        //                 $progressBar.width(percentage).attr('aria-valuenow', percent).text(percentage);
        //             }
        //         };

        //         return xhr;
        //     },

        //     success: function() {
        //         //$alert.show().addClass('alert-success').text('Upload success');
        //     },

        //     error: function() {
        //         avatar.src = initialAvatarURL;
        //         $alert.show().addClass('alert-warning').text('Upload error');
        //     },

        //     complete: function() {
        //         $("#myModal").modal('hide');
        //         $progress.hide();
        //         initialAvatarURL = avatar.src;
        //         avatar.src = canvas.toDataURL();
        //     },
        // });
    });

});
};
</script>

<script src="{{asset('assets/developer/patients.js')}}"></script>

@endsection