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

<div class="container-fluid cpanel">
    
    <?php 
    $permissions = permissions();
    if($permissions['role']==1 || (!empty($permissions['app_cpanel_permissions']))){
    ?>
    <div class="row">
      <div class="col-sm-9">
        <h1>Admin Control Cpanel</h1>
        <div class="row toggle-rows cpanel-pdl">
          @if(!empty($admin_permissions))
          @foreach($admin_permissions as $key=>$value)
          <div class="col-sm-6" style="margin-bottom: 10px;">
            <span class="toggle-btn-text">
              {{$value->name}}
            </span>
            <input type="checkbox" class="toggle_btn change_permission" data-toggle="toggle" name="{{$value->id}}"
              value="{{$value->status}}" <?php echo ($value->status==1)?'checked':'';?>>
          </div>
          @endforeach
          @endif
        </div>
      </div>
    </div>
    <?php 
    } 
    if($permissions['role']==1 || (!empty($permissions['app_cpanel_accounts_list']))){
    ?>
    <div class="row">
      <div class="col-sm-12">
        <h1>Accounts list</h1>
        <div class="card">
          <div class="card-body">
              <h5>Cash Payment / Categories</h5>
              <div class="row categories">
                <div class="col-sm-10">
                  @if(!empty($account_categories))
                  @foreach($account_categories as $record)
                  @if($record->type==1)
                  <span class="badge badge-default cpanel-badges">
                    {{$record->name}} <i class="fa fa-tag" aria-hidden="true"></i>
                  </span> &nbsp;
                  @endif
                  @endforeach
                  @endif
                </div>
                <div class="col-sm-2">
                  <button class="btn btn-default cpanel-btn" data-toggle="modal" data-target="#addAccountCategoryModal"
                    type="button">Add Category</button>
                </div>
              </div>
              <hr>
              <h5>Cash Received / Categories</h5>
              <div class="row categories">
                <div class="col-sm-10">
                  @if(!empty($account_categories))
                  @foreach($account_categories as $record)
                  @if($record->type==2)
                  <span class="badge badge-default cpanel-badges">
                    {{$record->name}} <i class="fa fa-tag" aria-hidden="true"></i>
                  </span> &nbsp;
                  @endif
                  @endforeach
                  @endif
                </div>
                <div class="col-sm-2">
                  <button class="btn btn-default cpanel-btn" data-toggle="modal" data-target="#addAccountCategoryModal"
                    type="button">Add Category</button>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
    <?php 
    } 
    ?>
    <div class="row">
      <div class="col-sm-12">
        <?php 
        if($permissions['role']==1 || (!empty($permissions['app_cpanel_lab_tests']))){
        ?>
        <h1>Lab Tests</h1>
        <div class="card">
          <div class="card-body">
            <h5>Departments / Categories</h5>
            <div class="row categories">
              <div class="col-sm-10">
                @if(!empty($categories))
                @foreach($categories as $record)
                <span class="badge badge-default cpanel-badges">
                  {{$record->name}} <i class="fa fa-tag" aria-hidden="true"></i>
                </span> &nbsp;
                @endforeach
                @endif
              </div>
              <div class="col-sm-2">
                <button class="btn btn-default cpanel-btn" data-toggle="modal" data-target="#addCategory"
                  type="button">Add Category</button>
              </div>
            </div>
            <hr>

            <h5>Sub Heading<h6>Chain Reaction / PCR / No PCR</h6></h5>
            <div class="row categories">
              <div class="col-sm-10">
                @if(!empty($test_categories))
                @foreach($test_categories as $record)
                @if($record->type==1)
                <span class="badge badge-default cpanel-badges">
                  {{$record->name}} <i class="fa fa-tag" aria-hidden="true"></i>
                </span> &nbsp;
                @endif
                @endforeach
                @endif
              </div>
              <div class="col-sm-2">
                <button class="btn btn-default cpanel-btn" data-toggle="modal" data-target="#addTestCategoryModal"
                  type="button">Add Category</button>
              </div>
            </div>
            <hr>

            <h5>Test Samples List</h5>
            <div class="row categories">
              <div class="col-sm-10">
                @if(!empty($samples))
                @foreach($samples as $record)
                <span class="badge badge-default cpanel-badges">
                  {{$record->name}} <i class="fa fa-tag" aria-hidden="true"></i>
                </span> &nbsp;
                @endforeach
                @endif
              </div>
              <div class="col-sm-2">
                <button class="btn btn-default cpanel-btn" data-toggle="modal" data-target="#addSample"
                  type="button">Add Sample</button>
              </div>
            </div>
            <hr>

            <h5>Test Reporting Types</h5>
            <div class="row categories">
              <div class="col-sm-10">
                @if(!empty($reporting_units))
                @foreach($reporting_units as $record)
                @if(!empty($record))
                <span class="badge badge-default cpanel-badges">
                  {{$record->name}} <i class="fa fa-tag" aria-hidden="true"></i>
                </span> &nbsp;
                @endif
                @endforeach
                @endif
              </div>
              <div class="col-sm-2">
                <button class="btn btn-default cpanel-btn" data-toggle="modal" data-target="#addReportingUnit"
                  type="button">Add Unit</button>
              </div>
            </div>

            

          </div>
          
        </div>
        <?php 
        } 
        if($permissions['role']==1 || (!empty($permissions['app_cpanel_srr']))){
        ?>

        <div class="row">
          <div class="col-sm-12">
            <h1>Special Reports Requirements</h1>
            <div class="card">
              <div class="card-body">
                  <h5>Test Medicines</h5>
                  <div class="row categories">
                    <div class="col-sm-10">
                      @if(!empty($test_categories))
                      @foreach($test_categories as $record)
                      @if($record->type==2)
                      <span class="badge badge-default cpanel-badges">
                        {{$record->name}} <i class="fa fa-tag" aria-hidden="true"></i>
                      </span> &nbsp;
                      @endif
                      @endforeach
                      @endif
                    </div>
                    <div class="col-sm-2">
                      <button class="btn btn-default cpanel-btn" data-toggle="modal" data-target="#addTestCategoryModal"
                        type="button">Add Category</button>
                    </div>
                  </div>
                  <hr>
                  <h5>Genotype Reports Categories</h5>
                  <div class="row categories">
                    <div class="col-sm-10">
                      @if(!empty($test_categories))
                      @foreach($test_categories as $record)
                      @if($record->type==3)
                      <span class="badge badge-default cpanel-badges">
                        {{$record->name}} <i class="fa fa-tag" aria-hidden="true"></i>
                      </span> &nbsp;
                      @endif
                      @endforeach
                      @endif
                    </div>
                    <div class="col-sm-2">
                      <button class="btn btn-default cpanel-btn" data-toggle="modal" data-target="#addTestCategoryModal"
                        type="button">Add Category</button>
                    </div>
                  </div>
                  <hr>
                  <h5>Input Value Parameters</h5>
                  <div class="row categories">
                    <div class="col-sm-10">
                      Parameters will be Added Here
                    </div>
                    <div class="col-sm-2">
                      <button class="btn btn-default cpanel-btn" data-toggle="modal" data-target="#addTestCategoryModal"
                        type="button">Add Category</button>
                    </div>
                  </div>
                  
              </div>
            </div>
          </div>
        </div>
        <?php 
        } 
        ?>

        <div class="card">
        
        <?php 
        if($permissions['role']==1 || (!empty($permissions['app_cpanel_add_test']))){
        ?>
        <div class="card-body">
          <div class="add-tests">
            <a href="javascript::" id="addTest">+ Add Test</a>
          </div>
        </div>
        <?php 
        } 
        if($permissions['role']==1 || (!empty($permissions['app_cpanel_read_test']))){
        ?>
  

    <div class="row">
      <div class="col-sm-12">
        <h1>Draft Tests List</h1>
        <div class="card m-b-30">
          <div class="card-body">
            <div class="table-responsive">

              <table id="datatable" class="table table-bordered dt-responsive nowrap"
                style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                <!-- <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> -->

                <thead>
                  <tr>
                    <th scope="col">Test ID</th>
                    <th scope="col">Name/Parameters</th>
                    <th scope="col">Registrtaion Type</th>
                    <th scope="col">Category</th>

                    <!-- <th scope="col">Reporting Time(hrs)</th>
                        <th scope="col">Sample</th>
                        <th scope="col">Reporting Units</th> 
                        <th scope="col">Normal Value</th> -->

                    <th scope="col">Price</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @if(!empty($draft_tests))
                  <?php $counter = count($draft_tests) ; ?>
                  @foreach($draft_tests as $key=>$record)
                  <tr>
                    <td>
                      <?php echo $counter;?>
                    </td>
                    <td>{{$record->name}}</td>
                    <td>
                      <?php echo ($record->registration_type==1)?'Local':(($record->registration_type==2)?'Oversease':'-- --');?>
                    </td>
                    <td>{{$record->category->name}}</td>

                    {{--<td>{{$record->reporting_hrs}}</td>
                    <td>{{$record->sample->name}}</td>
                    <td>{{$record->reporting_units->name}}</td>
                    <td>{{$record->normal_value}}</td>--}}

                    <td>Rs: {{$record->price}}</td>
                    <td>
                      <?php 
                      if($permissions['role']==1 || (!empty($permissions['app_cpanel_update_test']))){
                      ?>
                      <a href="javascript::" class="test_id" rel="{{$record->id}}">View</a> |
                      <?php 
                      }
                      else{
                        echo "-- -- | ";
                      } 
                      if($permissions['role']==1 || (!empty($permissions['app_cpanel_delete_test']))){
                      ?> 
                      <a
                        href="{{url('admin/delete-test/'.$record->id)}}" class="delete_test"><i
                          class="fa fa-trash"></i></a>
                      <?php 
                      }
                      else{
                        echo "-- --";
                      } 
                      ?> 
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

    <div class="row">
      <div class="col-sm-12">
        <h1>Local Tests List</h1>
        <div class="card m-b-30">
          <div class="card-body">
            <div class="table-responsive">

              <table id="datatable2" class="table table-bordered dt-responsive nowrap"
                style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                <!-- <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> -->

                <thead>
                  <tr>
                    <th scope="col">Test ID</th>
                    <th scope="col">Name/Parameters</th>
                    <th scope="col">Registrtaion Type</th>
                    <th scope="col">Category</th>

                    <!-- <th scope="col">Reporting Time(hrs)</th>
                        <th scope="col">Sample</th>
                        <th scope="col">Reporting Units</th> 
                        <th scope="col">Normal Value</th> -->

                    <th scope="col">Price</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @if(!empty($local_tests))
                  <?php $counter = count($local_tests) ; ?>
                  @foreach($local_tests as $key=>$record)
                  <tr>
                    <td>
                      <?php echo $counter;?>
                    </td>
                    <td>{{$record->name}}</td>
                    <td>
                      <?php echo ($record->registration_type==1)?'Local':(($record->registration_type==2)?'Oversease':'-- --');?>
                    </td>
                    <td>{{$record->category->name}}</td>

                    {{--<td>{{$record->reporting_hrs}}</td>
                    <td>{{$record->sample->name}}</td>
                    <td>{{$record->reporting_units->name}}</td>
                    <td>{{$record->normal_value}}</td>--}}

                    <td>Rs: {{$record->price}}</td>
                    <td>
                      <?php 
                      if($permissions['role']==1 || (!empty($permissions['app_cpanel_update_test']))){
                      ?>
                      <a href="javascript::" class="test_id" rel="{{$record->id}}">View</a> |
                      <?php 
                      }
                      else{
                        echo "-- -- | ";
                      } 
                      if($permissions['role']==1 || (!empty($permissions['app_cpanel_delete_test']))){
                      ?> 
                      <a
                        href="{{url('admin/delete-test/'.$record->id)}}" class="delete_test"><i
                          class="fa fa-trash"></i></a>
                      <?php 
                      }
                      else{
                        echo "-- --";
                      } 
                      ?> 
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

    <div class="row">
      <div class="col-sm-12">
        <h1>Overseas Tests List</h1>
        <div class="card m-b-30">
          <div class="card-body">
            <div class="table-responsive">

              <table id="datatable3" class="table table-bordered dt-responsive nowrap"
                style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                <!-- <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> -->

                <thead>
                  <tr>
                    <th scope="col">Test ID</th>
                    <th scope="col">Name/Parameters</th>
                    <th scope="col">Registrtaion Type</th>
                    <th scope="col">Category</th>

                    <!-- <th scope="col">Reporting Time(hrs)</th>
                        <th scope="col">Sample</th>
                        <th scope="col">Reporting Units</th> 
                        <th scope="col">Normal Value</th> -->

                    <th scope="col">Price</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @if(!empty($overseas_tests))
                  <?php $counter = count($overseas_tests) ; ?>
                  @foreach($overseas_tests as $key=>$record)
                  <tr>
                    <td>
                      <?php echo $counter;?>
                    </td>
                    <td>{{$record->name}}</td>
                    <td>
                      <?php echo ($record->registration_type==1)?'Local':(($record->registration_type==2)?'Oversease':'-- --');?>
                    </td>
                    <td>{{$record->category->name}}</td>

                    {{--<td>{{$record->reporting_hrs}}</td>
                    <td>{{$record->sample->name}}</td>
                    <td>{{$record->reporting_units->name}}</td>
                    <td>{{$record->normal_value}}</td>--}}

                    <td>Rs: {{$record->price}}</td>
                    <td>
                      <?php 
                      if($permissions['role']==1 || (!empty($permissions['app_cpanel_update_test']))){
                      ?>
                      <a href="javascript::" class="test_id" rel="{{$record->id}}">View</a> |
                      <?php 
                      }
                      else{
                        echo "-- -- | ";
                      } 
                      if($permissions['role']==1 || (!empty($permissions['app_cpanel_delete_test']))){
                      ?> 
                      <a
                        href="{{url('admin/delete-test/'.$record->id)}}" class="delete_test"><i
                          class="fa fa-trash"></i></a>
                      <?php 
                      }
                      else{
                        echo "-- --";
                      } 
                      ?> 
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
    <?php 
    } 
    if($permissions['role']==1 || (!empty($permissions['app_cpanel_profile_tests']))){
    ?>

    <div class="row">
      <div class="col-sm-12">
        <h1>Profile Tests</h1>
        <div class="card m-b-30">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-12">
                <a href="javascript::" class="btn btn-info" id="add_profile_test">Add Profile</a>
              </div>
            </div>
            <div class="table-responsive">
              <table id="profile_test_datatable" class="table table-bordered dt-responsive nowrap"
                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                  <tr>
                    <th scope="col">Sr#</th>
                    <th scope="col">Profile Name</th>
                    <th scope="col">Profile Price</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @if(!empty($test_profiles))
                  <?php $counter = count($test_profiles) ; ?>
                  @foreach($test_profiles as $key=>$record)
                  <tr>
                    <td>
                      <?php echo $counter;?>
                    </td>
                    <td>{{$record->name}}</td>
                    <td>Rs: {{$record->price}}</td>
                    <td><a href="{{url('/admin/cpanel/'.$record->id)}}" class="profile_id">View</a> | <a
                        href="{{url('admin/delete-test-profile/'.$record->id)}}" class="delete_test_profile"><i
                          class="fa fa-trash"></i></a></td>
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
    <?php 
    } 
    ?>

    </div></div>

  </div><!-- container fluid -->

  <!-- Modal -->
  <div class="modal fade" id="addAccountCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addTestsLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addAccountCategoryLabel">Add Account Category</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="accountCategoryForm" method="post">
            @csrf
            <div class="form-group">
              <label for="add_category">Category Type</label>
              <select class="form-control select2 inputs_with_bottom_border" name="type">
                  <option value="">Select Category Type</option>
                  <option value="1">Cash Payment</option>
                  <option value="2">Cash Recieved</option>
              </select>
              <div class="all_errors type_error">
              </div>
            </div>
            <div class="form-group">
              <label for="add_category">Category Name</label>
              <input type="text" class="form-control" name="name" placeholder="Enter category name">
              <div class="all_errors name_error"></div>
            </div>
            <button type="submit" class="btn btn-primary">Save Category</button>
          </form>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

    <!-- Modal -->
  <div class="modal fade" id="addTestCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addTestsLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addTestCategoryLabel">Add Category</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="testCategoryForm" method="post">
            @csrf
            <div class="form-group">
              <label for="add_category">Category Type</label>
              <select class="form-control select2 inputs_with_bottom_border" name="type">
                  <option value="">Select Category Type</option>
                  <option value="1">Chain Reaction / PCR / No PCR</option>
                  <option value="2">Test Medicines</option>
                  <option value="3">Genotype Reports Categories</option>
              </select>
              <div class="all_errors type_error">
              </div>
            </div>
            <div class="form-group">
              <label for="add_category">Name</label>
              <input type="text" class="form-control" name="name" placeholder="Enter category name">
              <br>
              <label for="add_category">Medicine Label</label>
              <input type="text" class="form-control" name="name" placeholder="Enter Medicine Label">
              <div class="all_errors name_error"></div>
            </div>
            <button type="submit" class="btn btn-primary">Save Category</button>
          </form>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="addSample" tabindex="-1" role="dialog" aria-labelledby="addTestsLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addTestsLabel">Add Sample</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{url('admin/add-sample')}}" id="add-sample" method="post">
            @csrf
            <div class="form-group">
              <label for="add_category">Sample Name</label>
              <input type="text" class="form-control" id="add_sample" name="name" placeholder="Enter sample name">
            </div>
            <button type="submit" class="btn btn-primary">Save Sample</button>
          </form>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="addReportingUnit" tabindex="-1" role="dialog" aria-labelledby="addTestsLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addTestsLabel">Add Reporting Unit</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{url('admin/add-reporting-unit')}}" id="add-reporting-unit" method="post">
            @csrf
            <div class="form-group">
              <label for="add_reporting_unit">Reporting Unit Name</label>
              <input type="text" class="form-control" id="add_reporting_unit" name="name"
                placeholder="Enter reporting unit">
            </div>
            <button type="submit" class="btn btn-primary">Save Reporting Unit</button>
          </form>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="addTestModal" tabindex="-1" role="dialog" aria-labelledby="addTestModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content add-test-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addTestsLabel">Add Test</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="" method="post" id="test-form">
            @csrf

            <input type="hidden" name="id" value="" id="test_id">

            <div class="form-group row">
              <label for="name" class="col-sm-3 col-form-label pformlabel">Test Name/Parameters</label>
              <div class="col-sm-9">
                <input type="text" class="form-control inputs_with_bottom_border" id="name" name="name"
                  placeholder="Enter test name">
                <div class="all_errors name_error">
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="category_id" class="col-sm-3 col-form-label pformlabel">Category</label>
              <div class="col-sm-9">
                <select class="form-control select2 inputs_with_bottom_border" id="category_id" name="category_id">
                  <option value="">Select Category</option>
                  @if(!empty($categories))
                  @foreach($categories as $record)
                  <option value="{{$record->id}}">{{$record->name}}</option>
                  @endforeach
                  @endif
                </select>
                <div class="all_errors category_id_error">
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="reporting_hrs" class="col-sm-3 col-form-label pformlabel">Reporting Time (hrs)</label>
              <div class="col-sm-9">
                <input type="number" class="form-control inputs_with_bottom_border" id="reporting_hrs"
                  value="{{ old('reporting_hrs') }}" name="reporting_hrs" placeholder="Enter reporting time">
                <div class="all_errors reporting_hrs_error">
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="email" class="col-sm-3 col-form-label pformlabel">Sample</label>
              <div class="col-sm-9">
                <select class="form-control select2" id="sample_id" name="sample_id">
                  <option value="">Select Sample</option>
                  @if(!empty($samples))
                  @foreach($samples as $record)
                  <option value="{{$record->id}}">{{$record->name}}</option>
                  @endforeach
                  @endif
                </select>
                <div class="all_errors sample_id_error">
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="product_id" class="col-sm-3 col-form-label pformlabel">Test Kit</label>
              <div class="col-sm-9">
                <select class="form-control select2" id="product_id" name="product_id">
                  <option value="">Select Kit</option>
                  @if(!empty($products))
                  @foreach($products as $record)
                  <option value="{{$record->id}}">{{$record->name}}</option>
                  @endforeach
                  @endif
                </select>
                <div class="all_errors product_id_error">
                </div>
              </div>
            </div>
            
            <div class="form-group row">
              <label for="price" class="col-sm-3 col-form-label pformlabel">Test Price</label>
              <div class="col-sm-9">
                <input type="number" class="form-control inputs_with_bottom_border" id="price" name="price"
                  placeholder="Enter test price">
                <div class="all_errors price_error">
                </div>
              </div>
            </div>
            
           <!-- <fieldset class="form-group">
              <div class="row" style="margin-left: 42px;margin-top: 14px;">
                <legend class="col-form-label col-sm-2 pt-0 pformlabel">Registration Type</legend>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" id="customRadioInline1" name="registration_type" class="custom-control-input"
                    checked value="1">
                  <label class="custom-control-label" for="customRadioInline1">Local Patient</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" id="customRadioInline2" name="registration_type" class="custom-control-input"
                    value="2">
                  <label class="custom-control-label" for="customRadioInline2">Overseas Patient</label>
                </div>
              </div>
              <div class="all_errors registration_type_error" style="margin-left: 160px;">
              </div>
            </fieldset> -->

            <div class="form-group row">
              <legend class="col-form-label col-sm-3 pt-0 pformlabel">Test type</legend>
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="type1" name="type" class="custom-control-input" value="1" checked="">
                <label class="custom-control-label" for="type1">Local</label>
              </div>
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="type2" name="type" class="custom-control-input" value="2">
                <label class="custom-control-label" for="type2">Overseas</label>
              </div>
            </div>
            
            <div class="form-group row">
              <label for="reporting_unit_id" class="col-sm-3 col-form-label pformlabel">Reporting Type</label>
              <div class="col-sm-9">
                <select class="form-control select2 reporting_unit_id" id="reporting_unit_id" name="reporting_unit_id">
                  <option value="">Select Unit</option>
                  <!-- <option value="input-value">Input-Value</option> -->
                  @if(!empty($reporting_units))
                  @foreach($reporting_units as $record)
                  <option value="{{$record->id}}">{{$record->name}}</option>
                  @endforeach
                  @endif
                </select>
                <div class="all_errors reporting_unit_id_error">
                </div>
              </div>
            </div>
