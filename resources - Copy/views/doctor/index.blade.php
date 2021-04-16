@extends('layouts.doctor')
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

@if(session('error_message'))
    <script type="text/javascript">
        swal({
          title: "Warning",
          text: "{{session('error_message')}}",
          icon: "error",
          button: "OK",
        });
    </script>
@endif


<div class="container-fluid">

<div class="row">
<div class="col-sm-12">
<div class="page-title-box">
<div class="row align-items-center">
    <div class="col-sm-5">
        <h4 class="page-title m-0">Dashboard</h4>
    </div>
    
    <!-- <div class="col-sm-7">
        <div class="row emdatefilter">
            <div class="col-sm-2 no_padd">
                <p>Date Range</p>
            </div>
            <div class="col-sm-3 no_padd">
                <input class="form-control inputs_with_bottom_border" type="date" id="from_date" name="from_date">
            </div>
            <div class="col-sm-1"><p>To</p></div>
            <div class="col-sm-3 no_padd">
                <input class="form-control inputs_with_bottom_border" type="date" id="to_date" name="to_date">
            </div>
            <div class="col-sm-3">
                <a href="javascript::" class="btn btn-success embsearch" id="by_date">Search</a>
            </div>
        </div>
    </div> -->

</div>
<!-- end row -->
</div>
<!-- end page-title-box -->
</div>
</div> 
<!-- end page title -->


<div class="row">
<div class="col-xl-3 col-md-6">
<div class="card bg-primary mini-stat text-white">
<div class="p-3 mini-stat-desc">
    <div class="clearfix">
        <h4 class="mb-3 mt-0 float-right">Rs: {{$cash_in_hand}}</h4>
    </div>
    <div>
        <span class="ml-2 ml22">Account balance</span>
    </div>
    
</div>
<div class="p-3 p3_stat_btm">
    <div class="float-right">
        <a href="#" class="text-white-50"><i class="mdi mdi-cube-outline h5"></i></a>
    </div>
</div>
</div>
</div>

<div class="col-xl-3 col-md-6">
<div class="card bg-info mini-stat text-white" style="background-color: orange !important;">
<div class="p-3 mini-stat-desc">
    <div class="clearfix">
        <h4 class="mb-3 mt-0 float-right">Rs: {{$amount_withdrawn}}</h4>
    </div>
    <div> <span class="ml-2 ml22">Amount Withdrawn</span>
    </div>
</div>
<div class="p-3 p3_stat_btm">
    <div class="float-right">
        <a href="#" class="text-white-50"><i class="mdi mdi-buffer h5"></i></a>
    </div>
</div>
</div>
</div>
<div class="col-xl-3 col-md-6">
<div class="card bg-pink mini-stat text-white">
<div class="p-3 mini-stat-desc">
    <div class="clearfix">
        <h4 class="mb-3 mt-0 float-right">Rs: {{$cash_in_hand}}</h4>
    </div>
    <div> <span class="ml-2 ml22">Available to withdraw</span>
    </div>
</div>
<div class="p-3 p3_stat_btm">
    <div class="float-right">
        <a href="#" class="text-white-50"><i class="mdi mdi-tag-text-outline h5"></i></a>
    </div>
</div>
</div>
</div>

</div>  
<!-- end row -->

<!-- <div class="row">
<div class="col-sm-12">
<div class="page-title-box ptb_custom">
<div class="row align-items-center">
    <div class="col-sm-3">
        <h4 class="page-title m-0">Patients List</h4>
    </div>
    <div class="col-sm-9" style="padding-top: 17px;">
        <div class="row">
            <input type="hidden" id="airline" value="">
          
            <div class="col-sm-6">
                <div class="form-group row">
                    <label for="test_status" class="col-sm-4 col-form-label pformlabel no_padd">Filter By:</label>
                    <div class="col-sm-8">
                      <select class="form-control inputs_with_bottom_border select2" id="test_status" name="test_status">
                          <option value="">Select Here</option>
                          <option value="all">All</option>
                          <option value='0'>Awaiting Result</option>
                          <option value="1">Detected</option>
                          <option value="2">Not Detected</option>
                      </select>
                    </div>
                  </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div> --> 

<div class="row">
<div class="col-xl-12">
<div class="card">
<div class="card-body">
    <!-- <div class="row">
        <div class="col-sm-12">
         <a href="javascript::" class="btn btn-info" id="add_doctor" style="margin-bottom: 12px;">Add Doctor</a>
        </div>
    </div>  -->
    <h4 class="mt-0 header-title mb-4">Amounts Recieved</h4>
    <div class="table-responsive">
        <table class="table table-hover" id="datatable">
            <thead>
                <tr>
                    <th scope="col">Type</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Date</th>
                </tr>
            </thead>
            <tbody>
                @if(!empty($amounts_recieved))
                @foreach($amounts_recieved as $key => $value)
                  <tr>
                      <td><img src="{{asset('assets/images/Income.svg')}}"></td>
                      <td><?php echo '<span class="plus_amount"> + Rs: '.$value->amount.'</span>'; ?></td>
                      <td>{{$value->created_at}}</td>
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

<div class="row">
<div class="col-xl-12">
<div class="card">
<div class="card-body">
    <div class="row">
        <div class="col-sm-12">
         <a href="javascript::" class="btn btn-info" id="addWithdraw" style="margin-bottom: 12px;">Add Withdraw</a>
        </div>
    </div> 
    <h4 class="mt-0 header-title mb-4">Withdraw Requests</h4>
    <div class="table-responsive">
        <table class="table table-hover" id="datatable2">
            <thead>
                <tr>
                    <th scope="col">Type</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Date</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                @if(!empty($withdraws))
                @foreach($withdraws as $key => $value)
                  <tr>
                      <td><img src="{{asset('assets/images/expense.svg')}}"></td>
                      <td><?php echo '<span class="minus_amount"> - Rs: '.$value->amount.'</span>'; ?></td>
                      <td>{{$value->created_at}}</td>
                      <td>
                          <?php 
                          $status = '<a class="btn btn-warning" href="javascript::" style="cursor:auto;">Pending</a> | <a class="btn btn-danger withdrawCancel" href="'.url('doctor/cancel-withdraw/'.$value->id).'">Cancel</a>';
                          if($value->status==1){
                            $status = '<a class="btn btn-success" href="javascript::" style="cursor:auto;">Approved</a>';
                          }
                          if($value->status==2){
                            $status = '<a class="btn btn-danger" href="javascript::" style="cursor:auto;">Rejected</a>';
                          }
                          echo $status;
                          ?>
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
<div class="modal fade" id="addWithdrawModal" tabindex="-1" role="dialog" aria-labelledby="addWithdrawModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content add-test-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addWithdrawLabel">Request Withdraw</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form action="" method="post" id="addWithdrawForm">
                @csrf

                <div class="form-group row">
                  <label for="withdraw_amount" class="col-sm-3 col-form-label pformlabel">Withdraw Amount</label>
                  <div class="col-sm-9">
                    <input type="number" class="form-control inputs_with_bottom_border" id="withdraw_amount" name="withdraw_amount" placeholder="Enter amount">
                    <div class="all_errors withdraw_amount_error">
                    </div>
                  </div>
                </div>
                
                <div class="form-group row">
                  <div class="col-sm-9 offset-sm-3">
                      <button type="submit" class="btn btn-primary">Submit Request</button>
                  </div>
                </div>
            </form>
      </div>
    </div>
  </div>
</div>

<script src="{{asset('assets/developer/doctor.js')}}"></script>

@endsection