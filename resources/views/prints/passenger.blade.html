<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        <?php echo $result->unique_id; ?> - Test Reports | RealtimePCR Lab Official</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />


    <!-- <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/cmp-style.css')}}" rel="stylesheet" type="text/css"> -->


    <link href="https://pcr.realtimepcr.pk/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link href="https://pcr.realtimepcr.pk/assets/css/cmp-style.css" rel="stylesheet" type="text/css">
    <!-- <link href="../../../public/assets/css/cmp-style.css" rel="stylesheet" type="text/css"> -->


    <script>
        //CheckBOX function
        function checkFunction(x, y) {
            var checkBox = document.getElementById(x);
            var cmp = document.getElementById(y);
            if (checkBox.checked == true) {
                cmp.style.display = "";
            } else {
                cmp.style.display = "none";
            }
        }
    </script>


    <link rel="stylesheet" href="..\..\..\public\assets\plugins\particlejs\particle-style.css">



    <!-- <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script> -->
    <script src="{{asset('assets/qr-code/qr_code.js')}}"></script>

</head>

<body class="reports-body">

    <div id="particles-js">
    </div>
    <div class=" mbl-screen ">
        <button type="button " onclick="window.print() " class="btn btn-light btn-lg btn-block " id="clearedPayment ">Print / Convert to PDF</button>
    </div>

    <?php
    $auth = Auth::user();
    if (!empty($auth) && ($auth->role == 1 || $auth->role == 0 || $auth->role == 7)) {
    ?>
        <div class="container controlBox " id="controlBox">
            <div class="row component ">
                <div class="col-sm-8">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input " type="checkbox" value=" " id="checkHF " onclick="checkFunction( 'checkHF', 'address-cmp'); checkFunction( 'checkHF', 'noImgHeader'); checkFunction( 'checkHF', 'imgHeader'); " checked>
                        <label class="form-check-label " for="checkHF ">Header &amp; Footer</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input " type="checkbox" value=" " id="Consultants " onclick="checkFunction( 'Consultants', 'DocList'); " checked>
                        <label class="form-check-label " for="Consultants ">Consultants</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input " type="checkbox" value=" " id="checkComments " onclick="checkFunction( 'checkComments', 'TestCmnts-cmp'); checkFunction( 'checkComments', 'LabCmnt'); " checked>
                        <label class="form-check-label " for="checkComments ">Comments</label>

                    </div>


                    <div class="form-check form-check-inline">
                        <input class="form-check-input " type="checkbox" value=" " id="overseas-cmp-check " onclick="checkFunction( 'overseas-cmp-check', 'overseas-cmp'); " checked>
                        <label class="form-check-label " for="overseas-cmp-check ">Overseas details</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input " type="checkbox" value=" " id="address-cmp-check " onclick="checkFunction( 'address-cmp-check', 'address-cmp'); " checked>
                        <label class="form-check-label " for="address-cmp-check ">Address</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input " type="checkbox" value=" " id="everify-cmnt-check " onclick="checkFunction( 'everify-cmnt-check', 'everify-cmnt'); " checked>
                        <label class="form-check-label " for="everify-cmnt-check ">E-Verification</label>

                    </div>


                    <div class="form-check form-check-inline">
                        <input class="form-check-input " type="checkbox" value=" " id="patient-cmp-check " onclick="checkFunction( 'patient-cmp-check', 'patient-cmp'); " checked>
                        <label class="form-check-label " for="patient-cmp-check ">Patient Details</label>

                    </div>
                </div>
                <div class="col-sm-4">


                    <div class="form-check form-check-inline">
                        <input class="form-check-input " type="radio" name="flexRadioDefault " id="flexRadioDefault1 ">
                        <label class="form-check-label " for="flexRadioDefault1 ">Multi Page Report</label>
                    </div>
                    <div class="form-check form-check-inline">

                        <input class="form-check-input " type="radio" name="flexRadioDefault " id="flexRadioDefault2 " checked>
                        <label class="form-check-label " for="flexRadioDefault2 ">Single Page Report</label>
                    </div>
                    <div class="">
                        <?php if (!empty($result->amount_remaining) && $result->amount_remaining > 0) { ?>
                        <p id="pendingPayment ">This patient has pending amount of <b style="color: red; font-size:20px "> Rs:<?php echo $result->amount_remaining; ?> </b>
                            <br> you're not allowed to print this report.
                            <button type="button " class="btn btn-light ">Make Payment</button>
                        </p>
                        <?php } else { ?>
                        <button type="button " onclick="window.print() " class="btn btn-primary " id="clearedPayment ">Print Report</button>
                        <div class="input-group mt-3 ">
                            <input type="text " class="form-control " placeholder="mail@domain.com " aria-label="Recipient 's Email" aria-describedby="button-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-secondary" type="button" id="button-addon2">Send as Email</button>
                            </div>
                        </div>
                        <?php } ?>


                    </div>
                </div>
                <hr>

                <div class="" style="margin: auto;">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" value="" id="passportNum-check" onclick="checkFunction('passportNum-check ','passportNum ');" checked>
                        <label class="form-check-label" for="passportNum-check">Passport</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" value="" id="country-check" onclick="checkFunction('country-check ','country ');" checked>
                        <label class="form-check-label" for="country-check">Country</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" value="" id="airline-check" onclick="checkFunction('airline-check ','airline ');" checked>
                        <label class="form-check-label" for="airline-check">Airline</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" value="" id="dateTime-check" onclick="checkFunction('dateTime-check ','dateTime ');" checked>
                        <label class="form-check-label" for="dateTime-check">Date & Time</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" value="" id="flight-check" onclick="checkFunction('flight-check ','flight ');" checked>
                        <label class="form-check-label" for="flight-check">Flight#</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" value="" id="booking-check" onclick="checkFunction('booking-check ','booking ');" checked>
                        <label class="form-check-label" for="booking-check">Booking Ref#</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" value="" id="pnrNum-check" onclick="checkFunction('pnrNum-check ','pnrNum ');" checked>
                        <label class="form-check-label" for="pnrNum-check">PNR / Ticket#</label>
                    </div>




                </div>
                <hr>

                <div class="row">
                    <div class="col-sm-12">


                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" value="" id="airportList-check" onclick="checkFunction('airportList-check ','airportList ');">
                            <label class="form-check-label" for="airportList-check">Samples Collected From</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" value="" id="peshAirport-check" onclick="checkFunction('peshAirport-check ','peshAirport ');">
                            <label class="form-check-label" for="peshAirport-check">Peshawar Airport</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" value="" id="isbAirport-check" onclick="checkFunction('isbAirport-check ','isbAirport ');">
                            <label class="form-check-label" for="isbAirport-check">Islamabad Airport</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" value="" id="lhrAirport-check" onclick="checkFunction('lhrAirport-check ','lhrAirport ');">
                            <label class="form-check-label" for="lhrAirport-check">Lahore Airport</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <hr>
                <div class="row">
                    <?php
                $total_attempts = count($result->patient_tests);
                $repeated = 0;
                if (!empty($result->patient_tests)) {
                    foreach ($result->patient_tests as $ptpt) {
                        $ans = $ptpt->patient_tests_repeated;
                        if (!empty($ans)) {
                            $total_attempts = $total_attempts + $ans->no_of_repeat;
                            $repeated = $repeated + $ans->no_of_repeat;
                        }
                    }
                }
                ?>
                        <div class="col-sm-3">
                            <p>Total Attempts = <b style="color: #00aaff;"><?php echo $total_attempts; ?></b> </p>
                        </div>
                        <div class="col-sm-3">
                            <p>Repeated <b style="color: red;"><?php echo $repeated; ?> </b> Times </p>
                        </div>

                        <?php
                $auth = Auth::user();
                if (!empty($auth->role) && $auth->role == 1) {
                ?>
                            <div class="col-sm-3" id="adminControlBox">
                                <p>Net Earnings : <b style="color: green;">Rs:- - - -</b></p>
                            </div>
                            <div class="col-sm-3" id="adminControlBox">
                                <p>Distributed Earning <b style="color: red;">Rs:- - - -</b> </p>
                            </div>
                            <?php } ?>
                </div>
            </div>
        </div>
        <?php } ?>
        <div class="container mb-5" id="print_section">
            <div class="row" style="padding: 5px;">
                <div class="col-sm-4 border-right">
                    ID: # <b>

                    <?php echo $result->unique_id; ?>
                </b>&nbsp &nbsp Patient ID: # <b>

                    <?php echo (!empty($result->patient->id)) ? $result->patient->id : '---'; ?>
                </b>
                </div>

                <div class="col-sm-4 border-right">
                    Sample Date : <b>
                    <?php
                    //echo (!empty($result->patient->sample_date))?$result->patient->sample_date:'none';
                    echo (!empty($result->created_at)) ? $result->created_at : 'none';
                    ?>
                </b>

                </div>
                <div class="col-sm-4">
                    Reporting Time :
                    <?php
                    // $rdate = explode(' ', $result->patient->created_at);
                    // $days = $result->delivery_time." days";
                    // $date=date_create($rdate[0]);
                    // date_add($date,date_interval_create_from_date_string($days));
                    //if ($result->status == 1 || $result->status == 2) {
                    echo '<strong>' . $result->updated_at . '</strong>';
                    //} else {
                    //    echo '<strong>Not Reported Yet</strong>';
                    //}
                    ?>
                </div>
            </div>

            <div class="row component" style="border: none;">

                <div class="col-sm-2 border-right">
                    <img src="https://pcr.realtimepcr.pk/assets/images/pcr-logo.png" alt="logo" class="header-logo" style="width: 100%;">
                </div>
                <div class="col-sm-5">
                    <h1 class="lab-name">
                        REALTIME PCR
                    </h1>
                    <h6 class="lab-slogan">
                        Diagnostic, Research &amp; Reference Lab. Pvt. Ltd.
                    </h6>
                    <h6 class="lab-reg">ISO 9001-2015 Certified Laboratory</h6>
                </div>
                <div class="col-sm-5 col-cs-12 d-flex">
                    <div class="qr-bg">

                        <?php if (!empty($result->patient->image)) { ?>
                        <div class="qr" id="qrCode">
                            <img class="user-img" style="width: 100%;" src="{{asset('assets/webcam/avatar/'.$result->patient->image)}}" alt="Patient Image">
                        </div>
                        <?php } else { ?>
                        <div class="qr" id="qrCode" style="border: none;!important">
                        </div>
                        <?php } ?>

                    </div>
                    <div class="qr-bg">
                        <div class="qr" id="qrCode">
                            <?php
                        $base_url = URL::to('/');
                        $qrUrl2 = $base_url . '/track/' . $result->unique_id;
                        //QR SERVER CODE
                        $src = 'https://api.qrserver.com/v1/create-qr-code/?size=95x95&data=' . $base_url . '/track/' . $result->unique_id;
                        //Google Chart QR code API
                        //$src = 'https://chart.googleapis.com/chart?chs=95x95&cht=qr&chl='.$base_url.'/track/'.$result->unique_id;
                        ?>
                                <img src="<?php echo $src; ?>" alt="" title="" class="qr-img" />
                        </div>

                        <div class="qr-url d-flex justify-content-center ">
                            <h6 class="" style="text-transform: uppercase;">TRACK Report</h6>
                        </div>
                    </div>
                    <div class="qr-bg">
                        <div class="qr" id="qrCode">

                            <?php

                    $testResult = 'Not Detected';

                    if ($result->patient_tests[0]->status == 1) {
                        $testResult = 'Detected';
                    }
                    if ($result->patient_tests[0]->status == 2) {
                        $testResult = 'Not Detected';
                    }

                    $reptime = 'Not Reported Yet';
                    if ($result->patient_tests[0]->status != 0) {
                        $reptime = $result->patient_tests[0]->updated_at;
                    }

                    $passno = (!empty($result->passenger->passport_no)) ? $result->passenger->passport_no : 'Not Available';

                    $qrr = ' Patient ID: ' . $result->patient->id . '%0A Case Id: ' . $result->unique_id . '%0A Patient Name: ' . ucwords($result->patient->name) . '%0A Reg Date: ' . $result->created_at . '%0A Reporting time: ' . $result->updated_at . '%0A Passport No: ' . $passno . '%0A Result: ' . $testResult . '';

                    // QR Server API code 

                    $url = 'https://api.qrserver.com/v1/create-qr-code/?size=95x95&data=' . $qrr . '&choe=UTF-8';

                    //Google Chart QR code API
                    // $url = 'https://chart.googleapis.com/chart?chs=95x95&cht=qr&chl='.$qrr.'&choe=UTF-8';
                    ?>
                                <img class="qr-img" src="<?php echo $url; ?>" />

                        </div>

                        <div class="qr-url d-flex justify-content-center">
                            <h6 style="text-transform: uppercase;">Verify Patient</h6>
                        </div>
                    </div>


                    <span class="badge bg-primary track-url"><i>https://pcr.realtimepcr.pk/track/126456</i></span>


                </div>
            </div>

            <div class="row border-bottom" id="patient-cmp">
                <span class="col-sm-6 sec-label"> Patient Name: 
                <span class="sec-label-ans border-bottom border-2 border-primary text-primary"><?php echo (!empty($result->patient->name)) ? ucwords($result->patient->name) : 'None'; ?>
                    (<?php
                        if (!empty($result->patient->age)) {
                            echo $result->patient->age;
                        } elseif (!empty($result->patient->dob)) {
                            $date11 = new DateTime($result->patient->dob);
                            $now11 = new DateTime();
                            $interval = $now11->diff($date11);
                            echo $interval->y;
                        } else {
                            echo " ";
                        }
                        ?>) /
                    <?php echo ($result->patient->sex == 1) ? 'Male' : 'Female'; ?></span>
                </span>

                <div class="col-sm-3 sec-label">CNIC:
                    <span class="sec-label-ans border-bottom border-2 border-primary text-primary"><?php echo (!empty($result->patient->cnic)) ? $result->patient->cnic : 'none'; ?></span>
                </div>
                <div class="col-sm-3 sec-label">Contact:
                    <span class="sec-label-ans border-bottom border-2 border-primary text-primary"><?php echo (!empty($result->patient->contact_no)) ? $result->patient->contact_no : ''; ?></span>
                </div>
            </div>

            <div class="row mt-3 border-bottom border-2 border-dark mb-2" id="overseas-cmp">
                <span class="col-sm-3 sec-label"> Passport# 
                <span class="sec-label-ans border-bottom"><?php echo (!empty($result->passenger->passport_no)) ? $result->passenger->passport_no : 'Not Available'; ?></span>
                </span>

                <div class="col-sm-3 sec-label">Flying to:
                    <span class="sec-label-ans border-bottom"><?php echo (!empty($result->passenger->country->name)) ? $result->passenger->country->name : '-- -- --'; ?></span>
                </div>

                <?php if (!empty($result->passenger->city)) { ?>
                <div class="col-sm-3 sec-label">Arrival City:
                    <span class="sec-label-ans border-bottom"> {{$result->passenger->city}}</span>
                </div>
                <?php } ?>


                <div class="col-sm-3 sec-label">Airline:
                    <span class="sec-label-ans border-bottom"><?php echo (!empty($result->passenger->airline)) ? $result->passenger->airline : 'Not Available'; ?></span>
                </div>

                <div class="col-sm-3 sec-label"> Flght Date
                    <span class="sec-label-ans border-bottom"><?php echo (!empty($result->passenger->flight_date)) ? $result->passenger->flight_date : 'Not Available'; ?></span>
                </div>

                <div class="col-sm-3 sec-label"> Flght Time#
                    <span class="sec-label-ans border-bottom"><?php echo (!empty($result->passenger->flight_time)) ? $result->passenger->flight_time : ''; ?></span>
                </div>

                <?php if (!empty($result->passenger->flight_no)) { ?>
                <div class="col-sm-3 sec-label">Flight No#
                    <span class="sec-label-ans border-bottom">{{$result->passenger->flight_no}}</span>
                </div>
                <?php } ?>

                <?php if (!empty($result->passenger->booking_ref_no)) { ?>
                <div class="col-sm-3 sec-label">Booking Ref#
                    <span class="sec-label-ans border-bottom">{{$result->passenger->booking_ref_no}}</span>
                </div>
                <?php } ?>


                <?php if (!empty($result->passenger->ticket_no)) { ?>
                <div class="col-sm-3 sec-label">PNR/Ticket#
                    <span class="sec-label-ans border-bottom">{{$result->passenger->ticket_no}}</span>
                </div>
                <?php } ?>

                <?php if (!empty($result->passenger->airport)) { ?>
                <div class="col-sm-4 sec-label">Airport
                    <span class="sec-label-ans border-bottom">{{$result->passenger->airport}}</span>
                </div>
                <?php } ?>
            </div>

            <div class="dynamic-report-sec">
                <?php
        if (!empty($result->patient_tests)) {
            foreach ($result->patient_tests as $pt) {
                $ptr = $pt->patient_test_results;
        ?>
                    <div id="rep-type">
                        <div class="row ">
                            <div class="col-sm-12">

                                <?php if (empty($ptr->manual)) { ?>
                                <h3 class="TestDepartment">
                                    Department of
                                    <?php echo (!empty($pt->test->category->name)) ? $pt->test->category->name : 'Department of Molecular Virology'; ?>
                                </h3>
                                <div id="sub-heading">
                                    <?php
                                    if ($pt->status == 2) { ?>
                                        <div class="chainReaction">
                                            <?php echo (!empty($pt->test->test_category->name)) ? $pt->test->test_category->name : 'Qualitative Polymerase Chain Reaction'; ?>
                                        </div>
                                        <br>
                                </div>
                                <?php } ?>
                                <div class="row">
                                    <!-- Test name -->
                                    <div class="col-sm-2">Test Name:</div>
                                    <div class="col-sm-10">
                                        <h6>
                                            <?php echo (!empty($pt->test->name)) ? $pt->test->name : '---'; ?>
                                        </h6>
                                    </div>
                                    <!-- Specimen -->
                                    <div class="col-sm-2">Specimen:</div>
                                    <div class="col-sm-10">
                                        <h6>
                                            <?php echo (!empty($pt->test->sample->name)) ? $pt->test->sample->name : '---'; ?>
                                        </h6>
                                    </div>

                                    <!-- <?php
                                        if ($pt->status == 2) { ?>
                                    <div class="col-sm-2">Specimen:</div>
                                    <div class="col-sm-10">
                                        <h6>
                                            <?php echo (!empty($pt->test->sample->name)) ? $pt->test->sample->name : '---'; ?>
                                        </h6>
                                    </div>
                                <?php } ?> -->

                                    <!-- Sample Collected / Airpot List -->
                                    <!-- retreiving from DB -->

                                    <?php if (!empty($result->passenger->airport)) { ?>
                                    <!-- <span class="pnrAirport-check" id="pnrAirport">
                                        <div class="col-sm-2" id="b-ref">
                                            <p class="nomgn">Sample Collected Airport</p>
                                            <h6>
                                                <strong>
                                                    {{$result->passenger->airport}}
                                                </strong>
                                            </h6>
                                        </div>
                                    </span> -->
                                    <div class="col-sm-2">Sample Collected:</div>
                                    <div class="col-sm-10">
                                        <b>{{$result->passenger->airport}}</b>
                                    </div>

                                    <?php } ?>

                                    <!-- Adjusting Airport Locally -->

                                    <!-- <div class="row airportList-check" id="airportList" style="display: none; width: 100%; margin-left: 0px;">
                                    <div class="col-sm-2">Sample Collected:</div>
                                    <div class="col-sm-10">
                                        <b class="peshAirport-check" id="peshAirport" style="display: none;">Bacha Khan International Airport, Peshawar, Pakistan </b>
                                        <b class="isbAirport-check" id="isbAirport" style="display: none;">Islamabad International Airport, Pakistan</b>
                                        <b class="lhrAirport-check" id="lhrAirport" style="display: none;">Allama Iqbal International Airport, Lahore, Pakistan.</b>
                                    </div>
                                </div> -->

                                    <!-- Test Result -->
                                    <?php
                                if ($pt->status == 0) { ?>
                                        <div class="component nomgn pad5">
                                            <div class="col-sm-2">Test Result</div>
                                            <div class="col-sm-12">
                                                <h4 class="trh4">
                                                    <?php
                                                $test_result = '<span style="color:#FF9800;">Awaiting Result</span>';
                                                echo $test_result;
                                                ?>
                                                </h4>
                                            </div>
                                        </div>
                                        <?php } ?>
                                        <?php
                                if ($pt->status == 1 || $pt->status == 2) { ?>
                                            <div class="component nomgn pad5">
                                                <div class="col-sm-2">Test Result</div>
                                                <div class="col-sm-12">
                                                    <h4 class="trh4">
                                                        <?php
                                                if ($pt->status == 1) {
                                                    $test_result = '<span style="color:#DC4D41;"> Detected</span>';
                                                }
                                                if ($pt->status == 2) {
                                                    $test_result = '<span style="color:#7AB744;">Not Detected</span>';
                                                }
                                                echo $test_result;
                                                ?>
                                                    </h4>
                                                </div>
                                            </div>
                                            <?php } ?>
                                            <?php if ($pt->status == 3) { ?>
                                            <?php if ($ptr->type == 1) { ?>
                                            <div class="component nomgn pad5">
                                                <div class="col-sm-2">Test Result</div>
                                                <div class="col-sm-12">
                                                    <h4 class="trh4">
                                                        <?php
                                                    $color = ($ptr->dropdown_value == "Positive") ? '#DC4D41' : '#7AB744';
                                                    echo '<span style="color:' . $color . ';">' . $ptr->dropdown_value . '</span>';
                                                    ?>
                                                    </h4>
                                                </div>
                                            </div>
                                            <?php } ?>
                                            <?php if ($ptr->type == 2) { ?>
                                            <div class="component nomgn pad5">
                                                <div class="col-sm-2">Test Result</div>
                                                <div class="col-sm-12">
                                                    <h4 class="trh4">
                                                        <?php
                                                    $color = ($ptr->dropdown_value == "Detected") ? '#DC4D41' : '#7AB744';
                                                    echo '<span style="color:' . $color . ';">' . $ptr->dropdown_value . '</span>';
                                                    ?>
                                                    </h4>
                                                </div>
                                            </div>
                                            <?php } ?>
                                            <?php if ($ptr->type == 3) { ?>
                                            <div class="component nomgn pad5">
                                                <div class="col-sm-2">Test Result</div>
                                                <div class="col-sm-12">
                                                    <h4 class="trh4">
                                                        <?php
                                                    $color = ($ptr->dropdown_value == "Detected") ? '#DC4D41' : '#7AB744';
                                                    echo '<span style="color:' . $color . ';">' . $ptr->dropdown_value . '</span>';
                                                    ?>
                                                    </h4>
                                                </div>
                                                <div class="col-sm-2">Value</div>
                                                <div class="col-sm-12">"
                                                    <?php echo $ptr->input_value; ?>"</div>
                                            </div>
                                            <?php } ?>
                                            <?php if ($ptr->type == 4) { ?>
                                            <!--    <div class="col-sm-2">Value</div>
                            <div class="col-sm-10">"<?php echo $ptr->input_value; ?>"</div> -->
                                            <div class="component nomgn pad5">
                                                <div class="col-sm-2">Test Results</div>
                                                <div class="col-sm-12">
                                                    <div class="table-responsive">
                                                        <table class="table mb-0 reports-table">
                                                            <tr>
                                                                <th>Parameter</th>
                                                                <th>Result</th>
                                                                <th>Units</th>
                                                                <th>Normal Value</th>
                                                            </tr>
                                                            <?php
                                                        if (!empty($ptr->patient_medicine_results)) {
                                                            foreach ($ptr->patient_medicine_results as $ptrm) {
                                                        ?>
                                                                <tr>
                                                                    <td>
                                                                        <p class="tableText">
                                                                            <?php echo $ptrm->test_categories->name; ?>
                                                                        </p>
                                                                    </td>
                                                                    <td>
                                                                        <p class="tableText">
                                                                            <?php echo $ptrm->result; ?>
                                                                        </p>
                                                                    </td>
                                                                    <td>
                                                                        <p class="tableText">
                                                                            <?php echo $ptrm->test_categories->units; ?>
                                                                        </p>
                                                                    </td>
                                                                    <td>
                                                                        <p class="tableText">
                                                                            <?php echo $ptrm->test_categories->normal_value; ?>
                                                                        </p>
                                                                    </td>

                                                                </tr>
                                                                <?php }
                                                        } ?>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>
                                            <?php if ($ptr->type == 5) { ?>
                                            <div class="component nomgn pad5">
                                                <div class="col-sm-2">Test Result</div>
                                                <div class="col-sm-12">
                                                    "
                                                    <?php echo $ptr->dropdown_value; ?>"
                                                </div>
                                            </div>
                                            <?php } ?>
                                            <?php if ($ptr->type == 6) { ?>
                                            <div class="component nomgn pad5">
                                                <div class="col-sm-2">Specie</div>
                                                <div class="col-sm-10"><b><?php echo $ptr->specie; ?></b></div>
                                                <div class="col-sm-2">Duration</div>
                                                <div class="col-sm-10"><b><?php echo $ptr->duration; ?></b></div>
                                                <div class="col-sm-2">Test Results</div>
                                                <div class="col-sm-12">
                                                    <div class="table-responsive">
                                                        <table class="table mb-0 reports-table">
                                                            <tr>
                                                                <th>Medicine</th>
                                                                <th>Label</th>
                                                                <th>Report</th>
                                                            </tr>
                                                            <?php
                                                        if (!empty($ptr->patient_medicine_results)) {
                                                            foreach ($ptr->patient_medicine_results as $ptrm) {
                                                        ?>
                                                                <tr>
                                                                    <td>
                                                                        <p class="tableText">
                                                                            <?php echo $ptrm->test_categories->name; ?>
                                                                        </p>
                                                                    </td>
                                                                    <td>
                                                                        <p class="tableText">
                                                                            <?php echo $ptrm->test_categories->medicine_label; ?>
                                                                        </p>
                                                                    </td>
                                                                    <td>
                                                                        <p class="tableText">
                                                                            <?php echo $ptrm->result; ?>
                                                                        </p>
                                                                    </td>
                                                                </tr>
                                                                <?php }
                                                        } ?>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>

                                            <?php } ?>

                                </div>
                            </div>
                            <!-- Lab User Comments For the Specific Tests if Any -->
                            <?php if (!empty($ptr->comments)) { ?>
                            <div style="width: 100%;" id="LabCmnt">

                                <div class="LabCmnts">
                                    <b><i>Lab Comments:</i></b>
                                    <p style="margin: 0px;">
                                        <?php echo $ptr->comments; ?>
                                    </p>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                        <!-- Test Comments Component (Get from DB)-->
                        <div class="TestCmnts-cmp" id="TestCmnts-cmp">
                            <p class="TestCmnts">
                                <?php if (!empty($pt->test->comments)) { ?>
                                <b>Test Comments:</b> <br>
                                <?php echo $pt->test->comments; ?>
                                <br>
                                <?php } ?>

                                <?php
                            } else {
                                echo $ptr->manual;
                            }
                        ?>
                            </p>
                        </div>
                    </div>
                    <?php }
        } ?>
            </div>



            <div id="bottom">
                <h4 class="everify-cmnt border-top" id="everify-cmnt">*NOTE: This Report is generated by realtimepcr.pk Official Web-Application and it's electronically VERIFIED,<br> NO Stamp or Signatures needed. you can verify the report by scanning the QR code.
                </h4>
                <div class="DocList border-bottom border-top" id="DocList">
                    <div class="component nobdr">
                        <div class="row">
                            <div class="col-sm-3 docCard">


                                <h5 style="display:inline;">Dr. Sajid Ali
                                    <span class="badge badge-pill badge-default" style="background-color: #0080ff; color: #fff; font-size: 12px;">Chief
                                Executive</span>

                                </h5>

                                <span class="sec-label">(Ph.D Molecular Virology)</span>
                            </div>
                            <div class="col-sm-5 docCard">
                                <h5>Dr. Shabbir Ahmad</h5>

                                <span class="sec-label">
                            MBBS, M.Phill (Pathology),
                            MPH (KMU-IPHSS),
                            MCPS Family Medicine,
                            Chemical Pathologist
                        </span>
                            </div>
                            <div class="col-sm-4 docCard" style="border: none;">
                                <h5>Dr. Nourin Mehmood</h5>

                                <span class="sec-label">
                            BS Bio-Tech, M.Phill Bio-Tech,Ph.D Bio-Tech
                        </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Lab Addresses Component -->
                <div class="row" id="address-cmp">
                    <div class="col-sm-9">
                        <div class="col-sm-12 sec-label">
                            Main Lab # : <b>Shiekh Yaseen Tower, Near Naaz Cinema, Opposite LRH OPD Gate Peshawar.</b>
                            <br> Branch LAB # 01 : <b>Mezzanine floor, Block 50, Fazal Plaza, Blue Area Islamabad</b>
                            <br> Branch LAB # 02 : <b>G-30, Ground Floor, Auqaf Plaza, Dabgari Garden Peshawar </b>
                        </div>

                    </div>
                    <div class="col-sm-3 sec-label">
                        <h6>091-2563765 , 091-2572333</h6>
                        <h6>0303-7770520</h6>
                        <h6>0303-7770522</h6>
                    </div>

                </div>


                <!-- Print Detials -->
                <div class="row f-br border-top" style="padding: 5px;">
                    <div class="col-sm-4 sec-label">
                        Printed by: <span class="sec-label-ans border-bottom"><?php echo (!empty($logged_user->name)) ? $logged_user->name : ''; ?></span>
                        <!-- <?php echo (!empty($logged_user->name)) ? $logged_user->name : ''; ?> -->
                    </div>
                    <div class="col-sm-4 sec-label">
                        Processed by: LabUser <span class="sec-label-ans border-bottom"><?php
                            if (!empty($result->patient_tests[0]->processed->name)) {
                                echo $result->patient_tests[0]->processed->name;
                            }
                            ?></span>
                        <!-- <?php
                if (!empty($result->patient_tests[0]->processed->name)) {
                    echo $result->patient_tests[0]->processed->name;
                }
                ?> -->
                    </div>
                    <div class="col-sm-4 sec-label">
                        Print Date : <span class="sec-label-ans border-bottom"><?php
                            echo date('d-M-Y <b>g:i A</b>', time() + 5 * 60 * 60);
                            ?></span>
                        <!-- <?php echo date('d-M-Y <b>g:i A</b>', time() + 5 * 60 * 60); ?> -->
                    </div>
                    <div class="copyright-footer border-bottom border-top">
                        <footer class="footer">
                            <p class="mb-0 sec-label d-flex justify-content-center">Copyright &copy;
                                <script type="text/javascript">
                                    document.write(new Date().getFullYear());
                                </script>.
                                <a href="https://www.realtimepcr.pk" target="_blank">Realtime PCR Diagnostic, Research & Reference Lab. Pvt. Ltd. </a> <span class="d-none d-sm-inline-block ">

                            <span><i>powered by:</i></span>
                                <span> <a href="https://www.artflow.pk " target="_blank "><b>Artflow Studio</b></a></span>
                                </span>
                            </p>

                            <small class="d-flex justify-content-center "><a href="https://www.realtimepcr.pk" target="_blank">https://www.realtimepcr.pk</a> --- <a href="https://www.facebook.com/realtimepcr.pk" target="_blank">facebook.com/realtimepcr.pk</a></small>
                        </footer>
                    </div>
                </div>

            </div>
        </div>


        <script src="https://pcr.realtimepcr.pk/assets/plugins/particlejs/particles.js "></script>
        <script src="https://pcr.realtimepcr.pk/assets/plugins/particlejs/app.js "></script>
        </div>
</body>

</html>