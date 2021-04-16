<?php $layout = (Auth::user()->role==0 || Auth::user()->role==2 || Auth::user()->role==5)?'layouts.pcr':((Auth::user()->role == 1)?'layouts.admin':'layouts.lab_user'); ?>
@extends($layout)
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

<div class="container-fluid">

<form action="" method="post" id="update-form">
@csrf
<div class="row">
    <div class="col-sm-12">
        
        <div class="row">
          <div class="col-sm-12">
          <div class="page-title-box">
          <div class="row align-items-center">
              <div class="col-md-8">
                  <h1 class="page-title m-0 patient_reg_title">My Profile</h1>
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
          <div class="col-sm-6">
            <div class="form-group row">
              <label for="name" class="col-sm-2 col-form-label pformlabel">Name</label>
              <div class="col-sm-10">
                <input type="text" class="form-control inputs_with_bottom_border" id="name" value="{{$user->name}}" readonly="">
                <div class="all_errors" id="name_error">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group row">
              <label for="email" class="col-sm-2 col-form-label pformlabel">Email</label>
              <div class="col-sm-10">
                <input type="text" class="form-control inputs_with_bottom_border" id="email" value="{{$user->email}}" readonly="">
                <div class="all_errors" id="email_error">
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-6">
            <div class="form-group row">
              <label for="cnic" class="col-sm-2 col-form-label pformlabel">CNIC</label>
              <div class="col-sm-10">
                <input type="number" class="form-control inputs_with_bottom_border" id="cnic" value="{{$user->cnic}}" readonly="">
                <div class="all_errors" id="cnic_error">
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-6">
            <div class="form-group row">
              <label for="contact_no" class="col-sm-2 col-form-label pformlabel">Contact</label>
              <div class="col-sm-10">
                <input type="number" class="form-control inputs_with_bottom_border" id="contact_no" value="{{$user->contact_no}}" readonly="">
                <div class="all_errors" id="contact_no_error">
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- <div class="row">
          <div class="col-sm-6">
            <div class="form-group row">
              <label for="old_password" class="col-sm-2 col-form-label pformlabel">Old Password</label>
              <div class="col-sm-10">
                <input type="password" class="form-control inputs_with_bottom_border" id="old_password" name="old_password">
                <div class="all_errors" id="old_password_error">
                </div>
              </div>
            </div>
          </div>
        </div> -->
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group row">
              <label for="old_password" class="col-sm-2 col-form-label pformlabel">Old Password</label>
              <div class="col-sm-10">
                <input type="password" class="form-control inputs_with_bottom_border" id="old_password" name="old_password">
                <div class="all_errors" id="old_password_error">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group row">
              <label for="password" class="col-sm-2 col-form-label pformlabel">New Password</label>
              <div class="col-sm-10">
                <input type="password" class="form-control inputs_with_bottom_border" id="password" name="password">
                <div class="all_errors" id="password_error">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group row">
              <label for="password_confirmation" class="col-sm-2 col-form-label pformlabel">Confirm Password</label>
              <div class="col-sm-10">
                <input type="password" class="form-control inputs_with_bottom_border" id="password_confirmation" name="password_confirmation">
                <div class="all_errors" id="password_confirmation_error">
                </div>
              </div>
            </div>
          </div>
        </div>

    </div>
    <div class="col-sm-8 offset-sm-1">
        <button type="submit" class="btn btn-primary">Update</button>
    </div>

</div>  
<!-- end row -->
</form>

</div><!-- container fluid -->

<script src="{{asset('assets/developer/users.js')}}"></script>

@endsection