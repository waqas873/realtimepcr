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


<div class="container-fluid">

  <div class="row">
    <div class="col-sm-12">
      <div class="page-title-box">
        <div class="row align-items-center">
          <div class="col-sm-5">
            <h4 class="page-title m-0">Products</h4>
          </div>
          <div class="col-sm-1 no_padd">
            <p>Filter by LAB</p>
          </div>
          <div class="col-sm-6 no_padd">
            <select class="form-control" name="" id="">
              <option value="">All</option>

            </select>
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
          <div class="row">
            <div class="col-sm-6">
              <h4 class="mt-0 header-title mb-4">Test Kits List</h4>
            </div>

            <div class="col-sm-6">
              <?php
              $permissions = permissions();
              if ($permissions['role'] == 1 || (!empty($permissions['products_read_write']))) {
              ?>
                    <a href="javascript::" class="btn btn-success mb-2 float-right" id="addBtn">Add New Test kit</a>
              <?php } ?>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-hover" id="datatable">
              <thead>
                <tr>
                  <th scope="col">Kit Name</th>
                  <th scope="col">Assigned Test</th>
                  <th scope="col">Associated LAB</th>
                  <th scope="col">No of Test kits</th>
                  <th scope="col">Remaining kits</th>
                  <th scope="col">Expiry Date</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>
  </div>
  <!-- end row -->

</div><!-- container fluid -->

<!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addCollectionPointLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addCollectionPointLabel">Add Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" id="addForm" method="post">
          @csrf

          <!-- <input type="hidden" name="id" value="" id="product_id"> -->

          <input type="hidden" class="form-control iwbb" id="product_category_id" name="product_category_id" value="1">

          <div class="form-group row">
            <label for="lab_id" class="col-sm-2 col-form-label pformlabel">Select Lab</label>
            <div class="col-sm-10">
              <select class="form-control iwbb" id="lab_id" name="lab_id">
                <option value="">Select Lab</option>
                @if(!empty($labs))
                @foreach($labs as $record)
                <option value="{{$record->id}}">{{$record->name}}</option>
                @endforeach
                @endif
              </select>
              <div class="all_errors lab_id_error">
              </div>
            </div>
          </div>

          <div class="form-group row">
            <label for="test_id" class="col-sm-2 col-form-label pformlabel">Select Test</label>
            <div class="col-sm-10">
              <select class="form-control iwbb" id="test_id" name="test_id">
                <option value="">Select Test</option>
                @if(!empty($tests))
                @foreach($tests as $record)
                <option value="{{$record->id}}">{{$record->name}}</option>
                @endforeach
                @endif
              </select>
              <div class="all_errors test_id_error">
              </div>
            </div>
          </div>


          <div class="form-group row">
            <label for="supplier_id" class="col-sm-2 col-form-label pformlabel">Supplier</label>
            <div class="col-sm-10">
              <select class="form-control iwbb" id="supplier_id" name="supplier_id">
                <option value="">Select Supplier</option>
                @if(!empty($suppliers))
                @foreach($suppliers as $record)
                <option value="{{$record->id}}">{{$record->name}}</option>
                @endforeach
                @endif
              </select>
              <div class="all_errors supplier_id_error">
              </div>
            </div>
          </div>





          <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label pformlabel">Kit Name:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control iwbb" id="name" name="name" placeholder="Enter Name">
              <div class="all_errors name_error">
              </div>
            </div>
          </div>

          
          <div class="form-group row">
            <label for="lot_number" class="col-sm-2 col-form-label pformlabel">Lot Number:</label>
            <div class="col-sm-4">
              <input type="text" class="form-control iwbb" id="lot_number" name="lot_number" placeholder="Enter lot number">
              <div class="all_errors lot_number_error">
              </div>
            </div>

            <label for="expiry_date" class="col-sm-2 col-form-label pformlabel">Expiry Date:</label>
            <div class="col-sm-4">
              <input type="date" class="form-control iwbb" id="expiry_date" name="expiry_date" placeholder="Enter expiry_date">
              <div class="all_errors expiry_date_error">
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label for="quantity" class="col-sm-2 col-form-label pformlabel">Pack size:</label>
            <div class="col-sm-4">
              <input type="number" class="form-control iwbb" id="quantity" name="quantity" placeholder="Enter pack size">
              <div class="all_errors quantity_error">
              </div>
            </div>

            <label for="price" class="col-sm-2 col-form-label pformlabel">Prize: (PKR)</label>
            <div class="col-sm-4">
              <input type="number" class="form-control iwbb" id="price" name="price" placeholder="Enter price">
              <div class="all_errors price_error">
              </div>
              <small>Cost of sale per test will be Rs: 500</small>
            </div>
          </div>

          <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label pformlabel"></label>
            <div class="col-sm-10">
              <button type="submit" class="btn btn-secondary btn-block btn-lg">Save Data</button>
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

<script src="{{asset('assets/developer/admin/products.js')}}"></script>

@endsection