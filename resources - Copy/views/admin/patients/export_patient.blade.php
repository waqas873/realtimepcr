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
<!DOCTYPE html>
<html lang="en">

<head>
    


    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Fetched Data</title>
    <link href="https://pcr.realtimepcr.pk/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="https://pcr.realtimepcr.pk/assets/css/cmp-style.css" rel="stylesheet" type="text/css">


</head>

<body>
    <?php $id = (rand(1000,9999)); ?>

    <div class="container-fluid">
        <p> <i>

            This Report is generated by RealtimePCR webApp " 
            <b>
                <?php echo "Rep-{$id}"; ?> "
            </b>
            
        </i>
        </p>
<div class="divHeader">
            <div class="row component" id="noImgHeader">
                <div class="col-sm-2">
                    <img src="https://pcr.realtimepcr.pk/assets/images/pcr-logo.png" alt="logo" class="header-logo"
                        ;="">
                </div>
                <div class="col-sm-8">
                    <h1 class="lab-name">
                        REALTIME PCR
                    </h1>
                    <h5 class="lab-slogan">
                        Diagnostic, Research &amp; Reference Lab. Pvt. Ltd.
                    </h5>
                    <h6 class="lab-reg">ISO 9001-2015 Certified Laboratory</h6>
                    
                </div>
                <div class="col-sm-2">
                    <div class="">
                        <img class="iso-logo" src="https://pcr.realtimepcr.pk/assets/images/iso-logo.png" alt="">
                    </div>
                </div>

            </div>
        </div>

        <div class="row component" id="patient-cmp">

            <!-- <div class="col-sm-4">
                <p>Lab/CP Name</p>
                <h6>
                    <strong>
                        ----</strong>
                </h6>

            </div>
            <div class="col-sm-2">
                <p> Contact </p>
                <h6>
                    <strong> ---- </strong>
                </h6>
            </div>

            <div class="col-sm-2">
                <p> City </p>
                <h6>
                    <strong>----</strong>
                </h6>
            </div>

            <div class="col-sm-4">
                <p>Lab/Cp Address</p>
                <h6>
                    <b>----</b>
                </h6>
            </div>
            <hr> -->
            <div class="col-sm-2">
                <p>No. of Records</p>
                <h6><b>----</b></h6>
            </div>
            <div class="col-sm-2">
                <p>Date Filterd From</p>
                <h6><b>----</b></h6>
            </div>
            <div class="col-sm-2">
                <p>Date Filtered To</p>
                <h6><b>----</b></h6>
            </div>
            <div class="col-sm-2">
                <p>Reports ID</p>
                <h6><b><?php echo "Rep-{$id}"; ?></b></h6>
            </div>
            <div class="col-sm-2">
                <p>Print Date:</p>
                <h6>
                    <b>
                        <?php  
                                echo date('Y-m-d H:i:s');
                        ?>
                    </b>
                </h6>
                </b>
            </div>
            <div class="col-sm-2">
                <p>Printed BY:</p>
                <h6>
                    
                    <b>
                        ----
                    </b>
                </h6>
                </b>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card" style="margin-top: 50px;">
                    <div class="card-body">
                        <h4 class="mt-0 header-title mb-4">Patients List</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th scope="col">Patient ID</th>
                                        <th scope="col">Patient Name</th>
                                        <th scope="col">Reffered By</th>
                                        <th scope="col">Test</th>
                                        <th scope="col">Invoice ID</th>
                                        <th scope="col">Amount Paid</th>
                                        <th scope="col">Balance</th>
                                        <th scope="col">Added By</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($patients))
                                    @foreach($patients as $item)
                                    <?php 
                  $amount_paid = 0;
                  $amount_remaining = 0;
                  if(!empty($item->invoice)){
                   foreach($item->invoice as $inv){
                     $amount_paid = $amount_paid+$inv->amount_paid;
                     $amount_remaining = $amount_remaining+$inv->amount_remaining;
                   }
                  }
                ?>
                                    <tr>
                                        <td>
                                            <?php echo '#'.$item->id;?>
                                        </td>
                                        <td>
                                            <?php echo (!empty($item->name))?$item->name:'unavailable';?>
                                        </td>
                                        <td>
                                            <?php echo (!empty($item->user->name))?$item->user->name:'---';?>
                                        </td>
                                        <td>
                                            <?php
                      $tests = '---';
                      if(!empty($item->patient_tests[0]->test->name)){
                          $tooltip = '';
                          $cc = count($item->patient_tests);
                          foreach($item->patient_tests as $key2 => $test){
                              $i = $key2+1;
                              $tooltip .= $test->test->name;
                              ($i<$cc)?$tooltip .= ' , ':'';
                          }
                          $tests = '<a href="javascript::" data-toggle="tooltip" title="'.$tooltip.'">'.$item->patient_tests[0]->test->name.'</a>';
                      }
                      echo $tests;
                    ?>
                                        </td>
                                        <td>
                                            <?php echo (!empty($item->invoice[0]->unique_id))?'#'.$item->invoice[0]->unique_id:'---';?>
                                        </td>
                                        <td>
                                            <?php echo "Rs ".$amount_paid;?>
                                        </td>
                                        <td>
                                            <?php echo "Rs ".$amount_remaining;?>
                                        </td>
                                        <td>
                                            <?php echo (!empty($item->users->name))?$item->users->name:'-- --';?>
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
        </div>
        <p> <i>

            This Report is generated by RealtimePCR webApp " 
            <b>
                <?php echo "Rep-{$id}"; ?> "
            </b>
            
        </i>
        </p>
        <!-- end row -->


    </div><!-- container fluid -->

    <script src="{{asset('assets/developer/admin/patients.js')}}"></script>


</body>

</html>