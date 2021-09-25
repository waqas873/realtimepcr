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

  <form action="{{url('admin/export-patients')}}" method="post">
    @csrf

    <div class="row">
      <div class="col-sm-12">
        <div class="page-title-box">
          <div class="row align-items-center">
            <div class="col-md-5">
              <h4 class="page-title m-0">Patients</h4>
            </div>
            <div class="col-sm-7">
              <div class="row emdatefilter">
                <div class="col-sm-2 no_padd">
                  <p>Date Range</p>
                </div>
                <div class="col-sm-3 no_padd">
                  <input class="form-control inputs_with_bottom_border" type="date" id="from_date" name="from_date">
                </div>
                <div class="col-sm-1">
                  <p>To</p>
                </div>
                <div class="col-sm-3 no_padd">
                  <input class="form-control inputs_with_bottom_border" type="date" id="to_date" name="to_date">
                </div>
                <div class="col-sm-3">
                  <a href="javascript::" class="btn btn-success embsearch" id="by_date">Search</a>
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

    <!-- Filters List Starts here -->
    <div class="row">

      <div class="col-sm-3">
        <div class="form-group row">
          <label for="lab_id" class="col-sm-4 col-form-label pformlabel no_padd">Official Labs:</label>
          <div class="col-sm-8">
            <select class="form-control inputs_with_bottom_border " id="lab_id" name="lab_id">
              <option value="">Select Here</option>
              <option value="all">All</option>
              <?php
              foreach ($labs as $key => $value) {
              ?>
                <option value="{{$value->id}}">{{$value->name}}</option>
              <?php } ?>
            </select>
          </div>
        </div>
      </div>

      <div class="col-sm-3">
        <div class="form-group row">
          <label for="collection_point_id" class="col-sm-4 col-form-label pformlabel no_padd">CPs Name:</label>
          <div class="col-sm-8">
            <select class="form-control inputs_with_bottom_border " id="collection_point_id" name="collection_point_id">
              <option value="">Select Here</option>
              <option value="all">All</option>
              <?php
              foreach ($collection_points as $key => $value) {
              ?>
                <option value="{{$value->id}}">{{$value->name}}</option>
              <?php } ?>
            </select>
          </div>
        </div>
      </div>

      <div class="col-sm-3">
        <div class="form-group row">
          <label for="user_id" class="col-sm-4 col-form-label pformlabel no_padd">Registered by:</label>
          <div class="col-sm-8">
            <select class="form-control inputs_with_bottom_border " id="user_id" name="user_id">
              <option value="">Select Here</option>
              <option value="all">All</option>
              <?php
              foreach ($users as $key => $value) {
              ?>
                <option value="{{$value->id}}">{{$value->name}}</option>
              <?php } ?>
            </select>
          </div>
        </div>
      </div>

      <div class="col-sm-3">
        <div class="form-group row">
          <label for="lab_user" class="col-sm-4 col-form-label pformlabel no_padd">Processed By:</label>
          <div class="col-sm-8">
            <select class="form-control inputs_with_bottom_border " id="lab_user" name="lab_user">
              <option value="">Select Here</option>
              <option value="all">All</option>
              <?php
              foreach ($lab_users as $key => $value) {
              ?>
                <option value="{{$value->id}}">{{$value->name}}</option>
              <?php } ?>
            </select>
          </div>
        </div>
      </div>

      <div class="col-sm-3">
        <div class="form-group row">
          <label for="test_result" class="col-sm-4 col-form-label pformlabel no_padd">Test Type:</label>
          <div class="col-sm-8">
            <select class="form-control inputs_with_bottom_border " id="" name="">
              <option value="">Select Here</option>
              <option value="">Type 1</option>
              <option value="">Type 2</option>
            </select>
          </div>
        </div>
      </div>

      <div class="col-sm-3">
        <div class="form-group row">
          <label for="test_result" class="col-sm-4 col-form-label pformlabel no_padd">Test Department:</label>
          <div class="col-sm-8">
            <select class="form-control inputs_with_bottom_border " id="" name="">
              <option value="">Select Here</option>
            </select>
          </div>
        </div>
      </div>

      <div class="col-sm-3">
        <div class="form-group row">
          <label for="test_id" class="col-sm-4 col-form-label pformlabel no_padd">Test Name:</label>
          <div class="col-sm-8">
            <select class="form-control inputs_with_bottom_border " id="test_id" name="test_id">
              <option value="">Select Here</option>
              <option value="all">All</option>
              <?php
              foreach ($tests as $key => $value) {
              ?>
                <option value="{{$value->id}}">{{$value->name}}</option>
              <?php } ?>
            </select>
          </div>
        </div>
      </div>

      <div class="col-sm-3">
        <div class="form-group row">
          <label for="test_result" class="col-sm-4 col-form-label pformlabel no_padd">Test Results</label>
          <div class="col-sm-8">
            <select class="form-control inputs_with_bottom_border " id="test_result" name="test_result">
              <option value="">Select Here</option>
              <option value="Positive">Positive</option>
              <option value="Negative">Negative</option>
              <option value="Detected">Detected</option>
              <option value="Not Detected">Not Detected</option>
              <option value="Awaiting Results">Awaiting Results</option>
            </select>
          </div>
        </div>
      </div>

      <div class="col-sm-3">
        <div class="form-group row">
          <label for="doctor_id" class="col-sm-4 col-form-label pformlabel no_padd">Reffered By:</label>
          <div class="col-sm-8">
            <select class="form-control inputs_with_bottom_border " id="doctor_id" name="doctor_id">
              <option value="">Select Here</option>
              <option value="all">All</option>
              <?php
              foreach ($doctors as $key => $value) {
              ?>
                <option value="{{$value->id}}">{{$value->name}}</option>
              <?php } ?>
            </select>
          </div>
        </div>
      </div>

      <div class="col-sm-3">
        <div class="form-group row">
          <label for="payment_filter" class="col-sm-4 col-form-label pformlabel no_padd">Payment Status:</label>
          <div class="col-sm-8">
            <select class="form-control inputs_with_bottom_border " id="payment_filter" name="payment_filter">
              <option value="">Select Here</option>
              <option value="all">All</option>
              <option value="1">Paid</option>
              <option value="2">Pending</option>
            </select>
          </div>
        </div>
      </div>

      <div class="col-sm-3">
        <div class="form-group row">
          <label for="local_overseas" class="col-sm-4 col-form-label pformlabel no_padd">Local / Overseas</label>
          <div class="col-sm-8">
            <select class="form-control inputs_with_bottom_border " id="local_overseas" name="local_overseas">
              <option value="">Select Here</option>
              <option value="all">All</option>
              <option value="1">Local</option>
              <option value="2">Overseas</option>
            </select>
          </div>
        </div>
      </div>

      <div class="col-sm-3">
        <div class="form-group row">
          <label for="airline" class="col-sm-4 col-form-label pformlabel no_padd">Airlines:</label>
          <div class="col-sm-8">
            <select class="form-control inputs_with_bottom_border " id="airline" name="airline">
              <option value="">Select Here</option>
              <option value="all">All</option>
              <?php
              foreach ($airlines as $key => $value) {
              ?>
                <option value="{{$value->name}}">{{$value->name}}</option>
              <?php } ?>
            </select>
          </div>
        </div>
      </div>

      <div class="col-sm-3">
        <div class="form-group row">
          <label for="country_id" class="col-sm-4 col-form-label pformlabel no_padd">Country</label>
          <div class="col-sm-8">
            <select class="form-control inputs_with_bottom_border " id="country_id" name="country_id">
              <option value="">Select Here</option>
              <option value="all">All</option>
              <?php
              foreach ($countries as $key => $value) {
              ?>
                <option value="{{$value->id}}">{{$value->name}}</option>
              <?php } ?>
            </select>
          </div>
        </div>
      </div>

      <div class="col-sm-3">
        <div class="form-group row">
          <label for="" class="col-sm-4 col-form-label pformlabel no_padd">Flight No:</label>
          <div class="col-sm-8">
            <input type="text" class="form-control inputs_with_bottom_border" style="text-transform:uppercase">
          </div>
        </div>
      </div>

      <div class="col-sm-3">
        <div class="form-group row">
          <label for="" class="col-sm-4 col-form-label pformlabel no_padd">Passport No:</label>
          <div class="col-sm-8">
            <input type="text" class="form-control inputs_with_bottom_border" style="text-transform:uppercase">
          </div>
        </div>
      </div>

    </div>
    <div class="row">
      <div class="col-sm-4">
        <input type="submit" value="Export Patient Data" class="btn btn-success" style="margin-bottom: 10px;">
      </div>
    </div>
</div>

</form>

<div class="row">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <h4 class="mt-0 header-title mb-4">Patients List</h4>
        <div class="table-responsive">
          <table class="table table-hover" id="datatable">
            <thead>
              <tr>
                <th scope="col">Patient ID</th>
                <th scope="col">Patient Name</th>
                <th scope="col">Reffered By</th>
                <th scope="col">Test</th>
                <th scope="col">Invoice ID</th>
                <th scope="col">Amount Paid</th>
                <th scope="col">Balance</th>
                <th scope="col">Added By</th>
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


</div><!-- container fluid -->

<!-- Modal -->
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

<script src="{{asset('assets/developer/admin/patient-tests.js')}}"></script>

@endsection