@extends('layouts.lab_user')
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
    <div class="col-md-8">
        <h4 class="page-title m-0">Reports</h4>
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
    <h4 class="mt-0 header-title mb-4">Reports List</h4>
    <div class="table-responsive">
        <table class="table table-hover" id="datatable2">
            <thead>
                <tr>
                    <th scope="col">Invoice ID</th>
                    <th scope="col">Patient Name</th>
                    <th scope="col">Test</th>
                    <th scope="col">Result</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            {{--<tbody>
                @if(!empty($tests))
                @foreach($tests as $key=>$value)
                @if($value->invoice->status < 5)
                <tr>
                    <td>#{{$value->invoice->unique_id}}</td>
                    <td>{{$value->patient->name}}</td>
                    <td>{{$value->test->name}}</td>
                    <td>
                        <?php echo ($value->status==1)?'Detected':'Not Detected'; ?>
                    </td>
                    <td><a href="{{url('track/'.$value->invoice->unique_id)}}" class="btn btn-sm btn-success detected_or_not">View</a> | <a href="{{url('lab/revoke/'.$value->id)}}" class="btn btn-sm btn-success revoke">Revoke</a></td>
                </tr>
                @endif
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


</div><!-- container fluid -->

<script src="{{asset('assets/developer/lab_user.js')}}"></script>

@endsection