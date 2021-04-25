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
                        <h4 class="page-title m-0">Assets / Liabilities</h4>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end page-title-box -->
        </div>
    </div>
    <!-- end page title -->

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

    <div class="row">

        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h6>Assets </h6>



                    <div class="row">
                        <div class="col-5 data-card">
                            <h3 class="val-card">Rs:50000</h3>
                            <p>Current Assets</p>
                        </div>
                        <div class="col-5 data-card">
                            <h3 class="val-card">Rs:25000</h3>
                            <p>Non-Current Assets</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12"><button type="button" class="btn btn-light float-right" style="margin: 10px;">Add Assets</button></div>
                    </div>
                    <div class="row">
                        <table class="table table-borderless">
                            <thead class="thead-dark">
                                <tr>
                                    <th>S.No</th>
                                    <th>Asset Name</th>
                                    <th>Asset Value</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>----</td>
                                    <td>-------</td>
                                    <td>-------</td>

                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                            <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-126px, 35px, 0px);">
                                                <a href="javascript::" class="">
                                                    <button class="dropdown-item" type="button">Edit</button>
                                                </a>
                                                <a href="" class="">
                                                    <button class="dropdown-item" type="button">Delete</button>
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

        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h6>Liability </h6>



                    <div class="row">
                        <div class="col-5 data-card">
                            <h3 class="val-card">Rs:50000</h3>
                            <p>Current Liabilities</p>
                        </div>
                        <div class="col-5 data-card">
                            <h3 class="val-card">Rs:25000</h3>
                            <p>Non-Current Liabilities</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12"><button type="button" class="btn btn-light float-right" style="margin: 10px;">Add Liability</button></div>
                    </div>
                    <div class="row">
                        <table class="table table-borderless">
                            <thead class="thead-dark">
                                <tr>
                                    <th>S.No</th>
                                    <th>Liability Name</th>
                                    <th>Liability Value</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>----</td>
                                    <td>-------</td>
                                    <td>-------</td>

                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                            <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-126px, 35px, 0px);">
                                                <a href="javascript::" class="">
                                                    <button class="dropdown-item" type="button">Edit</button>
                                                </a>
                                                <a href="" class="">
                                                    <button class="dropdown-item" type="button">Delete</button>
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
    </div>
</div>

<!-- container fluid -->

<script src="{{asset('assets/developer/admin/accounts.js')}}"></script>





@endsection