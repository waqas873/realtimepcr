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
                        <h4 class="page-title m-0">Invoices List</h4>
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

                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#systemInvoices" role="tab"><span class="d-none d-md-block">System Invoices</span><span class="d-block d-md-none"><i class="mdi mdi-home-variant h5"></i></span></a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#patientInvoices" role="tab"><span class="d-none d-md-block">Patients Invoices</span><span class="d-block d-md-none"><i class="mdi mdi-account h5"></i></span></a></li>
                    </ul><!-- Tab panes -->


                    <div class="tab-content">
                        <div class="tab-pane active p-3" id="systemInvoices" role="tabpanel">

                            <table class="table table-borderless" id="cashUserWallets">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Date</th>
                                        <th>Category</th>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>Generated by</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>#22568</td>
                                        <td>22-22-2021</td>
                                        <td>Daily Expense</td>
                                        <td>Expense</td>
                                        <td>RS: 2500</td>
                                        <td>User Name</td>
                                        <td>View / Delete</td>
                                    </tr>

                                </tbody>
                            </table>

                        </div>
                    
                        <div class="tab-pane p-3" id="patientInvoices" role="tabpanel">
                            <table class="table table-borderless" id="cashUserWallets">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Patient ID</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Discount</th>
                                        <th>Paid</th>
                                        <th>Balance</th>
                                        <th>Generated by</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td>#22568</td>
                                        <td>1122556</td>
                                        <td>22-22-2020</td>
                                        <td>Rs: 2500</td>
                                        <td>RS: 2500</td>
                                        <td>RS: 2500</td>
                                        <td>RS: 2500</td>
                                        <td>Receptionist Name</td>
                                        <td>View Profile</td>
                                    </tr>
                                    <tr>
                                        <td>#22568</td>
                                        <td>1122556</td>
                                        <td>22-22-2020</td>
                                        <td>Rs: 2500</td>
                                        <td>RS: 2500</td>
                                        <td>RS: 2500</td>
                                        <td>RS: 2500</td>
                                        <td>Receptionist Name</td>
                                        <td>View Profile</td>
                                    </tr>
                                    <tr>
                                        <td>#22568</td>
                                        <td>1122556</td>
                                        <td>22-22-2020</td>
                                        <td>Rs: 2500</td>
                                        <td>RS: 2500</td>
                                        <td>RS: 2500</td>
                                        <td>RS: 2500</td>
                                        <td>Receptionist Name</td>
                                        <td>View Profile</td>
                                    </tr>
                                    <tr>
                                        <td>#22568</td>
                                        <td>1122556</td>
                                        <td>22-22-2020</td>
                                        <td>Rs: 2500</td>
                                        <td>RS: 2500</td>
                                        <td>RS: 2500</td>
                                        <td>RS: 2500</td>
                                        <td>Receptionist Name</td>
                                        <td>View Profile</td>
                                    </tr>
                                    <tr>
                                        <td>#22568</td>
                                        <td>1122556</td>
                                        <td>22-22-2020</td>
                                        <td>Rs: 2500</td>
                                        <td>RS: 2500</td>
                                        <td>RS: 2500</td>
                                        <td>RS: 2500</td>
                                        <td>Receptionist Name</td>
                                        <td>View Profile</td>
                                    </tr>
                                    <tr>
                                        <td>#22568</td>
                                        <td>1122556</td>
                                        <td>22-22-2020</td>
                                        <td>Rs: 2500</td>
                                        <td>RS: 2500</td>
                                        <td>RS: 2500</td>
                                        <td>RS: 2500</td>
                                        <td>Receptionist Name</td>
                                        <td>View Profile</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


<!-- container fluid -->

<script src="{{asset('assets/developer/admin/liabilities.js')}}"></script>





@endsection