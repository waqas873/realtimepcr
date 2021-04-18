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

<div class="container-fluid">

<div class="row">
  <div class="col-sm-12">
    <div class="page-title-box">
      <div class="row align-items-center">
        <div class="col-md-8">
          <h1 class="page-title m-0">Add Sub Admin</h1>
        </div>
        <!-- end col -->
      </div>
      <!-- end row -->
    </div>
    <!-- end page-title-box -->
  </div>
</div>

<div class="row">
  <div class="col-sm-12">
    <form action="" method="post" id="addForm">
      @csrf

      <div class="row">
        <div class="col-sm-6">
          <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label pformlabel">Name:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control inputs_with_bottom_border" name="name" placeholder="Enter admin name">
              <div class="all_errors name_error">
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group row">
            <label for="email" class="col-sm-2 col-form-label pformlabel">Email:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control inputs_with_bottom_border" name="email" placeholder="Enter admin email">
              <div class="all_errors email_error">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-6">
          <div class="form-group row">
            <label for="contact_no" class="col-sm-2 col-form-label pformlabel">Contact:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control inputs_with_bottom_border" name="contact_no" placeholder="Enter contact number">
              <div class="all_errors contact_no_error">
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group row">
            <label for="password" class="col-sm-2 col-form-label pformlabel">Password:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control inputs_with_bottom_border" name="password" placeholder="Enter password">
              <div class="all_errors password_error">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-6">
          <div class="form-group row">
            <label for="status" class="col-sm-2 col-form-label pformlabel">Status:</label>
            <div class="col-sm-10">
              <select class="form-control select2 inputs_with_bottom_border" name="status">
                  <option value="1">Active</option>
                  <option value="0">Inactive</option>
              </select>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-6">
          <div class="form-group row">
            <label for="patients" class="col-sm-2 col-form-label pformlabel">Patients:</label>
            <div class="col-sm-10">
              
              <div class="col-auto my-1">
                <div class="custom-control custom-checkbox mr-sm-2">
                  <input type="checkbox" name="patients_read" class="custom-control-input" id="customControlAutosizing" value="patients_read">
                  <label class="custom-control-label" for="customControlAutosizing">Read Only</label>
                </div>
              </div>
              <div class="col-auto my-1">
                <div class="custom-control custom-checkbox mr-sm-2">
                  <input type="checkbox" name="patients_read_write" class="custom-control-input" id="customControlAutosizing2" value="patients_read_write">
                  <label class="custom-control-label" for="customControlAutosizing2">Read and Write</label>
                </div>
              </div>
              <div class="col-auto my-1">
                <div class="custom-control custom-checkbox mr-sm-2">
                  <input type="checkbox" name="patients_update" class="custom-control-input" id="customControlAutosizing3" value="patients_update">
                  <label class="custom-control-label" for="customControlAutosizing3">Update</label>
                </div>
              </div>
              <div class="col-auto my-1">
                <div class="custom-control custom-checkbox mr-sm-2">
                  <input type="checkbox" name="patients_delete" class="custom-control-input" id="customControlAutosizing4" value="patients_delete">
                  <label class="custom-control-label" for="customControlAutosizing4">Delete</label>
                </div>
              </div>
              <div class="col-auto my-1">
                <div class="custom-control custom-checkbox mr-sm-2">
                  <input type="checkbox" name="patients_timing_change" class="custom-control-input" id="customControlAutosizing5" value="patients_timing_change">
                  <label class="custom-control-label" for="customControlAutosizing5">Timing Change</label>
                </div>
              </div>

            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group row">
            <label for="labs" class="col-sm-2 col-form-label pformlabel">Labs:</label>
            <div class="col-sm-10">
              
              <div class="col-auto my-1">
                <div class="custom-control custom-checkbox mr-sm-2">
                  <input type="checkbox" name="labs_read" class="custom-control-input" id="customControlAutosizing6" value="labs_read">
                  <label class="custom-control-label" for="customControlAutosizing6">Read Only</label>
                </div>
              </div>
              <div class="col-auto my-1">
                <div class="custom-control custom-checkbox mr-sm-2">
                  <input type="checkbox" name="labs_read_write" class="custom-control-input" id="customControlAutosizing7" value="labs_read_write">
                  <label class="custom-control-label" for="customControlAutosizing7">Read and Write</label>
                </div>
              </div>
              <div class="col-auto my-1">
                <div class="custom-control custom-checkbox mr-sm-2">
                  <input type="checkbox" name="labs_update" class="custom-control-input" id="customControlAutosizing8" value="labs_update">
                  <label class="custom-control-label" for="customControlAutosizing8">Update</label>
                </div>
              </div>
              <div class="col-auto my-1">
                <div class="custom-control custom-checkbox mr-sm-2">
                  <input type="checkbox" name="labs_delete" class="custom-control-input" id="customControlAutosizing9" value="labs_delete">
                  <label class="custom-control-label" for="customControlAutosizing9">Delete</label>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-6">
          <div class="form-group row">
            <label for="patients" class="col-sm-2 col-form-label pformlabel">Collection Points:</label>
            <div class="col-sm-10">
              <div class="col-auto my-1">
                <div class="custom-control custom-checkbox mr-sm-2">
                  <input type="checkbox" name="cp_read" class="custom-control-input" id="customControlAutosizing10" value="cp_read">
                  <label class="custom-control-label" for="customControlAutosizing10">Read Only</label>
                </div>
              </div>
              <div class="col-auto my-1">
                <div class="custom-control custom-checkbox mr-sm-2">
                  <input type="checkbox" name="cp_read_write" class="custom-control-input" id="customControlAutosizing11" value="cp_read_write">
                  <label class="custom-control-label" for="customControlAutosizing11">Read and Write</label>
                </div>
              </div>
              <div class="col-auto my-1">
                <div class="custom-control custom-checkbox mr-sm-2">
                  <input type="checkbox" name="cp_update" class="custom-control-input" id="customControlAutosizing12" value="cp_update">
                  <label class="custom-control-label" for="customControlAutosizing12">Update</label>
                </div>
              </div>
              <div class="col-auto my-1">
                <div class="custom-control custom-checkbox mr-sm-2">
                  <input type="checkbox" name="cp_delete" class="custom-control-input" id="customControlAutosizing13" value="cp_delete">
                  <label class="custom-control-label" for="customControlAutosizing13">Delete</label>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group row">
            <label for="labs" class="col-sm-2 col-form-label pformlabel">Labs And Cps Report:</label>
            <div class="col-sm-10">
              <div class="col-auto my-1">
                <div class="custom-control custom-checkbox mr-sm-2">
                  <input type="checkbox" name="labs_and_cp_reports_read" class="custom-control-input" id="customControlAutosizing14" value="labs_and_cp_reports_read">
                  <label class="custom-control-label" for="customControlAutosizing14">Read Only</label>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-6">
          <div class="form-group row">
            <label for="patients" class="col-sm-2 col-form-label pformlabel">App Cpanel:</label>
            <div class="col-sm-10">
              <div class="col-auto my-1">
                <div class="custom-control custom-checkbox mr-sm-2">
                  <input type="checkbox" name="app_cpanel_read" class="custom-control-input" id="customControlAutosizing15" value="app_cpanel_read">
                  <label class="custom-control-label" for="customControlAutosizing15">Read Only</label>
                </div>
              </div>
              <div class="col-auto my-1">
                <div class="custom-control custom-checkbox mr-sm-2">
                  <input type="checkbox" name="app_cpanel_permissions" class="custom-control-input" id="customControlAutosizing16" value="app_cpanel_permissions">
                  <label class="custom-control-label" for="customControlAutosizing16">Set Permissions</label>
                </div>
              </div>
              <div class="col-auto my-1">
                <div class="custom-control custom-checkbox mr-sm-2">
                  <input type="checkbox" name="app_cpanel_accounts_list" class="custom-control-input" id="customControlAutosizing17" value="app_cpanel_accounts_list">
                  <label class="custom-control-label" for="customControlAutosizing17">Accounts List</label>
                </div>
              </div>
              <div class="col-auto my-1">
                <div class="custom-control custom-checkbox mr-sm-2">
                  <input type="checkbox" name="app_cpanel_lab_tests" class="custom-control-input" id="customControlAutosizing18" value="app_cpanel_lab_tests">
                  <label class="custom-control-label" for="customControlAutosizing18">Labs Tests</label>
                </div>
              </div>
              <div class="col-auto my-1">
                <div class="custom-control custom-checkbox mr-sm-2">
                  <input type="checkbox" name="app_cpanel_srr" class="custom-control-input" id="customControlAutosizing19" value="app_cpanel_srr">
                  <label class="custom-control-label" for="customControlAutosizing19">Special Reports Requirements</label>
                </div>
              </div>
              <div class="col-auto my-1">
                <div class="custom-control custom-checkbox mr-sm-2">
                  <input type="checkbox" name="app_cpanel_add_test" class="custom-control-input" id="customControlAutosizing20" value="app_cpanel_add_test">
                  <label class="custom-control-label" for="customControlAutosizing20">Add Tests</label>
                </div>
              </div>
              <div class="col-auto my-1">
                <div class="custom-control custom-checkbox mr-sm-2">
                  <input type="checkbox" name="app_cpanel_read_test" class="custom-control-input" id="customControlAutosizing21" value="app_cpanel_read_test">
                  <label class="custom-control-label" for="customControlAutosizing21">Read Tests</label>
                </div>
              </div>
              <div class="col-auto my-1">
                <div class="custom-control custom-checkbox mr-sm-2">
                  <input type="checkbox" name="app_cpanel_update_test" class="custom-control-input" id="customControlAutosizing22" value="app_cpanel_update_test">
                  <label class="custom-control-label" for="customControlAutosizing22">Update Tests</label>
                </div>
              </div>
              <div class="col-auto my-1">
                <div class="custom-control custom-checkbox mr-sm-2">
                  <input type="checkbox" name="app_cpanel_delete_test" class="custom-control-input" id="customControlAutosizing23" value="app_cpanel_delete_test">
                  <label class="custom-control-label" for="customControlAutosizing23">Delete Tests</label>
                </div>
              </div>
              <div class="col-auto my-1">
                <div class="custom-control custom-checkbox mr-sm-2">
                  <input type="checkbox" name="app_cpanel_profile_tests" class="custom-control-input" id="customControlAutosizing24" value="app_cpanel_profile_tests">
                  <label class="custom-control-label" for="customControlAutosizing24">Profile Tests</label>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group row">
            <label for="labs" class="col-sm-2 col-form-label pformlabel">Accounts:</label>
            <div class="col-sm-10">
              <div class="col-auto my-1">
                <div class="custom-control custom-checkbox mr-sm-2">
                  <input type="checkbox" name="accounts_read" class="custom-control-input" id="customControlAutosizing25" value="accounts_read">
                  <label class="custom-control-label" for="customControlAutosizing25">Read Only</label>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-6">
          <div class="form-group row">
            <label for="patients" class="col-sm-2 col-form-label pformlabel">Inventory:</label>
            <div class="col-sm-10">
              <div class="col-auto my-1">
                <div class="custom-control custom-checkbox mr-sm-2">
                  <input type="checkbox" name="products_read" class="custom-control-input" id="customControlAutosizing26" value="products_read">
                  <label class="custom-control-label" for="customControlAutosizing26">Read Only</label>
                </div>
              </div>
              <div class="col-auto my-1">
                <div class="custom-control custom-checkbox mr-sm-2">
                  <input type="checkbox" name="products_read_write" class="custom-control-input" id="customControlAutosizing27" value="products_read_write">
                  <label class="custom-control-label" for="customControlAutosizing27">Read and Write</label>
                </div>
              </div>
              <div class="col-auto my-1">
                <div class="custom-control custom-checkbox mr-sm-2">
                  <input type="checkbox" name="products_delete" class="custom-control-input" id="customControlAutosizing28" value="products_delete">
                  <label class="custom-control-label" for="customControlAutosizing28">Delete</label>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group row">
            <label for="patients" class="col-sm-2 col-form-label pformlabel">App Users:</label>
            <div class="col-sm-10">
              <div class="col-auto my-1">
                <div class="custom-control custom-checkbox mr-sm-2">
                  <input type="checkbox" name="app_users_read" class="custom-control-input" id="customControlAutosizing29" value="app_users_read">
                  <label class="custom-control-label" for="customControlAutosizing29">Read Only</label>
                </div>
              </div>
              <div class="col-auto my-1">
                <div class="custom-control custom-checkbox mr-sm-2">
                  <input type="checkbox" name="app_users_read_write" class="custom-control-input" id="customControlAutosizing30" value="app_users_read_write">
                  <label class="custom-control-label" for="customControlAutosizing30">Read and Write</label>
                </div>
              </div>
              <div class="col-auto my-1">
                <div class="custom-control custom-checkbox mr-sm-2">
                  <input type="checkbox" name="app_users_update" class="custom-control-input" id="customControlAutosizing300" value="app_users_update">
                  <label class="custom-control-label" for="customControlAutosizing300">Update</label>
                </div>
              </div>
              <div class="col-auto my-1">
                <div class="custom-control custom-checkbox mr-sm-2">
                  <input type="checkbox" name="app_users_delete" class="custom-control-input" id="customControlAutosizing31" value="app_users_delete">
                  <label class="custom-control-label" for="customControlAutosizing31">Delete</label>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-6">
          <div class="form-group row">
            <label for="patients" class="col-sm-2 col-form-label pformlabel">Deleted Patients:</label>
            <div class="col-sm-10">
              <div class="col-auto my-1">
                <div class="custom-control custom-checkbox mr-sm-2">
                  <input type="checkbox" name="deleted_patients_read" class="custom-control-input" id="customControlAutosizing32" value="deleted_patients_read">
                  <label class="custom-control-label" for="customControlAutosizing32">Read Only</label>
                </div>
              </div>
              <div class="col-auto my-1">
                <div class="custom-control custom-checkbox mr-sm-2">
                  <input type="checkbox" name="deleted_patients_delete" class="custom-control-input" id="customControlAutosizing33" value="deleted_patients_delete">
                  <label class="custom-control-label" for="customControlAutosizing33">Delete</label>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group row">
            <label for="patients" class="col-sm-2 col-form-label pformlabel">Patient Tests:</label>
            <div class="col-sm-10">
              <div class="col-auto my-1">
                <div class="custom-control custom-checkbox mr-sm-2">
                  <input type="checkbox" name="patient_tests_read" class="custom-control-input" id="customControlAutosizing34" value="patient_tests_read">
                  <label class="custom-control-label" for="customControlAutosizing34">Read Only</label>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-6">
          <div class="form-group row">
            <label for="patients" class="col-sm-2 col-form-label pformlabel">Doctors:</label>
            <div class="col-sm-10">
              <div class="col-auto my-1">
                <div class="custom-control custom-checkbox mr-sm-2">
                  <input type="checkbox" name="doctors_read" class="custom-control-input" id="customControlAutosizing35" value="doctors_read">
                  <label class="custom-control-label" for="customControlAutosizing35">Read Only</label>
                </div>
              </div>
              <div class="col-auto my-1">
                <div class="custom-control custom-checkbox mr-sm-2">
                  <input type="checkbox" name="doctors_read_write" class="custom-control-input" id="customControlAutosizing36" value="doctors_read_write">
                  <label class="custom-control-label" for="customControlAutosizing36">Read and Write</label>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group row">
            <label for="patients" class="col-sm-2 col-form-label pformlabel">Suppliers:</label>
            <div class="col-sm-10">
              <div class="col-auto my-1">
                <div class="custom-control custom-checkbox mr-sm-2">
                  <input type="checkbox" name="suppliers_read" class="custom-control-input" id="customControlAutosizing37" value="suppliers_read">
                  <label class="custom-control-label" for="customControlAutosizing37">Read Only</label>
                </div>
              </div>
              <div class="col-auto my-1">
                <div class="custom-control custom-checkbox mr-sm-2">
                  <input type="checkbox" name="suppliers_read_write" class="custom-control-input" id="customControlAutosizing38" value="suppliers_read_write">
                  <label class="custom-control-label" for="customControlAutosizing38">Read and Write</label>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-6">
          <div class="form-group row">
            <label for="patients" class="col-sm-2 col-form-label pformlabel">Arham's API:</label>
            <div class="col-sm-10">
              <div class="col-auto my-1">
                <div class="custom-control custom-checkbox mr-sm-2">
                  <input type="checkbox" name="api_read" class="custom-control-input" id="customControlAutosizing39" value="api_read">
                  <label class="custom-control-label" for="customControlAutosizing39">Read Only</label>
                </div>
              </div>
              <div class="col-auto my-1">
                <div class="custom-control custom-checkbox mr-sm-2">
                  <input type="checkbox" name="api_read_write" class="custom-control-input" id="customControlAutosizing40" value="api_read_write">
                  <label class="custom-control-label" for="customControlAutosizing40">Read and Write</label>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group row">
            <label for="patients" class="col-sm-2 col-form-label pformlabel">Acivity History:</label>
            <div class="col-sm-10">
              <div class="col-auto my-1">
                <div class="custom-control custom-checkbox mr-sm-2">
                  <input type="checkbox" name="logs_read" class="custom-control-input" id="customControlAutosizing41" value="logs_read">
                  <label class="custom-control-label" for="customControlAutosizing41">Read Only</label>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-6">
          <div class="form-group row">
            <label for="patients" class="col-sm-2 col-form-label pformlabel">Progress Report:</label>
            <div class="col-sm-10">
              <div class="col-auto my-1">
                <div class="custom-control custom-checkbox mr-sm-2">
                  <input type="checkbox" name="progress_report_read" class="custom-control-input" id="customControlAutosizing42" value="progress_report_read">
                  <label class="custom-control-label" for="customControlAutosizing42">Read Only</label>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group row">
            <label for="patients" class="col-sm-2 col-form-label pformlabel">Invoices:</label>
            <div class="col-sm-10">
              <div class="col-auto my-1">
                <div class="custom-control custom-checkbox mr-sm-2">
                  <input type="checkbox" name="invoices_read" class="custom-control-input" id="customControlAutosizing43" value="invoices_read">
                  <label class="custom-control-label" for="customControlAutosizing43">Display</label>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-6">
          <div class="form-group row">
            <label for="patients" class="col-sm-2 col-form-label pformlabel">Dashboard:</label>
            <div class="col-sm-10">
              <div class="col-auto my-1">
                <div class="custom-control custom-checkbox mr-sm-2">
                  <input type="checkbox" name="dashboard_read" class="custom-control-input" id="customControlAutosizing44" value="dashboard_read">
                  <label class="custom-control-label" for="customControlAutosizing44">Display</label>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>


      <div class="form-group row">
        <div class="col-sm-10 offset-sm-1">
            <button type="submit" class="btn btn-primary save_btn">Save Data</button>
        </div>
      </div>
  </form>
  </div>
</div>

</div><!-- container fluid -->



</div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>

<script src="{{asset('assets/developer/admin/admins.js')}}"></script>

@endsection