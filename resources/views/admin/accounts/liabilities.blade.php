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
                    <div class="col-sm-7">
                        <button type="button" class="btn btn-light float-right" style="margin: 10px;" data-toggle="modal" data-target="#addModal">Add Assets & Liabilities</button>
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
            border: none;
            margin: 5px;
            border-radius: 5px;
        }

        .data-card h3 {
            text-align: left;
        }

        .row {
            margin: auto;
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
                        <table class="table table-borderless">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Type</th>
                                    <th>Asset Name</th>
                                    <th>Asset Value</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Current</td>
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
                        <table class="table table-borderless">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Type</th>
                                    <th>Liability Name</th>
                                    <th>Liability Value</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Non-Current/td>
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


    <!-- Add Assets Modal -->


    <!-- Add Assets / Liabilities Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Assets / Liabilities</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">


                    <form>
                        <div class="form-group">
                            <label for="mainType">Select Main Type</label>
                            <select class="form-control" id="mainType">
                                <option>Assets</option>
                                <option>Liabilities</option>
                            </select>
                            <small id="mainType" class="form-text text-muted">You can choose the main type e.g: Assets / Liabilities.</small>
                        </div>
                        <div class="form-group">
                            <label for="subType">Select Sub Type</label>
                            <select class="form-control" id="subType">
                                <option>Current</option>
                                <option>non-Current</option>
                            </select>
                            <small id="subType" class="form-text text-muted">You can choose the sub type e.g: current / Non-Current.</small>
                        </div>
                        <div class="form-group">
                            <label for="assetName">Name</label>
                            <input type="text" class="form-control" id="assetName" aria-describedby="assetName" placeholder="Enter Name">
                            <small id="assetName" class="form-text text-muted">Enter name of the Asset OR Liability in this field.</small>
                        </div>
                        <div class="form-group">
                            <label for="assetVal">Enter Value</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Rs:</div>
                                </div>
                                <input type="text" class="form-control" id="assetVal" placeholder="Enter Value">
                            </div>

                            <small id="assetVal" class="form-text text-muted">Enter Value of the Asset OR Liability in PKR e.g: Rs:2500.</small>
                        </div>


                        <button type="submit" class="btn btn-primary btn-lg btn-block">Submit</button>
                    </form>


                </div>
            </div>
        </div>
    </div>
</div>

<!-- container fluid -->

<script src="{{asset('assets/developer/admin/accounts.js')}}"></script>





@endsection