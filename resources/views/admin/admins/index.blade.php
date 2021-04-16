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
    <div class="col-md-8">
        <h4 class="page-title m-0">Sub Admins</h4>
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
    <div class="row">
        <div class="col-sm-12">
         <a href="{{url('admin/add-admin')}}" class="btn btn-info" style="margin-bottom: 12px;">Add Sub Admin</a>
        </div>
    </div>
    <h4 class="mt-0 header-title mb-4">Sub Admins List</h4>
    <div class="table-responsive">
        <table class="table table-hover" id="datatable">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Contact</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @if(!empty($admins))
                @foreach($admins as $key=>$value)
                <tr>
                    <td>{{$value->name}}</td>
                    <td>{{$value->email}}</td>
                    <td>{{$value->contact_no}}</td>
                    <td><a href="{{url('admin/update-admin/'.createBase64($value->id))}}">View</a> <!-- | <a href="{{url('admin/delete-test/'.$value->id)}}" class="delete_test"><i class="fa fa-trash"></i></a> --></td>
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
<!-- end row -->


</div><!-- container fluid -->


<script src="{{asset('assets/developer/admin/admins.js')}}"></script>

@endsection