@extends('layouts.pcr')
@section('content')

<div class="container-fluid">

  <div class="row">
    <div class="col-sm-12">
      <div class="page-title-box">
        <div class="row align-items-center">
          <div class="col-md-8">
            <h4 class="page-title m-0">Dashboard</h4>
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
    <div class="col-xl-3 col-md-6">
      <div class="card bg-primary mini-stat text-white">
        <div class="p-3 mini-stat-desc">
          <div class="clearfix">
            <h6 class="text-uppercase mt-0 float-left text-white-50">Patients</h6>
            <h4 class="mb-3 mt-0 float-right">{{-- {{count($patients)}} --}} 11</h4>
          </div>
          <div>
            <span class="ml-2">Patients Registered</span>
          </div>

        </div>
        <div class="p-3">
          <div class="float-right">
            <a href="#" class="text-white-50"><i class="mdi mdi-cube-outline h5"></i></a>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-md-6">
      <div class="card bg-info mini-stat text-white">
        <div class="p-3 mini-stat-desc">
          <div class="clearfix">
            <h6 class="text-uppercase mt-0 float-left text-white-50">Reports</h6>
            <h4 class="mb-3 mt-0 float-right"> {{$reports_delivered}}</h4>
          </div>
          <div> <span class="ml-2">Reports Delivered</span>
          </div>
        </div>
        <div class="p-3">
          <div class="float-right">
            <a href="#" class="text-white-50"><i class="mdi mdi-buffer h5"></i></a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6">
      <div class="card bg-pink mini-stat text-white">
        <div class="p-3 mini-stat-desc">
          <div class="clearfix">
            <h6 class="text-uppercase mt-0 float-left text-white-50">Reports</h6>
            <h4 class="mb-3 mt-0 float-right">{{$reports_pending}}</h4>
          </div>
          <div> <span class="ml-2">Pending Reports</span>
          </div>
        </div>
        <div class="p-3">
          <div class="float-right">
            <a href="#" class="text-white-50"><i class="mdi mdi-tag-text-outline h5"></i></a>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-md-6">
      <div class="card bg-success mini-stat text-white">
        <div class="p-3 mini-stat-desc">
          <div class="clearfix">
            <h6 class="text-uppercase mt-0 float-left text-white-50">Sale</h6>
            <h4 class="mb-3 mt-0 float-right">Rs: {{$today_sale}}</h4>
          </div>
          <div><span class="ml-2">Today's Sale</span>
          </div>
        </div>
        <div class="p-3">
          <div class="float-right">
            <a href="#" class="text-white-50"><i class="mdi mdi-briefcase-check h5"></i></a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- end row -->

  <!-- <div class="row">
  <div class="col-xl-9">
  <div class="card">
  <div class="card-body">
      <h4 class="mt-0 header-title">Patients Handled this Month</h4>
      <div class="row">
          <div class="col-lg-12">
              <div id="morris-line-example" class="morris-chart" style="height: 300px"></div>
          </div>
      </div>
  </div>
  </div>
  </div>
  <div class="col-xl-3">
  <div class="card bg-pink mini-stat text-white">
  <div class="p-3 mini-stat-desc">
      <div class="clearfix">
          <h6 class="text-uppercase mt-0 float-left text-white-50">Expense</h6>
          <h4 class="mb-3 mt-0 float-right">Rs: {{$total_expense}}</h4>
      </div>
      <div> <span class="ml-2">Expense</span>
      </div>
  </div>
  <div class="p-3">
      <div class="float-right">
          <a href="#" class="text-white-50"><i class="fa fa-plus-circle" aria-hidden="true" style="font-size: 18px;" id="add_expense"></i></a>
      </div>

      <button type="button" class="btn btn-light waves-effect" id="add_expense">Add Expense</button>
  </div>
  </div>
  <div class="card bg-info mini-stat text-white">
  <div class="p-3 mini-stat-desc">
      <div class="clearfix">
          <h6 class="text-uppercase mt-0 float-left text-white-50">Cash</h6>
          <h4 class="mb-3 mt-0 float-right">Rs: {{$cash_in_hand}}</h4>
      </div>
      <div> <span class="ml-2">Cash in Hand</span>
      </div>
  </div>
  <div class="p-3">
      <div class="float-right">
          <a href="#" class="text-white-50"><i class="fa fa-minus-circle" aria-hidden="true" style="font-size: 18px;" id="transfer_amount_btn"></i></a>
      </div>
  </div>
  </div>
  </div>
  </div> -->
  <!-- end row -->
  <!-- 
  {{--<div class="row">
  <div class="col-xl-12">
  <div class="card">
  <div class="card-body">
      <h4 class="mt-0 header-title mb-4">Recently Added Patients</h4>
      <div class="table-responsive">
          <table class="table table-hover">
              <thead>
                  <tr>
                      <th scope="col">Patient ID</th>
                      <th scope="col">Patient Name</th>
                      <th scope="col">Reffered By</th>
                      <th scope="col">Test</th>
                      <th scope="col">Amount Paid</th>
                      <th scope="col">Balance</th>
                      <th scope="col">Status</th>
                  </tr>
              </thead>
              <tbody>
                  @if(!empty($patients))
                  <?php $counter = count($patients); ?>
                  @foreach($patients as $value)
                  <tr>
                      <td>#{{$counter}}</td>
                      <td>{{$value->name}}</td>
                      <td><?php echo (!empty($value->user->name)) ? $value->user->name : '---'; ?></td>
                      <td>
                          <?php
                          if (!empty($value->patient_tests[0]->test->name)) {
                            $tooltip = '';
                            $cc = count($value->patient_tests);
                            foreach ($value->patient_tests as $key2 => $test) {
                              $i = $key2 + 1;
                              $tooltip .= $test->test->name;
                              ($i < $cc) ? $tooltip .= ' , ' : '';
                            }
                            echo '<a href="javascript::" data-toggle="tooltip" title="' . $tooltip . '">' . $value->patient_tests[0]->test->name . '</a>';
                          } else {
                            echo "---";
                          }
                          ?>
                      </td>
                      <?php
                      $status = '---';
                      $amount_paid = 0;
                      $amount_remaining = 0;
                      if (!empty($value->invoice[0])) {
                        foreach ($value->invoice as $inv) {
                          $amount_paid = $amount_paid + $inv->amount_paid;
                          $amount_remaining = $amount_remaining + $inv->amount_remaining;
                        }
                        $invc = $value->invoice[0];
                        if ($invc->status == 0) {
                          $status = 'Pending';
                        }
                        if ($invc->status == 1) {
                          $status = 'Awaiting Result';
                        }
                        if ($invc->status == 2) {
                          $status = 'Pay Invoice';
                        }
                        if ($invc->status == 3) {
                          $status = 'Print';
                        }
                        if ($invc->status == 4) {
                          $status = 'Delivered';
                        }
                      }
                      ?>
                      <td>Rs: {{$amount_paid}}</td>
                      <td>Rs: {{$amount_remaining}}</td>
                      <td>{{$status}}</td>
                  </tr>
                  <?php $counter--; ?>
                  @endforeach
                  @endif
              </tbody>
          </table>
      </div>

  </div>
  </div>
  </div>
  </div>
  --}} -->
  <!-- end row -->

  <hr>

  <!-- Amount History Page Starts Here -->

  <div class="row">
    <div class="col-xl-3 col-md-6">
      <div class="card bg-primary mini-stat text-white">
        <div class="p-3 mini-stat-desc">
          <div class="clearfix">
            <h4 class="mb-3 mt-0 float-right">Rs: <?php echo (!empty($total_income)) ? $total_income : '0'; ?></h4>
          </div>
          <div>
            <span class="ml-2">Total Income</span>
          </div>

        </div>
      </div>
    </div>

    <div class="col-xl-3 col-md-6">
      <div class="card bg-info mini-stat text-white">
        <div class="p-3 mini-stat-desc">
          <div class="clearfix">
            <h4 class="mb-3 mt-0 float-right">Rs: <?php echo (!empty($total_expense)) ? $total_expense : '0'; ?></h4>
          </div>
          <div> <span class="ml-2">Total Expense</span>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6">
      <div class="card bg-pink mini-stat text-white">
        <div class="p-3 mini-stat-desc">
          <div class="clearfix">
            <h4 class="mb-3 mt-0 float-right">Rs: <?php echo $cash_in_hand; ?></h4>
          </div>
          <div> <span class="ml-2">Cash In Hand</span>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-md-6">
      <div class="card bg-success mini-stat text-white">
        <div class="p-3 mini-stat-desc">
          <div class="clearfix">
            <h4 class="mb-3 mt-0 float-right">Rs: <?php echo (!empty($cash_recieved)) ? $cash_recieved : '0'; ?></h4>
          </div>
          <div><span class="ml-2">Cash Recieved</span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- end row -->

  

  <!-- end row -->


</div>



<!-- container fluid -->

<script src="{{asset('assets/developer/amounts.js')}}"></script>

@endsection