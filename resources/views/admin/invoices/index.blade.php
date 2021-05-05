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
<h4 class="page-title m-0">Invoices</h4>
</div>
<!-- end col -->
</div>
<!-- end row -->
</div>
<!-- end page-title-box -->
</div>
</div>
<!-- end page title -->

<!-- Add Assets Modal -->


</div>

<!-- container fluid -->

<script src="{{asset('assets/developer/admin/liabilities.js')}}"></script>





@endsection