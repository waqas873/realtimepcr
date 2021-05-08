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
        <div class="col-sm-8">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-5">
                        <h4 class="page-title m-0">Income Statment</h4>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end page-title-box -->
        </div>
    </div>
    <!-- end page title -->

    <!-- <script>

$(document).on('click', '#print_cntnt', function (e) {
    var mywindow = window.open('', 'PRINT', 'height=700,width=1000');

    mywindow.document.write('<html><head><title></title>');
    mywindow.document.write('<link rel="stylesheet" href="http://pcr.realtimepcr.pk/assets/css/bootstrap.min.css">');
    mywindow.document.write('<link rel="stylesheet" href="http://pcr.realtimepcr.pk/assets/css/developer.css">');
    mywindow.document.write('<link rel="stylesheet" href="http://pcr.realtimepcr.pk/assets/css/cmp-style.css">');
    mywindow.document.write('</head><body >');
    mywindow.document.write(document.getElementById("print_section").innerHTML);
    mywindow.document.write('</body></html>');

    mywindow.document.close(); // necessary for IE >= 10
    //mywindow.focus(); // necessary for IE >= 10*/

    mywindow.print();
    //mywindow.close();

    return true;
}); -->
    </script>

    <div class="row">

        <div class="col-xl-12">
            <div class="card" id="print_section">
                <div class="card-body">


                    <div class="row component nobdr">

                        <div class="col-sm-3">
                            <p>Date Filterd From</p>
                            <h6><b>----</b></h6>
                        </div>
                        <div class="col-sm-3">
                            <p>Date Filtered To</p>
                            <h6><b>----</b></h6>
                        </div>
                        <div class="col-sm-3">
                            <p>Print Date:</p>
                            <h6>
                                <b>
                                    <?php
                                    echo date('Y-m-d H:i:s');
                                    ?>
                                </b>
                            </h6>
                        </div>
                        <div class="col-sm-3">
                            <p>Printed BY:</p>
                            <h6>

                                <b>
                                    ----
                                </b>
                            </h6>
                        </div>
                    </div>


                    <div class="row component">
                        <div class="col-sm-2">
                            <img src="https://pcr.realtimepcr.pk/assets/images/pcr-logo.png" alt="logo" class="header-logo" ;>
                        </div>
                        <div class="col-sm-8">
                            <h1 class="lab-name">
                                REALTIME PCR
                            </h1>
                            <h6 class="lab-slogan">
                                Diagnostic, Research & Reference Lab. Pvt. Ltd.
                            </h6>
                            <h6 class="lab-reg">ISO 9001-2015 Certified Laboratory</h6>
                        </div>
                        <div class="col-sm-2">
                            <div class="">
                                <img class="iso-logo" src="https://pcr.realtimepcr.pk/assets/images/iso-logo.png" alt="">
                            </div>
                        </div>

                    </div>

                    <div class="page-title">
                        <h2>INCOME STATEMENT</h2>
                    </div>
                    <style>
                        th.w80p {
                            width: 60%;
                        }

                        th.w10p {
                            width: 10%;
                        }

                        .totalRowRed {
                            color: #fff;
                            background-color: #ff000070;
                            font-weight: 600;
                            font-size: 18px;
                        }

                        .totalRowCyan {
                            color: #fff;
                            background-color: #00aaff;
                            font-weight: 600;
                            font-size: 18px;
                        }

                        .totalRowGreen {
                            color: #fff;
                            background-color: #00c169;
                            font-weight: 600;
                            font-size: 18px;
                        }
                    </style>
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="w80p">Description</th>
                                <th class="w10p"></th>
                                <th class="w10p"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Cash Sale</td>
                                <td></td>
                                <td>Rs:20000</td>
                            </tr>
                            <tr>
                                <td>Credit Sale</td>
                                <td>Rs:25000</td>
                                <td></td>
                            </tr>

                            <!-- <tr>
                                <td>Cash Received From Debtors</td>
                                <td>- Rs: 15000</td>
                                <td>Rs: 10000</td>
                            </tr> -->

                            <tr class="totalRowRed">
                                <td>Total Sale for the Month</td>
                                <td></td>
                                <td>Rs: 30000</td>
                            </tr>

                            <tr>
                                <td>Cost of Goods Sold</td>
                                <td>- Rs: 25000</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Daily Expenses</td>
                                <td>-RS 25000</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Total Direct Expenses</td>
                                <td></td>
                                <td>- Rs: 50000</td>
                            </tr>

                            <tr class="totalRowCyan">
                                <td>Gross Profit</td>
                                <td></td>
                                <td> - Rs: 20000</td>
                            </tr>


                            <tr>
                                <td>Category of the Expenses</td>
                                <td>523652</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Category of the Expenses</td>
                                <td>523652</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Category of the Expenses</td>
                                <td>523652</td>
                                <td></td>
                            </tr>

                            <tr class="totalRowGreen">
                                <td>Total Sale for the Month</td>
                                <td></td>
                                <td>Rs : 255555</td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

</div><!-- container fluid -->

<script src="{{asset('assets/developer/admin/accounts.js')}}"></script>

@endsection