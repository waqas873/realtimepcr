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
        <h4 class="page-title m-0">Labs Entries Reports</h4>
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
<div class="col-sm-12">
<div class="page-title-box">
<div class="row align-items-center">
    <div class="col-sm-5">
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