<!--
            <div class="form-group row unitsNormal">
              <label for="units" class="col-sm-3 col-form-label pformlabel">Units</label>
              <div class="col-sm-9">
                <input type="text" class="form-control inputs_with_bottom_border" id="units" name="units"
                  placeholder="Enter normal value">
                <div class="all_errors units_error">
                </div>
              </div>
            </div>

            <div class="form-group row unitsNormal">
              <label for="normal_value" class="col-sm-3 col-form-label pformlabel">Normal Value</label>
              <div class="col-sm-9">
                <input type="text" class="form-control inputs_with_bottom_border" id="normal_value" name="normal_value"
                  placeholder="Enter normal value">
                <div class="all_errors normal_value_error">
                </div>
              </div>
            </div>
            
            -->

             <div class="form-group row">
              <label for="email" class="col-sm-3 col-form-label pformlabel">Sub Heading / Chain Reaction</label>
             
              <div class="col-sm-9">
                <select class="form-control select2" id="test_category_id" name="test_category_id">
                  <option value="">Select Chain</option>
                  @if(!empty($test_categories))
                  @foreach($test_categories as $record)
                  @if($record->type==1)
                  <option value="{{$record->id}}">{{$record->name}}</option>
                  @endif
                  @endforeach
                  @endif
                </select>
                <div class="all_errors test_category_id_error">
                </div>
              </div>
            </div>
            
            <div class="form-group row">
              <label for="email" class="col-sm-3 col-form-label pformlabel">Test Comments</label>
             <!--Getting Css File-->
             <link rel="stylesheet" href="https://pcr.realtimepcr.pk/assets/css/cmp-style.css">
              <div class="col-sm-9">
                <textarea class="component comments" name="comments" id="comments" cols="0" rows="5"
                                placeholder="Type Comments Here (If Any) Leave Blank if there's No Comments"></textarea>
                <div class="all_errors comments_error">
                </div>
              </div>
              
            </div>

            <div class="form-group row">
              <div class="col-sm-9 offset-sm-3">
                <button type="submit" class="btn btn-primary test_save_btn">Save Test</button>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="addProfileTestModal" tabindex="-1" role="dialog"
    aria-labelledby="addProfileTestModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content add-test-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addProfileTestModalLabel">Add Profile</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="" method="post" id="profile-test-form">
            @csrf

            <input type="hidden" name="id" value="" id="profile_id">

            <div class="form-group row">
              <label for="profile_name" class="col-sm-3 col-form-label pformlabel">Profile Name</label>
              <div class="col-sm-9">
                <input type="text" class="form-control inputs_with_bottom_border" id="profile_name" name="name"
                  placeholder="Enter profile name">
                <div class="all_errors" id="profile_name_error">
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="profile_price" class="col-sm-3 col-form-label pformlabel">Price</label>
              <div class="col-sm-9">
                <input type="number" class="form-control inputs_with_bottom_border" id="profile_price" name="price"
                  placeholder="Enter profile price">
                <div class="all_errors" id="profile_price_error">
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="profile_tests" class="col-sm-3 col-form-label pformlabel">Select Tests</label>
              <div class="col-sm-9" id="">
                <select class="form-control select2 inputs_with_bottom_border" id="profile_tests" name="tests[]"
                  multiple="">
                  @if(!empty($tests))
                  @foreach($tests as $record)
                  <option value="{{$record->id}}">{{$record->name}}</option>
                  @endforeach
                  @endif
                </select>
                <div class="all_errors" id="tests_error">
                </div>
              </div>
            </div>

            <div class="form-group row">
              <div class="col-sm-9 offset-sm-3">
                <button type="submit" class="btn btn-primary profile_save_btn">Save Profile</button>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>


  <?php 
