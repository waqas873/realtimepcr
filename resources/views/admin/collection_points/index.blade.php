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
            <h4 class="page-title m-0">Collection Points</h4>
          </div>
          <div class="col-sm-7">
            <div class="row emdatefilter">
              <div class="col-sm-3 offset-sm-9">
                <a href="javascript::" class="btn btn-success embsearch" id="add_btn">Add New</a>
              </div>
            </div>
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
          <!-- <div class="row">
        <div class="col-sm-12">
         <a href="javascript::" class="btn btn-info" id="add_doctor" style="margin-bottom: 12px;">Add Doctor</a>
        </div>
    </div>  -->
          <h4 class="mt-0 header-title mb-4">Collection Points List</h4>
          <div class="table-responsive">
            <table class="table table-hover" id="datatable">
              <thead>
                <tr>
                  <th scope="col">Sr#</th>
                  <th scope="col">Name</th>
                  <th scope="col">Domain</th>
                  <th scope="col">Focal Person</th>
                  <th scope="col">Contact No</th>
                  <th scope="col">city</th>
                  <th scope="col">Address</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                @if(!empty($collection_points))
                @foreach($collection_points as $key=>$value)
                <tr>
                  <td>#{{$key+1}}</td>
                  <td>{{$value->name}}</td>
                  <td>
                    {{$value->domain}}
                  </td>
                  <td>
                    {{$value->focal_person}}
                  </td>
                  <td>
                    {{$value->contact_no}}
                  </td>
                  <td>
                    {{$value->city}}
                  </td>
                  <td>
                    {{$value->address}}
                  </td>
                  <td>
                    <div class="btn-group">
                      <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                      <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-126px, 35px, 0px);">
                        <a href="javascript::" class="">
                          <button class="dropdown-item" type="button">Edit</button>
                        </a>
                        <a href="javascript::" class="">
                          <button class="dropdown-item" type="button">Entries Reports</button>
                        </a>
                        <a href="javascript::" class="">
                          <button class="dropdown-item" type="button">View Profile</button>
                        </a>
                        <a href="javascript::" class="">
                          <button class="dropdown-item" type="button">Ledgers</button>
                        </a>
                        <a href="{{url('admin/delete-cp/'.$value->id)}}" class="delete_cp">
                          <button class="dropdown-item" type="button">Delete</button>
                        </a>
                      </div>
                    </div>
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
<div class="modal fade" id="addCollectionPointModal" tabindex="-1" role="dialog" aria-labelledby="addCollectionPointLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addCollectionPointLabel">Add Collection Point</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" id="add-form" method="post">
          @csrf
          <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label pformlabel">Name:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control inputs_with_bottom_border" id="name" name="name" placeholder="Enter Name">
              <div class="all_errors" id="name_error">
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label for="domain" class="col-sm-2 col-form-label pformlabel">Domain:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control inputs_with_bottom_border" id="domain" name="domain" placeholder="Enter domain">
              <div class="all_errors" id="domain_error">
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label for="focal_person" class="col-sm-2 col-form-label pformlabel">Focal Person:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control inputs_with_bottom_border" id="focal_person" name="focal_person" placeholder="Enter focal person">
              <div class="all_errors" id="focal_person_error">
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label for="contact_no" class="col-sm-2 col-form-label pformlabel">Contact No:</label>
            <div class="col-sm-10">
              <input type="number" class="form-control inputs_with_bottom_border" id="contact_no" name="contact_no" placeholder="Enter contact no">
              <div class="all_errors" id="contact_no_error">
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label for="city" class="col-sm-2 col-form-label pformlabel">City:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control inputs_with_bottom_border" id="city" name="city" placeholder="Enter city">
              <div class="all_errors" id="city_error">
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label for="address" class="col-sm-2 col-form-label pformlabel">Address:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control inputs_with_bottom_border" id="address" name="address" placeholder="Enter address">
              <div class="all_errors" id="address_error">
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

<script src="{{asset('assets/developer/admin/collection_points.js')}}"></script>

@endsection