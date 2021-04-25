<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Realtime PCR Invoice</title>
    <meta content="Admin Dashboard" name="description" />
    <meta content="ThemeDesign" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link href="https://pcr.realtimepcr.pk/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <!-- <link href="{{asset('assets/css/cmp-style.css')}}" rel="stylesheet" type="text/css"> -->
    <link rel="stylesheet" href="https://pcr.realtimepcr.pk/assets/css/cmp-style.css">
</head>

<body>

    <div class="container" style="padding: 20px;" id="print_section">
        <div class="row">
            <div class="col-sm-4">
                Invoice ID: #
                <?php echo $result->unique_id; ?>
            </div>
            <div class="col-sm-4">
                Invoice Date :
                <?php 
                $rdate = '0000-00-00';
                if(!empty($result->patient->created_at)){
                    $rdate = explode(' ', $result->patient->created_at);
                    $rdate = $rdate[0];
                }
                echo $rdate;
              ?>
            </div>
            <div class="col-sm-4">
                Reporting Time:
                <?php 
                $days = $result->delivery_time." days";

                $date=date_create($rdate);
              date_add($date,date_interval_create_from_date_string($days));
              echo date_format($date,"Y-m-d");
                ?>
            </div>
        </div>
        <div class="row component" id="header-cmp">
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
            				$src = 'https://api.qrserver.com/v1/create-qr-code/?size=90x90&data='.$base_url.'/track/'.$result->unique_id;

            				?>
                    <img src="<?php echo $src;?>" alt="" title="" class="qr-img" />

                </div>
                <div class="qr-url">
                    <?php echo $base_url.'/track/'.$result->unique_id;?>
                </div>
            </div>
        </div>

        <!-- Patient details Component -->

        <div class="row component" id="patient-cmp">
            <div class="col-sm-8">
                <p class="cmp-header">Patient Details</p>
            </div>
            <div class="col-sm-4">
                <p class="p-id">ID #
                    <?php echo (!empty($result->patient->id))?$result->patient->id:'---'; ?>
                </p>
            </div>

            <div class="col-sm-3">
                <p> Name</p>
                <h6>
                    <strong>
                        <?php echo (!empty($result->patient->name))?ucwords($result->patient->name):'None'; ?>
                        <?php echo (!empty($result->patient->age))?$result->patient->age.' (Y)':''; ?> /
                        <?php echo (!empty($result->patient->sex) && $result->patient->sex==1)?'Male':'Female'; ?>
                    </strong>
                </h6>
            </div>
            <div class="col-sm-3">
                <p> CNIC</p>
                <h6>
                    <strong>
                        <?php echo (!empty($result->patient->cnic))?$result->patient->cnic:'none'; ?>
                    </strong>
                </h6>
            </div>
            <div class="col-sm-2">
                <p> Contact</p>
                <h6>
                    <strong>
                        <?php echo (!empty($result->patient->contact_no))?$result->patient->contact_no:''; ?>
                    </strong>
                </h6>
            </div>
            <div class="col-sm-4">
                <p> Reffered by</p>
                <h6>
                    <strong>
                        <?php echo (!empty($result->patient->user->name))?$result->patient->user->name:'None'; ?>
                    </strong>
                </h6>
            </div>
            <div class="col-sm-3">
                <p>Registered by (LAB / CP)</p>
                <h6>
                    <strong>
                        <?php
                          $registered_by = '-- -- --';
                          if(!empty($result->user->collection_point->name)){
                            $registered_by = 'Collection Point';
                          }
                          if(!empty($result->user->lab->name)){
                            $registered_by = 'Lab';
                          }
                          echo $registered_by;
                        ?>
                    </strong>
                </h6>
            </div>
            <div class="col-sm-3">
                <p>City</p>
                <h6>
                    <strong>
                        <?php
                          $city = '-- -- --';
                          if(!empty($result->user->collection_point->city)){
                            $city = $result->user->collection_point->city;
                          }
                          if(!empty($result->user->lab->city)){
                            $city = $result->user->lab->city;
                          }
                          echo $city;
                        ?>
                    </strong>
                </h6>
            </div>
            <div class="col-sm-6">
                <p>LAB / CP Name</p>
                <h6>
                    <strong>
                        <?php
                          $lab_cp = '-- -- --';
                          if(!empty($result->user->collection_point->name)){
                            $lab_cp = $result->user->collection_point->name;
                          }
                          if(!empty($result->user->lab->name)){
                            $lab_cp = $result->user->lab->name;
                          }
                          echo $lab_cp;
                        ?>
                    </strong>
                </h6>
            </div>

        </div>

        <?php if(!empty($result->passenger->passport_no)) { ?>
        <!-- Overseas Patient Component -->
        <div class="row component" id="overseas-cmp">
            <div class="col-sm-12">
                <p>Overseas Details</p>
            </div>
            <div class="col-sm-3">
                <p>Passport#</p>
                <h6>
                    <strong>
                        <?php echo (!empty($result->passenger->passport_no))?$result->passenger->passport_no:'Not Available'; ?>
                    </strong>
                </h6>
            </div>
            <div class="col-sm-3">
                <p> Flying to</p>
                <h6>
                    <strong>
                        <?php echo (!empty($result->passenger->country->name))?$result->passenger->country->name:'-- -- --'; ?>
                    </strong>
                </h6>
            </div>
            <div class="col-sm-3">
                <p> Airline</p>
                <h6>
                    <strong>
                        <?php echo (!empty($result->passenger->airline))?$result->passenger->airline:'Not Available'; ?>
                    </strong>
                </h6>
            </div>
            <div class="col-sm-3">
                <p> Flight Date & Time</p>
                <h6>
                    <strong>
                        <?php echo (!empty($result->passenger->flight_date))?$result->passenger->flight_date:'Not Available'; ?>
                        <?php echo (!empty($result->passenger->flight_time))?$result->passenger->flight_time:'Not Available'; ?>
                    </strong>
                </h6>
            </div>
        </div>
        <?php } ?>

        <!-- Tests Area Component -->

        <div class="row component" id="test-area-cmp">
            <div class="col-sm-12">
                <table class="table table-hover">
                    <thead style="background: #DADADA;">
                        <tr>
                            <th scope="col">Case ID</th>
                            <th scope="col">Test Name</th>
                            <th scope="col" style="text-align: right;">Amount</th>
                        </tr>
                    </thead>
                    <tbody id="tests_detail">
                        <?php
                                    if(!empty($result->patient_tests)){
                                        foreach($result->patient_tests as $key2 => $test){
                                            echo '<tr>
                                                <td>#'.$test->test->id.'</td>
                                                <td>'.$test->test->name.'</td>
                                                <td style="text-align: right;color: #5D7BFF;">Rs: '.$test->test->price.'</td>
                                            </tr>';
                                        }
                                    }
                                    ?>
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-sm-4 offset-sm-9" id="total_details">
                        <div class="row">
                            <div class="col-sm-6 amp1">
                                Total Amount
                            </div>
                            <div class="col-sm-6 amp2">
                                Rs: {{$result->total_amount}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 amp1">
                                Discount
                            </div>
                            <div class="col-sm-6 amp2">
                                Rs: {{$result->total_discount}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 amp1">
                                Advance
                            </div>
                            <div class="col-sm-6 amp2">
                                Rs: {{$result->amount_paid}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 amp1">
                                Balance
                            </div>
                            <div class="col-sm-6 amp2">
                                Rs: {{$result->amount_remaining}}
                            </div>
                        </div>

                    </div>
                </div>
            </div>


        </div>
        <div class="row component nobdr" id="inv-comment-cmp">
          <p class="TestCmnts">
            Thank you for Choosing <b> RealtimePCR Lab,</b> You can track your report status online by scanning the QR
            Code.
            <br>
            *NOTE:
            you will not be able to track your reports if you have pending amount.
        </p>
        </div>

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
        <div class="row">
            <div class="col-sm-8">
                Printed by:
                <?php echo $printed_by;?>
            </div>
            <div class="col-sm-4">
                Print Date :
                <?php  
                    echo date('Y-m-d H:i:s');
                  ?>
            </div>
        </div>

        <div class="copyright-footer">
            <hr>
            <footer class="footer">
                <p>Copyright &copy;
                    <script type="text/javascript">
                        document.write(new Date().getFullYear());
                    </script>. Realtime PCR Lab <span class="d-none d-sm-inline-block">

                        <span><i>powered by</i></span> <span> <a href="https://www.artflow.pk" target="_blank">Artflow
                                Studio</a></span< /p>
            </footer>
        </div>
    </div>
    </div>
    </div>

</html>