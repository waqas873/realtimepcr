@extends('layouts.pcr')
@section('content')

<style type="text/css">
  .ml-2 {
    font-size: 18px !important;
  }

  .badge {
    font-size: 16px;
  }
</style>

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
          <div class="col-md-8">
            <h4 class="page-title m-0">Amount History</h4>
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


  <div class="row">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-body">

          <div class="row">
            <div class="col-sm-12">
              <a href="javascript::" class="btn btn-info" id="add_expense" style="margin-bottom: 12px;">Add Expense</a>
              <a href="javascript::" class="btn btn-success" id="transfer_amount_btn" style="margin-bottom: 12px;">Transfer Amount</a>
            </div>
          </div>

          <div class="table-responsive">
            <table class="table table-hover" id="datatable">
              <thead>
                <tr>
                  <th scope="col">Type</th>
                  <th scope="col">Description</th>
                  <th scope="col">Amount</th>
                  <th scope="col">Date</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                @if(!empty($listing))
                <?php $counter = count($listing); ?>
                @foreach($listing as $key=>$value)
                <tr>
                  <td>
                    <?php
                    if ($value->from_user == $login_user_id || $value->type == 2) {
                    ?>
                      <img src="{{asset('assets/images/expense.svg')}}">
                    <?php
                    } else {
                    ?>
                      <img src="{{asset('assets/images/Income.svg')}}">
                    <?php
                    }
                    ?>
                  </td>
                  <td>
                    <?php
                    echo (!empty($value->description)) ? $value->description : '------';
                    if (!empty($value->patient_id)) {
                      echo ' &nbsp; <a href="' . url('patient-detail/' . $value->patient_id) . '"  class="btn btn-sm btn-primary" target="_blank">View Patient</a>';
                    }
                    ?>
                  </td>
                  <td><?php echo ($value->from_user == $login_user_id || $value->type == 2) ? '<span class="minus_amount"> - Rs: ' . $value->amount . '</span>' : '<span class="plus_amount"> + Rs: ' . $value->amount . '</span>' ?></td>
                  <td>{{$value->created_at}}</td>
                  <td>
                    <?php
                    $action = '---';
                    if ($value->is_accepted == 1) {
                      if ($value->from_user == $login_user_id) {
                        $action = '<a href="' . url('cancel-transfer/' . $value->id) . '" class="btn btn-danger transfer_action">Cancel Transfer</a>';
                      } else {
                        $action = '<a href="' . url('accept-transfer/' . $value->id) . '" class="btn btn-success transfer_action">Accept</a> | <a href="' . url('reject-transfer/' . $value->id) . '" class="btn btn-danger transfer_action">Reject</a>';
                      }
                      // if($value->is_accepted==0){
                      //   $status = '<span class="badge badge-warning">Pending</span>';
                      // }
                    } elseif ($value->is_accepted == 2) {
                      $action = '<span class="badge badge-success">Accepted</span>';
                    } elseif ($value->is_accepted == 3) {
                      $action = '<span class="badge badge-danger">Rejected</span>';
                    }
                    echo $action;
                    ?>
                  </td>
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
        <form action="" method="post" id="expenseForm">
          @csrf

          <div class="form-group row">
            <label for="title" class="col-sm-3 col-form-label pformlabel">Select Category</label>
            <div class="col-sm-9">
              <!-- <input type="text" class="form-control  iwbb" id="title" name="title" placeholder="Enter item"> -->
              <select name="account_category_id" class="form-control ">Select Expense Category
              @if(!empty($expense_categories))
              @foreach($expense_categories as $record)
              <option value="">Select Expense Category</option>
              <option value="{{$record->id}}">{{$record->name}}</option>
              @endforeach
              @endif
              </select>
              <div class="all_errors account_category_id_error">
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label for="amount" class="col-sm-3 col-form-label pformlabel">Amount Spent</label>
            <div class="col-sm-9">
              <input type="number" class="form-control  iwbb" id="amount" name="amount" placeholder="Enter amount">
              <div class="all_errors amount_error">
              </div>
            </div>
          </div>

          <div class="form-group row">
            <label for="description" class="col-sm-3 col-form-label pformlabel">Description</label>
            <div class="col-sm-9">
              <textarea class="form-control  iwbb" id="description" name="description"></textarea>
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
              <input type="number" class="form-control  iwbb" id="amount_transfer" name="amount_transfer" placeholder="Enter amount">
              <div class="all_errors" id="amount_transfer_error">
              </div>
            </div>
          </div>

          <div class="form-group row">
            <label for="user_id" class="col-sm-3 col-form-label pformlabel">Submitted To</label>
            <div class="col-sm-9">
              <select class="form-control  iwbb " id="user_id" name="user_id">
                <option value="">Select User</option>
                <?php
                if (!empty($users)) {
                  foreach ($users as $key => $value) {
                    $isAdmin = ($value->role == 1 || $value->role == 7)?' (Admin)' : '';
                    echo '<option value="' . $value->id . '">' . $value->name . $isAdmin . '</option>';
                  }
                }
                ?>
              </select>
              <div class="all_errors" id="user_id_error">
              </div>
            </div>
          </div>
          
          <!-- <div class="form-group row">
            <label for="title" class="col-sm-3 col-form-label pformlabel">Select Category</label>
            <div class="col-sm-9">
              
              <select name="account_category_id" class="form-control ">Select Income Category
              @if(!empty($expense_categories))
              @foreach($expense_categories as $record)
              <option value="">Select Income Category</option>
              <option value="{{$record->id}}">{{$record->name}}</option>
              @endforeach
              @endif
              </select>
              <div class="all_errors account_category_id_error">
              </div>
            </div>
          </div> -->

          <div class="form-group row">
            <label for="description" class="col-sm-3 col-form-label pformlabel">Description</label>
            <div class="col-sm-9">
              <textarea class="form-control  iwbb" name="description"></textarea>
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