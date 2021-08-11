@extends('layouts.lab_user')
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

  <div class="row" style="margin-top: 95px;">
    <div class="col-xl-3 col-md-6">
      <div class="card bg-primary mini-stat text-white">
        <div class="p-3 mini-stat-desc">
          <div class="clearfix">
            <h6 class="text-uppercase mt-0 float-left text-white-50">Tests</h6>
            <h4 class="mb-3 mt-0 float-right">
              {{$in_process}}
            </h4>
          </div>
          <div>
            <span class="ml-2">Tests in Process</span>
          </div>

        </div>
        <div class="p-3">
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-md-6">
      <div class="card bg-info mini-stat text-white">
        <div class="p-3 mini-stat-desc">
          <div class="clearfix">
            <h6 class="text-uppercase mt-0 float-left text-white-50">Tests</h6>
            <h4 class="mb-3 mt-0 float-right">{{$performed}}</h4>
          </div>
          <div> <span class="ml-2">Tests Performed</span>
          </div>
        </div>
        <div class="p-3">
        </div>
      </div>
    </div>


    <div class="col-xl-3 col-md-3">
      <div class="card bg-info mini-stat text-white">
        <div class="p-3 mini-stat-desc">
          <div class="clearfix">
            <h6 class="text-uppercase mt-0 float-left text-white-50">Tests</h6>
            <h4 class="mb-3 mt-0 float-right">{{$repeated_tests}}</h4>
          </div>
          <div> <span class="ml-2">Repeated Tests</span>
          </div>
        </div>
        <div class="p-3">
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-3">
      <div class="card bg-info mini-stat text-white">
        <div class="p-3 mini-stat-desc">
          <div class="clearfix">
            <h6 class="text-uppercase mt-0 float-left text-white-50">Tests</h6>
            <h4 class="mb-3 mt-0 float-right">{{$repeat_ratio}}%</h4>
          </div>
          <div> <span class="ml-2">Repeat Ratio</span>
          </div>
        </div>
        <div class="p-3">
        </div>
      </div>
    </div>
  </div>


</div>
</div>
<!-- end row -->

<div class="row">
  <div class="col-sm-12">
    <div class="page-title-box">
      <div class="row align-items-center">
        <div class="col-md-8">
          <h4 class="page-title m-0">Open Cases</h4>
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
        <!-- <div class="row">
        <div class="col-sm-12">
         <a href="javascript::" class="btn btn-info" id="add_doctor" style="margin-bottom: 12px;">Add Doctor</a>
        </div>
    </div>  -->
        <h4 class="mt-0 header-title mb-4">Open Cases List</h4>
        <div class="table-responsive">
          <table class="table table-hover" id="datatable">
            <thead>
              <tr>
                <th scope="col">Invoice ID</th>
                <th scope="col">Patient Name</th>
                <th scope="col">Test Name</th>
                <th scope="col">Reg Date</th>
                <th scope="col">Available Kits / Select Kit</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              @if(!empty($tests))
              @foreach($tests as $key=>$value)
              @if(!empty($value->invoice->unique_id))
              <tr>
                <td>
                  <?php echo (!empty($value->invoice->unique_id)) ? '#' . $value->invoice->unique_id : '---'; ?>
                </td>
                <td>
                  <?php echo (!empty($value->patient->name)) ? $value->patient->name : '---'; ?>
                </td>
                <td>{{(!empty($value->test->name))?$value->test->name:'-- --'}}</td>
                <td>{{$value->created_at}}</td>
                <td><a href="" class="" data-toggle="modal" data-target="#kitView"> <span class="btn btn-light" style=""> 0 </span> Select Kit</a> </td>
                <td>
                  <!-- <?php
                        $datetime = strtotime($value->invoice->created_at);
                        if (strtotime("-0 hours") > $datetime) {
                        ?> -->
                  <!--                       
                  <a href="{{url('lab/detected/'.$value->id)}}"
                    class="btn btn-sm btn-success detected_or_not">Detected</a>
                  <a href="{{url('lab/not_detected/'.$value->id)}}" class="btn btn-sm btn-danger detected_or_not">Not
                    Detected</a> -->

                  <a href="{{$value->id}}" rel="{{!(empty($value->test->reporting_units->type))?$value->test->reporting_units->type:''}}" class="btn btn-success waves-effect waves-light submit_reports">Submit Report</a>


                  <div class="btn-group">
                    <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                    <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-126px, 35px, 0px);">
                      <?php
                          $id = createBase64($value->id);
                      ?>
                      <a href="{{url('lab/repeat-test/'.$id)}}" class="repeat_test_id">
                        <button class="dropdown-item" type="button">Repeat Test</button>
                      </a>
                      <a href="{{url('lab/manual/'.$id)}}" class="">
                        <button class="dropdown-item" type="button">MS-Word Report</button>
                      </a>

                    </div>
                  </div>




                <?php
                        } else {
                          echo "-- -- --";
                        }
                ?>
                </td>
              </tr>
              @endif
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

</div>

<!-- container fluid -->

