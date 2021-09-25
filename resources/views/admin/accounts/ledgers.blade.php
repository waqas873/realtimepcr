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


<div class="container">

  <div class="row">
    <div class="col-sm-12">
      <div class="page-title-box">
        <div class="row align-items-center">
          <div class="col-sm-5">
            <h4 class="page-title m-0">Ledger</h4>
          </div>
          <!-- end col -->
        </div>
        <!-- end row -->
      </div>
      <!-- end page-title-box -->
    </div>
  </div>
  <div class="col-xl-12">
    <div class="card m-b-30">
      <div class="card-body">
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#CP" role="tab"><span class="d-none d-md-block">CP Ledger</span><span class="d-block d-md-none"><i class="mdi mdi-home-variant h5"></i></span></a></li>
          <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#Lab" role="tab"><span class="d-none d-md-block">Lab Ledger</span><span class="d-block d-md-none"><i class="mdi mdi-account h5"></i></span></a></li>
          <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#doctors" role="tab"><span class="d-none d-md-block">Doctors Ledger</span><span class="d-block d-md-none"><i class="mdi mdi-account h5"></i></span></a></li>          
          <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#airLines" role="tab"><span class="d-none d-md-block">Airlines Ledger</span><span class="d-block d-md-none"><i class="mdi mdi-email h5"></i></span></a></li>
          <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#embassies" role="tab"><span class="d-none d-md-block">Embassies Ledger</span><span class="d-block d-md-none"><i class="mdi mdi-settings h5"></i></span></a></li>
          <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#vendors" role="tab"><span class="d-none d-md-block">Vendors Ledger</span><span class="d-block d-md-none"><i class="mdi mdi-settings h5"></i></span></a></li>
        </ul><!-- Tab panes -->
        <div class="tab-content">
          <div class="tab-pane active p-3 print-aria" id="CP" role="tabpanel">

            <form>

              <div class="form-group">
                <label for="collection_point_id">Select Collection Point</label>
                <select name="collection_point_id" id="collection_point_id" class="form-control form-control-lg">
                  @if(!empty($collection_points))
                  @foreach($collection_points as $key=>$value)
                  <option value="{{$value->id}}" <?php echo (!empty($cp_id) && $cp_id==$value->id)?"selected":''; ?>>{{$value->name}}</option>
                  @endforeach
                  @endif
                </select>
                <small id="CPledger" class="form-text text-muted">You can select Collecction Point here.</small>
              </div>

              <div class="col-sm-12">
                <div class="row emdatefilter">
                  <div class="col-sm-2 no_padd">
                    <p>Date Range</p>
                  </div>
                  <div class="col-sm-3 no_padd">
                    <input class="form-control inputs_with_bottom_border" type="date" id="from_date" name="from_date">
                  </div>
                  <div class="">
                    <p>To</p>
                  </div>
                  <div class="col-sm-3 no_padd">
                    <input class="form-control inputs_with_bottom_border" type="date" id="to_date" name="to_date">
                  </div>
                  <div class="col-sm-3">
                    <a href="javascript::" class="btn btn-success embsearch" id="by_date">Search</a>
                  </div>
                </div>
              </div>

            </form>

            <br>
            <hr>
            <div class="row">
              <div class="col-sm-10">
                <h5>Ledger</h5>
              </div>
              <div class="col-sm-2">
                <button type="button" onclick="window.print()" class="btn btn-primary">Print Report</button>
              </div>
            </div>


            <div class="table-responsive">
              <table class="table table-bordered table-sm" id="cp_ledger">
                <thead>
                  <tr>
                    <!-- <th scope="col">#</th> -->
                    <th scope="col">ID</th>
                    <th scope="col">Date</th>
                    <th scope="col">Particulars / Description</th>
                    <th scope="col">Debit</th>
                    <th scope="col">Credit</th>
                    <th scope="col">Balance</th>
                  </tr>
                </thead>
                <footer>
                  <tr class="thead-dark">
                    <th colspan="4">Total</th>
                    <th>Rs: 12000</th>
                    <th>Rs: 5000</th>
                    <th>Rs: 7000</th>
                  </tr>
                </footer>

                <caption>
                  Captions of the table
                </caption>

              </table>
            </div>


          </div>

          <div class="tab-pane p-3 print-aria" id="Lab" role="tabpanel">
            <form>
              <div class="form-group">
                <label for="lab_id">Select Lab</label>
                <select name="lab_id" id="lab_id" class="form-control form-control-lg ">
                  @if(!empty($labs))
                  @foreach($labs as $key=>$value)
                  <option value="{{$value->id}}">{{$value->name}}</option>
                  @endforeach
                  @endif
                </select>
                <small id="labledger" class="form-text text-muted">You can select Lab here.</small>
              </div>
              <div class="col-sm-12">

                <div class="row emdatefilter">
                  <div class="col-sm-2 no_padd">
                    <p>Date Range</p>
                  </div>
                  <div class="col-sm-3 no_padd">
                    <input class="form-control inputs_with_bottom_border" type="date" id="lab_from_date" name="from_date">
                  </div>
                  <div class="">
                    <p>To</p>
                  </div>
                  <div class="col-sm-3 no_padd">
                    <input class="form-control inputs_with_bottom_border" type="date" id="lab_to_date" name="to_date">
                  </div>
                  <div class="col-sm-3">
                    <a href="javascript::" class="btn btn-success embsearch" id="lab_by_date">Search</a>
                  </div>
                </div>

              </div>
            </form>
            <br>
            <hr>
            <h5>Ledger</h5>

            <div class="table-responsive">
              <table class="table table-bordered table-sm" id="lab_ledger" style="width: 100% !important;">
                <thead>
                  <tr>
                    <!-- <th scope="col">#</th> -->
                    <th scope="col">ID</th>
                    <th scope="col">Date</th>
                    <th scope="col">Particulars / Description</th>
                    <th scope="col">Debit</th>
                    <th scope="col">Credit</th>
                    <th scope="col">Balance</th>
                  </tr>
                </thead>
              </table>
            </div>


          </div>

          <div class="tab-pane p-3 print-aria" id="doctors" role="tabpanel">

            <form>

              <div class="form-group">
                <label for="doctor_id">Select Doctor</label>
                <select name="doctor_id" id="doctor_id" class="form-control form-control-lg ">
                  @if(!empty($doctors))
                  @foreach($doctors as $key=>$value)
                  <option value="{{$value->id}}" <?php echo (!empty($doctor_id) && $doctor_id==$value->id)?"selected":''; ?>><?php echo (!empty($value->user->name))?$value->user->name:'---' ?></option>
                  @endforeach
                  @endif
                </select>
                <small id="doctorledger" class="form-text text-muted">You can select doctor here.</small>
              </div>

              <div class="col-sm-12">
                <div class="row emdatefilter">
                  <div class="col-sm-2 no_padd">
                    <p>Date Range</p>
                  </div>
                  <div class="col-sm-3 no_padd">
                    <input class="form-control inputs_with_bottom_border" type="date" id="doctor_from_date" name="from_date">
                  </div>
                  <div class="">
                    <p>To</p>
                  </div>
                  <div class="col-sm-3 no_padd">
                    <input class="form-control inputs_with_bottom_border" type="date" id="doctor_to_date" name="to_date">
                  </div>
                  <div class="col-sm-3">
                    <a href="javascript::" class="btn btn-success embsearch" id="doctor_by_date">Search</a>
                  </div>
                </div>
              </div>

            </form>

            <br>
            <hr>
            <div class="row">
              <div class="col-sm-10">
                <h5>Ledger</h5>
              </div>
              <div class="col-sm-2">
                <button type="button" onclick="window.print()" class="btn btn-primary">Print Report</button>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table table-bordered table-sm" id="doctor_ledger" style="width: 100% !important;">
                <thead>
                  <tr>
                    <!-- <th scope="col">#</th> -->
                    <th scope="col">ID</th>
                    <th scope="col">Date</th>
                    <th scope="col">Particulars / Description</th>
                    <th scope="col">Debit</th>
                    <th scope="col">Credit</th>
                    <th scope="col">Balance</th>
                  </tr>
                </thead>
              </table>
            </div>

          </div>

          <div class="tab-pane p-3 print-aria" id="airLines" role="tabpanel">

            <form>

              <div class="form-group">
                <label for="airline_user_id">Select Airline User</label>
                <select name="airline_user_id" id="airline_user_id" class="form-control form-control-lg ">
                  @if(!empty($airline_users))
                  @foreach($airline_users as $key=>$value)
                  <option value="{{$value->id}}">{{$value->name}}</option>
                  @endforeach
                  @endif
                </select>
                <small id="airlineledger" class="form-text text-muted">You can select user here.</small>
              </div>

              <div class="col-sm-12">
                <div class="row emdatefilter">
                  <div class="col-sm-2 no_padd">
                    <p>Date Range</p>
                  </div>
                  <div class="col-sm-3 no_padd">
                    <input class="form-control inputs_with_bottom_border" type="date" id="airline_user_from_date" name="from_date">
                  </div>
                  <div class="">
                    <p>To</p>
                  </div>
                  <div class="col-sm-3 no_padd">
                    <input class="form-control inputs_with_bottom_border" type="date" id="airline_user_to_date" name="to_date">
                  </div>
                  <div class="col-sm-3">
                    <a href="javascript::" class="btn btn-success embsearch" id="airline_by_date">Search</a>
                  </div>
                </div>
              </div>

            </form>

            <br>
            <hr>
            <div class="row">
              <div class="col-sm-10">
                <h5>Ledger</h5>
              </div>
              <div class="col-sm-2">
                <button type="button" onclick="window.print()" class="btn btn-primary">Print Report</button>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table table-bordered table-sm" id="airline_user_ledger" style="width: 100% !important;">
                <thead>
                  <tr>
                    <!-- <th scope="col">#</th> -->
                    <th scope="col">ID</th>
                    <th scope="col">Date</th>
                    <th scope="col">Particulars / Description</th>
                    <th scope="col">Debit</th>
                    <th scope="col">Credit</th>
                    <th scope="col">Balance</th>
                  </tr>
                </thead>
              </table>
            </div>

          </div>
          <div class="tab-pane p-3 print-aria" id="embassies" role="tabpanel">

            <form>

              <div class="form-group">
                <label for="embassy_user_id">Select Embassy User</label>
                <select name="embassy_user_id" id="embassy_user_id" class="form-control form-control-lg ">
                  @if(!empty($embassy_users))
                  @foreach($embassy_users as $key=>$value)
                  <option value="{{$value->id}}">{{$value->name}}</option>
                  @endforeach
                  @endif
                </select>
                <small id="embassyledger" class="form-text text-muted">You can select user here.</small>
              </div>

              <div class="col-sm-12">
                <div class="row emdatefilter">
                  <div class="col-sm-2 no_padd">
                    <p>Date Range</p>
                  </div>
                  <div class="col-sm-3 no_padd">
                    <input class="form-control inputs_with_bottom_border" type="date" id="embassy_user_from_date" name="from_date">
                  </div>
                  <div class="">
                    <p>To</p>
                  </div>
                  <div class="col-sm-3 no_padd">
                    <input class="form-control inputs_with_bottom_border" type="date" id="embassy_user_to_date" name="to_date">
                  </div>
                  <div class="col-sm-3">
                    <a href="javascript::" class="btn btn-success embsearch" id="embassy_by_date">Search</a>
                  </div>
                </div>
              </div>

            </form>

            <br>
            <hr>
            <div class="row">
              <div class="col-sm-10">
                <h5>Ledger</h5>
              </div>
              <div class="col-sm-2">
                <button type="button" onclick="window.print()" class="btn btn-primary">Print Report</button>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table table-bordered table-sm" id="embassy_user_ledger" style="width: 100% !important;">
                <thead>
                  <tr>
                    <!-- <th scope="col">#</th> -->
                    <th scope="col">ID</th>
                    <th scope="col">Date</th>
                    <th scope="col">Particulars / Description</th>
                    <th scope="col">Debit</th>
                    <th scope="col">Credit</th>
                    <th scope="col">Balance</th>
                  </tr>
                </thead>
              </table>
            </div>

          </div>
          <div class="tab-pane p-3 print-aria" id="vendors" role="tabpanel">

            <form>

              <div class="form-group">
                <label for="supplier_id">Select Vendor</label>
                <select name="supplier_id" id="supplier_id" class="form-control form-control-lg ">
                  @if(!empty($suppliers))
                  @foreach($suppliers as $key=>$value)
                  <option value="{{$value->id}}">{{$value->name}}</option>
                  @endforeach
                  @endif
                </select>
                <small id="" class="form-text text-muted">You can select vendor here.</small>
              </div>

              <div class="col-sm-12">
                <div class="row emdatefilter">
                  <div class="col-sm-2 no_padd">
                    <p>Date Range</p>
                  </div>
                  <div class="col-sm-3 no_padd">
                    <input class="form-control inputs_with_bottom_border" type="date" id="supplier_from_date" name="from_date">
                  </div>
                  <div class="">
                    <p>To</p>
                  </div>
                  <div class="col-sm-3 no_padd">
                    <input class="form-control inputs_with_bottom_border" type="date" id="supplier_to_date" name="to_date">
                  </div>
                  <div class="col-sm-3">
                    <a href="javascript::" class="btn btn-success embsearch" id="supplier_by_date">Search</a>
                  </div>
                </div>
              </div>

            </form>

            <br>
            <hr>
            <div class="row">
              <div class="col-sm-10">
                <h5>Ledger</h5>
              </div>
              <div class="col-sm-2">
                <button type="button" onclick="window.print()" class="btn btn-primary">Print Report</button>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table table-bordered table-sm" id="supplier_ledger" style="width: 100% !important;">
                <thead>
                  <tr>
                    <!-- <th scope="col">#</th> -->
                    <th scope="col">ID</th>
                    <th scope="col">Date</th>
                    <th scope="col">Particulars / Description</th>
                    <th scope="col">Debit</th>
                    <th scope="col">Credit</th>
                    <th scope="col">Balance</th>
                  </tr>
                </thead>
              </table>
            </div>

          </div>
        </div>


      </div>
    </div>
  </div>
</div>
</div>
</div>

<!-- container fluid -->

<script src="{{asset('assets/developer/admin/accounts.js')}}"></script>

<script src="{{asset('assets/developer/admin/ledgers.js')}}"></script>

@endsection