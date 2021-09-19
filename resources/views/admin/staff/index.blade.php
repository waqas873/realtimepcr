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
            <h4 class="page-title m-0">Lab Employees</h4>
          </div>
          <?php
          $permissions = permissions();
          if ($permissions['role'] == 1 || (!empty($permissions['app_users_read_write']))) {
          ?>
            <div class="col-sm-7">
              <div class="row emdatefilter">
                <div class="col-sm-3 offset-sm-9">
                  <a href="javascript::" class="btn btn-success embsearch" id="add_lab_user">Add New</a>
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
          <h4 class="mt-0 header-title mb-4">Lab Employees List</h4>
          <div class="table-responsive">
            <table class="table table-hover" id="datatable">
              <thead>
                <tr>
                  <th scope="col">Sr#</th>
                  <th scope="col">Name</th>
                  <th scope="col">Email</th>
                  <th scope="col">CNIC</th>
                  <th scope="col">Contact No</th>
                  <th scope="col">Pay</th>
                  <th scope="col">User Type</th>
                  <th scope="col">Lab</th>
                  <th scope="col">Account Status</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                @if(!empty($lab_users))
                @foreach($lab_users as $key=>$value)
                <tr>
                  <td>#{{$key+1}}</td>
                  <td>{{$value->name}}</td>
                  <td>{{$value->email}}</td>
                  <td>{{$value->cnic}}</td>
                  <td>{{$value->contact_no}}</td>
                  <td>{{$value->pay}}</td>
                  <td>
                    <?php echo ($value->role == 0) ? 'Receptionist' : 'Lab User'; ?>
                  </td>
                  <td><?php echo (!empty($value->lab->name)) ? $value->lab->name : '---'; ?></td>
                  <td>
                    <div class="col-sm-5">
                      <button type="button" class="btn btn-xs btn-toggle active" data-toggle="button" aria-pressed="true" autocomplete="off">
                        <div class="handle"></div>
                      </button>
                    </div>
                  </td>
                  <td>
                    <?php if ($permissions['role'] == 1 || (!empty($permissions['app_users_update']))) { ?>
                      <a href="javascript::" class="">View</a>
                    <?php
                    } else {
                      echo "-- --";
                    }
                    ?>
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

  <?php if ($permissions['role'] == 1 || (!empty($permissions['app_users_read_write']))) { ?>
    <div class="row">
      <div class="col-sm-12">
        <div class="row emdatefilter">
          <div class="col-sm-3 offset-sm-9">
            <a href="javascript::" class="btn btn-success embsearch" id="add_cp_user">Add New User</a>
          </div>
        </div>
      </div>
    </div>
  <?php } ?>

  <div class="row">
    <div class="col-sm-12">
      <div class="page-title-box">
        <div class="row align-items-center">
          <div class="col-sm-5">
            <h4 class="page-title m-0">Collection Points Operators</h4>
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
          <h4 class="mt-0 header-title mb-4">Collection Points Operators List</h4>
          <div class="table-responsive">
            <table class="table table-hover" id="datatable2">
              <thead>
                <tr>
                  <th scope="col">Sr#</th>
                  <th scope="col">Name</th>
                  <th scope="col">Email</th>
                  <th scope="col">Contact No</th>
                  <th scope="col">Collection Point</th>
                  <th scope="col">Account Status</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                @if(!empty($cp_users))
                @foreach($cp_users as $key=>$value)
                <tr>
                  <td>#{{$key+1}}</td>
                  <td>{{$value->name}}</td>
                  <td>{{$value->email}}</td>
                  <td>{{$value->contact_no}}</td>
                  <td><?php echo (!empty($value->collection_point->name)) ? $value->collection_point->name : '---'; ?></td>
                  <td>
                    <div class="col-sm-5">
                      <button type="button" class="btn btn-xs btn-toggle active" data-toggle="button" aria-pressed="true" autocomplete="off">
                        <div class="handle"></div>
                      </button>
                    </div>
                  </td>
                  <td>
                    <?php if ($permissions['role'] == 1 || (!empty($permissions['app_users_update']))) { ?>
                      <a href="javascript::" class="">View | </a>
                    <?php
                    } else {
                      echo "-- -- | ";
                    }
                    ?>
                    <?php if ($permissions['role'] == 1 || (!empty($permissions['app_users_delete']))) { ?>
                      <a href="{{url('admin/delete-user/'.$value->id)}}" class="delete_user"><i class="fa fa-trash"></i> </a>
                    <?php
                    } else {
                      echo "-- --";
                    }
                    ?>
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

  <div class="row">
    <div class="col-sm-12">
      <div class="page-title-box">
        <div class="row align-items-center">
          <div class="col-sm-5">
            <h4 class="page-title m-0">Embassy Users</h4>
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
          <h4 class="mt-0 header-title mb-4">Embassy Users List</h4>
          <div class="table-responsive">
            <table class="table table-hover" id="datatable3">
              <thead>
                <tr>
                  <th scope="col">Sr#</th>
                  <th scope="col">Name</th>
                  <th scope="col">Email</th>
                  <th scope="col">Contact No</th>
                  <th scope="col">Account Status</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                @if(!empty($embassy_users))
                @foreach($embassy_users as $key=>$value)
                <tr>
                  <td>#{{$key+1}}</td>
                  <td>{{$value->name}}</td>
                  <td>{{$value->email}}</td>
                  <td>{{$value->contact_no}}</td>
                  <td>
                    <div class="col-sm-5">
                      <button type="button" class="btn btn-xs btn-toggle active" data-toggle="button" aria-pressed="true" autocomplete="off">
                        <div class="handle"></div>
                      </button>
                    </div>
                  </td>
                  <td>
                    <?php if ($permissions['role'] == 1 || (!empty($permissions['app_users_update']))) { ?>
                      <a href="{{url('admin/embassy-profile/'.$value->id)}}" class="">View | </a>
                    <?php
                    } else {
                      echo "-- -- | ";
                    }
                    ?>
                    <?php if ($permissions['role'] == 1 || (!empty($permissions['app_users_delete']))) { ?>
                      <a href="{{url('admin/delete-user/'.$value->id)}}" class="delete_user"><i class="fa fa-trash"></i> </a>
                    <?php
                    } else {
                      echo "-- --";
                    }
                    ?>
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

  <div class="row">
    <div class="col-sm-12">
      <div class="page-title-box">
        <div class="row align-items-center">
          <div class="col-sm-5">
            <h4 class="page-title m-0">Airline Users</h4>
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
          <h4 class="mt-0 header-title mb-4">Airline Users List</h4>
          <div class="table-responsive">
            <table class="table table-hover" id="datatable4">
              <thead>
                <tr>
                  <th scope="col">Sr#</th>
                  <th scope="col">Name</th>
                  <th scope="col">Email</th>
                  <th scope="col">Contact No</th>
                  <th scope="col">Airline</th>
                  <th scope="col">Account Status</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                @if(!empty($airline_users))
                @foreach($airline_users as $key=>$value)
                <tr>
                  <td>#{{$key+1}}</td>
                  <td>{{$value->name}}</td>
                  <td>{{$value->email}}</td>
                  <td>{{$value->contact_no}}</td>
                  <td><?php echo (!empty($value->airline->name)) ? $value->airline->name : '---'; ?></td>
                  <td>
                    <div class="col-sm-5">
                      <button type="button" class="btn btn-xs btn-toggle active" data-toggle="button" aria-pressed="true" autocomplete="off">
                        <div class="handle"></div>
                      </button>
                    </div>
                  </td>
                  <td>
                    <?php if ($permissions['role'] == 1 || (!empty($permissions['app_users_update']))) { ?>
                      <a href="{{url('admin/airline-profile/'.$value->id)}}" class="">View | </a>
                    <?php
                    } else {
                      echo "-- -- | ";
                    }
                    ?>
                    <?php if ($permissions['role'] == 1 || (!empty($permissions['app_users_delete']))) { ?>
                      <a href="{{url('admin/delete-user/'.$value->id)}}" class="delete_user"><i class="fa fa-trash"></i> </a>
                    <?php
                    } else {
                      echo "-- --";
                    }
                    ?>
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
<div class="modal fade" id="addLabUserModal" tabindex="-1" role="dialog" aria-labelledby="addLabUserLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addLabUserLabel">Add Lab Employee</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" id="add-lab-user-form" method="post">
          @csrf
          <div class="form-group row">
            <label for="lab_id" class="col-sm-2 col-form-label pformlabel">Lab:</label>
            <div class="col-sm-4">
              <select class="form-control  " id="lab_id" name="lab_id">
                <option value="">Select here</option>
                @if(!empty($labs))
                @foreach($labs as $record)
                <option value="{{$record->id}}">{{$record->name}}</option>
                @endforeach
                @endif
              </select>
              <div class="all_errors" id="lab_id_error">
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label for="role" class="col-sm-2 col-form-label pformlabel">User Type:</label>
            <div class="col-sm-4">
              <select class="form-control  " id="role" name="role">
                <option value="">Select Type</option>
                <option value="0">Receptionist</option>
                <option value="4">Lab User</option>
              </select>
              <div class="all_errors" id="role_error">
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label pformlabel">Full Name:</label>
            <div class="col-sm-4">
              <input type="text" class="form-control " id="name" name="name" placeholder="Enter name">
              <div class="all_errors" id="name_error">
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label for="cnic" class="col-sm-2 col-form-label pformlabel">CNIC:</label>
            <div class="col-sm-4">
              <input type="number" class="form-control " id="cnic" name="cnic" placeholder="Enter CNIC">
              <div class="all_errors" id="cnic_error">
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label for="contact_no" class="col-sm-2 col-form-label pformlabel">Contact No:</label>
            <div class="col-sm-4">
              <input type="number" class="form-control " id="contact_no" name="contact_no" placeholder="Enter contact no">
              <div class="all_errors" id="contact_no_error">
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label for="pay" class="col-sm-2 col-form-label pformlabel">Basic Pay:</label>
            <div class="col-sm-4">
              <input type="number" class="form-control " id="pay" name="pay" placeholder="Enter pay">
              <div class="all_errors" id="pay_error">
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label for="username" class="col-sm-2 col-form-label pformlabel">Username:</label>
            <div class="col-sm-4">
              <input type="text" class="form-control " id="username" name="username" placeholder="Enter username">
              <div class="all_errors" id="username_error">
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label for="password" class="col-sm-2 col-form-label pformlabel">Password:</label>
            <div class="col-sm-4">
              <input type="text" class="form-control " id="password" name="password" placeholder="Enter password">
              <div class="all_errors" id="password_error">
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

<!-- Modal -->
<div class="modal fade" id="addCpUserModal" role="dialog" aria-labelledby="addCpUserLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addCpUserLabel">Add New User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" id="add-user-form" method="post">
          @csrf
          <div class="form-group row">
            <label for="user_type" class="col-sm-2 col-form-label pformlabel">Select User Type:</label>
            <div class="col-sm-10" style="padding-top: 10px;">
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="customRadioInline1" name="cp_role" class="custom-control-input cp_role" value="5">
                <label class="custom-control-label" for="customRadioInline1">Collection Point</label>
              </div>
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="customRadioInline2" name="cp_role" class="custom-control-input cp_role" value="3">
                <label class="custom-control-label" for="customRadioInline2">Embassy</label>
              </div>
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="customRadioInline3" name="cp_role" class="custom-control-input cp_role" value="6">
                <label class="custom-control-label" for="customRadioInline3">Airline</label>
              </div>
              <div class="all_errors" id="cp_role_error">
              </div>
            </div>
          </div>
          <div class="form-group row" id="cp_row">
            <label for="collection_point_id" class="col-sm-2 col-form-label pformlabel">Collection Point:</label>
            <div class="col-sm-10">
              <select class="form-control  " id="collection_point_id" name="collection_point_id">
                <!-- <option value="">Select here</option> -->
                @if(!empty($collection_points))
                @foreach($collection_points as $record)
                <option value="{{$record->id}}">{{$record->name}}</option>
                @endforeach
                @endif
              </select>
              <div class="all_errors" id="cp_collection_point_id_error">
              </div>
            </div>
          </div>
          <div class="form-group row" id="airline_row">
            <label for="airline_id" class="col-sm-2 col-form-label pformlabel">Airlines:</label>
            <div class="col-sm-10">
              <select class="form-control  " id="airline_id" name="airline_id">
                <!-- <option value="">Select here</option> -->
                @if(!empty($airlines))
                @foreach($airlines as $record)
                <option value="{{$record->id}}">{{$record->name}}</option>
                @endforeach
                @endif
              </select>
              <div class="all_errors" id="cp_airline_id_error">
              </div>
            </div>
          </div>
          <div class="form-group row" id="countries_row">
            <label for="country_id" class="col-sm-2 col-form-label pformlabel">Select Country:</label>
            <div class="col-sm-10">
              <select class="form-control  " id="country_id" name="country_id">
                <!-- <option value="">Select here</option> -->
                @if(!empty($countries))
                @foreach($countries as $record)
                <option value="{{$record->id}}">{{$record->name}}</option>
                @endforeach
                @endif
              </select>
              <div class="all_errors" id="cp_country_id_error">
              </div>
            </div>
          </div>
          <div class="form-group row" id="tests_row">
            <label for="test_id" class="col-sm-2 col-form-label pformlabel">Select Test:</label>
            <div class="col-sm-10">
              <select class="form-control  " id="test_id" name="test_id">
                <!-- <option value="">Select here</option> -->
                @if(!empty($tests))
                @foreach($tests as $record)
                <option value="{{$record->id}}">{{$record->name}}</option>
                @endforeach
                @endif
              </select>
              <div class="all_errors" id="cp_test_id_error">
              </div>
            </div>
          </div>
          <div class="form-group row" id="domain_row">
            <label for="ae_domain" class="col-sm-2 col-form-label pformlabel">Domain:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control " id="ae_domain" value="realtimepcr.pk" readonly="">
            </div>
          </div>
          <div class="form-group row">
            <label for="cp_name" class="col-sm-2 col-form-label pformlabel">Full Name:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control " id="cp_name" name="name" placeholder="Enter name">
              <div class="all_errors" id="cp_name_error">
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label for="cp_contact_no" class="col-sm-2 col-form-label pformlabel">Contact No:</label>
            <div class="col-sm-10">
              <input type="number" class="form-control " id="cp_contact_no" name="contact_no" placeholder="Enter contact no">
              <div class="all_errors" id="cp_contact_no_error">
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label for="cp_username" class="col-sm-2 col-form-label pformlabel">Username:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control " id="cp_username" name="username" placeholder="Enter username">
              <div class="all_errors" id="cp_username_error">
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label for="cp_password" class="col-sm-2 col-form-label pformlabel">Password:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control " id="cp_password" name="password" placeholder="Enter password">
              <div class="all_errors" id="cp_password_error">
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

<script src="{{asset('assets/developer/admin/staff.js')}}"></script>

@endsection