<!-- Modal -->
<!-- <div class="modal fade" id="doctorsModal" tabindex="-1" role="dialog" aria-labelledby="doctorsModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content add-test-content">
      <div class="modal-header">
        <h5 class="modal-title" id="doctorssLabel">Add Doctor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="post" id="doctors-form">
          @csrf

          <input type="hidden" name="id" value="" id="update_id">

          <div class="form-group row">
            <label for="name" class="col-sm-3 col-form-label pformlabel">Doctor Name</label>
            <div class="col-sm-9">
              <input type="text" class="form-control inputs_with_bottom_border" id="name" name="name"
                placeholder="Enter doctor name">
              <div class="all_errors" id="name_error">
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label for="email" class="col-sm-3 col-form-label pformlabel">Doctor email</label>
            <div class="col-sm-9">
              <input type="text" class="form-control inputs_with_bottom_border" id="email" name="email"
                placeholder="Enter doctor email">
              <div class="all_errors" id="email_error">
              </div>
            </div>
          </div>

          <div class="form-group row">
            <label for="hospital" class="col-sm-3 col-form-label pformlabel">Hospital/Clinic Name</label>
            <div class="col-sm-9">
              <input type="text" class="form-control inputs_with_bottom_border" id="hospital" name="hospital"
                placeholder="Enter hospital name">
              <div class="all_errors" id="hospital_error">
              </div>
            </div>
          </div>

          <div class="form-group row">
            <label for="affiliate_share" class="col-sm-3 col-form-label pformlabel">Affiliate Share</label>
            <div class="col-sm-9">
              <input type="number" class="form-control inputs_with_bottom_border" id="affiliate_share"
                name="affiliate_share" placeholder="Enter affiliate share">
              <div class="all_errors" id="affiliate_share_error">
              </div>
            </div>
          </div>

          <div class="form-group row">
            <div class="col-sm-9 offset-sm-3">
              <button type="submit" class="btn btn-primary save_btn">Save Doctor</button>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div> -->

<!-- Submit Test Report  Modal -->
<div class="modal fade bs-example-modal-center" id="addModal1" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title mt-0">Submit Reports & Comments</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="allForms" id="addForm1">

          <input type="hidden" name="type" value="1">
          <input type="hidden" name="patient_test_id" class="patient_test_id">

          <div class="component" id="rep-type1">
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Select</label>
              <div class="col-sm-10">
                <select name="dropdown_value" class="form-control">
                  <option value="">Select</option>
                  <option value="Positive">Positive</option>
                  <option value="Negative">Negative</option>
                </select>
                <div class="all_errors dropdown_value_error"></div>
              </div>
            </div>
            <div class="LabCmnts">
              <textarea class="component" name="comments" id="LabCmnt" cols="0" rows="5" placeholder="Type Comments Here (If Any) Leave Blank if there's No Comments"></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-lg btn-block waves-effect waves-light">Submit Results</button>
          </div>
        </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>

<!-- Submit Test Report  Modal -->
<div class="modal fade bs-example-modal-center" id="addModal2" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title mt-0">Submit Reports & Comments</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="allForms" id="addForm2">

          <input type="hidden" name="type" value="2">
          <input type="hidden" name="patient_test_id" class="patient_test_id">

          <div class="component" id="rep-type2">
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Select</label>
              <div class="col-sm-10">
                <select name="dropdown_value" class="form-control">
                  <option value="">Select</option>
                  <option value="Detected">Detected</option>
                  <option value="Not Detected">Not Detected</option>
                </select>
                <div class="all_errors dropdown_value_error"></div>
              </div>
            </div>
            <div class="LabCmnts">
              <textarea class="component" name="comments" id="LabCmnt" cols="0" rows="5" placeholder="Type Comments Here (If Any) Leave Blank if there's No Comments"></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-lg btn-block waves-effect waves-light">Submit Results</button>
          </div>
        </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>

<!-- Submit Test Report  Modal -->
<div class="modal fade bs-example-modal-center" id="addModal3" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title mt-0">Submit Reports & Comments</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="allForms" id="addForm3">

          <input type="hidden" name="type" value="3">
          <input type="hidden" name="patient_test_id" class="patient_test_id">

          <div class="component" id="rep-type3">
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Select</label>
              <div class="col-sm-10">
                <select name="dropdown_value" class="form-control">
                  <option value="">Select</option>
                  <option value="Positive">Positive</option>
                  <option value="Negative">Negative</option>
                </select>
                <div class="all_errors dropdown_value_error"></div>
              </div>
            </div>
            <div class="form-group row">
              <label for="example-text-input" class="col-sm-2 col-form-label">Input Value</label>
              <div class="col-sm-10">
                <input class="form-control" name="input_value" type="text" placeholder="Enter Patient Value Here" id="example-text-input">
                <div class="all_errors input_value_error"></div>
              </div>
            </div>
            <div class="LabCmnts">
              <textarea class="component" name="comments" id="LabCmnt" cols="0" rows="5" placeholder="Type Comments Here (If Any) Leave Blank if there's No Comments"></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-lg btn-block waves-effect waves-light">Submit Results</button>
          </div>
        </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>

