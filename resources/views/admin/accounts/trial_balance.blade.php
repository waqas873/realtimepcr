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

<style>
    .table > tbody > tr > td{
    text-align: center;
    padding: 5px;
    border-right: solid 1px #c3c3c3;
}

th{
    text-align: center;
    vertical-align: middle;
    border: solid 1px #c3c3c3;
}

.grandTotal {
    text-align: right;
}

th.category-header {
    border: none;
    border-bottom: solid 1px #c3c3c3;
    text-align: left;
    padding: 10px 0px 5px 0px;
}

/* Print Setting */

@media print {

    .side-menu,
    .topbar,
    .noprint {
        display: none;
    }

    .container-fluid {
        display block;
    }
}
</style>

<div class="container">

    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-5">
                        <h4 class="page-title m-0">Trial Balance</h4>
                    </div>
                    <div class="col-sm-7">
                        <div class="row emdatefilter">
                            <div class="col-sm-2 no_padd">
                                <p>Date Range</p>
                            </div>
                            <div class="col-sm-3 no_padd">
                                <input class="form-control inputs_with_bottom_border" type="date" id="from_date" name="from_date">
                            </div>
                            <div class="col-sm-1">
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
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end page-title-box -->
        </div>
    </div>
    <!-- end page title -->



</div>
<!-- end page title -->


<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div id="datatable_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                    <div class="row">
                        <div class="offset-sm-10">
                            <button type="button" onclick="window.print()" class="btn btn-primary noprint">Print Report</button>

                        </div>

                    </div>
                    <br>

                    <!-- <div class="col-sm-12 col-md-6 noprint">
                        <div class="dt-buttons btn-group"><a class="btn btn-secondary buttons-copy buttons-html5" tabindex="0" aria-controls="datatable-buttons" href="#"><span>Copy</span></a><a class="btn btn-secondary buttons-excel buttons-html5" tabindex="0" aria-controls="datatable-buttons" href="#"><span>Excel</span></a><a class="btn btn-secondary buttons-pdf buttons-html5" tabindex="0" aria-controls="datatable-buttons" href="#"><span>PDF</span></a></div>
                    </div> -->
                    <div class="table-borderless">
                        <table class="table table-hover" id="trialBalance_datatable">
                            <thead>
                                <tr>
                                    <th scope="col" rowspan="2">S.No</th>
                                    <th scope="col" rowspan="2">Particulars</th>
                                    <th scope="col" colspan="2">Opening Balance</th>
                                    <th scope="col" colspan="2">Current Month</th>
                                    <th scope="col" colspan="2">Closing Balance</th>
                                </tr>

                                <tr>
                                    <th scope="col">Debit</th>
                                    <th scope="col">Credit</th>
                                    <th scope="col">Debit</th>
                                    <th scope="col">Credit</th>
                                    <th scope="col">Debit</th>
                                    <th scope="col">Credit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th colspan="8" class="category-header">Category Heading</th>
                                </tr>
                                <tr>
                                    <td scope="col">1</td>
                                    <td scope="col">#Description here</td>
                                    <td scope="col">debit her</td>
                                    <td scope="col">credit here</td>
                                    <td scope="col">debit her</td>
                                    <td scope="col">credit here</td>
                                    <td scope="col">debit her</td>
                                    <td scope="col">credit here</td>
                                </tr>
                                <tr>
                                    <td scope="col">1</td>
                                    <td scope="col">#Description here</td>
                                    <td scope="col">debit her</td>
                                    <td scope="col">credit here</td>
                                    <td scope="col">debit her</td>
                                    <td scope="col">credit here</td>
                                    <td scope="col">debit her</td>
                                    <td scope="col">credit here</td>
                                </tr>
                                <tr>
                                    <th colspan="8" class="category-header">Category Heading</th>
                                </tr>
                                <tr>
                                    <td scope="col">1</td>
                                    <td scope="col">#Description here</td>
                                    <td scope="col">debit her</td>
                                    <td scope="col">credit here</td>
                                    <td scope="col">debit her</td>
                                    <td scope="col">credit here</td>
                                    <td scope="col">debit her</td>
                                    <td scope="col">credit here</td>
                                </tr>
                                <tr>
                                    <td scope="col">1</td>
                                    <td scope="col">#Description here</td>
                                    <td scope="col">debit her</td>
                                    <td scope="col">credit here</td>
                                    <td scope="col">debit her</td>
                                    <td scope="col">credit here</td>
                                    <td scope="col">debit her</td>
                                    <td scope="col">credit here</td>
                                </tr>
                                <tr>
                                    <td scope="col">1</td>
                                    <td scope="col">#Description here</td>
                                    <td scope="col">debit her</td>
                                    <td scope="col">credit here</td>
                                    <td scope="col">debit her</td>
                                    <td scope="col">credit here</td>
                                    <td scope="col">debit her</td>
                                    <td scope="col">credit here</td>
                                </tr>
                                <tr>
                                    <td scope="col">1</td>
                                    <td scope="col">#Description here</td>
                                    <td scope="col">debit her</td>
                                    <td scope="col">credit here</td>
                                    <td scope="col">debit her</td>
                                    <td scope="col">credit here</td>
                                    <td scope="col">debit her</td>
                                    <td scope="col">credit here</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th id="grandTotal" colspan="2">Grand Total:</th>
                                    <th>200</th>
                                    <th>200</th>
                                    <th>1212</th>
                                    <th>1212</th>
                                    <th>1212</th>
                                    <th>1212</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

</div><!-- container fluid -->

<script src="{{asset('assets/developer/admin/accounts.js')}}"></script>

@endsection