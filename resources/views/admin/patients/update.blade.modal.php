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

<link rel="stylesheet" href="{{asset('assets/webcam/assets/css/layout.css')}}">
<link rel="stylesheet" href="{{asset('assets/webcam/cropper/cropper.css')}}">

<script src="{{asset('assets/webcam/assets/js/dropzone.js')}}"></script>
<script src="{{asset('assets/webcam/webcamjs/webcam.min.js')}}"></script>
<script src="{{asset('assets/webcam/cropper/cropper.js')}}"></script>

<div class="container-fluid">

  <form action="" method="post" id="update-form">
    @csrf
    <div class="row">
      <div class="col-sm-12">

        <div class="row">
          <div class="col-sm-12">
            <div class="page-title-box">
              <div class="row align-items-center">
                <div class="col-md-8">
                  <h1 class="page-title m-0 patient_reg_title">Patient Update</h1>
                </div>
                <!-- end col -->
              </div>
              <!-- end row -->
            </div>
            <!-- end page-title-box -->
          </div>
        </div>
        <!-- end page title -->

        <input type="hidden" name="patient_id" value="{{$result->id}}">

        <div class="row">
          <div class="col-sm-6">
            <div class="form-group row">
              <label for="name" class="col-sm-2 col-form-label pformlabel">Name</label>
              <div class="col-sm-10">
                <input type="text" class="form-control inputs_with_bottom_border" id="name" name="name" placeholder="Enter Name" value="{{$result->name}}">
                <div class="all_errors" id="name_error">
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group row">
              <label for="cnic" class="col-sm-2 col-form-label pformlabel">CNIC</label>
              <div class="col-sm-10">
                <input type="text" class="form-control inputs_with_bottom_border" id="cnic" name="cnic" placeholder="Enter CNIC" value="{{$result->cnic}}">
                <div class="all_errors" id="cnic_error">
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-6">
            <div class="form-group row">
              <label for="dob" class="col-sm-2 col-form-label pformlabel">DOB</label>
              <div class="col-sm-10">
                <input type="date" class="form-control inputs_with_bottom_border" id="dob" value="{{$result->dob}}" name="dob" placeholder="Enter dob">
                <div class="all_errors" id="dob_error">
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <fieldset class="form-group">
              <div class="row">
                <legend class="col-form-label col-sm-2 pt-0 pformlabel">Sex</legend>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" id="customRadioInline1" name="sex" class="custom-control-input" value="1" <?php echo ($result->sex == 1) ? 'checked' : ''; ?>>
                  <label class="custom-control-label" for="customRadioInline1">Male</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" id="customRadioInline2" name="sex" class="custom-control-input" value="0" <?php echo ($result->sex == 0) ? 'checked' : ''; ?>>
                  <label class="custom-control-label" for="customRadioInline2">Female</label>
                </div>
              </div>
            </fieldset>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-6">
            <div class="form-group row">
              <label for="contact_no" class="col-sm-2 col-form-label pformlabel">Contact</label>
              <div class="col-sm-10">
                <input type="number" class="form-control inputs_with_bottom_border" id="contact_no" value="{{$result->contact_no}}" name="contact_no" placeholder="Enter contact no here">
                <div class="all_errors" id="contact_no_error">
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group row">
              <label for="email" class="col-sm-2 col-form-label pformlabel">Email</label>
              <div class="col-sm-10">
                <input type="email" class="form-control inputs_with_bottom_border" id="email" name="email" value="{{$result->email}}" placeholder="Enter Email">
                <div class="all_errors" id="email_error">
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">

          <div class="col-sm-6">
            <div class="form-group row">
              <label for="reffered_by" class="col-sm-2 col-form-label pformlabel">Reffered By</label>
              <div class="col-sm-10">
                <select class="form-control inputs_with_bottom_border select2" id="reffered_by" name="reffered_by">
                  <option value="">Select doctor</option>
                  @if(!empty($doctors))
                  @foreach($doctors as $record)
                  <option value="{{$record->id}}" <?php echo ($record->id == $result->reffered_by) ? 'selected' : ''; ?>>
                    {{$record->name}}
                  </option>
                  @endforeach
                  @endif
                </select>
              </div>
            </div>
          </div>
          <?php
          $permissions = permissions();
          if ($permissions['role'] == 1 || (!empty($permissions['patients_timing_change']))) {
          ?>
            <div class="col-sm-6">
              <div class="form-group row">
                <label for="sample_date" class="col-sm-2 col-form-label pformlabel">Patient Entry Date</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control inputs_with_bottom_border" id="sample_date" name="sample_date" value="{{$result->sample_date}}">
                  <div class="all_errors" id="sample_date_error"></div>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>

        <div class="form-group row" style="position:relative;top: -21px;left: -90px;">
          <label for="image" class="col-sm-2 col-form-label pformlabel">Image</label>
          <div class="col-sm-8">
            <label class="btn upload"> <i class="fa fa-upload"></i> &nbsp; Upload<input type="file" class="sr-only" id="input" name="image" accept="image/*"></label>
            <button type="button" class="btn camera" data-backdrop="static" data-toggle="modal" data-target="#cameraModal"><i class="fa fa-camera"></i> &nbsp; Capture Image</button>

            <div class="avatararea">
              <div class="row">
                <div class="imagearea col-lg-5 col-md-5 col-sm-12">
                  <div class="avatarimage" id="drop-area">
                    <?php
                    $src = 'webcam/assets/img/avatar.jpg';
                    if (!empty($result->image)) {
                      $src = asset('assets/webcam/avatar/' . $result->image);
                    }
                    ?>
                    <img src="<?php echo $src; ?>" alt="avatar" id="avatarimage" />
                    <!-- <p>Drop your avatar here</p> -->
                  </div>
                  <div class="buttonarea">

                    <!-- <label class="btn upload"> <i class="fa fa-upload"></i> &nbsp; Upload<input type="file" class="sr-only" id="input" name="image" accept="image/*"></label>
                        <button class="btn camera" data-backdrop="static" data-toggle="modal" data-target="#cameraModal"><i class="fa fa-camera"></i> &nbsp;  Camera</button> -->
                  </div>
                  <div class="alert" role="alert"></div>
                </div>
              </div>
            </div>

          </div>
        </div>

        <style type="text/css">
          .avatararea {
            width: 224px !important;
            min-height: 204px !important;
            height: 200px !important;
            margin-top: 15px;
          }

          .avatarimage {
            margin: 0px !important;
          }

          #drop-area {
            height: 200px !important;
            border: none !important;
          }

          #avatarimage {
            height: 200px !important;
            width: 220px !important;
            border-radius: 15px;
            margin-left: 1px;
            margin-top: 1px;
          }
        </style>

        <!--Patient Details END-->
        <!--Patient Invoices Details Start-->

        <hr>
        <!--Added by Raheel-->
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group row">
              <label for="unique_id" class="col-sm-2 col-form-label pformlabel">Select Invoice</label>
              <div class="col-sm-10">
                <select class="invoice_id form-control inputs_with_bottom_border select2" id="Invoice_id" name="invoice_id">
                  <option value="">Select Invoice Number</option>
                  <?php
                  if (!empty($result->invoice)) {
                    foreach ($result->invoice as $key => $value) {
                  ?>
                      <option value="{{$value->id}}">{{$value->unique_id}}</option>
                  <?php }
                  } ?>
                </select>

                {{--<!--
                              <input type="text" name="created_at" class="form-control inputs_with_bottom_border" id="created_at" value="{{$result->invoice[0]->created_at}}">
                -->
                <!-- <div class="all_errors psngr_err" id="created_at"></div> -->--}}
              </div>
            </div>
            <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target=".bs-example-modal-center" style="
          width: 100%;
          margin: 0px;
          padding: 10px;
          background-color: #f5f5f5;
          color: #808080;
          font-weight: 500;
          border: solid 1px #d5d5d5;
          font-size: 16px;
          margin: auto;
      ">Edit Overseas Details</button>
          </div>



          <div class="col-sm-6">


            <!--Added by Raheel-->
            <?php
            $permissions = permissions();
            if ($permissions['role'] == 1 || (!empty($permissions['patients_timing_change']))) {
            ?>
              <div class="form-group row">
                <label for="created_at" class="col-sm-2 col-form-label pformlabel">Invoice / Reg Date</label>
                <div class="col-sm-10">
                  <input type="text" name="created_at" class="form-control inputs_with_bottom_border times" id="created_at" value="">
                  <div class="all_errors created_at_err"></div>
                </div>
              </div>
              <div class="form-group row">
                <label for="reporting_time" class="col-sm-2 col-form-label pformlabel">Reporting Time</label>
                <div class="col-sm-10">
                  <input type="text" name="reporting_time" class="form-control inputs_with_bottom_border times" id="reporting_time" value="">
                  <div class="all_errors psngr_err" id="reporting_time_error"></div>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>

        <button type="button" class="btn btn-primary update_btn" style="
            width: 100%;
            margin: 0px;
            padding: 30px;
            background-color: #fff;
            color: #0080ff;
            font-weight: 800;
            border: solid 1px #d5d5d5;
            font-size: 18px;
        ">Save Patient Data</button>

        <div class="row">
          <!--Modal Test-->

          <!-- Small modal -->



          <div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content" style="height: 450px;">
                <div class="modal-header">
                  <h5 class="modal-title mt-0">Passenger Details Update</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">



                  <!--Passenger Details Start-->

                  <?php
                  if (!empty($result->passenger->passport_no)) {
                  ?>
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="form-group row">

                          <!-- passport -->
                          <label for="passport_no" class="col-sm-2 col-form-label pformlabel">Passport#</label>
                          <div class="col-sm-4">
                            <input type="text" name="passport_no" class="form-control" id="passport_no" value="{{$result->passenger->passport_no}}">
                            <div class="all_errors psngr_err" id="passport_no_error"></div>
                          </div>

                          <!-- Airline -->
                          <label for="airline" class="col-sm-2 col-form-label pformlabel">Airline</label>
                          <div class="col-sm-4">
                            <select class="form-control" id="airline" name="airline">
                              <option value="">Select Airline</option>
                              <?php
                              foreach ($airlines as $key => $value) {
                              ?>
                                <option value="{{$value->name}}" <?php echo ($value->name == $result->passenger->airline) ? 'selected' : ''; ?>>{{$value->name}}
                                </option>
                              <?php } ?>

                            </select>
                            <div class="all_errors psngr_err" id="airline_error"></div>
                          </div>
                        </div>

                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="form-group row">
                          <!-- Country -->
                          <label for="country_id" class="col-sm-2 col-form-label pformlabel">Travelling To</label>
                          <div class="col-sm-4">
                            <select class="form-control" id="country_id" name="country_id">
                              <option value="">Select Country</option>
                              <?php
                              foreach ($countries as $key => $value) {
                              ?>
                                <option value="{{$value->id}}" <?php echo ($value->id == $result->passenger->country_id) ? 'selected' : ''; ?>>{{$value->name}}
                                </option>
                              <?php } ?>

                            </select>
                            <div class="all_errors psngr_err" id="country_id_error"></div>
                          </div>

                          <!-- Airport -->
                          <label for="" class="col-sm-2 col-form-label pformlabel">Airport</label>
                          <div class="col-sm-4">
                            <select name="" id="" class="form-control">
                              <option value="">Select Airport</option>
                            </select>

                          </div>
                        </div>
                      </div>
                      <!--<div class="col-sm-6">
                      <div class="form-group row">
                        <label for="collection_point" class="col-sm-2 col-form-label pformlabel">Collection Point</label>
                        <div class="col-sm-10">
                          <input type="text" name="collection_point" class="form-control inputs_with_bottom_border" id="collection_point" value="{{$result->passenger->collection_point}}">
                          <div class="all_errors psngr_err" id="collection_point_error"></div>
                        </div>
                      </div>
                    </div> -->
                    </div>

                    <div class="row">
                      <div class="col-sm-12">
                        <div class="form-group row">
                          <!-- Flight Date -->
                          <label for="flight_date" class="col-sm-2 col-form-label pformlabel">Flight Date</label>
                          <div class="col-sm-4">
                            <input type="date" name="flight_date" class="form-control" id="flight_date" value="{{$result->passenger->flight_date}}">
                            <div class="all_errors psngr_err" id="flight_date_error"></div>
                          </div>
                          <!-- Flight Time -->
                          <label for="flight_time" class="col-sm-2 col-form-label pformlabel">Flight Time</label>
                          <div class="col-sm-4">
                            <input type="time" name="flight_time" class="form-control" id="flight_time" value="{{$result->passenger->flight_time}}">
                            <!-- <div class="all_errors psngr_err" id="flight_time_error"></div> -->
                          </div>
                        </div>
                      </div>
                    </div>



                    <div class="row">
                      <div class="col-sm-12">
                        <div class="form-group row">
                          <!-- Flight Number -->
                          <label for="flight_no" class="col-sm-2 col-form-label pformlabel">Flight No</label>
                          <div class="col-sm-4">
                            <input type="text" name="flight_no" class="form-control" id="flight_no" value="{{$result->passenger->flight_no}}">
                            <div class="all_errors psngr_err" id="flight_no_error"></div>
                          </div>

                          <!-- Booking Ref # -->

                          <label for="booking_ref_no" class="col-sm-2 col-form-label pformlabel">Booking Ref No</label>
                          <div class="col-sm-4">
                            <input type="text" name="booking_ref_no" class="form-control" id="booking_ref_no" value="{{$result->passenger->booking_ref_no}}">
                            <div class="all_errors psngr_err" id="booking_ref_no_error"></div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-12">
                        <div class="form-group row">
                          <!-- Ticket Number -->
                          <label for="ticket_no" class="col-sm-2 col-form-label pformlabel">Ticket No</label>
                          <div class="col-sm-4">
                            <input type="text" name="ticket_no" class="form-control" id="ticket_no" value="{{$result->passenger->ticket_no}}">
                            <div class="all_errors psngr_err" id="ticket_no_error"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php } ?>

                </div>
                <div class="col-sm-12">
                  <button type="button" class="btn btn-success update_btn btn-lg btn-block">Save Passenger Details</button>
                </div>

              </div>
              <!-- end row -->
  </form>

</div><!-- container fluid -->



</div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>




<!-- Reason Modal -->
<div class="modal fade" id="reasonModel" tabindex="-1" role="dialog" aria-labelledby="reasonLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="reasonLabel">What is the reason of update?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="reason-form" method="post">
          @csrf
          <div class="form-group">
            <label for="reason">Describe Reason</label>
            <textarea name="reason" class="form-control"></textarea>
            <div class="all_errors" id="reason_error"></div>
          </div>
          <button type="submit" class="btn btn-primary">Save Reason</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- The Make Selection Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Make a selection</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        <div id="cropimage">
          <img id="imageprev" src="assets/img/bg.png" />
        </div>
        <div class="progress">
          <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
        </div>
      </div>
      <!-- Modal footer -->
      <div class="modal-footer">
        <div class="btngroup">
          <button type="button" class="btn upload1 float-left" data-dismiss="modal">Close</button>
          <button type="button" class="btn btnsmall" id="rotateL" title="Rotate Left"><i class="fa fa-undo"></i></button>
          <button type="button" class="btn btnsmall" id="rotateR" title="Rotate Right"><i class="fa fa-repeat"></i></button>
          <button type="button" class="btn btnsmall" id="scaleX" title="Flip Horizontal"><i class="fa fa-arrows-h"></i></button>
          <button type="button" class="btn btnsmall" id="scaleY" title="Flip Vertical"><i class="fa fa-arrows-v"></i></button>
          <button type="button" class="btn btnsmall" id="reset" title="Reset"><i class="fa fa-refresh"></i></button>
          <button type="button" class="btn camera1 float-right" id="saveAvatar">Save</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- The Camera Modal -->
<div class="modal" id="cameraModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Take a picture</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        <div id="my_camera"></div>
      </div>
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn upload" data-dismiss="modal">Close</button>
        <button type="button" class="btn camera" onclick="take_snapshot()">Take a picture</button>
      </div>
    </div>
  </div>
</div>

<script language="JavaScript">
  // Configure a few settings and attach camera

  var image_file;

  function configure() {
    Webcam.set({
      width: 640,
      height: 480,
      image_format: 'jpeg',
      jpeg_quality: 100
    });
    Webcam.attach('#my_camera');
  }
  // A button for taking snaps

  function take_snapshot() {
    // take snapshot and get image data
    Webcam.snap(function(data_uri) {
      // display results in page
      $("#cameraModal").modal('hide');
      $("#myModal").modal({
        backdrop: "static"
      });
      $("#cropimage").html('<img id="imageprev" src="' + data_uri + '"/>');
      cropImage();
      //document.getElementById('cropimage').innerHTML = ;
    });
    Webcam.reset();
  }

  function saveSnap() {
    // Get base64 value from <img id='imageprev'> source
    var base64image = document.getElementById("imageprev").src;
    Webcam.upload(base64image, 'upload.php', function(code, text) {
      console.log('Save successfully');
    });
  }

  $('#cameraModal').on('show.bs.modal', function() {
    configure();
  })

  $('#cameraModal').on('hide.bs.modal', function() {
    Webcam.reset();
    $("#cropimage").html("");
  })

  $('#myModal').on('hide.bs.modal', function() {
    $("#cropimage").html('<img id="imageprev" src="assets/img/bg.png"/>');
  })

  /* UPLOAD Image */
  var input = document.getElementById('input');
  var $alert = $('.alert');


  /* DRAG and DROP File */
  $("#drop-area").on('dragenter', function(e) {
    e.preventDefault();
  });

  $("#drop-area").on('dragover', function(e) {
    e.preventDefault();
  });

  $("#drop-area").on('drop', function(e) {
    var image = document.querySelector('#imageprev');
    var files = e.originalEvent.dataTransfer.files;

    var done = function(url) {
      input.value = '';
      image.src = url;
      $alert.hide();
      $("#myModal").modal({
        backdrop: "static"
      });
      cropImage();
    };

    var reader;
    var file;
    var url;

    if (files && files.length > 0) {
      file = files[0];

      if (URL) {
        done(URL.createObjectURL(file));
      } else if (FileReader) {
        reader = new FileReader();
        reader.onload = function(e) {
          done(reader.result);
        };
        reader.readAsDataURL(file);
      }
    }

    e.preventDefault();

  });

  /* INPUT UPLOAD FILE */
  input.addEventListener('change', function(e) {
    var image = document.querySelector('#imageprev');
    var files = e.target.files;
    var done = function(url) {
      input.value = '';
      image.src = url;
      $alert.hide();
      $("#myModal").modal({
        backdrop: "static"
      });
      cropImage();

    };
    var reader;
    var file;
    var url;

    if (files && files.length > 0) {
      file = files[0];

      if (URL) {
        done(URL.createObjectURL(file));
      } else if (FileReader) {
        reader = new FileReader();
        reader.onload = function(e) {
          done(reader.result);
        };
        reader.readAsDataURL(file);
      }
    }
  });
  /* CROP IMAGE AFTER UPLOAD */
  function cropImage() {
    var image = document.querySelector('#imageprev');
    var minAspectRatio = 0.5;
    var maxAspectRatio = 1.5;

    var cropper = new Cropper(image, {
      aspectRatio: 10 / 10,
      minCropBoxWidth: 25,
      minCropBoxHeight: 25,

      ready: function() {
        var cropper = this.cropper;
        var containerData = cropper.getContainerData();
        var cropBoxData = cropper.getCropBoxData();
        var aspectRatio = cropBoxData.width / cropBoxData.height;
        //var aspectRatio = 4 / 3;
        var newCropBoxWidth;
        cropper.setDragMode("move");
        if (aspectRatio < minAspectRatio || aspectRatio > maxAspectRatio) {
          newCropBoxWidth = cropBoxData.height * ((minAspectRatio + maxAspectRatio) / 2);

          cropper.setCropBoxData({
            left: (containerData.width - newCropBoxWidth) / 2,
            width: newCropBoxWidth
          });
        }
      },

      cropmove: function() {
        var cropper = this.cropper;
        var cropBoxData = cropper.getCropBoxData();
        var aspectRatio = cropBoxData.width / cropBoxData.height;

        if (aspectRatio < minAspectRatio) {
          cropper.setCropBoxData({
            width: cropBoxData.height * minAspectRatio
          });
        } else if (aspectRatio > maxAspectRatio) {
          cropper.setCropBoxData({
            width: cropBoxData.height * maxAspectRatio
          });
        }
      },


    });

    $("#scaleY").click(function() {
      var Yscale = cropper.imageData.scaleY;
      if (Yscale == 1) {
        cropper.scaleY(-1);
      } else {
        cropper.scaleY(1);
      };
    });

    $("#scaleX").click(function() {
      var Xscale = cropper.imageData.scaleX;
      if (Xscale == 1) {
        cropper.scaleX(-1);
      } else {
        cropper.scaleX(1);
      };
    });

    $("#rotateR").click(function() {
      cropper.rotate(45);
    });
    $("#rotateL").click(function() {
      cropper.rotate(-45);
    });
    $("#reset").click(function() {
      cropper.reset();
    });


    $("#saveAvatar").click(function() {
      var $progress = $('.progress');
      var $progressBar = $('.progress-bar');
      var avatar = document.getElementById('avatarimage');
      var $alert = $('.alert');
      canvas = cropper.getCroppedCanvas({
        width: 220,
        height: 240,
      });

      $progress.show();
      $alert.removeClass('alert-success alert-warning');
      canvas.toBlob(function(blob) {
        var formData = new FormData();

        image_file = blob;
        console.log(image_file);

        $("#myModal").modal('hide');
        $progress.hide();
        initialAvatarURL = avatar.src;
        avatar.src = canvas.toDataURL();
        return false;

        // formData.append('avatar', blob, 'avatar.jpg');
        // $.ajax('upload.php', {
        //     method: 'POST',
        //     data: formData,
        //     processData: false,
        //     contentType: false,

        //     xhr: function() {
        //         var xhr = new XMLHttpRequest();

        //         xhr.upload.onprogress = function(e) {
        //             var percent = '0';
        //             var percentage = '0%';

        //             if (e.lengthComputable) {
        //                 percent = Math.round((e.loaded / e.total) * 100);
        //                 percentage = percent + '%';
        //                 $progressBar.width(percentage).attr('aria-valuenow', percent).text(percentage);
        //             }
        //         };

        //         return xhr;
        //     },

        //     success: function() {
        //         //$alert.show().addClass('alert-success').text('Upload success');
        //     },

        //     error: function() {
        //         avatar.src = initialAvatarURL;
        //         $alert.show().addClass('alert-warning').text('Upload error');
        //     },

        //     complete: function() {
        //         $("#myModal").modal('hide');
        //         $progress.hide();
        //         initialAvatarURL = avatar.src;
        //         avatar.src = canvas.toDataURL();
        //     },
        // });
      });

    });
  };
</script>

<script src="{{asset('assets/developer/admin/patients.js')}}"></script>

@endsection