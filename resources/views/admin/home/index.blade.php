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
  .card.mini-stat{
    margin-bottom: 15px !important;
  }
  .ml22 {
    font-size: 15px !important;
  }
</style>

<div class="container">
<?php
$permissions = permissions();
if($permissions['role'] == 1 || (!empty($permissions['dashboard_read']))){ 
?>

<div class="row">
<div class="col-sm-12">
<div class="page-title-box">
<div class="row align-items-center">
    <div class="col-sm-5">
        <h4 class="page-title m-0">Dashboard</h4>
    </div>
    <!-- <div class="col-sm-7">
        
    </div> -->
</div>
</div>
</div>
</div> 

<div class="row">
  <div class="col-sm-5">
    
  </div>
  <div class="col-sm-7">

    <div class="row">
      <div class="col-xl-4 col-md-6">
        <div class="card bg-primary mini-stat text-white">
        <div class="p-3 mini-stat-desc">
            <div class="clearfix">
                <h4 class="mb-3 mt-0 float-right">23423</h4>
            </div>
            <div>
                <span class="ml-2 ml22">Net Profit</span>
            </div>
        </div>
        <div class="p-3 p3_stat_btm"></div>
        </div>
      </div>
      <div class="col-xl-4 col-md-6">
        <div class="card bg-info mini-stat text-white" style="background-color: orange !important;">
        <div class="p-3 mini-stat-desc">
            <div class="clearfix">
              <h4 class="mb-3 mt-0 float-right">23423</h4>
            </div>
            <div> <span class="ml-2 ml22">Total Income</span>
            </div>
        </div>
        <div class="p-3 p3_stat_btm"></div>
        </div>
      </div>
      <div class="col-xl-4 col-md-6">
        <div class="card bg-pink mini-stat text-white">
        <div class="p-3 mini-stat-desc">
            <div class="clearfix">
                <h4 class="mb-3 mt-0 float-right">234234</h4>
            </div>
            <div> <span class="ml-2 ml22">Total Expense</span>
            </div>
        </div>
        <div class="p-3 p3_stat_btm"></div>
        </div>
      </div>
      <div class="col-xl-4 col-md-6">
        <div class="card bg-pink mini-stat text-white">
        <div class="p-3 mini-stat-desc">
            <div class="clearfix">
                <h4 class="mb-3 mt-0 float-right">234234</h4>
            </div>
            <div> <span class="ml-2 ml22">Bank Payments</span>
            </div>
        </div>
        <div class="p-3 p3_stat_btm"></div>
        </div>
      </div>
      <div class="col-xl-4 col-md-6">
        <div class="card bg-primary mini-stat text-white">
        <div class="p-3 mini-stat-desc">
            <div class="clearfix">
                <h4 class="mb-3 mt-0 float-right">23423</h4>
            </div>
            <div>
                <span class="ml-2 ml22">Total Discount</span>
            </div>
        </div>
        <div class="p-3 p3_stat_btm"></div>
        </div>
      </div>
      <div class="col-xl-4 col-md-6">
        <div class="card bg-info mini-stat text-white" style="background-color: orange !important;">
        <div class="p-3 mini-stat-desc">
            <div class="clearfix">
              <h4 class="mb-3 mt-0 float-right">23423</h4>
            </div>
            <div> <span class="ml-2 ml22">Receptionist Cash</span>
            </div>
        </div>
        <div class="p-3 p3_stat_btm"></div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-xl-12">
        <h5>Doctors Commission</h5>
      </div>
      <div class="col-xl-4 col-md-6">
        <div class="card bg-info mini-stat text-white" style="background-color: orange !important;">
        <div class="p-3 mini-stat-desc">
            <div class="clearfix">
              <h4 class="mb-3 mt-0 float-right">23423</h4>
            </div>
            <div> <span class="ml-2 ml22">Comission Paid</span>
            </div>
        </div>
        <div class="p-3 p3_stat_btm"></div>
        </div>
      </div>
      <div class="col-xl-4 col-md-6">
        <div class="card bg-pink mini-stat text-white">
        <div class="p-3 mini-stat-desc">
            <div class="clearfix">
                <h4 class="mb-3 mt-0 float-right">234234</h4>
            </div>
            <div> <span class="ml-2 ml22">Commission to Pay</span>
            </div>
        </div>
        <div class="p-3 p3_stat_btm"></div>
        </div>
      </div>
      <div class="col-xl-4 col-md-6">
        <div class="card bg-primary mini-stat text-white">
        <div class="p-3 mini-stat-desc">
            <div class="clearfix">
                <h4 class="mb-3 mt-0 float-right">23423</h4>
            </div>
            <div>
                <span class="ml-2 ml22">Net Commission</span>
            </div>
        </div>
        <div class="p-3 p3_stat_btm"></div>
        </div>
      </div>
    </div>

  </div>
</div>

<div class="row">
<div class="col-sm-12">
<div class="page-title-box" style="padding: 0px !important;padding-bottom: 13px !important;">
<div class="row align-items-center">
    <div class="col-sm-5">
        <h4 class="page-title m-0">Tests</h4>
    </div>
    <!-- <div class="col-sm-7">
        
    </div> -->
</div>
</div>
</div>
</div>

<div class="row">
  <div class="col-xl-7">
    <div class="card">
      <div class="card-body" style="min-height: 222px;">
          <!-- <h4 class="mt-0 header-title">Patients Handled this Month</h4> -->
          <!-- <div class="row">
              <div class="col-lg-12">
                  <div id="morris-line-example" class="morris-chart" style="height: 300px"></div>
              </div>
          </div> -->
      </div>
      </div>
  </div>
  <div class="col-xl-5">
    <div class="row">
      <div class="col-xl-6 col-md-6">
        <div class="card bg-success mini-stat text-white">
        <div class="p-3 mini-stat-desc">
            <div class="clearfix">
                <h4 class="mb-3 mt-0 float-right">234234</h4>
            </div>
            <div><span class="ml-2 ml22">Verified Tests</span>
            </div>
        </div>
        <div class="p-3 p3_stat_btm"></div>
        </div>
      </div>
      <div class="col-xl-6 col-md-6">
        <div class="card bg-pink mini-stat text-white">
        <div class="p-3 mini-stat-desc">
            <div class="clearfix">
                <h4 class="mb-3 mt-0 float-right">234234</h4>
            </div>
            <div> <span class="ml-2 ml22">Pending Tests</span>
            </div>
        </div>
        <div class="p-3 p3_stat_btm"></div>
        </div>
      </div>
      <div class="col-xl-6 col-md-6">
        <div class="card bg-primary mini-stat text-white">
        <div class="p-3 mini-stat-desc">
            <div class="clearfix">
                <h4 class="mb-3 mt-0 float-right">23423</h4>
            </div>
            <div>
                <span class="ml-2 ml22">Cancelled Tests</span>
            </div>
        </div>
        <div class="p-3 p3_stat_btm"></div>
        </div>
      </div>
      <div class="col-xl-6 col-md-6">
        <div class="card bg-info mini-stat text-white" style="background-color: orange !important;">
        <div class="p-3 mini-stat-desc">
            <div class="clearfix">
              <h4 class="mb-3 mt-0 float-right">23423</h4>
            </div>
            <div> <span class="ml-2 ml22">Total Tests</span>
            </div>
        </div>
        <div class="p-3 p3_stat_btm"></div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-xl-5">
    <div class="row">
      <div class="col-xl-6 col-md-6">
        <div class="card bg-success mini-stat text-white">
        <div class="p-3 mini-stat-desc">
            <div class="clearfix">
                <h4 class="mb-3 mt-0 float-right">234234</h4>
            </div>
            <div><span class="ml-2 ml22">Pathology</span>
            </div>
        </div>
        <div class="p-3 p3_stat_btm"></div>
        </div>
      </div>
      <div class="col-xl-6 col-md-6">
        <div class="card bg-pink mini-stat text-white">
        <div class="p-3 mini-stat-desc">
            <div class="clearfix">
                <h4 class="mb-3 mt-0 float-right">234234</h4>
            </div>
            <div> <span class="ml-2 ml22">Analogy</span>
            </div>
        </div>
        <div class="p-3 p3_stat_btm"></div>
        </div>
      </div>
      <div class="col-xl-6 col-md-6">
        <div class="card bg-primary mini-stat text-white">
        <div class="p-3 mini-stat-desc">
            <div class="clearfix">
                <h4 class="mb-3 mt-0 float-right">23423</h4>
            </div>
            <div>
                <span class="ml-2 ml22">Immunology</span>
            </div>
        </div>
        <div class="p-3 p3_stat_btm"></div>
        </div>
      </div>
      <div class="col-xl-6 col-md-6">
        <div class="card bg-info mini-stat text-white" style="background-color: orange !important;">
        <div class="p-3 mini-stat-desc">
            <div class="clearfix">
              <h4 class="mb-3 mt-0 float-right">23423</h4>
            </div>
            <div> <span class="ml-2 ml22">Hematology</span>
            </div>
        </div>
        <div class="p-3 p3_stat_btm"></div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-7">
    <div class="card">
      <div class="card-body" style="min-height: 222px;">
          <!-- <h4 class="mt-0 header-title">Patients Handled this Month</h4> -->
          <!-- <div class="row">
              <div class="col-lg-12">
                  <div id="morris-line-example" class="morris-chart" style="height: 300px"></div>
              </div>
          </div> -->
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-sm-6">
    <div class="row">
      <div class="col-sm-12">
      <div class="page-title-box" style="padding: 0px !important;padding-bottom: 13px !important;">
      <div class="row align-items-center">
          <div class="col-sm-5">
              <h4 class="page-title m-0">Amount Receivable</h4>
          </div>
      </div>
      </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12">
      <div class="card">
      <div class="card-body">

      </div>
      </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="row">
      <div class="col-sm-12">
      <div class="page-title-box" style="padding: 0px !important;padding-bottom: 13px !important;">
      <div class="row align-items-center">
          <div class="col-sm-5">
              <h4 class="page-title m-0">Amount Payable</h4>
          </div>
      </div>
      </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12">
      <div class="card">
      <div class="card-body">

      </div>
      </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-sm-12">
  <div class="page-title-box" style="padding: 0px !important;padding-bottom: 13px !important;">
  <div class="row align-items-center">
      <div class="col-sm-5">
          <h4 class="page-title m-0">Inventory Stock</h4>
      </div>
  </div>
  </div>
  </div>
</div>
<div class="row">
  <div class="col-xl-5">
    <div class="row">
      <div class="col-xl-6 col-md-6">
        <div class="card bg-success mini-stat text-white">
        <div class="p-3 mini-stat-desc">
            <div class="clearfix">
                <h4 class="mb-3 mt-0 float-right">234234</h4>
            </div>
            <div><span class="ml-2 ml22">Available Kits</span>
            </div>
        </div>
        <div class="p-3 p3_stat_btm"></div>
        </div>
      </div>
      <div class="col-xl-6 col-md-6">
        <div class="card bg-pink mini-stat text-white">
        <div class="p-3 mini-stat-desc">
            <div class="clearfix">
                <h4 class="mb-3 mt-0 float-right">234234</h4>
            </div>
            <div> <span class="ml-2 ml22">Used Kits</span>
            </div>
        </div>
        <div class="p-3 p3_stat_btm"></div>
        </div>
      </div>
      <div class="col-xl-6 col-md-6">
        <div class="card bg-primary mini-stat text-white">
        <div class="p-3 mini-stat-desc">
            <div class="clearfix">
                <h4 class="mb-3 mt-0 float-right">23423</h4>
            </div>
            <div>
                <span class="ml-2 ml22">Repeat Test Kits</span>
            </div>
        </div>
        <div class="p-3 p3_stat_btm"></div>
        </div>
      </div>
      <div class="col-xl-6 col-md-6">
        <div class="card bg-info mini-stat text-white" style="background-color: orange !important;">
        <div class="p-3 mini-stat-desc">
            <div class="clearfix">
              <h4 class="mb-3 mt-0 float-right">23423</h4>
            </div>
            <div> <span class="ml-2 ml22">Repeat Ratio</span>
            </div>
        </div>
        <div class="p-3 p3_stat_btm"></div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-7">
    <div class="card">
      <div class="card-body" style="min-height: 222px;">
          <!-- <h4 class="mt-0 header-title">Patients Handled this Month</h4> -->
          <!-- <div class="row">
              <div class="col-lg-12">
                  <div id="morris-line-example" class="morris-chart" style="height: 300px"></div>
              </div>
          </div> -->
      </div>
    </div>
  </div>
</div>

<?php } ?>

</div><!-- container fluid -->


@endsection

