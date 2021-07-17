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

<style type="text/css">
  .nav-tabs .nav-link {
    font-size: 17px;
  }
</style>

<div class="container">

  <div class="row">
    <div class="col-sm-12">
      <div class="page-title-box">
        <div class="row align-items-center">
          <div class="col-sm-5">
            <h4 class="page-title m-0">Vouchers</h4>
          </div>

          <div class="col-sm-7">
            <a href="javascript::" id="addBankPaymentBtn" class="btn btn-success" style="float: right;margin-bottom: 20px;margin-right: 1.5%;">Add Bank Voucher</a>
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

          <ul class="nav nav-tabs nav-justified md-tabs indigo" id="myTabJust" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="home-tab-just" data-toggle="tab" href="#home-just" role="tab" aria-controls="home-just" aria-selected="true">Cash Payment</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="profile-tab-just" data-toggle="tab" href="#profile-just" role="tab" aria-controls="profile-just" aria-selected="false">Cash Recieved</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="contact-tab-just" data-toggle="tab" href="#contact-just" role="tab" aria-controls="contact-just" aria-selected="false">Journal</a>
            </li>
            <li class="nav-item">
              <a class="nav-link show" id="contact-tab-just" data-toggle="tab" href="#BankPayment-just" role="tab" aria-controls="contact-just" aria-selected="false">Bank Payment</a>
            </li>
            <li class="nav-item">
              <a class="nav-link show" id="contact-tab-just" data-toggle="tab" href="#BankReceived-just" role="tab" aria-controls="contact-just" aria-selected="false">Bank Received</a>
            </li>
          </ul>
          <div class="tab-content card pt-5" id="myTabContentJust">
            <div class="tab-pane fade show active" id="home-just" role="tabpanel" aria-labelledby="home-tab-just">

              <div class="row">
                <div class="col-xl-12">
                  <!-- <a href="javascript::" class="btn btn-success" style="float: right;margin-bottom: 20px;margin-right: 1.5%;">Add Voucher</a> -->
                </div>
              </div>

              <div class="table-responsive">
                <table class="table table-hover" id="cash_payment_datatable">
                  <thead>
                    <tr>
                      <th scope="col">Invoice-ID</th>
                      <th scope="col">Category</th>
                      <th scope="col">Description</th>
                      <th scope="col">Amount Debit</th>
                    </tr>
                  </thead>
                </table>
              </div>

            </div>
            <div class="tab-pane fade" id="profile-just" role="tabpanel" aria-labelledby="profile-tab-just">

              <div class="row">
                <div class="col-xl-12">
                  <!-- <a href="javascript::" class="btn btn-success" style="float: right;margin-bottom: 20px;margin-right: 1.5%;">Add Voucher</a> -->
                </div>
              </div>

              <div class="table-responsive">
                <table class="table table-hover" id="cash_recieved_datatable" style="width: 100% !important;">
                  <thead>
                    <tr>
                      <th scope="col">Invoice-ID</th>
                      <th scope="col">Category</th>
                      <th scope="col">Description</th>
                      <th scope="col">Amount Credit</th>
                    </tr>
                  </thead>
                </table>
              </div>

            </div>
            <div class="tab-pane fade" id="contact-just" role="tabpanel" aria-labelledby="contact-tab-just">

              <div class="row">
                <div class="col-xl-12">
                  <div style="float:right;
                  margin-bottom: 20px;margin-right: 1.5%;">
                    <a href="javascript::" class="btn btn-success" id="addJournalBtn">Journal Adjustment</a>
                  </div>
                </div>
              </div>

              <div class="table-responsive">
                <table class="table table-hover" id="journal_datatable" style="width: 100% !important;">
                  <thead>
                    <tr>
                      <th scope="col">Invoice-ID</th>
                      <th scope="col">Category</th>
                      <th scope="col">Description</th>
                      <th scope="col">Type</th>
                      <th scope="col">Adjustment</th>
                    </tr>
                  </thead>
                </table>
              </div>

            </div>


            <div class="tab-pane fade" id="BankPayment-just" role="tabpanel" aria-labelledby="profile-tab-just">

              <div class="table-responsive">
                <table class="table table-hover" id="bank_payment_datatable" style="width: 100% !important;">
                  <thead>
                    <tr>
                      <th scope="col">Invoice-ID</th>
                      <th scope="col">Category</th>
                      <th scope="col">Description</th>
                      <th scope="col">Amount Debit</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
            <div class="tab-pane fade" id="BankReceived-just" role="tabpanel" aria-labelledby="profile-tab-just">

              <div class="table-responsive">
                <table class="table table-hover"id="bank_recieved_datatable" style="width: 100% !important;">
                  <thead>
                    <tr>
                      <th scope="col">Invoice-ID</th>
                      <th scope="col">Category</th>
                      <th scope="col">Description</th>
                      <th scope="col">Amount Debit</th>
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

<div class="modal fade addBankPayment" id="addBankPaymentModal" tabindex="-1" role="dialog" aria-labelledby="addBankPayment" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Bank Payment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="addBankPaymentForm" method="post">
      <div class="modal-body">
          @csrf
          
          <div class="form-group">
            <label for="message-text" class="col-form-label">Payment Type</label>
            <select class="form-control is_recieved select2" name="is_recieved">
              <option value="">Select here</option>
              <option value="1">Recieved From Bank</option>
              <option value="0">Payment to Bank</option>
            </select>
            <div class="all_errors is_recieved_error"></div>
          </div>

          <div class="form-group">
            <label for="message-text" class="col-form-label">Account Category</label>
            <select class="form-control account_category_id select2" name="account_category_id">
              <option value="">Select here</option>
              @if(!empty($account_categories))
              @foreach($account_categories as $record)
              <option value="{{$record->id}}">{{$record->name}}</option>
              @endforeach
              @endif
            </select>
            <div class="all_errors account_category_id_error"></div>
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

<div class="modal fade addJournal" id="addJournalModal" tabindex="-1" role="dialog" aria-labelledby="addJournal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Journal Adjustment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="addJournalForm" method="post">
      <div class="modal-body">
          @csrf
          
          <div class="form-group">
            <label for="message-text" class="col-form-label">Journal Type</label>
            <select class="form-control is_recieved select2" name="is_recieved">
              <option value="">Select here</option>
              <option value="1">Credit Adjustment</option>
              <option value="0">Debit Adjustment</option>
            </select>
            <div class="all_errors is_recieved_error"></div>
          </div>

          <div class="form-group">
            <label for="message-text" class="col-form-label">Account Category</label>
            <select class="form-control account_category_id select2" name="account_category_id">
              <option value="">Select here</option>
              @if(!empty($account_categories))
              @foreach($account_categories as $record)
              <option value="{{$record->id}}">{{$record->name}}</option>
              @endforeach
              @endif
            </select>
            <div class="all_errors account_category_id_error"></div>
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

<script src="{{asset('assets/developer/admin/accounts.js')}}"></script>

  @endsection