@extends('layouts.admin')
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
                    <th scope="col">Username</th>
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
                    <td><?php echo (!empty($value->user->name))?$value->user->name:'---';?></td>
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
                    <th scope="col">Username</th>
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
                    <td><?php echo (!empty($value->user->name))?$value->user->name:'---';?></td>
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
                    <th scope="col">Username</th>
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
                    <td><?php echo (!empty($value->user->name))?$value->user->name:'---';?></td>
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
                    <td><a href="{{url('admin/invoice-detail/'.$value->unique_id)}}" target="_blank">View</a></td>
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

<script src="{{asset('assets/developer/admin/patients.js')}}"></script>

@endsection