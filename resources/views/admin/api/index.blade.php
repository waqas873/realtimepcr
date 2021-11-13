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

<div class="row">
<div class="col-sm-12">
<div class="page-title-box">
<div class="row align-items-center">
    <div class="col-sm-5">
        <h4 class="page-title m-0">Arham's API Services</h4>
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
        <h4 class="mb-3 mt-0 float-right">{{count($sent)}}</h4>
    </div>
    <div>
        <span class="ml-2 ml22">Patient Details Send</span>
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
        <h4 class="mb-3 mt-0 float-right">{{count($pending)}}</h4>
    </div>
    <div> <span class="ml-2 ml22">Pending Patients Reports</span>
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
        <h4 class="mb-3 mt-0 float-right">{{count($total)}}</h4>
    </div>
    <div> <span class="ml-2 ml22">Complete Records Send</span>
    </div>
</div>
<div class="p-3 p3_stat_btm">
    <div class="float-right">
        <a href="#" class="text-white-50"><i class="mdi mdi-tag-text-outline h5"></i></a>
    </div>
</div>
</div>
</div>

<!--Added by Rahee For Input -->

<div class="col-xl-3 col-md-6">
<div class="card bg-success mini-stat text-white">
<div class="p-3 mini-stat-desc">
    <div class="clearfix">
        <input placeholder="Enter Patient ID to Cancel Records from API" class="" style="
    width: 100%;
    height: 60px;
    border: none;
    border-radius: 5px;
    margin-bottom: 4px;
    padding: 10px;
    font-size: 15px;
">
    </div>
    
</div>
<div>
     <input type="button" value="Cancel Records" style="
    width: 100%;
    border: none;
    height: 34px;
    background-color: #4eb778;
    border-radius: 0px 0px 5px 5px;
    color: white;
">
</div>


</div>
</div>
</div>  
<!--Added by Rahee Ends here -->
<!-- end row -->

<?php 
    $permissions = permissions();
    ?>

<div class="row">
  <div class="col-sm-12">
    <div class="page-title-box">
      <div class="row align-items-center">
        <div class="col-md-5">
          
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

<div class="row">
<div class="col-xl-12">
<div class="card">
<div class="card-body">
    <h4 class="mt-0 header-title mb-4">Awaiting to Send Patient Details Automatically</h4>
    <div class="table-responsive">
        <table class="table table-hover" id="datatable1">
            <thead>
                <tr>
                    <th scope="col">Registration Date</th>
                    <th scope="col">Patient ID</th>
                    <th scope="col">Invoice ID</th>
                    <th scope="col">Patient Name</th>
                    <th scope="col">Action</th>
                    <!-- <th scope="col">P# Details</th>
                    <th scope="col">P# Records</th>
                    <th scope="col">Action</th> -->
                </tr>
            </thead>
            {{--<tbody>
                @if(!empty($pending))
                @foreach($pending as $key=>$value)
                <tr>
                    <td scope="col">{{$value->patient->created_at}}</td>
                    <td scope="col">#{{$value->patient->id}}</td>
                    <td scope="col">#{{$value->invoice->unique_id}}</td>
                    <td scope="col">{{ucwords($value->patient->name)}}</td>
                    <td>
                      <?php 
                      if($permissions['role']==1 || (!empty($permissions['api_read_write']))){
                      ?>
                      <a href="<?php echo url('admin/cancel-api-request/'.$value->id);?>" class="btn btn-danger cancel_api_request">Cancel</a>
                      <?php } else {echo "-- -- ";} ?>
                    </td>
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

<!-- Comment by Raheel -->
{{--
<div class="row">
<div class="col-xl-12">
<div class="card">
<div class="card-body">
    <h4 class="mt-0 header-title mb-4">Test Results send today</h4>
    <div class="table-responsive">
        <table class="table table-hover" id="datatable2">
            <thead>
                <tr>
                    <th scope="col">Registration Date</th>
                    <th scope="col">Patient ID</th>
                    <th scope="col">Invoice ID</th>
                    <th scope="col">Patient Name</th>
                </tr>
            </thead>
            <tbody>
                @if(!empty($results_sent))
                @foreach($results_sent as $key=>$value)
                <tr>
                    <td scope="col">{{$value->patient->created_at}}</td>
                    <td scope="col">#{{$value->patient->id}}</td>
                    <td scope="col">#{{$value->invoice->unique_id}}</td>
                    <td scope="col">{{ucwords($value->patient->name)}}</td>
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

<div class="row">
<div class="col-xl-12">
<div class="card">
<div class="card-body">
    <h4 class="mt-0 header-title mb-4">Queued/Records Waiting For Tests Results To Be Delivered</h4>
    <div class="table-responsive">
        <table class="table table-hover" id="datatable">
            <thead>
                <tr>
                    <th scope="col">Registration Date</th>
                    <th scope="col">Patient ID</th>
                    <th scope="col">Invoice ID</th>
                    <th scope="col">Patient Name</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td scope="col">Registration Date</td>
                    <td scope="col">Patient ID</td>
                    <td scope="col">Invoice ID</td>
                    <td scope="col">Patient Name</td>
                </tr>
            </tbody>
        </table>
    </div>

</div>
</div>
</div>
</div> 

<div class="row">
<div class="col-xl-12">
<div class="card">
<div class="card-body">
    <h4 class="mt-0 header-title mb-4">Successfully Send Records Today</h4>
    <div class="table-responsive">
        <table class="table table-hover" id="datatable3">
            <thead>
                <tr>
                    <th scope="col">Registration Date</th>
                    <th scope="col">Patient ID</th>
                    <th scope="col">Invoice ID</th>
                    <th scope="col">Patient Name</th>
                </tr>
            </thead>
            <tbody>
                @if(!empty($total))
                @foreach($total as $key=>$value)
                <tr>
                    <td scope="col">{{$value->patient->created_at}}</td>
                    <td scope="col">#{{$value->patient->id}}</td>
                    <td scope="col">#{{$value->invoice->unique_id}}</td>
                    <td scope="col">{{ucwords($value->patient->name)}}</td>
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

</div> --}}

<script src="{{asset('assets/developer/admin/api.js')}}"></script>

@endsection