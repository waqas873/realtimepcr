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
        <h4 class="page-title m-0">Ledger</h4>
    </div>
    <!-- end col -->
</div>
<!-- end row -->
</div>
<!-- end page-title-box -->
</div>
</div> <div class="col-xl-12">
    <div class="card m-b-30">
      <div class="card-body">
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#CPprofile" role="tab"><span class="d-none d-md-block">CP Ledger</span><span class="d-block d-md-none"><i class="mdi mdi-home-variant h5"></i></span></a></li>
          <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#cpReports" role="tab"><span class="d-none d-md-block">Lab Ledger</span><span class="d-block d-md-none"><i class="mdi mdi-account h5"></i></span></a></li>
          <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#prizes" role="tab"><span class="d-none d-md-block">Airlines Ledger Prizes</span><span class="d-block d-md-none"><i class="mdi mdi-email h5"></i></span></a></li>
          <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#CPLedgers" role="tab"><span class="d-none d-md-block">Embassies Ledger</span><span class="d-block d-md-none"><i class="mdi mdi-settings h5"></i></span></a></li>
          <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#Trx" role="tab"><span class="d-none d-md-block">Vendors Ledger</span><span class="d-block d-md-none"><i class="mdi mdi-settings h5"></i></span></a></li>
        </ul><!-- Tab panes -->
        <div class="tab-content">
          <div class="tab-pane active p-3" id="CPprofile" role="tabpanel">
          <div class="tab-pane active p-3" id="CPprofile" role="tabpanel">
          <div class="tab-pane active p-3" id="CPprofile" role="tabpanel">
          <div class="tab-pane active p-3" id="CPprofile" role="tabpanel">
          <div class="tab-pane active p-3" id="CPprofile" role="tabpanel">
              
          
          
          <!-- container fluid -->

<script src="{{asset('assets/developer/admin/accounts.js')}}"></script>

@endsection