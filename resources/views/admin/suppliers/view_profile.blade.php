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
            <h4 class="page-title m-0">Vendor / Suuplier Profile</h4>
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
          <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#VendorProfile" role="tab"><span class="d-none d-md-block"> Profile</span><span class="d-block d-md-none"><i class="mdi mdi-home-variant h5"></i></span></a></li>
          <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#Purchases" role="tab"><span class="d-none d-md-block">Purchases</span><span class="d-block d-md-none"><i class="mdi mdi-account h5"></i></span></a></li>
          <!-- <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#Trx" role="tab"><span class="d-none d-md-block">Transactions</span><span class="d-block d-md-none"><i class="mdi mdi-settings h5"></i></span></a></li> -->
        </ul><!-- Tab panes -->
        <div class="tab-content">
          <div class="tab-pane active p-3" id="VendorProfile" role="tabpanel">
            <div class="row">
              <div class="col-sm-2">Supplier Name :</div>
              <div class="col-sm-10"><b>{{$result->name}}</b></div>
              <div class="col-sm-2">Shop Name</div>
              <div class="col-sm-10"><b>{{$result->shop_name}}</b></div>
              <div class="col-sm-2">Contact: </div>
              <div class="col-sm-10"><b>{{$result->contact}}</b></div>
              <div class="col-sm-2">City:</div>
              <div class="col-sm-10"><b>{{$result->city}}</b></div>
              <div class="col-sm-2">E-Wallet / Bank Account</div>
              <div class="col-sm-10"><b>{{$result->bank_name}}</b></div>
              <div class="col-sm-2">Account No</div>
              <div class="col-sm-10"><b>{{$result->account_no}}</b></div>

            </div>
            
          </div>


          <div class="tab-pane p-3" id="Purchases" role="tabpanel">

            
            <div class="row">
            <div class="col-sm-12">
              <button type="button" id="addPurchaseBtn" class="btn btn-light float-right" style="margin: 10px;">Make Purchase</button>
            </div>
            <table class="table table-borderless" id="purchases_datatable">
              <thead class="thead-dark">
                <tr>
                  <th>Purchase ID</th>
                  <th>Purchase Type</th>
                  <th>Description</th>
                  <th>Total Price</th>
                  <th>Advance Payment</th>
                  <th>Payment Balance</th>
                  <th>Action</th>
                </tr>
              </thead>
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
                <p>Total Purchases</p>
              </div>
              <div class="col-sm-2 data-card">
                <h3 class="val-card">25%</h3>
                <p>Total Transactions</p>
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
            <!-- <div class="row">
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
            </div> -->

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
          <input type="hidden" name="supplier_id" value="{{$result->id}}" class="supplier_id">

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

<div class="modal fade addPurchase" id="addPurchaseModal" tabindex="-1" role="dialog" aria-labelledby="addPurchase" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Purchase</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="addPurchaseForm" method="post">
      <div class="modal-body">
          @csrf

          <!-- <input type="hidden" name="id" class="purchase_id"> -->
          <input type="hidden" name="supplier_id" value="{{$result->id}}" class="supplier_id">

          <?php
          $purchase_types = [['id'=>1,'name'=>'Kits'],['id'=>2,'name'=>'Boxes']];
          ?>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Purchase Type</label>
            <select class="form-control purchase_type" name="purchase_type" id="purchase_type">
              <option value="">Select here</option>
              <?php 
              if(!empty($purchase_types)){
                foreach ($purchase_types as $key => $value) {
              ?>
              <option value="<?php echo $value['id'];?>"><?php echo $value['name'];?></option>
              <?php
                }
              }
              ?>
            </select>
            <div class="all_errors purchase_type_error"></div>
          </div>
          <div class="form-group">
            <label for="price">Total Price</label>
            <div class="input-group mb-2">
              <div class="input-group-prepend">
                <div class="input-group-text">Rs:</div>
              </div>
              <input name="price" type="number" class="form-control value price" placeholder="Enter Value">
            </div>
            <div class="all_errors price_error"></div>
          </div>
          <div class="form-group">
            <label for="advance_payment">Advance Payment</label>
            <div class="input-group mb-2">
              <div class="input-group-prepend">
                <div class="input-group-text">Rs:</div>
              </div>
              <input name="advance_payment" type="number" class="form-control value advance_payment" placeholder="Enter Value">
            </div>
            <div class="all_errors advance_payment_error"></div>
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Date:</label>
            <input type="date" name="date" class="form-control date">
            <div class="all_errors date_error"></div>
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

<div class="modal fade addPurchasePay" id="addPurchasePayModal" tabindex="-1" role="dialog" aria-labelledby="addPurchasePay" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Pay Pending Balance</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="addPurchasePayForm" method="post">
      <div class="modal-body">
          @csrf

          <input type="hidden" name="id" class="purchase_id">
          
          <div class="form-group">
            <label for="amount">Amount to Pay</label>
            <div class="input-group mb-2">
              <div class="input-group-prepend">
                <div class="input-group-text">Rs:</div>
              </div>
              <input name="amount" type="number" class="form-control value amount" placeholder="Enter Value">
            </div>
            <div class="all_errors amount_error"></div>
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Date:</label>
            <input type="date" name="date" class="form-control date">
            <div class="all_errors date_error"></div>
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

<script src="{{asset('assets/developer/admin/suppliers.js')}}"></script>
<script src="{{asset('assets/developer/admin/accounts.js')}}"></script>

@endsection