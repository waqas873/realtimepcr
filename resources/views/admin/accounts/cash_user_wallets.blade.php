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
<!-- cash user wallets page -->

<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-sm-5">
                    <h4 class="page-title m-0">Cash User Wallets</h4>
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
    <div class="col-sm-12">
    <div class="card">

        <div class="card-body">
        <div class="row">
                        <div class="col-3 data-card">
                            <h3 class="val-card">Rs:{{$my_cash}}</h3>
                            <p>My Account Balance</p>
                        </div>
                        <div class="col-3 data-card">
                            <h3 class="val-card">Rs:{{$users_cash}}</h3>
                            <p>Cash with Users</p>
                        </div>
                        
                    </div>

            <table class="table table-borderless" id="cashUserWallets">
                <thead class="thead-dark">
                    <tr>
                        <th>S.No</th>
                        <th>Name</th>
                        <th>User Type</th>
                        <th>Associated LAB</th>
                        <th>Total Cash</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($records))
                    @foreach($records as $key=>$value)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{(!empty($value->name))?$value->name:'-- --'}}</td>
                        <td>
                            <?php
                            $role = 'Receptionist';
                            if($value->role==1){
                                $role = 'Admin';
                            }
                            if($value->role==7){
                                $role = 'Sub Admin';
                            }
                            echo $role;
                            ?>
                        </td>
                        <td>{{(!empty($value->lab->name))?$value->lab->name:'-- --'}}</td>
                        <td>Rs: {{(!empty($value->cash->cash_in_hand))?$value->cash->cash_in_hand:'0'}}</td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-126px, 35px, 0px);">
                                    <a href="javascript::" class="transfer_cash" rel="{{$value->id}}" id="collect">
                                        <button class="dropdown-item" type="button">Collect Cash</button>
                                    </a>
                                    <a href="javascript::" class="transfer_cash" rel="{{$value->id}}" id="transfer">
                                        <button class="dropdown-item" type="button">Transfer Amount</button>
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>

        </div>
    </div>
    </div>
</div>

<div class="modal fade" id="transferModal" tabindex="-1" role="dialog" aria-labelledby="transferModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="transferModalLabel">Transfer Amount</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">

<form id="transferForm">
@csrf

<input type="hidden" name="action" class="action">
<input type="hidden" name="id" class="user_id">

<div class="form-group">
<label for="amount">Amount</label>
<input name="amount" type="number" class="form-control amount" id="amount" aria-describedby="amount" placeholder="Enter Amount">
<div class="all_errors amount_error"></div>
</div>
<button type="submit" class="btn btn-primary btn-lg btn-block">Submit</button>
</form>
</div>
</div>
</div>
</div>

<script src="{{asset('assets/developer/admin/accounts.js')}}"></script>

@endsection