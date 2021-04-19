<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Realtime PCR | Test Reports</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link href="https://pcr.realtimepcr.pk/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/cmp-style.css')}}" rel="stylesheet" type="text/css">


    <!-- <link rel="stylesheet" href="https://pcr.realtimepcr.pk/assets/css/cmp-style.css"> -->


    <!-- <link rel="stylesheet" href="cmp-style.css"> -->

    <script>
        function checkFunction(x, y) {
            var checkBox = document.getElementById(x);
            var cmp = document.getElementById(y);
            if (checkBox.checked disabled == true) {
                cmp.style.display = "";
            } else {
                cmp.style.display = "none";
            }
        }
    </script>

</head>

<body>
    <!-- Errors -->

    <!--

    <div class="container" style="padding: 20px;" id="errPayment">
        <div class="component">
            <h2 style="text-align: center; color: grey; font-size: 26px;">
                Please pay your pending amount of <span style="color: red;">Rs: 2500 </span>to get your Results
            </h2>
            <hr>
            <img src="https://pcr.realtimepcr.pk/assets/images/errPayment.jpg" alt="Payment Error" class="errImg">
        </div>
    </div>

    <div class="container" style="padding: 20px;" id="errAwaiting">
        <div class="component">
            <h2 style="text-align: center; color: grey; font-size: 26px;">
                Your Test is in Process.</h2>
            <hr>
            <img src="https://pcr.realtimepcr.pk/assets/images/errAwaiting.jpg" alt="Payment Error" class="errImg">
        </div>
    </div>

    <div class="container" style="padding: 20px;" id="errNoRecord">
        <div class="component">
            <img src="https://pcr.realtimepcr.pk/assets/images/errNoRecord.jpg" alt="Payment Error" class="errImg">
        </div>
    </div>


        -->
    <div class="container controlBox" id="controlBox">
        <div class="row component">


            <div class="col-sm-2">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="checkHF" onclick="checkFunction('checkHF','address-cmp'); checkFunction('checkHF','noImgHeader'); checkFunction('checkHF','imgHeader');" checked disabled>
                    <label class="form-check-label" for="checkHF">Header &amp; Footer</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="Consultants" onclick="checkFunction('Consultants','DocList');" checked disabled>
                    <label class="form-check-label" for="Consultants">Consultants</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="checkComments" onclick="checkFunction('checkComments','TestCmnts-cmp'); checkFunction('checkComments','LabCmnt');" checked disabled>
                    <label class="form-check-label" for="checkComments">Comments</label>

                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="overseas-cmp-check" onclick="checkFunction('overseas-cmp-check','overseas-cmp');" checked disabled>
                    <label class="form-check-label" for="overseas-cmp-check">Overseas details</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="address-cmp-check" onclick="checkFunction('address-cmp-check','address-cmp');" checked disabled>
                    <label class="form-check-label" for="address-cmp-check">Address</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="everify-cmnt-check" onclick="checkFunction('everify-cmnt-check','everify-cmnt');" checked disabled>
                    <label class="form-check-label" for="everify-cmnt-check">E-Veridication</label>

                </div>
            </div>
            <div class="col-sm-3">

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                    <label class="form-check-label" for="flexRadioDefault1">Multi Page Report</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked disabled>
                    <label class="form-check-label" for="flexRadioDefault2">Single Page Report</label>
                </div>
            </div>
            <div class="col-sm-4">
                <button type="button" class="btn btn-light">Download PDF</button>
                <button type="button" onclick="window.print()" class="btn btn-primary">Print Report</button>
            </div>
        </div>
    </div>

    <div class="container" style="padding: 20px" ; id="print_section">
        <div class="row component" style="padding: 5px;">
            <div class="col-sm-4">
                Case ID: # <b>

                    <?php echo $result->unique_id; ?>
                </b>
            </div>
            <div class="col-sm-4">
                Sample Date : <b>
                    <?php
                    //echo (!empty($result->patient->sample_date))?$result->patient->sample_date:'none';
                    echo (!empty($result->created_at)) ? $result->created_at : 'none';
                    ?>
                </b>

            </div>
            <div class="col-sm-4">
                Reporting Time:
                <?php
                // $rdate = explode(' ', $result->patient->created_at);
                // $days = $result->delivery_time." days";
                // $date=date_create($rdate[0]);
                // date_add($date,date_interval_create_from_date_string($days));
                if ($result->status == 3 || $result->status == 5) {
                    echo '<strong>' . $result->updated_at . '</strong>';
                } else {
                    echo '<strong>Not Reported Yet</strong>';
                }
                ?>

            </div>
        </div>

        <!-- Image Header Section -->
        <?php if (!empty($result->patient->image)) { ?>

            <div class="row component" id="imgHeader">
                <div class="col-sm-2">
                    <img src="https://pcr.realtimepcr.pk/assets/images/pcr-logo.png" alt="logo" class="header-logo" ;>
                </div>
                <div class="col-sm-4">
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
                <div class="col-sm-2">
                    <div class="qr">
                        <img class="user-img" style="width: 100%;" src="{{asset('assets/webcam/avatar/'.$result->patient->image)}}" alt="Patient Image">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="qr">
                        <?php
                        $base_url = URL::to('/');
                        //QR SERVER CODE
                        $src = 'https://api.qrserver.com/v1/create-qr-code/?size=90x90&data=' . $base_url . '/track/' . $result->unique_id;
                        //Google Chart QR code API
                        //$src = 'https://chart.googleapis.com/chart?chs=125x125&cht=qr&chl='.$base_url.'/track/'.$result->unique_id;
                        ?>
                        <img src="<?php echo $src; ?>" alt="" title="" class="qr-img" />
                    </div>
                    <div class="qr-url">
                        <?php echo $base_url . '/track/' . $result->unique_id; ?>
                    </div>
                </div>
            </div>
        <?php } else { ?>
            <!-- No Image Header -->
            <div class="row component" id="noImgHeader">
                <div class="col-sm-2">
                    <img src="https://pcr.realtimepcr.pk/assets/images/pcr-logo.png" alt="logo" class="header-logo" ;>
                </div>
                <div class="col-sm-6">
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
                <div class="col-sm-2">
                    <div class="qr">
                        <?php
                        $base_url = URL::to('/');

                        //QR SERVER CODE
                        $src = 'https://api.qrserver.com/v1/create-qr-code/?size=90x90&data=' . $base_url . '/track/' . $result->unique_id;

                        //Google Chart QR code API
                        //$src = 'https://chart.googleapis.com/chart?chs=125x125&cht=qr&chl='.$base_url.'/track/'.$result->unique_id;
                        ?>
                        <img src="<?php echo $src; ?>" alt="" title="" class="qr-img" />

                    </div>
                    <div class="qr-url">
                        <?php echo $base_url . '/track/' . $result->unique_id; ?>
                    </div>
                </div>
            </div>
        <?php } ?>

        <!-- Patient Details Section  -->

        <div class="row component nobdr" id="patient-cmp">
            <!-- <div class="col-sm-12">
                <h6 class="cmp-header">Patient Details</h6>
            </div> -->


            <div class="col-sm-4">
                <p>Name</h6>
                <h6>
                    <strong>
                        <?php echo (!empty($result->patient->name)) ? ucwords($result->patient->name) : 'None'; ?>
                        <?php echo (!empty($result->patient->age)) ? $result->patient->age . ' (Y)' : ''; ?> /
                        <?php echo ($result->patient->sex == 1) ? 'Male' : 'Female'; ?>
                    </strong>
                </h6>

            </div>
            <div class="col-sm-2">
                <p> CNIC</p>
                <h6>
                    <strong>
                        <?php echo (!empty($result->patient->cnic)) ? $result->patient->cnic : 'none'; ?>
                    </strong>
                </h6>
            </div>
            <div class="col-sm-2">
                <p> Contact</p>
                <h6>
                    <strong>
                        <?php echo (!empty($result->patient->contact_no)) ? $result->patient->contact_no : ''; ?>
                    </strong>
                </h6>
            </div>
            <div class="col-sm-2">
                <p>Patient ID #</p>
                <h6>
                    <b>
                        <?php echo (!empty($result->patient->id)) ? $result->patient->id : '---'; ?>
                    </b>
                </h6>
            </div>
            <div class="col-sm-2">
                <div class="qr">

                    <?php

                    $testResult = 'Awaiting Result';
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

                    $url = 'https://api.qrserver.com/v1/create-qr-code/?size=90x90&data=' . $qrr . '&choe=UTF-8';

                    //Google Chart QR code API
                    // $url = 'https://chart.googleapis.com/chart?chs=125x125&cht=qr&chl='.$qrr.'&choe=UTF-8';
                    ?>

                    <img class="qr-img" src="<?php echo $url; ?>" />
                </div>
            </div>
        </div>

        <hr>
        <!-- Overseas Details Section -->

        <div class="row" id="overseas-cmp">
            <div class="col-sm-2">
                <p class="nomgn">Passport#</p>
                <h6>
                    <strong>
                        <?php echo (!empty($result->passenger->passport_no)) ? $result->passenger->passport_no : 'Not Available'; ?>
                    </strong>
                </h6>
            </div>
            <div class="col-sm-2">
                <p class="nomgn"> Flying to</p>
                <h6>
                    <strong>
                        <?php echo (!empty($result->passenger->country->name)) ? $result->passenger->country->name : '-- -- --'; ?>
                    </strong>
                </h6>
            </div>
            <div class="col-sm-2">
                <p class="nomgn"> Airline</p>
                <h6>
                    <strong>
                        <?php echo (!empty($result->passenger->airline)) ? $result->passenger->airline : 'Not Available'; ?>
                    </strong>
                </h6>
            </div>
            <div class="col-sm-2">
                <p class="nomgn"> Flight Date & Time</p>
                <h6>
                    <strong>
                        <?php echo (!empty($result->passenger->flight_date)) ? $result->passenger->flight_date : 'Not Available'; ?>
                        <?php echo (!empty($result->passenger->flight_time)) ? $result->passenger->flight_time : ''; ?>
                    </strong>
                </h6>
            </div>

            <?php if (!empty($result->passenger->flight_no)) { ?>
                <div class="col-sm-2" id="b-ref">
                    <p class="nomgn">Flight No#</p>
                    <h6>
                        <strong>
                            {{$result->passenger->flight_no}}
                        </strong>
                    </h6>
                </div>
            <?php } ?>

            <?php if (!empty($result->passenger->booking_ref_no)) { ?>
                <div class="col-sm-2" id="b-ref">
                    <p class="nomgn">Booking Ref#</p>
                    <h6>
                        <strong>
                            {{$result->passenger->booking_ref_no}}
                        </strong>
                    </h6>
                </div>
            <?php } ?>
            <?php if (!empty($result->passenger->ticket_no)) { ?>
                <div class="col-sm-2" id="b-ref">
                    <p class="nomgn">PNR/Ticket Number</p>
                    <h6>
                        <strong>
                            {{$result->passenger->ticket_no}}
                        </strong>
                    </h6>
                </div>
            <?php } ?>
        </div>
        <hr>
        <div class="page-title">
            <h2>Test Reports</h2>
        </div>

        <?php
        if (!empty($result->patient_tests)) {
            foreach ($result->patient_tests as $pt) {
                $ptr = $pt->patient_test_results;
        ?>
                <div id="rep-type">
                    <div class="row ">
                        <div class="col-sm-12">
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

                            <?php
                            if ($pt->status == 2) { ?>

                                <div class="col-sm-2">Specimen:</div>
                                <div class="col-sm-10">
                                    <h6>

                                        <?php echo (!empty($pt->test->sample->name)) ? $pt->test->sample->name : '---'; ?>
                                    </h6>
                                </div>

                            <?php } ?>
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
                                        <div class="col-sm-12">"<?php echo $ptr->input_value; ?>"</div>
                                    </div>
                                <?php } ?>
                                <?php if ($ptr->type == 4) { ?>
                                    <!-- <div class="col-sm-2">Value</div>
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
                                                                    <p class="tableText"><?php echo $ptrm->test_categories->name; ?></p>
                                                                </td>
                                                                <td>
                                                                    <p class="tableText"><?php echo $ptrm->result; ?></p>
                                                                </td>
                                                                <td>
                                                                    <p class="tableText"><?php echo $ptrm->test_categories->units; ?></p>
                                                                </td>
                                                                <td>
                                                                    <p class="tableText"><?php echo $ptrm->test_categories->normal_value; ?></p>
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
                                            "<?php echo $ptr->dropdown_value; ?>"
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
                                                                    <p class="tableText"><?php echo $ptrm->test_categories->name; ?></p>
                                                                </td>
                                                                <td>
                                                                    <p class="tableText"><?php echo $ptrm->test_categories->medicine_label; ?></p>
                                                                </td>
                                                                <td>
                                                                    <p class="tableText"><?php echo $ptrm->result; ?></p>
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
                                <hr>
                                <div class="LabCmnts">
                                    <b><i>Lab Technician Comments:</i></b>
                                    <p style="margin: 0px;"><?php echo $ptr->comments; ?></p>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <!-- Test Comments Component (Get from DB)-->
                    <div class="TestCmnts-cmp" id="TestCmnts-cmp">
                        <p class="TestCmnts">
                            <?php if (!empty($pt->test->comments)) { ?>
                                <b>Methodology:</b>
                                <?php echo $pt->test->comments; ?>
                                <br>
                            <?php } ?>
                            <b>Note:</b> Negative results do not exclude infection, might a person get infection after the test.
                            Secondly, persons who are positive for Covid-19 RNA may be quarantined according to the
                            WHO/NIH/Government Health policy.
                        </p>
                    </div>
                </div>
        <?php }
        } ?>

        <!-- Electronic Verification -->
        <br>
        <h4 class="everify-cmnt" id="everify-cmnt">*NOTE: This Report is generated by realtimepcr.pk Official Web-Application and it's
            electronically VERIFIED,<br> NO Stamp or Signatures needed. you can verify the report by scanning the QR
            code.
        </h4>
        <hr>

        <!-- Doctors List -->

        <div class="DocList" id="DocList">
            <div class="component nobdr">
                <div class="row">
                    <div class="col-sm-3 docCard">


                        <h5 style="display:inline;">Dr. Sajid Ali
                            <span class="badge badge-pill badge-default" style="background-color: #0080ff; color: #fff; font-size: 12px;">Chief
                                Executive</span>

                        </h5>

                        <h6>(Ph.D Molecular Virology)</h6>
                    </div>
                    <!-- <div class="col-sm-3 docCard">
                        <h5>Dr. M.Riazuddin Ghauri</h5>

                        <p>M.Phil Haematology
                            <br>
                            Head of pathology Department
                            <br>
                            NMC/QHAMC
                        </p>
                        <p></p>
                    </div> -->
                    <div class="col-sm-5 docCard">
                        <h5>Dr. Shabbir Ahmad</h5>

                        <p>
                            MBBS, M.Phill (Pathology),
                            MPH (KMU-IPHSS),
                            MCPS Family Medicine,
                            Chemical Pathologist
                        </p>
                    </div>
                    <div class="col-sm-4 docCard" style="border: none;">
                        <h5>Dr. Nourin Mehmood</h5>

                        <p>
                            BS Bio-Tech, M.Phill Bio-Tech,Ph.D Bio-Tech
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Doctors List Image Component -->

        <!-- <div class="component">

            <img class="DocList" style="width: 100%;" src="/assets/images/realtime-report-footer.jpg" alt="Doctors List"
                class="reports-footer">

        </div> -->


        <!-- Lab Address Component -->
        <div class="row component" id="address-cmp">
            <div class="col-sm-9">
                <div class="col-sm-12">
                    Main Lab # : <b>Shiekh Yaseen Tower, Near Naaz Cinema, Opposite LRH OPD Gate Peshawar.</b>
                    <br>
                    Branch LAB # 01 : <B>Mezzanine floor, Block 50, Fazal Plaza, Blue Area Islamabad</B>
                    <br>
                    Branch LAB # 02 : <b>G-30, Ground Floor, Auqaf Plaza, Dabgari Garden Peshawar </b>
                </div>

            </div>
            <div class="col-sm-3">
                <h6>091-2563765 , 091-2572333</h6>
                <h6>0303-7770520</h6>
                <h6>0303-7770522</h6>
            </div>

        </div>

        <!-- Print Detials -->
        <div class="row f-br component nomgn" style="padding: 5px;">
            <div class="col-sm-4">
                Printed by:
                <?php echo (!empty($logged_user->name)) ? $logged_user->name : ''; ?>
            </div>
            <div class="col-sm-4">
                Processed by:
                <?php
                if (!empty($result->patient_tests[0]->processed->name)) {
                    echo $result->patient_tests[0]->processed->name;
                }
                ?>
            </div>
            <div class="col-sm-4">
                Print Date :
                <?php
                echo date('Y-m-d H:i:s');
                ?>
            </div>
            <div class="copyright-footer">
                <hr>
                <footer class="footer">
                    <p>Copyright &copy;
                        <script type="text/javascript">
                            document.write(new Date().getFullYear());
                        </script>. Realtime PCR Lab <span class="d-none d-sm-inline-block">

                            <span><i>powered by</i></span>
                            <span> <a href="https://www.artflow.pk" target="_blank">Artflow Studio</a></span>
                </footer>
            </div>


        </div>
    </div>
    </div>
    </div>
</body>

</html>