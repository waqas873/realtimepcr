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

<style type="text/css">
  .nav-tabs .nav-link {
    font-size: 17px;
  }
</style>

<div class="container-fluid">

<div class="row">
<div class="col-sm-12">
<div class="page-title-box">
<div class="row align-items-center">
    <div class="col-sm-5">
        <h4 class="page-title m-0">Vouchers</h4>
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

    <ul class="nav nav-tabs nav-justified md-tabs indigo" id="myTabJust" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="home-tab-just" data-toggle="tab" href="#home-just" role="tab" aria-controls="home-just"
          aria-selected="true">Cash Payment</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="profile-tab-just" data-toggle="tab" href="#profile-just" role="tab" aria-controls="profile-just"
          aria-selected="false">Cash Recieved</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="contact-tab-just" data-toggle="tab" href="#contact-just" role="tab" aria-controls="contact-just"
          aria-selected="false">Journal</a>
      </li>
    </ul>
    <div class="tab-content card pt-5" id="myTabContentJust">
      <div class="tab-pane fade show active" id="home-just" role="tabpanel" aria-labelledby="home-tab-just">
        
        <div class="row">
          <div class="col-xl-12">
            <a href="javascript::" class="btn btn-success" style="float: right;margin-bottom: 20px;margin-right: 1.5%;">Add Voucher</a>
          </div>
        </div>

        <div class="table-responsive">
          <table class="table table-hover" id="cash_payment_datatable">
            <thead>
              <tr>
                  <th scope="col">V-ID</th>
                  <th scope="col">Category</th>
                  <th scope="col">Description</th>
                  <th scope="col">Amount Debit</th>
              </tr>
            </thead>
            <tbody>
                <tr>
                  <td scope="col">#080954</td>
                  <td scope="col">Food</td>
                  <td scope="col">Testing description</td>
                  <td scope="col">Rs: 543534</td>
                </tr>
                <tr>
                  <td scope="col">#080954</td>
                  <td scope="col">Food</td>
                  <td scope="col">Testing description</td>
                  <td scope="col">Rs: 543534</td>
                </tr>
                <tr>
                  <td scope="col">#080954</td>
                  <td scope="col">Food</td>
                  <td scope="col">Testing description</td>
                  <td scope="col">Rs: 543534</td>
                </tr>
                <tr>
                  <td scope="col">#080954</td>
                  <td scope="col">Food</td>
                  <td scope="col">Testing description</td>
                  <td scope="col">Rs: 543534</td>
                </tr>
                <tr>
                  <td scope="col">#080954</td>
                  <td scope="col">Food</td>
                  <td scope="col">Testing description</td>
                  <td scope="col">Rs: 543534</td>
                </tr>
                <tr>
                  <td scope="col">#080954</td>
                  <td scope="col">Food</td>
                  <td scope="col">Testing description</td>
                  <td scope="col">Rs: 543534</td>
                </tr>
            </tbody>
          </table>
        </div>

      </div>
      <div class="tab-pane fade" id="profile-just" role="tabpanel" aria-labelledby="profile-tab-just">
        
        <div class="row">
          <div class="col-xl-12">
            <a href="javascript::" class="btn btn-success" style="float: right;margin-bottom: 20px;margin-right: 1.5%;">Add Voucher</a>
          </div>
        </div>

        <div class="table-responsive">
          <table class="table table-hover" id="cash_recieved_datatable">
            <thead>
              <tr>
                  <th scope="col">V-ID</th>
                  <th scope="col">Category</th>
                  <th scope="col">Description</th>
                  <th scope="col">Amount Debit</th>
              </tr>
            </thead>
            <tbody>
                <tr>
                  <td scope="col">#080954</td>
                  <td scope="col">Food</td>
                  <td scope="col">Testing description</td>
                  <td scope="col">Rs: 543534</td>
                </tr>
                <tr>
                  <td scope="col">#080954</td>
                  <td scope="col">Food</td>
                  <td scope="col">Testing description</td>
                  <td scope="col">Rs: 543534</td>
                </tr>
                <tr>
                  <td scope="col">#080954</td>
                  <td scope="col">Food</td>
                  <td scope="col">Testing description</td>
                  <td scope="col">Rs: 543534</td>
                </tr>
                <tr>
                  <td scope="col">#080954</td>
                  <td scope="col">Food</td>
                  <td scope="col">Testing description</td>
                  <td scope="col">Rs: 543534</td>
                </tr>
                <tr>
                  <td scope="col">#080954</td>
                  <td scope="col">Food</td>
                  <td scope="col">Testing description</td>
                  <td scope="col">Rs: 543534</td>
                </tr>
                <tr>
                  <td scope="col">#080954</td>
                  <td scope="col">Food</td>
                  <td scope="col">Testing description</td>
                  <td scope="col">Rs: 543534</td>
                </tr>
            </tbody>
          </table>
        </div>

      </div>
      <div class="tab-pane fade" id="contact-just" role="tabpanel" aria-labelledby="contact-tab-just">
        
        <div class="row">
          <div class="col-xl-12">
            <div style="display: inline-block;float: right;margin-bottom: 20px;margin-right: 1.5%;">
            <a href="javascript::" class="btn btn-success">Debit Adjustment</a>
            <a href="javascript::" class="btn btn-success">Credit Adjustment</a>
            </div>
          </div>
        </div>

        <div class="table-responsive">
          <table class="table table-hover" id="journal_datatable">
            <thead>
              <tr>
                  <th scope="col">V-ID</th>
                  <th scope="col">Category</th>
                  <th scope="col">Description</th>
                  <th scope="col">Type</th>
                  <th scope="col">Adjustment</th>
              </tr>
            </thead>
            <tbody>
                <tr>
                  <td scope="col">#080954</td>
                  <td scope="col">Food</td>
                  <td scope="col">Testing description</td>
                  <td scope="col">Debit</td>
                  <td scope="col">Rs: 543534</td>
                </tr>
                <tr>
                  <td scope="col">#080954</td>
                  <td scope="col">Food</td>
                  <td scope="col">Testing description</td>
                  <td scope="col">Credit</td>
                  <td scope="col">Rs: 543534</td>
                </tr>
                <tr>
                  <td scope="col">#080954</td>
                  <td scope="col">Food</td>
                  <td scope="col">Testing description</td>
                  <td scope="col">Debit</td>
                  <td scope="col">Rs: 543534</td>
                </tr>
                <tr>
                  <td scope="col">#080954</td>
                  <td scope="col">Food</td>
                  <td scope="col">Testing description</td>
                  <td scope="col">Debit</td>
                  <td scope="col">Rs: 543534</td>
                </tr>
                <tr>
                  <td scope="col">#080954</td>
                  <td scope="col">Food</td>
                  <td scope="col">Testing description</td>
                  <td scope="col">Credit</td>
                  <td scope="col">Rs: 543534</td>
                </tr>
                <tr>
                  <td scope="col">#080954</td>
                  <td scope="col">Food</td>
                  <td scope="col">Testing description</td>
                  <td scope="col">Debit</td>
                  <td scope="col">Rs: 543534</td>
                </tr>
            </tbody>
          </table>
        </div>

      </div>
    </div>


</div>
</div>
</div>
</div>
<!-- end row -->

</div><!-- container fluid -->

<script src="{{asset('assets/developer/admin/accounts.js')}}"></script>

@endsection