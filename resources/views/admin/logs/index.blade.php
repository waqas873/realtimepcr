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
                    <div class="col-sm-6">
                        <h4 class="page-title m-0">Activity History</h4>
                    </div>
                    <div class="">
                        Filter By:
                    </div>
                    <div class="col-sm-5">
                        <select class="form-control" aria-label="Default select example">
                            <option selected="">Anwar {Admin}</option>
                            <option value="1">Anwar {SubAdmin}</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
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
                    <div class="col-sm-12">
                        <h4 class="mt-0 header-title">Activity List</h4>
                        <button type="button" class="btn btn-danger float-right mb-3">Delete All Records</button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover" id="datatable">
                            <thead>
                                <tr>
                                    <th scope="col">User</th>
                                    <th scope="col">Activity</th>
                                    <th scope="col">Reason</th>
                                    <th scope="col">Patient Name</th>
                                    <th scope="col">Date</th>
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

<script src="{{asset('assets/developer/admin/logs.js')}}"></script>

@endsection