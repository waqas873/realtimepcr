@extends('layouts.pcr')
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
    <div class="col-md-8">
        <h4 class="page-title m-0">Patients</h4>
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
<div class="page-title-box">
<div class="row align-items-center">
    <div class="col-sm-5">
        <h4 class="page-title m-0">Patients List</h4>
    </div>
    <div class="col-sm-7">
        <div class="row emdatefilter">
            <div class="col-sm-2 no_padd">
                <p>Date Range</p>
            </div>
            <div class="col-sm-3 no_padd">
                <input class="form-control inputs_with_bottom_border" type="date" id="from_date" name="from_date">
            </div>
            <div class="col-sm-1"><p>To</p></div>
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

<div class="row">
<div class="col-xl-12">
<div class="card">
<div class="card-body">
    <h4 class="mt-0 header-title mb-4">Patients List</h4>
    <div class="table-responsive">
        <table class="table table-hover" id="datatable">
            <thead>
                <tr>
                    <th scope="col">Patient ID</th>
                    <th scope="col">Patient Name</th>
                    <th scope="col">Reffered By</th>
                    <th scope="col">Test</th>
                    <th scope="col">Amount Paid</th>
                    <th scope="col">Balance</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @if(!empty($patients))
                <?php $counter = count($patients) ; ?>
                @foreach($patients as $value)
                <tr>
                    <td>#{{$counter}}</td>
                    <td>{{$value->name}}</td>
                    <td><?php echo (!empty($value->user->name))?$value->user->name:'---'; ?></td>
                    <td>
                        <?php 
                            if(!empty($value->patient_tests[0]->test->name)){
                                $tooltip = '';
                                $cc = count($value->patient_tests);
                                foreach($value->patient_tests as $key2 => $test){
                                    $i = $key2+1;
                                    $tooltip .= $test->test->name;
                                    ($i<$cc)?$tooltip .= ' , ':'';
                                }
                                echo '<a href="javascript::" data-toggle="tooltip" title="'.$tooltip.'">'.$value->patient_tests[0]->test->name.'</a>';
                            }
                            else{
                                echo "---";
                            }
                        ?>
                    </td>
                    <?php 
                       $amount_paid = 0;
                       $amount_remaining = 0;
                       if(!empty($value->invoice)){
                        foreach($value->invoice as $inv){
                           $amount_paid = $amount_paid+$inv->amount_paid;
                           $amount_remaining = $amount_remaining+$inv->amount_remaining;
                        }
                       }
                    ?>
                    <td>Rs: {{$amount_paid}}</td>
                    <td>Rs: {{$amount_remaining}}</td>
                    <td><a href="{{url('patient-detail/'.$value->id)}}">View</a>
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

<script src="{{asset('assets/developer/patients.js')}}"></script>

@endsection