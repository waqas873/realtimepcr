@extends('layouts.pcr')
@section('content')

<div class="container-fluid">

<div class="row">
<div class="col-sm-12">
<div class="page-title-box">
<div class="row align-items-center">
    <div class="col-md-8">
        <h4 class="page-title m-0">Invoices</h4>
    </div>
    <!-- end col -->
</div>
<!-- end row -->
</div>
<!-- end page-title-box -->
</div>
</div> 
<!-- end page title -->


<div class="row">
<div class="col-xl-12">
<div class="card">
<div class="card-body">
    <h4 class="mt-0 header-title mb-4">Open Invoices</h4>
    <div class="table-responsive">
        <table class="table table-hover" id="datatable">
            <thead>
                <tr>
                    <th scope="col">Invoice ID</th>
                    <th scope="col">Date Generated</th>
                    <th scope="col">Patient Name</th>
                    <th scope="col">Test Name/Description</th>
                    <th scope="col">Total Amount</th>
                    <th scope="col">Paid</th>
                    <th scope="col">Balance</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            {{--<tbody>
                @if(!empty($invoices))
                @foreach($invoices as $key => $value)
                <tr>
                    <th scope="row">#{{$value->id}}</th>
                    <td>
                        <?php 
                            $date = explode(' ', $value->created_at);
                            echo $date[0];
                        ?>
                    </td>
                    <td><?php echo (!empty($value->patient->name))?$value->patient->name:'---'; ?></td>
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
                    <td>Rs: {{$value->total_amount}}</td>
                    <td>Rs: {{$value->amount_paid}}</td>
                    <td>Rs: {{$value->amount_remaining}}</td>
                    <td>
                        <a href="{{url('/invoice-detail/'.$value->unique_id)}}" target="_blank">View</a>
                        <?php
                        if($value->amount_remaining>0){
                        ?>
                         | <a href="javascript::" rel="{{$value->id}}" class="pay_now">Pay Now</a>
                        <?php } ?>
                    </td>
                    <!-- <td><a href="javascript::" rel="{{$value->id}}" class="invoice_id">View</a></td> -->
                </tr>
                @endforeach
                @endif
            </tbody>--}}
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
    <h4 class="mt-0 header-title mb-4">Closed Invoices</h4>
    <div class="table-responsive">
        <table class="table table-hover" id="datatable2">
            <thead>
                <tr>
                    <th scope="col">Invoice ID</th>
                    <th scope="col">Date Generated</th>
                    <th scope="col">Patient Name</th>
                    <th scope="col">Test Name/Description</th>
                    <th scope="col">Total Amount</th>
                    <th scope="col">Paid</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @if(!empty($closed))
                @foreach($closed as $key => $value)
                <tr>
                    <th scope="row">#{{$value->id}}</th>
                    <td>
                        <?php 
                            $date = explode(' ', $value->created_at);
                            echo $date[0];
                        ?>
                    </td>
                    <td><?php echo (!empty($value->patient->name))?$value->patient->name:'---'; ?></td>
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
                    <td>Rs: {{$value->total_amount}}</td>
                    <td>Rs: {{$value->amount_paid}}</td>
                    <td>
                        <a href="{{url('/invoice-detail/'.$value->unique_id)}}" target="_blank">View</a>
                    </td>
                </tr>
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
      </div>
      <div class="modal-body">
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

<div class="modal fade" id="payNowModel" tabindex="-1" role="dialog" aria-labelledby="payNowLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="reasonLabel">Pay Now</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
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
        <div class="row" style="margin-top: 20px;">
            <div class="col-sm-12">
                <form id="pay-now-form" method="post">
                  @csrf
                  <input type="hidden" name="invoice_id" id="invoice_id">
                  <div class="form-group">
                    <label for="amount_remaining">Enter Amount</label>
                    <input type="number" name="amount_remaining" class="form-control">
                    <div class="all_errors" id="amount_remaining_error"></div>
                  </div>
                  <div class="form-group">
                    <label for="discount">
                      <input type="checkbox" name="discount" value="1" class="form-control">
                     <span>Convert Balance to Discount</span></label>
                  </div>
                  <button type="submit" class="btn btn-primary">Pay Now</button>
                </form>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script src="{{asset('assets/developer/invoices.js')}}"></script>

@endsection