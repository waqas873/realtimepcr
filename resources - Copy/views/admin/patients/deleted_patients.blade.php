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

<div class="container-fluid" style="margin-top: 100px;">

<div class="row">
<div class="col-xl-12">
<div class="card">
<div class="card-body">
    <h4 class="mt-0 header-title mb-4">Deleted Patients List</h4>
    <div class="table-responsive">
        <table class="table table-hover" id="deleted_patients">
            <thead>
                <tr>
                    <th scope="col">Patient Name</th>
                    <th scope="col">Delete Date</th>
                    <th scope="col">Reason</th>
                    <th scope="col">Deleted By</th>
                    <th scope="col">Action</th>
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

<!-- Modal -->
<div class="modal fade" id="reasonModel" tabindex="-1" role="dialog" aria-labelledby="reasonLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="reasonLabel">What is the reason of update?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form id="reason-form" method="post">
            @csrf
            <div class="form-group">
              <label for="reason">Describe Reason</label>
              <textarea name="reason" class="form-control"></textarea>
              <div class="all_errors" id="reason_error"></div>
            </div>
            <button type="submit" class="btn btn-primary">Save Reason</button>
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script src="{{asset('assets/developer/admin/patients.js')}}"></script>

@endsection