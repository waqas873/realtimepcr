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
        <h4 class="page-title m-0">Suppliers</h4>
    </div>
    <?php 
    $permissions = permissions();
    if($permissions['role']==1 || (!empty($permissions['suppliers_read_write']))){
    ?>
    <div class="col-sm-7">
        <div class="row emdatefilter">
            <div class="col-sm-3 offset-sm-9">
                <a href="javascript::" class="btn btn-success embsearch" id="addBtn">Add New</a>
            </div>
        </div>
    </div>
    <?php } ?>
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
    <!-- <div class="row">
        <div class="col-sm-12">
         <a href="javascript::" class="btn btn-info" id="add_doctor" style="margin-bottom: 12px;">Add Doctor</a>
        </div>
    </div>  -->
    <h4 class="mt-0 header-title mb-4">Suppliers List</h4>
    <div class="table-responsive">
        <table class="table table-hover" id="datatable">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Shop Name</th>
                    <th scope="col">Contact</th>
                    <th scope="col">city</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @if(!empty($list))
                @foreach($list as $key=>$value)
                <tr>
                    <td>{{$value->name}}</td>
                    <td>
                      {{$value->email}}  
                    </td>
                    <td>
                      {{$value->shop_name}}  
                    </td>
                    <td>
                      {{$value->contact}}  
                    </td>
                    <td>
                      {{$value->city}}  
                    </td>
                    <td>
                      <?php if($permissions['role']==1 || (!empty($permissions['suppliers_read_write']))){ ?>
                      <a href="javascript::" rel="{{$value->id}}" class="update_id">Edit</a> 
                    <?php } else{echo "-- --";}?>
                      <!-- <a href=""><i class="fa fa-trash"></i> </a> -->
                    </td>
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

<!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addCollectionPointLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addCollectionPointLabel">Add Supplier</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form action="" id="addForm" method="post">
              @csrf

              <input type="hidden" name="id" value="" id="supplier_id">

              <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label pformlabel">Name:</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control inputs_with_bottom_border" id="name" name="name" placeholder="Enter Name">
                  <div class="all_errors name_error">
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label pformlabel">Email:</label>
                <div class="col-sm-10">
                  <input type="email" class="form-control inputs_with_bottom_border" id="email" name="email" placeholder="Enter email">
                  <div class="all_errors email_error">
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label for="shop_name" class="col-sm-2 col-form-label pformlabel">Shop Name:</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control inputs_with_bottom_border" id="shop_name" name="shop_name" placeholder="Enter shop name">
                  <div class="all_errors shop_name_error">
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label for="contact" class="col-sm-2 col-form-label pformlabel">Contact:</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control inputs_with_bottom_border" id="contact" name="contact" placeholder="Enter contact">
                  <div class="all_errors contact_error">
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label for="city" class="col-sm-2 col-form-label pformlabel">City:</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control inputs_with_bottom_border" id="city" name="city" placeholder="Enter city">
                  <div class="all_errors city_error">
                  </div>
                </div>
              </div>
              <div class="form-group row">
                  <label for="bank_name" class="col-sm-2 col-form-label pformlabel">Bank / eWallet Name</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control inputs_with_bottom_border" id="bank_name" name="bank_name" placeholder="Enter eWallet Name number">
                    <div class="all_errors" id="bank_name_error">
                    </div>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="account_no" class="col-sm-2 col-form-label pformlabel">Bank / eWallet Account#</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control inputs_with_bottom_border" id="account_no" name="account_no" placeholder="Enter eWallet Account number">
                    <div class="all_errors" id="account_no_error">
                    </div>
                  </div>
                </div>

              <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label pformlabel"></label>
                <div class="col-sm-10">
                  <button type="submit" class="btn btn-primary">Save Data</button>
                </div>
              </div>
            </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script src="{{asset('assets/developer/admin/suppliers.js')}}"></script>

@endsection