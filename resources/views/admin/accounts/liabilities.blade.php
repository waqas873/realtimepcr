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
<button type="button" class="btn btn-light float-right" style="margin: 10px;" id="addButton">Add Assets & Liabilities</button>
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
<h3 class="val-card">Rs:{{$current_assets}}</h3>
<p>Current Assets</p>
</div>
<div class="col-5 data-card">
<h3 class="val-card">Rs:{{$non_current_assets}}</h3>
<p>Non-Current Assets</p>
</div>
</div>

<div class="row">
<table class="table table-borderless" id="datatable">
<thead class="thead-dark">
    <tr>
        <th>Type</th>
        <th>Asset Name</th>
        <th>Asset Value</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
    @if(!empty($records))
    @foreach($records as $key=>$value)
    @if($value->type==1)
    <tr>
        <td><?php echo ($value->sub_type==1)?'Current':'Non-Current'; ?></td>
        <td><?php echo $value->name; ?></td>
        <td>Rs: <?php echo $value->value; ?></td>
        <td>
            <div class="btn-group">
                <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-126px, 35px, 0px);">
                    <a href="javascript::" rel="{{$value->id}}" class="update_id">
                        <button class="dropdown-item" type="button">Edit</button>
                    </a>
                    <a href="{{url('admin/delete-liability/'.$value->id)}}" class="delete">
                        <button class="dropdown-item" type="button">Delete</button>
                    </a>
                </div>
            </div>
        </td>
    </tr>
    @endif
    @endforeach
    @endif
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
<h3 class="val-card">Rs:{{$current_liabilities}}</h3>
<p>Current Liabilities</p>
</div>
<div class="col-5 data-card">
<h3 class="val-card">Rs:{{$non_current_liabilities}}</h3>
<p>Non-Current Liabilities</p>
</div>
</div>

<div class="row">
<table class="table table-borderless" id="datatable2">
<thead class="thead-dark">
    <tr>
        <th>Type</th>
        <th>Liability Name</th>
        <th>Liability Value</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
    @if(!empty($records))
    @foreach($records as $key=>$value)
    @if($value->type==2)
    <tr>
        <td><?php echo ($value->sub_type==1)?'Current':'Non-Current'; ?></td>
        <td><?php echo $value->name; ?></td>
        <td>Rs: <?php echo $value->value; ?></td>
        <td>
            <div class="btn-group">
                <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-126px, 35px, 0px);">
                    <a href="javascript::" rel="{{$value->id}}" class="update_id">
                        <button class="dropdown-item" type="button">Edit</button>
                    </a>
                    <a href="{{url('admin/delete-liability/'.$value->id)}}" class="delete">
                        <button class="dropdown-item" type="button">Delete</button>
                    </a>
                </div>
            </div>
        </td>
    </tr>
    @endif
    @endforeach
    @endif
</tbody>
</table>
</div>


</div>
</div>
</div>
</div>


<!-- Add Assets Modal -->


<!-- Add Assets / Liabilities Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="addModalLabel">Add Assets / Liabilities</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">

<form id="addForm">
@csrf

<input type="hidden" name="id" value="" id="liability_id">

<div class="form-group">
<label for="mainType">Select Main Type</label>
<select name="type" class="form-control select2 type" id="mainType">
    <option value="">Select here</option>
    <option value="1">Assets</option>
    <option value="2">Liabilities</option>
</select>
<div class="all_errors type_error"></div>
</div>
<div class="form-group">
<label for="subType">Select Sub Type</label>
<select name="sub_type" class="form-control select2 sub_type" id="subType">
    <option value="">Select here</option>
    <option value="1">Current</option>
    <option value="2">non-Current</option>
</select>
<div class="all_errors sub_type_error"></div>
</div>
<div class="form-group">
<label for="assetName">Name</label>
<input name="name" type="text" class="form-control name" id="assetName" aria-describedby="assetName" placeholder="Enter Name">
<div class="all_errors name_error"></div>
</div>
<div class="form-group">
<label for="assetVal">Enter Value</label>
<div class="input-group mb-2">
    <div class="input-group-prepend">
        <div class="input-group-text">Rs:</div>
    </div>
    <input name="value" type="number" class="form-control value" id="assetVal" placeholder="Enter Value">
</div>
<div class="all_errors value_error"></div>
</div>
<button type="submit" class="btn btn-primary btn-lg btn-block">Submit</button>
</form>
</div>
</div>
</div>
</div>


</div>

<!-- container fluid -->

<script src="{{asset('assets/developer/admin/liabilities.js')}}"></script>





@endsection