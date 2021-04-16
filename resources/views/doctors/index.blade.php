@extends('layouts.admin')
@section('content')

<div class="container-fluid">

<div class="row">
<div class="col-sm-12">
<div class="page-title-box">
<div class="row align-items-center">
    <div class="col-md-8">
        <h4 class="page-title m-0">Doctors</h4>
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
    <?php 
    $permissions = permissions();
    if($permissions['role']==1 || (!empty($permissions['doctors_read_write']))){
    ?>
    <div class="row">
        <div class="col-sm-12">
         <a href="javascript::" class="btn btn-info" id="add_doctor" style="margin-bottom: 12px;">Add Doctor</a>
        </div>
    </div>
    <?php } ?>
    <h4 class="mt-0 header-title mb-4">Doctors List</h4>
    <div class="table-responsive">
        <table class="table table-hover" id="datatable">
            <thead>
                <tr>
                    <th scope="col">Doctor ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Hospital/Clinic</th>
                    <th scope="col">Affiliate Share</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @if(!empty($doctors))
                <?php $counter = count($doctors) ; ?>
                @foreach($doctors as $key=>$value)
                <tr>
                    <td>{{$counter}}</td>
                    <td>{{$value->user->name}}</td>
                    <td>{{$value->user->email}}</td>
                    <td>{{$value->hospital}}</td>
                    <td>{{$value->affiliate_share}}%</td>
                    <td>
                      <?php 
                      if($permissions['role']==1 || (!empty($permissions['doctors_read_write']))){
                      ?>
                      <a href="javascript::" class="update_id" rel="{{$value->user->id}}">View</a>
                      <?php } else {echo "-- -- ";} ?>
                       <!-- | <a href="{{url('admin/delete-test/'.$value->id)}}" class="delete_test"><i class="fa fa-trash"></i></a> --></td>
                </tr>
                <?php $counter--; ?>
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
<div class="modal fade" id="doctorsModal" tabindex="-1" role="dialog" aria-labelledby="doctorsModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content add-test-content">
      <div class="modal-header">
        <h5 class="modal-title" id="doctorssLabel">Add Doctor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form action="" method="post" id="doctors-form">
                @csrf

                <input type="hidden" name="id" value="" id="update_id">

                <div class="form-group row">
                  <label for="name" class="col-sm-3 col-form-label pformlabel">Doctor Name</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control inputs_with_bottom_border" id="name" name="name" placeholder="Enter doctor name">
                    <div class="all_errors" id="name_error">
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="email" class="col-sm-3 col-form-label pformlabel">Doctor email</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control inputs_with_bottom_border" id="email" name="email" placeholder="Enter doctor email">
                    <div class="all_errors" id="email_error">
                    </div>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="hospital" class="col-sm-3 col-form-label pformlabel">Hospital/Clinic Name</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control inputs_with_bottom_border" id="hospital" name="hospital" placeholder="Enter hospital name">
                    <div class="all_errors" id="hospital_error">
                    </div>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="contact" class="col-sm-3 col-form-label pformlabel">Contact</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control inputs_with_bottom_border" id="contact" name="contact" placeholder="Enter contact number">
                    <div class="all_errors" id="contact_error">
                    </div>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="bank_name" class="col-sm-3 col-form-label pformlabel">Bank / eWallet Name</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control inputs_with_bottom_border" id="bank_name" name="bank_name" placeholder="Enter eWallet Name number">
                    <div class="all_errors" id="bank_name_error">
                    </div>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="account_no" class="col-sm-3 col-form-label pformlabel">Bank / eWallet Account#</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control inputs_with_bottom_border" id="account_no" name="account_no" placeholder="Enter eWallet Account number">
                    <div class="all_errors" id="account_no_error">
                    </div>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="password" class="col-sm-3 col-form-label pformlabel">Password</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control inputs_with_bottom_border" id="password" name="password" placeholder="Enter password">
                    <div class="all_errors" id="password_error">
                    </div>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="affiliate_share" class="col-sm-3 col-form-label pformlabel">Affiliate Share</label>
                  <div class="col-sm-9">
                    <input type="number" class="form-control inputs_with_bottom_border" id="affiliate_share" name="affiliate_share" placeholder="Enter affiliate share">
                    <div class="all_errors"  id="affiliate_share_error">
                    </div>
                  </div>
                </div>
                
                <div class="form-group row">
                  <div class="col-sm-9 offset-sm-3">
                      <button type="submit" class="btn btn-primary save_btn">Save Doctor</button>
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

<script src="{{asset('assets/developer/doctors.js')}}"></script>

@endsection