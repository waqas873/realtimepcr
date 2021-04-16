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

<style type="text/css">
.btn.btn-secondary.buttons-excel.buttons-html5 {
    background-color: #46CD93 !important;
}
#patients_datatable_length label{
    position: relative;
    top: 33px;
}
</style>

<div class="container-fluid">

<div class="row">
<div class="col-sm-12">
<div class="page-title-box">
<div class="row align-items-center">
    <div class="col-sm-12">
        <h4 class="page-title m-0">{{$title}}</h4>
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
        <h4 class="mb-3 mt-0 float-right">{{$patients_registered}}</h4>
    </div>
    <div>
        <span class="ml-2 ml22">Patients Registered</span>
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
        <h4 class="mb-3 mt-0 float-right">{{$open_cases}}</h4>
    </div>
    <div> <span class="ml-2 ml22">Open Cases</span>
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
        <h4 class="mb-3 mt-0 float-right">{{$closed_cases}}</h4>
    </div>
    <div> <span class="ml-2 ml22">Closed Cases</span>
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
        <h4 class="mb-3 mt-0 float-right">Rs: {{$pending_balance}}</h4>
    </div>
    <div><span class="ml-2 ml22">Pending Balance</span>
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
<div class="page-title-box">
<div class="row align-items-center">
    <div class="col-sm-5">
        <div class="row">
            <div class="col-sm-2"><strong>Select User</strong></div>
            <div class="col-sm-10">
                <select class="form-control inputs_with_bottom_border select2" id="user_id" name="user_id">
                  <option value="">Select here</option>
                  <option value="all">All</option>
                  @if(!empty($users))
                      @foreach($users as $record)
                      <option value="{{$record->id}}">{{$record->name}}</option>
                      @endforeach
                  @endif
                </select>
            </div>
        </div>
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
<div class="col-xl-12">
<div class="card">
<div class="card-body">
    <!-- <div class="row">
        <div class="col-sm-12">
         <a href="javascript::" class="btn btn-info" id="add_doctor" style="margin-bottom: 12px;">Add Doctor</a>
        </div>
    </div>  -->
    <h4 class="mt-0 header-title mb-4">Patients Registered List</h4>
    <div class="table-responsive">
        <table class="table table-hover" id="patients_datatable">
            <thead>
                <tr>
                    <th scope="col">Date</th>
                    <th scope="col">#ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">CNIC</th>
                    <th scope="col">Contact No</th>
                    <th scope="col">Username</th>
                    <th scope="col">Details</th>
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

<input type="hidden" id="lab_id" value="<?php echo (!empty($lab))?$lab->id:'';?>">
<input type="hidden" id="collection_point_id" value="<?php echo (!empty($cp))?$cp->id:'';?>">

<script src="{{asset('assets/developer/admin/staff.js')}}"></script>

@endsection