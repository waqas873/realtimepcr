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

 <!-- Doctors Profile -->

  <div class="container-fluid">

    <div class="row">
      <div class="col-sm-12">
        <div class="page-title-box">
          <div class="row align-items-center">
            <div class="col-sm-5">
              <h4 class="page-title m-0">Doctors Profile</h4>
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
            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#docProfile" role="tab"><span class="d-none d-md-block">Doctor Profile</span><span class="d-block d-md-none"><i class="mdi mdi-home-variant h5"></i></span></a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#prizes" role="tab"><span class="d-none d-md-block">Special Prizes</span><span class="d-block d-md-none"><i class="mdi mdi-email h5"></i></span></a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#Trx" role="tab"><span class="d-none d-md-block">Transactions</span><span class="d-block d-md-none"><i class="mdi mdi-settings h5"></i></span></a></li>
          </ul><!-- Tab panes -->
          <div class="tab-content">
            <div class="tab-pane active p-3" id="docProfile" role="tabpanel">

              <div class="row">
                <div class="col-sm-2">Doctor Name :</div>
                <div class="col-sm-10"><b>{{$result->user->name}}</b></div>
                <div class="col-sm-2">Email</div>
                <div class="col-sm-10"><b>{{$result->user->email}}</b></div>
                <div class="col-sm-2">Clinic Name</div>
                <div class="col-sm-10"><b>{{$result->hospital}}</b></div>
                <div class="col-sm-2">Contact: </div>
                <div class="col-sm-10"><b>{{$result->contact}}</b></div>
                <div class="col-sm-2">Ledgers:</div>
                <div class="col-sm-10">
                  <a href="{{url('admin/accounts/ledgers/doctor/'.$result->id)}}">Click here to view ledger</a>
                </div>
              </div>

              <hr>
              <table class="table table-borderless">
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
                  @if(!empty($result->doctor_categories))
                  @foreach($result->doctor_categories as $key=>$value)
                  <tr>
                    <td>{{$key+1}}</td>
                    <td>{{(!empty($value->category->name))?$value->category->name:''}}</td>
                    <td>{{$value->discount_percentage}}%</td>
                    <td>{{($value->custom_prizes==1)?'Yes':'No'}}</td>
                    <td><a href="javascript::" rel="{{$value->id}}" class="doctor_category_update_id">
                        Edit
                      </a></td>
                  </tr>
                  @endforeach
                  @endif
                </tbody>
              </table>
            </div>


            <div class="tab-pane p-3" id="prizes" role="tabpanel">

              <form id="doctorTestForm">
              @csrf
              <input type="hidden" name="id" id="doctor_test_id">
              <input type="hidden" name="doctor_id" value="{{$result->id}}">
              <div class="col-sm-6">
                <label for="test_id">Select Test</label>
                <select class="form-control select2 inputs_with_bottom_border test_id" name="test_id">
                  <option value="">Select here</option>
                  @if(!empty($tests))
                  @foreach($tests as $record)
                  <option value="{{$record->id}}">{{$record->name}} &nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size: 11px !important;"> (Rs: {{$record->price}})</span></option>
                  @endforeach
                  @endif
                </select>
                <div class="all_errors test_id_error">
                </div>
              </div>
              <br>
              <div class="col-sm-6">
                <label for="discounted_price">Enter Discounted Prize</label>
                <input type="number" class="form-control discounted_price" name="discounted_price" placeholder=" Discounted Prize">
                <div class="all_errors discounted_price_error">
                </div>
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
                    @if(!empty($doctor_tests))
                    @foreach($doctor_tests as $key=>$value)
                    <tr>
                      <td>{{$key+1}}</td>
                      <td>{{(!empty($value->test->name))?$value->test->name:'----'}}</td>
                      <td>{{(!empty($value->test->category->name))?$value->test->category->name:'----'}}</td>
                      <td>Rs: {{(!empty($value->test->price))?$value->test->price:'----'}}</td>
                      <td>Rs: {{(!empty($value->discounted_price))?$value->discounted_price:'----'}}</td>
                      <td><a href="javascript::" rel="{{$value->id}}" class="doctor_test_update_id">
                          Edit
                        </a> | 
                        <a href="{{url('admin/delete-doctor-test/'.$value->id.'/'.$result->id)}}" class="delete-doctor-test">
                          Delete
                        </a>
                      
                      </td>
                    </tr>
                    @endforeach
                    @endif
                  </tbody>
                </table>
              </div>
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

</div>

<!-- Modal -->
<div class="modal fade" id="updateDoctorCategoryModal" tabindex="-1" role="dialog" aria-labelledby="updateDoctorCategoryLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateDoctorCategoryLabel">Update Doctor Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" id="updateDoctorCategoryForm" method="post">
          @csrf

          <input type="hidden" name="id" id="doctor_category_id">

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

<script src="{{asset('assets/developer/doctors.js')}}"></script>

@endsection