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
        <h4 class="mb-3 mt-0 float-right">Rs:  {{$today_sale}}</h4>
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

<div class="row">
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
</div>
<!-- end row -->

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
                <?php $counter = count($patients) ; ?>
                @foreach($patients as $value)
                <tr>
                    <td>#{{$counter}}</td>
                    <td>{{$value->name}}</td>
                    <td><?php echo (!empty($value->user->name))?$value->user->name:'---'; ?></td>
                    <td>
                        <?php 
                            if(!empty($value->patient_tests[0]->test->name)){
                                $tooltip = '';
                                $cc = count($value->patient_tests);
                                foreach($value->patient_tests as $key2 => $test){
                                    $i = $key2+1;
                                    $tooltip .= $test->test->name;
                                    ($i<$cc)?$tooltip .= ' , ':'';
                                }
                                echo '<a href="javascript::" data-toggle="tooltip" title="'.$tooltip.'">'.$value->patient_tests[0]->test->name.'</a>';
                            }
                            else{
                                echo "---";
                            }
                        ?>
                    </td>
                    <?php
                       $status = '---' ;
                       $amount_paid = 0;
                       $amount_remaining = 0;
                       if(!empty($value->invoice[0])){
                        foreach($value->invoice as $inv){
                           $amount_paid = $amount_paid+$inv->amount_paid;
                           $amount_remaining = $amount_remaining+$inv->amount_remaining;
                        }
                        $invc = $value->invoice[0];
                        if($invc->status==0){
                            $status = 'Pending';
                        }
                        if($invc->status==1){
                            $status = 'Awaiting Result';
                        }
                        if($invc->status==2){
                            $status = 'Pay Invoice';
                        }
                        if($invc->status==3){
                            $status = 'Print';
                        }
                        if($invc->status==4){
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
--}}
<!-- end row -->

</div><!-- container fluid -->

<!-- Modal -->
<div class="modal fade" id="expenseModal" tabindex="-1" role="dialog" aria-labelledby="expenseModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content add-test-content">
      <div class="modal-header">
        <h5 class="modal-title" id="expenseLabel">Expense</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form action="" method="post" id="expense-form">
                @csrf

                <div class="form-group row">
                  <label for="title" class="col-sm-3 col-form-label pformlabel">Item</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control inputs_with_bottom_border" id="title" name="title" placeholder="Enter item">
                    <div class="all_errors" id="title_error">
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="amount" class="col-sm-3 col-form-label pformlabel">Amount Spent</label>
                  <div class="col-sm-9">
                    <input type="number" class="form-control inputs_with_bottom_border" id="amount" name="amount" placeholder="Enter amount">
                    <div class="all_errors" id="amount_error">
                    </div>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="description" class="col-sm-3 col-form-label pformlabel">Description</label>
                  <div class="col-sm-9">
                    <textarea class="form-control inputs_with_bottom_border" id="description" name="description"></textarea>
                  </div>
                </div>
                
                <div class="form-group row">
                  <div class="col-sm-9 offset-sm-3">
                      <button type="submit" class="btn btn-primary">Save Expense</button>
                  </div>
                </div>
            </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="transfer_amount_modal" tabindex="-1" role="dialog" aria-labelledby="transfer_amountModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content add-test-content">
      <div class="modal-header">
        <h5 class="modal-title" id="transfer_amountLabel">Transfer Amount</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form action="" method="post" id="amount_transfer_form">
                @csrf

                <div class="form-group row">
                  <label for="amount_transfer" class="col-sm-3 col-form-label pformlabel">Amount Submitted</label>
                  <div class="col-sm-9">
                    <input type="number" class="form-control inputs_with_bottom_border" id="amount_transfer" name="amount_transfer" placeholder="Enter amount">
                    <div class="all_errors" id="amount_transfer_error">
                    </div>
                  </div>
                </div>
                
                <div class="form-group row">
                  <label for="user_id" class="col-sm-3 col-form-label pformlabel">Submitted To</label>
                  <div class="col-sm-9">
                    <select class="form-control inputs_with_bottom_border select2" id="user_id" name="user_id">
                      <option value="">Select User</option>
                      <?php
                        if(!empty($users)){
                          foreach($users as $key => $value){
                            echo '<option value="'.$value->id.'">'.$value->name.'</option>';
                          }
                        }
                      ?>
                    </select>
                    <div class="all_errors" id="user_id_error">
                    </div>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="description" class="col-sm-3 col-form-label pformlabel">Description</label>
                  <div class="col-sm-9">
                    <textarea class="form-control inputs_with_bottom_border" name="description"></textarea>
                  </div>
                </div>
                
                <div class="form-group row">
                  <div class="col-sm-9 offset-sm-3">
                      <button type="submit" class="btn btn-primary">Transfer Amount</button>
                  </div>
                </div>
            </form>
      </div>
    </div>
  </div>
</div>

<script src="{{asset('assets/developer/amounts.js')}}"></script>

@endsection