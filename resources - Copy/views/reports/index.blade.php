@extends('layouts.pcr')
@section('content')

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
                      <select class="form-control inputs_with_bottom_border select2" id="status_filter" name="status_filter">
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
<div class="col-xl-12">
<div class="card">
<div class="card-body">
    <h4 class="mt-0 header-title mb-4">All Reports</h4>
    <div class="table-responsive">
        <table class="table table-hover" id="datatable">
            <thead>
                <tr>
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