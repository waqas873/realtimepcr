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

<div class="container-fluid">

<div class="row">
<div class="col-sm-12">
<div class="page-title-box">
<div class="row align-items-center">
    <div class="col-md-8">
        <h1 class="page-title m-0 patient_reg_title">Patient Registration</h1>
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
    <div class="col-sm-6">
        
        <form action="" method="post" id="add-form">
          @csrf
          <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label pformlabel">Name</label>
            <div class="col-sm-8">
              <input type="text" class="form-control inputs_with_bottom_border" id="name" name="name" placeholder="Enter Name" value="{{ old('name') }}">
              <div class="all_errors" id="name_error">
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label for="cnic" class="col-sm-2 col-form-label pformlabel">CNIC</label>
            <div class="col-sm-8">
              <input type="number" class="form-control inputs_with_bottom_border" id="cnic" name="cnic" placeholder="Enter CNIC" value="{{ old('cnic') }}">
              <div class="all_errors" id="cnic_error">
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label for="age" class="col-sm-2 col-form-label pformlabel">Age</label>
            <div class="col-sm-8">
              <input type="number" class="form-control inputs_with_bottom_border" id="age" value="{{ old('age') }}" name="age" placeholder="Enter Age">
              <div class="all_errors" id="age_error">
              </div>
            </div>
          </div>
          <fieldset class="form-group">
            <div class="row">
              <legend class="col-form-label col-sm-2 pt-0 pformlabel">Sex</legend>
              <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" id="customRadioInline1" name="sex" class="custom-control-input" value="1" checked="">
                  <label class="custom-control-label" for="customRadioInline1">Male</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" id="customRadioInline2" name="sex" class="custom-control-input" value="0">
                  <label class="custom-control-label" for="customRadioInline2">Female</label>
              </div>
            </div>
          </fieldset>
          <div class="form-group row">
            <label for="contact_no" class="col-sm-2 col-form-label pformlabel">Contact</label>
            <div class="col-sm-8">
              <input type="number" class="form-control inputs_with_bottom_border" id="contact_no" value="{{ old('contact_no') }}" name="contact_no" placeholder="Enter contact no here">
              <div class="all_errors" id="contact_no_error">
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label for="email" class="col-sm-2 col-form-label pformlabel">Email</label>
            <div class="col-sm-8">
              <input type="email" class="form-control inputs_with_bottom_border" id="email" name="email" value="{{ old('email') }}" placeholder="Enter Email">
              <div class="all_errors" id="email_error">
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label for="reffered_by" class="col-sm-2 col-form-label pformlabel">Reffered By</label>
            <div class="col-sm-8">
              <select class="form-control inputs_with_bottom_border" id="reffered_by" name="reffered_by">
                  <option value="">Select doctor</option>
                  @if(!empty($doctors))
                      @foreach($doctors as $record)
                      <option value="{{$record->id}}">{{$record->name}}</option>
                      @endforeach
                  @endif
              </select>
            </div>
          </div>

            <!-- Modal -->
            <div class="modal fade" id="addTests" tabindex="-1" role="dialog" aria-labelledby="addTestsLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="addTestsLabel">Add Tests</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                      <p>Select Tests</p>
                      <select class="form-control inputs_with_bottom_border select2" id="tests" name="tests[]" multiple="">
                        @if(!empty($tests))
                        @foreach($tests as $record)
                        <option value="{{$record->id}}">{{$record->name}} &nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size: 11px !important;"> (Rs: {{$record->price}})</span></option>
                        @endforeach
                        @endif
                      </select>

                      <p style="margin-top: 17px;">Select Test Profile</p>
                      <select class="form-control inputs_with_bottom_border select2" id="test_profiles" name="test_profiles[]" multiple="">
                        @if(!empty($test_profiles))
                        @foreach($test_profiles as $record)
                        <option value="{{$record->id}}">{{$record->name}} &nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size: 11px !important;"> (Rs: {{$record->price}})</span></option>
                        @endforeach
                        @endif
                      </select>

                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-primary save-tests" data-dismiss="modal" id="save-tests">Save & Continue</button>
                  </div>
                </div>
              </div>
            </div>
            
            <input type="hidden" name="total_amount" id="total_amount">
            <input type="hidden" name="discount_percentage" id="discount_percentage">
            <input type="hidden" name="paid_amount" id="paid_amount">
            <input type="hidden" name="reporting_hrs" id="reporting_hrs">
          
          <div class="form-group row">
            <div class="col-sm-8 offset-sm-2">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addTests">Add Tests</button>
                <button type="submit" class="btn btn-primary patient_save_btn">Save Data</button>
            </div>
          </div>

          <div class="form-group row">
            <div class="col-sm-10">
              <h4>Select Tests</h4>
              <select class="form-control inputs_with_bottom_border select2" id="tests" name="tests[]" multiple="">
                @if(!empty($tests))
                @foreach($tests as $record)
                <option value="{{$record->id}}">{{$record->name}} &nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size: 11px !important;"> (Rs: {{$record->price}})</span></option>
                @endforeach
                @endif
              </select>
            </div>
          </div>

          <div class="form-group row">
            <div class="col-sm-10">
              <h4>Select Test Profile</h4>
              <select class="form-control inputs_with_bottom_border select2" id="tests" name="tests[]" multiple="">
                @if(!empty($tests))
                @foreach($tests as $record)
                <option value="{{$record->id}}">{{$record->name}} &nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size: 11px !important;"> (Rs: {{$record->price}})</span></option>
                @endforeach
                @endif
              </select>
            </div>
          </div>

        </form>

    </div>

    <div class="col-sm-6">
      <div class="row">
        <div class="col-sm-10 offset-sm-1">
          <div class="row">
            <div class="col-sm-6">
              <div class="invoice_box1">
                
              </div>
            </div>
            <div class="col-sm-6">
              <div class="invoice_box2">

              </div>
            </div>
          </div>
          <div class="form-group row invoice-inputs">
            <label for="discount" class="col-sm-3 col-form-label pformlabel">Discount</label>
            <div class="col-sm-9">
              <input type="number" class="form-control inputs_with_bottom_border" id="discount">
            </div>
          </div>
          <div class="form-group row invoice-inputs">
            <label for="amount_paid" class="col-sm-3 col-form-label pformlabel">Amount Paid</label>
            <div class="col-sm-9">
              <input type="number" class="form-control inputs_with_bottom_border" id="amount_paid">
            </div>
          </div>
          <div class="form-group row invoice-inputs">
            <label for="delivery_time" class="col-sm-3 col-form-label pformlabel">Delivery time (days)</label>
            <div class="col-sm-9">
              <input type="number" class="form-control inputs_with_bottom_border" id="delivery_time">
            </div>
          </div>

          <div class="form-group row invoice-inputs">    
            <div class="col-sm-12">
              <button type="button" class="btn btn-primary save-tests" id="invoice_btn">Generate & Print Invoice</button>
            </div>
          </div>

        </div>
      </div>
    </div>

