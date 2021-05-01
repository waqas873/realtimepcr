<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Realtime PCR | Test Reports</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link href="https://pcr.realtimepcr.pk/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/cmp-style.css')}}" rel="stylesheet" type="text/css">
    <!-- <link rel="stylesheet" href="https://pcr.realtimepcr.pk/assets/css/cmp-style.css"> -->
    <!-- <link rel="stylesheet" href="cmp-style.css"> -->

<script type="text/javascript">
    var base_url = '<?php echo url('/'); ?>';
</script>
<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<script src="{{asset('assets/developer/lab_user.js')}}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script src="https://cdn.tiny.cloud/1/v0u7jdmk1u47xhd7xzip7l7rzzz1x5y9hxaq7sk115kbjzlj/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

    <script>
        function checkFunction(x, y) {
            var checkBox = document.getElementById(x);
            var cmp = document.getElementById(y);
            if (checkBox.checked disabled == true) {
                cmp.style.display = "";
            } else {
                cmp.style.display = "none";
            }
        }
    </script>

<script>
tinymce.init({
  selector: 'textarea',
  plugins: 'a11ychecker advcode casechange formatpainter linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tinycomments tinymcespellchecker',
  toolbar: 'a11ycheck addcomment showcomments casechange checklist code formatpainter pageembed permanentpen table',
  toolbar_mode: 'floating',
  tinycomments_mode: 'embedded',
  tinycomments_author: 'Author name',
});
</script>

</head>
<body>
<div class="container" style="padding: 20px" ; id="print_section">

    <h2>Add Test Result</h2>

    <div class="row">
        <div class="col-sm-12">
            <form action="" method="post" id="manualReportForm">
                @csrf

                <input type="hidden" name="patient_test_id" value="{{$patient_test_id}}">

                <div class="form-group row">
                  <label for="name" class="col-sm-3 col-form-label pformlabel">Report Details</label>
                  <div class="col-sm-9">
                    <textarea name="manual" class="form-control inputs_with_bottom_border"></textarea>
                    <div class="all_errors manual_error">
                    </div>
                  </div>
                </div>
                
                <div class="form-group row">
                  <div class="col-sm-9 offset-sm-3">
                      <button type="submit" class="btn btn-primary save_btn">Save Report</button>
                  </div>
                </div>
            </form>
        </div>
    </div>
    <hr>

    <!-- Doctors List -->

    <div class="DocList" id="DocList">
        <div class="component nobdr">
            <div class="row">
                <div class="col-sm-3 docCard">
                    <h5 style="display:inline;">Dr. Sajid Ali
                        <span class="badge badge-pill badge-default" style="background-color: #0080ff; color: #fff; font-size: 12px;">Chief
                            Executive</span>
                    </h5>
                    <h6>(Ph.D Molecular Virology)</h6>
                </div>
                <div class="col-sm-5 docCard">
                    <h5>Dr. Shabbir Ahmad</h5>
                    <p>
                        MBBS, M.Phill (Pathology),
                        MPH (KMU-IPHSS),
                        MCPS Family Medicine,
                        Chemical Pathologist
                    </p>
                </div>
                <div class="col-sm-4 docCard" style="border: none;">
                    <h5>Dr. Nourin Mehmood</h5>
                    <p>
                        BS Bio-Tech, M.Phill Bio-Tech,Ph.D Bio-Tech
                    </p>
                </div>

            </div>
        </div>
    </div>
    <!-- Print Detials -->
    <div class="row f-br component nomgn" style="padding: 5px;">
        <div class="copyright-footer">
            <hr>
            <footer class="footer">
                <p>Copyright &copy;
                    <script type="text/javascript">
                        document.write(new Date().getFullYear());
                    </script>. Realtime PCR Lab <span class="d-none d-sm-inline-block">

                        <span><i>powered by</i></span>
                        <span> <a href="https://www.artflow.pk" target="_blank">Artflow Studio</a></span>
            </footer>
        </div>
    </div>
</div>
</body>

</html>