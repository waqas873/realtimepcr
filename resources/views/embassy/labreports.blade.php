


<div class="container-fluid">

<div class="row">
<div class="col-sm-12">
<div class="page-title-box">
<div class="row align-items-center">
    <div class="col-sm-5">
        <h4 class="page-title m-0">Reports</h4>
    </div>
    <div class="col-sm-7">
        <div class="row emdatefilter">
            <div class="col-sm-2 offset-sm-4 no_padd">
                <p>Date Filter</p>
            </div>
            <div class="col-sm-3 no_padd">
                <input class="form-control inputs_with_bottom_border" type="date" id="date" name="date">
            </div>
            <div class="col-sm-3">
                <a href="javascript::" class="btn btn-success embsearch" id="by_date">Search</a>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div> 


<div class="row">
<div class="col-xl-3 col-md-6">
<div class="card bg-primary mini-stat text-white">
<div class="p-3 mini-stat-desc">
    <div class="clearfix">
        <h4 class="mb-3 mt-0 float-right">{{$patients_registered}}</h4>
    </div>
    <div>
        <span class="ml-2 ml22">Patients Registered</span>
    </div>
    
</div>
<div class="p-3 p3_stat_btm">
    <div class="float-right">
        <a href="#" class="text-white-50"><i class="mdi mdi-cube-outline h5"></i></a>
    </div>
</div>
</div>
</div>

<div class="col-xl-3 col-md-6">
<div class="card bg-info mini-stat text-white" style="background-color: orange !important;">
<div class="p-3 mini-stat-desc">
    <div class="clearfix">
      <h4 class="mb-3 mt-0 float-right">{{$awaiting_results}}</h4>
    </div>
    <div> <span class="ml-2 ml22">Awaiting Results</span>
    </div>
</div>
<div class="p-3 p3_stat_btm">
    <div class="float-right">
        <a href="#" class="text-white-50"><i class="mdi mdi-buffer h5"></i></a>
    </div>
</div>
</div>
</div>
<div class="col-xl-3 col-md-6">
<div class="card bg-pink mini-stat text-white">
<div class="p-3 mini-stat-desc">
    <div class="clearfix">
        <h4 class="mb-3 mt-0 float-right">{{$sample_collected}}</h4>
    </div>
    <div> <span class="ml-2 ml22">Sample Collected</span>
    </div>
</div>
<div class="p-3 p3_stat_btm">
    <div class="float-right">
        <a href="#" class="text-white-50"><i class="mdi mdi-tag-text-outline h5"></i></a>
    </div>
</div>
</div>
</div>

<div class="col-xl-3 col-md-6">
<div class="card bg-success mini-stat text-white">
<div class="p-3 mini-stat-desc">
    <div class="clearfix">
        <h4 class="mb-3 mt-0 float-right">{{$reports_delivered}}</h4>
    </div>
    <div><span class="ml-2 ml22">Reports Delivered</span>
    </div>
</div>
<div class="p-3 p3_stat_btm">
    <div class="float-right">
        <a href="#" class="text-white-50"><i class="mdi mdi-briefcase-check h5"></i></a>
    </div>
</div>
</div>
</div>
</div>  
<!-- end row -->



<div class="row">
<div class="col-xl-12">
<div class="card">
<div class="card-body">
    <!-- <div class="row">
        <div class="col-sm-12">
         <a href="javascript::" class="btn btn-info" id="add_doctor" style="margin-bottom: 12px;">Add Doctor</a>
        </div>
    </div>  -->
    <h4 class="mt-0 header-title mb-4">Reports From Collection Points</h4>
    <div class="table-responsive">
        <table class="table table-hover" id="datatable">
            <thead>
                <tr>
                    <th scope="col">Sr#</th>
                    <th scope="col">Name</th>
                    <th scope="col">city</th>
                    <th scope="col">Patients Registered</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @if(!empty($collection_points))
                @foreach($collection_points as $key=>$value)
                <tr>
                    <td>#{{$key+1}}</td>
                    <td>{{$value->name}}</td>
                    <td>
                      {{$value->city}}  
                    </td>
                    <td>
                      <?php
                      $patients = 0;
                      foreach($value->users as $user){
                        if(!empty($date)){
                          foreach($user->patients as $pp){
                              if(strpos($pp->created_at,$date) !== false){
                                $patients = $patients+1;
                              }
                          }
                        }
                        else{
                          $patients = $patients+$user->patients->count();
                        }
                      }
                      echo $patients;
                      ?>
                    </td>
                    <td><a href="{{url('admin/staff-patients/collection-point/'.$value->id)}}" class="" target="_blank">View</a></td>
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
<!-- end row -->

<div class="row">
<div class="col-xl-12">
<div class="card">
<div class="card-body">
    <!-- <div class="row">
        <div class="col-sm-12">
         <a href="javascript::" class="btn btn-info" id="add_doctor" style="margin-bottom: 12px;">Add Doctor</a>
        </div>
    </div>  -->
    <h4 class="mt-0 header-title mb-4">Reports From Labs</h4>
    <div class="table-responsive">
        <table class="table table-hover" id="datatable2">
            <thead>
                <tr>
                    <th scope="col">Sr#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Contact No</th>
                    <th scope="col">Patients Registered</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @if(!empty($labs))
                @foreach($labs as $key=>$value)
                <tr>
                    <td>#{{$key+1}}</td>
                    <td>{{$value->name}}</td>
                    <td>
                      {{$value->contact_no}}  
                    </td>
                    <td>
                      <?php
                      $patients = 0;
                      foreach($value->users as $user){
                        if(!empty($date)){
                          foreach($user->patients as $pp){
                              if(strpos($pp->created_at,$date) !== false){
                                $patients = $patients+1;
                              }
                          }
                        }
                        else{
                          $patients = $patients+$user->patients->count();
                        }
                      }
                      echo $patients;
                      ?>  
                    </td>
                    <td><a href="{{url('admin/staff-patients/lab/'.$value->id)}}" class="" target="_blank">View</a></td>
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
<!-- end row -->

</div><!-- container fluid -->

<script src="{{asset('assets/developer/embassy.js')}}"></script>

@endsection