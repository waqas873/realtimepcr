@extends('layouts.pcr')
@section('content')

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.9/jquery.datetimepicker.min.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.9/jquery.datetimepicker.full.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.9/jquery.datetimepicker.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  $('.datetimepicker').datetimepicker();
})
</script>
<div class="container-fluid">

  <div class="row">
    <div class="col-sm-12">
      <div class="page-title-box ptb_custom">
        <div class="row align-items-center">
          <div class="col-sm-3">
            <h4 class="page-title m-0">Reports</h4>
          </div>
          <div class="col-sm-9" style="padding-top: 17px;">
            <div class="row">
              <div class="offset-sm-6 col-sm-6">
                <div class="form-group row">
                  <label for="reffered_by" class="col-sm-4 col-form-label pformlabel no_padd">Filter By Status:</label>
                  <div class="col-sm-8">
                    <select class="form-control" id="status_filter" name="status_filter">
                      <option value="all">All</option>
                      <option value="3">Final Reports</option>
                      <option value="1">Awaiting Results</option>
                      <option value="0">Reports in Queue</option>
                      <option value="2">Pending Payment</option>
                      <option value="5">Reports Delivered</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
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
    <div class="form-group col-sm-2">
      <label for="test_type" class=" col-form-label pformlabel">Filter by test Type</label>
      <div class="">
        <select class="form-control" id="test_type" name="test_type" required="">
          <option value="">Select TestType</option>
          <option value="1">Type1 Positive / Negative</option>
          <option value="2">Type2 Detected / Not-Detected</option>
        </select>
        <div class="all_errors test_type_err" id="test_type_error"></div>
      </div>
    </div>
    <div class="form-group col-sm-2">
      <label for="airline" class=" col-form-label pformlabel">Filter by Airline</label>
      <div class="">
        <select class="form-control" id="airline" name="airline">
          <option value="">Select Airline</option>
          @if(!empty($airlines))
          @foreach($airlines as $airline)
          <option value="{{$airline->name}}">{{$airline->name}}</option>
          @endforeach
          @endif
        </select>
        <div class="all_errors airline_err" id="airline_error"></div>
      </div>
    </div>
    <div class="form-group col-sm-4">
      <label for="test_id" class=" col-form-label pformlabel">Filter by Test</label>
      <div class="">
        <select class="form-control" id="test_id" name="test_id" required="">
          <option value="">Select Test</option>
          @if(!empty($tests))
          @foreach($tests as $test)
          <option value="{{$test->id}}">{{$test->name}}</option>
          @endforeach
          @endif
        </select>
        <div class="all_errors test_id_err" id="test_id_error"></div>
      </div>
    </div>
    <div class="form-group col-sm-2">
      <label for="start_date" class=" col-form-label pformlabel">Start Date&Time</label>
      <div class="">
        <input type="text" name="start_date" id="start_date" class="form-control start_date datetimepicker" required="">
        <div class="all_errors psngr_err" id="start_date_error"></div>
      </div>
    </div>
    <div class="form-group col-sm-2">
      <label for="end_date" class=" col-form-label pformlabel">End Date&Time</label>
      <div class="">
        <input type="text" name="end_date" required="" id="end_date" class="form-control end_date datetimepicker">
        <div class="all_errors end_date_err" id="end_date_error"></div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="form-group col-sm-4">
      <label for="user_id" class=" col-form-label pformlabel">Filter by User</label>
      <div class="">
        <select class="form-control" id="user_id" name="user_id">
          <option value="">Select User</option>
          @if(!empty($users))
          @foreach($users as $value)
          <option value="{{$value->id}}">{{$value->name}}</option>
          @endforeach
          @endif
        </select>
        <div class="all_errors user_id_err" id="user_id_error"></div>
      </div>
    </div>
  </div>

  


<form action="{{url('track-form')}}" target="_blank" method="post">
  @csrf
  <div class="row">
    <div class="col-sm-12">
      <input type="submit" class="btn btn-dark waves-effect waves-light submit_reports float-right mb-2" value="Print All Fetched Reports">
    </div>
  </div>
  <div class="row">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-body">
          <div class="col-sm-12">
            <h4 class="mt-0 header-title mb-4">All Reports</h4>
          </div>
          <div class="table-responsive">
            <table class="table table-hover" id="datatable">
              <thead>
                <tr>
                  <th scope="col">---</th>
                  <th scope="col">Invoice ID</th>
                  <th scope="col">Patient Name</th>
                  <th scope="col">Test</th>
                  <th scope="col">Amount Paid</th>
                  <th scope="col">Balance</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
            </table>
          </div>

        </div>
      </div>
    </div>
  </div>
  <!-- end row -->
</form>

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
              <form id="pay-now-form">
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


</div><!-- container fluid -->

<script src="{{asset('assets/developer/reports.js')}}"></script>

@endsection