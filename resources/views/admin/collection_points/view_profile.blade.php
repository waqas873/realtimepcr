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
            <h4 class="page-title m-0">Collection Point Profile</h4>
          </div>
          <!-- end col -->
        </div>
        <!-- end row -->
      </div>
      <!-- end page-title-box -->
    </div>
  </div>
  <!-- end page title -->

  <div class="col-xl-12">
    <div class="card m-b-30">
      <div class="card-body">
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#CPprofile" role="tab"><span class="d-none d-md-block">CP Profile</span><span class="d-block d-md-none"><i class="mdi mdi-home-variant h5"></i></span></a></li>
          <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#cpReports" role="tab"><span class="d-none d-md-block">Reports</span><span class="d-block d-md-none"><i class="mdi mdi-account h5"></i></span></a></li>
          <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#prizes" role="tab"><span class="d-none d-md-block">Special Prizes</span><span class="d-block d-md-none"><i class="mdi mdi-email h5"></i></span></a></li>
          <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#CPLedgers" role="tab"><span class="d-none d-md-block">Ledgers</span><span class="d-block d-md-none"><i class="mdi mdi-settings h5"></i></span></a></li>
          <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#Trx" role="tab"><span class="d-none d-md-block">Transactions</span><span class="d-block d-md-none"><i class="mdi mdi-settings h5"></i></span></a></li>
        </ul><!-- Tab panes -->
        <div class="tab-content">
          <div class="tab-pane active p-3" id="CPprofile" role="tabpanel">
            <div class="row">
              <div class="col-sm-2">Collection Point Name :</div>
              <div class="col-sm-10"><b>{{$result->name}}</b></div>
              <div class="col-sm-2">Focal Person:</div>
              <div class="col-sm-10"><b>{{$result->focal_person}}</b></div>
              <div class="col-sm-2">Domain</div>
              <div class="col-sm-10"><b>{{$result->domain}}</b></div>
              <div class="col-sm-2">Contact: </div>
              <div class="col-sm-10"><b>{{$result->contact_no}}</b></div>
              <div class="col-sm-2">City:</div>
              <div class="col-sm-10"><b>{{$result->city}}</b></div>
              <div class="col-sm-2">Address</div>
              <div class="col-sm-10"><b>{{$result->address}}</b></div>
              <div class="col-sm-2">Registered Users:</div>
              <div class="col-sm-8"><b>{{$result->users->count()}}</b></div>
            </div>
            <hr>
            <table class="table table-borderless" id="collection_point_categories">
              <thead class="thead-dark">
                <tr>
                  <th>S.No</th>
                  <th>Departments</th>
                  <th>Discount Assigned</th>
                  <th>Prioritize Custom Prizes</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @if(!empty($result->cp_categories))
                @foreach($result->cp_categories as $key=>$value) 
                <tr>
                  <td>{{$key+1}}</td>
                  <td>{{(!empty($value->category->name))?$value->category->name:''}}</td>
                  <td>{{$value->discount_percentage}}%</td>
                  <td>{{($value->custom_prizes==1)?'Yes':'No'}}</td>
                  <td><a href="javascript::" rel="{{$value->id}}" class="cp_category_update_id">
                        Edit
                    </a></td>
                </tr>
                @endforeach
                @endif
              </tbody>
            </table>
          </div>


          <div class="tab-pane p-3" id="cpReports" role="tabpanel">

            <!-- Staff Page Content Starts here   -->
          SHOW the LAB Reports in this AREA, path: Admin\staff\patients.blade.php
            <!-- Staff Page Content ENDs here   -->
          </div>
          <div class="tab-pane p-3" id="prizes" role="tabpanel">

            <form>
              <div class="col-sm-6">
                <label for="">Select Test</label>
                <input type="" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Select Test">
              </div>
              <br>
              <div class="col-sm-6">
                <label for="">Enter Discounted Prize</label>
                <input type="" class="form-control" id="exampleInputPassword1" placeholder=" Discounted Prize">
              </div>
              <div class="col-sm-6" style="height: 100px;"> <br>
                <button type="submit" class="btn btn-light" style="width: 100%;">Save Prize</button>

              </div>

            </form>

            <div class="row">
              <table class="table table-borderless">
                <thead class="thead-dark">
                  <tr>
                    <th>S.No</th>
                    <th>Test Name</th>
                    <th>Department</th>
                    <th>Actual Prize</th>
                    <th>Discounted Prize</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td>CBC</td>
                    <td>Molecular Virology</td>
                    <td>Rs: 500%</td>
                    <td>Rs: 150</td>
                    <td>EDIT</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="tab-pane p-3" id="CPLedgers" role="tabpanel">
          Current User Ledger will be shown here
          </div>
          <div class="tab-pane p-3" id="Trx" role="tabpanel">

            <style>
              .data-card {
                padding: 10px 20px;
                border: solid 1px #e5e5e5;
                margin: 5px;
                border-radius: 5px;
              }

              .data-card h3 {
                text-align: left;
              }
            </style>
            <div class="row">
              <div class="col-sm-2 data-card">
                <h3 class="val-card">Rs:5000</h3>
                <p>Total Discount</p>
              </div>
              <div class="col-sm-2 data-card">
                <h3 class="val-card">25%</h3>
                <p>Discount Ratio</p>
              </div>
              <div class="col-sm-2 data-card">
                <h3 class="val-card" style="color: #00c169;">Rs:5000</h3>
                <p>Amount Paid</p>
              </div>
              <div class="col-sm-2 data-card">
                <h3 class="val-card" style="color: #ff000080;">Rs:5000</h3>
                <p>Amount Payable</p>
              </div>

            </div>
            <div class="row">
              <div class="col-sm-12">
                <button type="submit" class="btn btn-light float-right">Add Payment</button>
              </div>

            </div>
            <br>
            <div class="row">
              <table class="table table-borderless">
                <thead class="thead-dark">
                  <tr>
                    <th>S.No</th>
                    <th>Date</th>
                    <th>Invoice ID</th>
                    <th>Description</th>
                    <th>Payment Method</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td>11-11-1111</td>
                    <td>#225566</td>
                    <td>Description</td>
                    <td>Cash</td>
                    <td>
                      <div class="btn-group">
                        <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                        <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-126px, 35px, 0px);">
                          <a href="javascript::" class="">
                            <button class="dropdown-item" type="button">Edit</button>
                          </a>
                          <a href="" class="">
                            <button class="dropdown-item" type="button">Delete</button>
                          </a>
                        </div>
                      </div>
                    </td>

                  </tr>
                </tbody>
              </table>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- end row -->

</div><!-- container fluid -->

<!-- Modal -->
<div class="modal fade" id="updateCpCategoryModal" tabindex="-1" role="dialog" aria-labelledby="updateCpCategoryLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateCpCategoryLabel">Update Collection Point Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" id="updateCpCategoryForm" method="post">
          @csrf

          <input type="hidden" name="id" id="cp_category_id">

          <div class="form-group row">
            <label for="discount_percentage" class="col-sm-2 col-form-label pformlabel">Discount Assigned:</label>
            <div class="col-sm-10">
              <input type="number" class="form-control inputs_with_bottom_border discount_percentage" name="discount_percentage" placeholder="Enter discount percentage">
              <div class="all_errors discount_percentage_error">
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label for="custom_prizes" class="col-sm-2 col-form-label pformlabel">Prioritize Custom Price:</label>
            <div class="col-sm-10">
              <select class="form-control select2 inputs_with_bottom_border custom_prizes" name="custom_prizes">
                <option value="1">Yes</option>
                <option value="0">No</option>
              </select>
              <div class="all_errors custom_prizes_error">
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