</div>  
<!-- end row -->


</div><!-- container fluid -->

<!-- Modal -->
<div class="modal fade" id="generateInvoice" tabindex="-1" role="dialog" aria-labelledby="generateInvoiceLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="generateInvoiceLabel">Generate Invoice</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-10 offset-sm-1">
            <div class="row">
              <div class="col-sm-6">
                <div class="invoice_box1">
                  
                </div>
              </div>
              <div class="col-sm-6">
                <div class="invoice_box2">

                </div>
              </div>
            </div>
            <div class="form-group row invoice-inputs">
              <label for="discount" class="col-sm-3 col-form-label pformlabel">Discount</label>
              <div class="col-sm-9">
                <input type="number" class="form-control inputs_with_bottom_border" id="discount">
              </div>
            </div>
            <div class="form-group row invoice-inputs">
              <label for="amount_paid" class="col-sm-3 col-form-label pformlabel">Amount Paid</label>
              <div class="col-sm-9">
                <input type="number" class="form-control inputs_with_bottom_border" id="amount_paid">
              </div>
            </div>
            <div class="form-group row invoice-inputs">
              <label for="delivery_time" class="col-sm-3 col-form-label pformlabel">Delivery time (days)</label>
              <div class="col-sm-9">
                <input type="number" class="form-control inputs_with_bottom_border" id="delivery_time">
              </div>
            </div>

          </div>
          </div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary save-tests" data-dismiss="modal" id="invoice_btn">Save & Continue</button>
      </div>
    </div>
  </div>
</div>

<script src="{{asset('assets/developer/patients.js')}}"></script>

@endsection