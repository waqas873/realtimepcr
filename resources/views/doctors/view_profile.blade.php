@extends('layouts.admin')
@section('content')

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
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#docLedgers" role="tab"><span class="d-none d-md-block">Ledgers</span><span class="d-block d-md-none"><i class="mdi mdi-settings h5"></i></span></a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#Trx" role="tab"><span class="d-none d-md-block">Transactions</span><span class="d-block d-md-none"><i class="mdi mdi-settings h5"></i></span></a></li>
          </ul><!-- Tab panes -->
          <div class="tab-content">
            <div class="tab-pane active p-3" id="docProfile" role="tabpanel">
              <div class="row">
                <div class="col-sm-2">Doctor Name :</div>
                <div class="col-sm-10"><b>Dr. Sajid Ali</b></div>
                <div class="col-sm-2">Email</div>
                <div class="col-sm-10"><b>----</b></div>
                <div class="col-sm-2">Clinic Name</div>
                <div class="col-sm-10"><b>----</b></div>
                <div class="col-sm-2">Contact: </div>
                <div class="col-sm-10"><b>----</b></div>
                <div class="col-sm-2">City:</div>
                <div class="col-sm-10"><b>----</b></div>
                <div class="col-sm-2">Address</div>
                <div class="col-sm-10"><b>----</b></div>
                <div class="col-sm-10"></div>
                <div class="col-sm-2"><button type="button" class="btn btn-light float-right">Edit Profile</button></div>

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
                  <tr>
                    <td>1</td>
                    <td>Molecular Virology</td>
                    <td>50%</td>
                    <td>YES</td>
                    <td>EDIT</td>
                  </tr>
                </tbody>
              </table>
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
            <div class="tab-pane p-3" id="docLedgers" role="tabpanel">
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

</div>

<script src="{{asset('assets/developer/doctors.js')}}"></script>

@endsection