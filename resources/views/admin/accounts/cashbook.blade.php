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


<div class="container">

<div class="row">
<div class="col-sm-12">
<div class="page-title-box">
<div class="row align-items-center">
    <div class="col-sm-5">
        <h4 class="page-title m-0">Cashbook</h4>
    </div>


    <div class="col-sm-1 no_padd">
                <p>Filter by LAB</p>
            </div>
            <div class="col-sm-6 no_padd">
                <select class="form-control" name="" id="">
                <option value="">All</option>
                
                </select>
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
        <h4 class="mb-3 mt-0 float-right">3445</h4>
    </div>
    <div>
        <span class="ml-2 ml22">Previous</span>
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
        <h4 class="mb-3 mt-0 float-right">2433</h4>
    </div>
    <div> <span class="ml-2 ml22">Debit</span>
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
        <h4 class="mb-3 mt-0 float-right">23432</h4>
    </div>
    <div> <span class="ml-2 ml22">Credit</span>
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
        <h4 class="mb-3 mt-0 float-right">2342</h4>
    </div>
    <div><span class="ml-2 ml22">Balance</span>
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
    <!-- <h4 class="mt-0 header-title mb-4">Reports List</h4> -->
    <div class="table-responsive">
        <table class="table table-hover" id="cashbook_datatable">
            <thead>
              <tr>
                  <th scope="col">Date</th>
                  <th scope="col">V-ID</th>
                  <th scope="col">Description</th>
                  <th scope="col">Previous</th>
                  <th scope="col">Debit</th>
                  <th scope="col">Credit</th>
                  <th scope="col">Balance</th>
              </tr>
            </thead>
            <tbody>
                <tr>
                  <td scope="col">2020-06-22</td>
                  <td scope="col">#080954</td>
                  <td scope="col">Testing description</td>
                  <td scope="col">Rs: 4555</td>
                  <td scope="col">Rs: 3434</td>
                  <td scope="col">Rs: 8766</td>
                  <td scope="col">Rs: 543534</td>
                </tr>
                <tr>
                  <td scope="col">2020-06-22</td>
                  <td scope="col">#080954</td>
                  <td scope="col">Testing description</td>
                  <td scope="col">Rs: 4555</td>
                  <td scope="col">Rs: 3434</td>
                  <td scope="col">Rs: 8766</td>
                  <td scope="col">Rs: 543534</td>
                </tr>
                <tr>
                  <td scope="col">2020-06-22</td>
                  <td scope="col">#080954</td>
                  <td scope="col">Testing description</td>
                  <td scope="col">Rs: 4555</td>
                  <td scope="col">Rs: 3434</td>
                  <td scope="col">Rs: 8766</td>
                  <td scope="col">Rs: 543534</td>
                </tr>
                <tr>
                  <td scope="col">2020-06-22</td>
                  <td scope="col">#080954</td>
                  <td scope="col">Testing description</td>
                  <td scope="col">Rs: 4555</td>
                  <td scope="col">Rs: 3434</td>
                  <td scope="col">Rs: 8766</td>
                  <td scope="col">Rs: 543534</td>
                </tr>
                <tr>
                  <td scope="col">2020-06-22</td>
                  <td scope="col">#080954</td>
                  <td scope="col">Testing description</td>
                  <td scope="col">Rs: 4555</td>
                  <td scope="col">Rs: 3434</td>
                  <td scope="col">Rs: 8766</td>
                  <td scope="col">Rs: 543534</td>
                </tr>
                <tr>
                  <td scope="col">2020-06-22</td>
                  <td scope="col">#080954</td>
                  <td scope="col">Testing description</td>
                  <td scope="col">Rs: 4555</td>
                  <td scope="col">Rs: 3434</td>
                  <td scope="col">Rs: 8766</td>
                  <td scope="col">Rs: 543534</td>
                </tr>
            </tbody>
        </table>
    </div>

</div>
</div>
</div>
</div>
<!-- end row -->

</div><!-- container fluid -->

<script src="{{asset('assets/developer/admin/accounts.js')}}"></script>

@endsection