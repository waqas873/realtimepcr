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
<style>
        .data-card {
            padding: 10px 20px;
            border: solid 1px #e5e5e5;
            margin: 5px;
            border-radius: 5px;
        }

        .data-card h3 {
            text-align: left;
        }
    </style>
<!-- cash user wallets page -->

<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-sm-5">
                    <h4 class="page-title m-0">Cash User Wallets</h4>
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
    <div class="card">

        <div class="card-body">
        <div class="row">
                        <div class="col-3 data-card">
                            <h3 class="val-card">Rs:50000</h3>
                            <p>My Account Balance</p>
                        </div>
                        <div class="col-3 data-card">
                            <h3 class="val-card">Rs:25000</h3>
                            <p>Cash with Users</p>
                        </div>
                        
                    </div>

            <table class="table table-borderless">
                <thead class="thead-dark">
                    <tr>
                        <th>S.No</th>
                        <th>Name</th>
                        <th>User Type</th>
                        <th>Associated LAB</th>
                        <th>Total Cash</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>----</td>

                        <td>User Name </td>
                        <td>Admin / Receptionist</td>
                        <td>RealtimePCR peshawar</td>
                        <td>-------</td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-126px, 35px, 0px);">
                                    <a href="javascript::" class="">
                                        <button class="dropdown-item" type="button">Collect Cash</button>
                                    </a>
                                    <a href="" class="">
                                        <button class="dropdown-item" type="button">Transfer Amount</button>
                                    </a>
                                </div>
                            </div>
                        </td>

                    </tr>
                </tbody>
            </table>

        </div>
    </div>
    </div>
</div>

<script src="{{asset('assets/developer/admin/accounts.js')}}"></script>

@endsection