@extends('layouts.airlines')
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
        <h4 class="page-title m-0">Progress Reports</h4>
    </div>
    <div class="col-sm-7">
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
<div class="col-xl-3 col-md-6">
<div class="card bg-primary mini-stat text-white">
<div class="p-3 mini-stat-desc">
    <div class="clearfix">
        <h4 class="mb-3 mt-0 float-right">{{$completed}}</h4>
    </div>
    <div>
        <span class="ml-2 ml22">Tests Completed</span>
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
        <h4 class="mb-3 mt-0 float-right">{{$pending}}</h4>
    </div>
    <div> <span class="ml-2 ml22">Tests Pending</span>
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
        <h4 class="mb-3 mt-0 float-right">{{$positive}}</h4>
    </div>
    <div> <span class="ml-2 ml22">Covid-19 Positive</span>
    </div>
</div>
<div class="p-3 p3_stat_btm">
    <div class="float-right">
        <a href="#" class="text-white-50"><i class="mdi mdi-tag-text-outline h5"></i></a>
    </div>
</div>
</div>
</div>

<div class="col-xl-3 col-md-6">
<div class="card bg-success mini-stat text-white">
<div class="p-3 mini-stat-desc">
    <div class="clearfix">
        <h4 class="mb-3 mt-0 float-right">{{$negative}}</h4>
    </div>
    <div><span class="ml-2 ml22">Covid-19 Negative</span>
    </div>
</div>
<div class="p-3 p3_stat_btm">
    <div class="float-right">
        <a href="#" class="text-white-50"><i class="mdi mdi-briefcase-check h5"></i></a>
    </div>
</div>
</div>
</div>
</div>  
<!-- end row -->

<div class="row">
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
    <!-- <div class="row">
        <div class="col-sm-12">
         <a href="javascript::" class="btn btn-info" id="add_doctor" style="margin-bottom: 12px;">Add Doctor</a>
        </div>
    </div>  -->
    <h4 class="mt-0 header-title mb-4">Reports List</h4>
    <div class="table-responsive">
        <table class="table table-hover" id="datatable">
            <thead>
                <tr>
                    <th scope="col">Case ID</th>
                    <th scope="col">Registration Date</th>
                    <th scope="col">Patient Name</th>
                    <th scope="col">Airline</th>
                    <th scope="col">CP City</th>
                    <th scope="col">Result</th>
                    <th scope="col">Report</th>
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

<script src="{{asset('assets/developer/airlines.js')}}"></script>

@endsection