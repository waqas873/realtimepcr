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

    <script type="text/javascript">
        var base_url = '<?php echo url('/'); ?>';
    </script>
    <script src="{{asset('assets/js/jquery.min.js')}}"></script>
    <script src="{{asset('assets/developer/lab_user.js')}}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script src="https://cdn.tiny.cloud/1/v0u7jdmk1u47xhd7xzip7l7rzzz1x5y9hxaq7sk115kbjzlj/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

    <script>
        tinymce.init({
            selector: 'textarea',
            plugins: 'a11ychecker advcode casechange formatpainter linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tinycomments tinymcespellchecker',
            toolbar: 'a11ycheck addcomment showcomments casechange checklist code formatpainter pageembed permanentpen table',
            toolbar_mode: 'floating',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
        });
    </script>

    <style>
        .tox-statusbar__branding {
            display: none;
        }
    </style>

</head>

<body>
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




        <div class="row">
            <div class="col-sm-12">
                <form action="" method="post" id="manualReportForm">
                    @csrf

                    <input type="hidden" name="patient_test_id" value="{{$patient_test_id}}">

                    <div class="form-group row">
                        <div class="page-title">
                            <h2>Test Reports</h2>
                        </div>
                        <div class="col-sm-12">
                            <textarea name="manual" class="form-control inputs_with_bottom_border" style="height: 500px;"></textarea>
                            <div class="all_errors manual_error">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-primary btn-lg save_btn btn-block">Save Report</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <hr>

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

            <div class="copyright-footer">

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
</body>

</html>