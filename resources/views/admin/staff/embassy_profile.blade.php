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

  <!-- embassy Profile Page -->
  <div class="row">
    <div class="col-sm-12">
      <div class="page-title-box">
        <div class="row align-items-center">
          <div class="col-sm-5">
            <h4 class="page-title m-0">Embassy Profile</h4>
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
          <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#prizes" role="tab"><span class="d-none d-md-block">Special Prizes</span><span class="d-block d-md-none"><i class="mdi mdi-email h5"></i></span></a></li>
          <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#Trx" role="tab"><span class="d-none d-md-block">Transactions</span><span class="d-block d-md-none"><i class="mdi mdi-settings h5"></i></span></a></li>
        </ul><!-- Tab panes -->
        <div class="tab-content">
         
          <div class="tab-pane active p-3" id="prizes" role="tabpanel">

            <form id="commissionTestForm">
              @csrf
              <input type="hidden" name="id" id="commission_test_id">
              <input type="hidden" name="to_user_id" value="{{$result->id}}">

              <div class="col-sm-6">
                <label for="test_id">Select Overseas Test</label>
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
                <label for="">Select Lab</label>
                <select class="form-control select2 inputs_with_bottom_border lab_id" name="lab_id">
                  <option value="">Select here</option>
                  @if(!empty($labs))
                  @foreach($labs as $record)
                  <option value="{{$record->id}}">{{$record->name}}</option>
                  @endforeach
                  @endif
                </select>
                <div class="all_errors lab_id_error">
                </div>
              </div>
              <br>
              <div class="col-sm-6">
                <label for="">Select Collection Point</label>
                <select class="form-control select2 inputs_with_bottom_border collection_point_id" name="collection_point_id">
                  <option value="">Select here</option>
                  @if(!empty($collection_points))
                  @foreach($collection_points as $record)
                  <option value="{{$record->id}}">{{$record->name}}</option>
                  @endforeach
                  @endif
                </select>
                <div class="all_errors collection_point_id_error">
                </div>
              </div>
              <br>

              <div class="col-sm-6">
                <label for="">Commission Amount</label>
                <input type="number" name="commission_price" class="form-control commission_price" placeholder="Commission price">
                <div class="all_errors commission_price_error">
                </div>
              </div>
              <div class="col-sm-6" style="height: 100px;"> <br>
                <button type="submit" class="btn btn-light" style="width: 100%;">Save Prize</button>

              </div>

            </form>

            <div class="row">
              <table class="table table-borderless" id="commission_tests">
                <thead class="thead-dark">
                  <tr>
                    <th>S.No</th>
                    <th>Test Name</th>
                    <th>Department</th>
                    <th>LAB/CP City</th>
                    <th>Commission Prize</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @if(!empty($commission_tests))
                    @foreach($commission_tests as $key=>$value)
                    @if(!empty($value->user->role==3))
                    <tr>
                      <td>{{$key+1}}</td>
                      <td>{{(!empty($value->test->name))?$value->test->name:'----'}}</td>
                      <td>{{(!empty($value->test->category->name))?$value->test->category->name:'----'}}</td>
                      <td>
                        <?php 
                        if(!empty($value->lab_id)){
                          echo $value->lab->name;
                        }
                        if(!empty($value->collection_point_id)){
                          echo $value->collection_point->name;
                        }
                        ?>
                      </td>
                      <td>Rs: {{(!empty($value->commission_price))?$value->commission_price:'----'}}</td>
                      <td><a href="javascript::" rel="{{$value->id}}" class="commission_test_update_id">
                          Edit
                        </a> | 
                        <a href="{{url('admin/delete-commission-test/'.$value->id)}}" class="delete-commission-test">
                          Delete
                        </a>
                      </td>
                    </tr>
                    @endif
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
                <h3 class="val-card" style="color: #00c169;">Rs: {{$amount_paid}}</h3>
                <p>Amount Paid</p>
              </div>
              <div class="col-sm-2 data-card">
                <h3 class="val-card" style="color: #ff000080;">Rs: {{$amount_payable}}</h3>
                <p>Amount Payable</p>
              </div>

            </div>
            <div class="row">
              <div class="col-sm-12">
                <button type="button" class="btn btn-light float-right" id="addPaymentBtn">Add Payment</button>
              </div>

            </div>
            <br>
            <div class="row">
              <table class="table table-borderless" id="systemInvoices">
                  <thead class="thead-dark">
                    <tr>
                      <th>Date</th>
                      <th>Invoice ID</th>
                      <th>Amount</th>
                      <th>Description</th>
                      <th>Payment Method</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                </table>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- end row -->

</div><!-- container fluid -->

<div class="modal fade addPayment" id="addPaymentModal" tabindex="-1" role="dialog" aria-labelledby="addPayment" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Payment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="addPaymentForm" method="post">
      <div class="modal-body">
          @csrf

          <input type="hidden" name="id" class="system_invocie_id">
          <input type="hidden" name="embassy_user_id" value="{{$result->id}}" class="embassy_user_id">

          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Date:</label>
            <input type="date" name="date" class="form-control date">
            <div class="all_errors date_error"></div>
          </div>
          <div class="form-group">
            <label for="amount">Enter Amount</label>
            <div class="input-group mb-2">
              <div class="input-group-prepend">
                <div class="input-group-text">Rs:</div>
              </div>
              <input name="amount" type="number" class="form-control value amount" placeholder="Enter Value">
            </div>
            <div class="all_errors amount_error"></div>
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Payment Method</label>
            <select class="form-control payment_method" name="payment_method" id="payment_method">
              <option value="">Select here</option>
              <option value="Cash">Cash</option>
              <option value="Bank Transfer">Bank Transfer</option>
              <option value="Payment Gateway">Payment Gateway</option>
            </select>
            <div class="all_errors payment_method_error"></div>
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Description</label>
            <textarea class="form-control description" name="description" id="message-text"></textarea>
          </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save Record</button>
      </div>
      </form>
    </div>
  </div>
</div>

<script src="{{asset('assets/developer/admin/commission_tests.js')}}"></script>
<script src="{{asset('assets/developer/admin/accounts.js')}}"></script>

@endsection