function check_in_array($test_id, $profile_tests , $profile_id){
  foreach ($profile_tests as $record) {
     if($record['test_profile_id']==$profile_id && $record['test_id']==$test_id)
      return true;
  }
  return false;
}
?>

  @if(!empty($tp))
  <script type="text/javascript">
    $(document).ready(function () {
      $('#updateProfileTestModal').modal('show');
    });
  </script>
  <!-- Modal -->
  <div class="modal fade" id="updateProfileTestModal" tabindex="-1" role="dialog"
    aria-labelledby="updateProfileTestModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content add-test-content">
        <div class="modal-header">
          <h5 class="modal-title" id="updateProfileTestModalLabel">Update Profile</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="" method="post" id="update-profile-test-form">
            @csrf

            <input type="hidden" name="id" value="<?php echo (!empty($tp))?$tp['id']:'' ;?>">

            <div class="form-group row">
              <label for="update_profile_name" class="col-sm-3 col-form-label pformlabel">Profile Name</label>
              <div class="col-sm-9">
                <input type="text" class="form-control inputs_with_bottom_border" id="update_profile_name" name="name"
                  placeholder="Enter profile name" value="<?php echo (!empty($tp))?$tp['name']:'' ;?>">
                <div class="all_errors" id="update_profile_name_error">
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="update_profile_price" class="col-sm-3 col-form-label pformlabel">Price</label>
              <div class="col-sm-9">
                <input type="number" class="form-control inputs_with_bottom_border" id="update_profile_price"
                  name="price" value="<?php echo (!empty($tp))?$tp['price']:'' ;?>" placeholder="Enter profile price">
                <div class="all_errors" id="update_profile_price_error">
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="update_profile_tests" class="col-sm-3 col-form-label pformlabel">Select Tests</label>
              <div class="col-sm-9" id="">
                <select class="form-control select2 inputs_with_bottom_border" id="update_profile_tests" name="tests[]"
                  multiple="">
                  @if(!empty($tests))
                  @foreach($tests as $record)
                  <option value="{{$record->id}}" <?php echo isset($profile_tests) && check_in_array($record['id'],
                    $profile_tests , $tp['id'])? 'selected="selected"' : '' ; ?> >{{$record->name}}</option>
                  @endforeach
                  @endif
                </select>
                <div class="all_errors" id="update_tests_error">
                </div>
              </div>
            </div>

            <div class="form-group row">
              <div class="col-sm-9 offset-sm-3">
                <button type="submit" class="btn btn-primary profile_update_btn">Update Profile</button>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  @endif

  <script src="{{asset('assets/developer/admin/cpanel.js')}}"></script>
  <script src="{{asset('assets/developer/admin/tests.js')}}"></script>

  @endsection