<!-- Submit Test Report  Modal -->
<div class="modal fade bs-example-modal-center" id="addModal4" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title mt-0">Submit Reports & Comments</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="allForms" id="addForm4">

          <input type="hidden" name="type" value="4">
          <input type="hidden" name="patient_test_id" class="patient_test_id">

          <div class="component" id="rep-type4">

            <!-- <div class="form-group row">
            <label for="example-text-input" class="col-sm-2 col-form-label">Input Value</label>
            <div class="col-sm-10">
              <input class="form-control" name="input_value" type="text" placeholder="Enter Patient Value Here"
                id="example-text-input">
              <div class="all_errors input_value_error"></div>
            </div>
          </div>
          <br/> -->
            @if(!empty($test_categories))
            @foreach($test_categories as $key=>$value)
            @if($value->type==4)
            <input type="hidden" name="test_categories[]" value="{{$value->id}}">
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">{{$value->name}}</label>
              <div class="col-sm-8">
                <input class="form-control" name="results[]" type="text" placeholder="Enter Patient results Here">
                <div class="all_errors dropdown_value_error"></div>
              </div>
            </div>
            <br />
            @endif
            @endforeach
            @endif

            <div class="LabCmnts">
              <textarea class="component" name="comments" id="LabCmnt" cols="0" rows="5" placeholder="Type Comments Here (If Any) Leave Blank if there's No Comments"></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-lg btn-block waves-effect waves-light">Submit Results</button>
          </div>
        </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>

<!-- Submit Test Report  Modal -->
<div class="modal fade bs-example-modal-center" id="addModal5" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title mt-0">Submit Reports & Comments</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="allForms" id="addForm5">

          <input type="hidden" name="type" value="5">
          <input type="hidden" name="patient_test_id" class="patient_test_id">

          <div class="component" id="rep-type5">
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Select</label>
              <div class="col-sm-10">
                <select name="dropdown_value" class="form-control">
                  <option value="">Fetch From Genotypes</option>
                  @if(!empty($test_categories))
                  @foreach($test_categories as $key=>$value)
                  @if($value->type==3)
                  <option value="{{$value->name}}">{{$value->name}}</option>
                  @endif
                  @endforeach
                  @endif
                </select>
                <div class="all_errors dropdown_value_error"></div>
              </div>
            </div>
            <div class="LabCmnts">
              <textarea class="component" name="comments" id="LabCmnt" cols="0" rows="5" placeholder="Type Comments Here (If Any) Leave Blank if there's No Comments"></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-lg btn-block waves-effect waves-light">Submit Results</button>
          </div>
        </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>

<!-- Submit Test Report  Modal -->
<div class="modal fade bs-example-modal-center" id="addModal6" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title mt-0">Submit Reports & Comments</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="allForms" id="addForm6">

          <input type="hidden" name="type" value="6">
          <input type="hidden" name="patient_test_id" class="patient_test_id">

          <div class="component" id="rep-type6">
            <div class="form-group row">
              <label for="example-text-input" class="col-sm-2 col-form-label">Specie</label>
              <div class="col-sm-10">
                <input class="form-control" name="specie" type="text" placeholder="Type Specie Here" id="example-text-input">
                <div class="all_errors specie_error"></div>
              </div>
            </div>
            <div class="form-group row">
              <label for="example-text-input" class="col-sm-2 col-form-label">Duration</label>
              <div class="col-sm-10">
                <input class="form-control" name="duration" type="text" placeholder="Type Duration Here" id="example-text-input">
                <div class="all_errors duration_error"></div>
              </div>
            </div>
            @if(!empty($test_categories))
            @foreach($test_categories as $key=>$value)
            @if($value->type==2)
            <input type="hidden" name="test_categories[]" value="{{$value->id}}">
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">{{$value->name}}</label>
              <div class="col-sm-8">
                <select name="results[]" class="form-control">
                  <option value="">Select here</option>
                  <option value="Sensitive">Sensitive</option>
                  <option value="Partial Sensitive">Partial Sensitive</option>
                  <option value="Resistant">Resistant</option>
                  <option value="Not Tested">Not Tested</option>
                </select>
                <div class="all_errors dropdown_value_error"></div>
              </div>
            </div>
            @endif
            @endforeach
            @endif

            <div class="LabCmnts">
              <textarea class="component" name="comments" id="LabCmnt" cols="0" rows="5" placeholder="Type Comments Here (If Any) Leave Blank if there's No Comments"></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-lg btn-block waves-effect waves-light">Submit
              Results</button>
          </div>
        </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>

<!-- Kit View Modal -->
<div class="modal fade" id="kitView" tabindex="-1" role="dialog" aria-labelledby="kitView" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="kitViewLabel">Available Test Kits for Test</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table">
          <tr>
          <th>Lot #</th>
          <th>Kit Name</th>
          <th>Supplier</th>
          <th>Available Kits</th>
          <th style="color: red;">Expiry Date</th>
          </tr>
         <tr>
         <td> --- </td>
         <td> --- </td>
         <td> --- </td>
         <td> --- </td>
         <td style="color: red;"> --- </td>
         </tr>
          

        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>

  <script src="{{asset('assets/developer/lab_user.js')}}"></script>

  @endsection