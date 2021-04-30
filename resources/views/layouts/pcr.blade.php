<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Receptionist | RealtimePCR</title>
  <meta content="Admin Dashboard" name="description" />
  <meta content="ThemeDesign" name="author" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />

  <link rel="shortcut icon" href="{{asset('assets/images/favicon.ico')}}">

  <!-- morris css -->
  <link rel="stylesheet" href="{{asset('assets/plugins/morris/morris.css')}}">

  <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
  <link href="{{asset('assets/css/icons.css')}}" rel="stylesheet" type="text/css">
  <link href="{{asset('assets/css/style.css')}}" rel="stylesheet" type="text/css">

  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">


  <link href="{{asset('assets/developer/developer.css')}}" rel="stylesheet" type="text/css">

  <link href="{{asset('assets/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{asset('assets/select2/css/select2-bootstrap.min.css')}}" rel="stylesheet" type="text/css" />

  <link href="{{asset('assets/plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{asset('assets/plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
  <!-- Responsive datatable examples -->
  <link href="{{asset('assets/plugins/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />

  <script type="text/javascript">
    var bootstrap_file = '{{asset("assets/css/bootstrap.min.css")}}';
  </script>

  <script src="{{asset('assets/js/jquery.min.js')}}"></script>
  <script src="{{asset('assets/js/sweetalert.min.js')}}"></script>
  <script src="{{asset('assets/developer/loadingOverlay.js')}}"></script>

</head>


<body class="fixed-left">

  <!-- Loader -->
  <div id="preloader">
    <div id="status">
      <div class="spinner">
        <div class="rect1"></div>
        <div class="rect2"></div>
        <div class="rect3"></div>
        <div class="rect4"></div>
        <div class="rect5"></div>
      </div>
    </div>
  </div>

  <!-- Begin page -->
  <div id="wrapper">

    <!-- ========== Left Sidebar Start ========== -->
    <div class="left side-menu">
      <button type="button" class="button-menu-mobile button-menu-mobile-topbar open-left waves-effect">
        <i class="mdi mdi-close"></i>
      </button>


      <div class="sidebar-inner slimscrollleft">

        <div id="sidebar-menu">
          <ul>

            <li>
              <a href="" class="logo"><img src="{{asset('assets/images/pcr-logo.png')}}" height="170" alt="logo" class="dashboard-logo">
              </a>
            </li>

            <?php if (\Session::get('role') == 0) { ?>
              <li>
                <a href="{{url('reception')}}" class="waves-effect">
                  <img src="{{asset('assets/icons/sidebar-icons/icon4.svg')}}" class="sidebar_icons">
                  <span> Dashboard </span>
                </a>
              </li>
            <?php } ?>
            <li>
              <a href="{{url('patient-add')}}" class="waves-effect">
                <img src="{{asset('assets/icons/sidebar-icons/icon3.svg')}}" class="sidebar_icons">
                <span> Patient Registration </span>
              </a>
            </li>


            <?php if (\Session::get('role') == 5) { ?>
              <li>
                <a href="{{url('patient-add')}}" class="waves-effect">
                  <img src="{{asset('assets/icons/sidebar-icons/icon3.svg')}}" class="sidebar_icons">
                  <span> CP Admin</span>
                </a>
              </li>
            <?php } ?>

            <?php if (\Session::get('role') == 0) { ?>
              <li>
                <a href="{{url('reports')}}" class="waves-effect">
                  <img src="{{asset('assets/icons/sidebar-icons/icon8.svg')}}" class="sidebar_icons">
                  <span> Test Reports </span>
                </a>
              </li>

              <li>
                <a href="{{url('invoices')}}" class="waves-effect">
                  <img src="{{asset('assets/icons/sidebar-icons/icon2.svg')}}" class="sidebar_icons">
                  <span> Invoices </span>
                </a>
              </li>
            <?php } ?>
            <li>
              <a href="{{url('patients')}}" class="waves-effect">
                <img src="{{asset('assets/icons/sidebar-icons/icon5.svg')}}" class="sidebar_icons">
                <span> Patients List </span>
              </a>
            </li>
            <?php if (\Session::get('role') == 0) { ?>
              <li>
                <a href="{{url('amounts')}}" class="waves-effect">
                  <img src="{{asset('assets/icons/sidebar-icons/icon1.svg')}}" class="sidebar_icons">
                  <span> Amount History </span>
                </a>
              </li>
            <?php } ?>



          </ul>
        </div>
        <div class="clearfix"></div>
      </div> <!-- end sidebarinner -->
    </div>
    <!-- Left Sidebar End -->

    <!-- Start right Content here -->

    <div class="content-page">
      <!-- Start content -->
      <div class="content">

        <!-- Top Bar Start -->
        <div class="topbar">

          <div class="topbar-left d-none d-lg-block">
            <div class="text-center">
              <a href="" class="dashboard-heading">
                <h2>Realtime PCR</h2>
              </a>
            </div>
          </div>

          <nav class="navbar-custom">

            <ul class="list-inline float-right mb-0">
              <div class="dropdown-menu dropdown-menu-right dropdown-arrow dropdown-menu-lg dropdown-menu-animated">
                <!-- All-->
                <a href="javascript:void(0);" class="dropdown-item notify-all">
                  View All
                </a>

              </div>
              </li>

              <li class="list-inline-item dropdown notification-list nav-user">
                <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                  <img src="{{asset('assets/images/users/avatar-6.jpg')}}" alt="user" class="rounded-circle">
                  <span class="d-none d-md-inline-block ml-1">
                    {{ ucwords(Auth::user()->name) }}
                    <i class="mdi mdi-chevron-down"></i> </span>
                </a>

                <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated profile-dropdown">
                  <a class="dropdown-item" href="{{url('user-update')}}"><i class="dripicons-user text-muted"></i> Profile</a>
                  <!-- <a class="dropdown-item" href="#"><i class="dripicons-wallet text-muted"></i> My Wallet</a>
<a class="dropdown-item" href="#"><span class="badge badge-success float-right m-t-5">5</span><i class="dripicons-gear text-muted"></i> Settings</a>
<a class="dropdown-item" href="#"><i class="dripicons-lock text-muted"></i> Lock screen</a> -->
                  <div class="dropdown-divider"></div>

                  <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
 document.getElementById('logout-form').submit();"><i class="dripicons-exit text-muted"></i> Logout</a>

                </div>
              </li>

              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
              </form>

            </ul>

            <ul class="list-inline menu-left mb-0">
              <li class="list-inline-item">
                <button type="button" class="button-menu-mobile open-left waves-effect">
                  <i class="mdi mdi-menu"></i>
                </button>

                <input type="text" id="search_report_val" class="input-search" placeholder="Enter Invoice ID" style="
    height: 35px;
    border-radius: 2px;
    border: none;
    padding: 10px;
">
                <button type="button" id="search_report" class="btn search-btn" style="color: white;">Search Report</button>
                <input type="text" id="search_patient_val" class="input-search" placeholder="ID / Contact / CNIC" style="
    height: 35px;
    border-radius: 2px;
    border: none;
    padding: 10px;
">
                <button type="button" id="search_patient" class="btn" style="
    color: white;
">Search Patient</button>

              </li>

            </ul>

            <script type="text/javascript">
              $(document).ready(function() {

                $(document).on('click', '#search_report', function(e) {
                  e.preventDefault();

                  var id = $('#search_report_val').val();
                  if (id == '') {
                    return false;
                  }
                  var url = '<?php echo url('/'); ?>';
                  var redirect_url = url + '/track/' + id;
                  window.open(redirect_url, "_blank");
                });

                $(document).on('click', '#search_patient', function(e) {
                  e.preventDefault();
                  var id = $('#search_patient_val').val();
                  if (id == '') {
                    return false;
                  }
                  var url = '<?php echo url('/'); ?>';
                  var redirect_url = url + '/patient-detail/' + id + '/HbN';
                  window.open(redirect_url, "_blank");
                });

              });
            </script>

          </nav>

        </div>
        <!-- Top Bar End -->

        <div class="page-content-wrapper ">

          @yield('content')

        </div> <!-- Page content Wrapper -->

      </div> <!-- content -->

      <footer class="footer">
        <p class="font-size-sm mb-0">Copyright &copy;
          <script type="text/javascript">
            document.write(new Date().getFullYear());
          </script>. Realtime PCR Lab <span class="d-none d-sm-inline-block">

            <span><i>powered by</i></span> <span> <a href="https://www.artflow.pk" target="_blank">Artflow Studio</a></span> </footer>

    </div>
    <!-- End Right content here -->

  </div>
  <!-- END wrapper -->


  <!-- jQuery  -->

  <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('assets/js/modernizr.min.js')}}"></script>
  <script src="{{asset('assets/js/detect.js')}}"></script>
  <script src="{{asset('assets/js/fastclick.js')}}"></script>
  <script src="{{asset('assets/js/jquery.slimscroll.js')}}"></script>
  <script src="{{asset('assets/js/jquery.blockUI.js')}}"></script>
  <script src="{{asset('assets/js/waves.js')}}"></script>
  <script src="{{asset('assets/js/jquery.nicescroll.js')}}"></script>
  <script src="{{asset('assets/js/jquery.scrollTo.min.js')}}"></script>

  <!--Morris Chart-->
  <script src="{{asset('assets/plugins/morris/morris.min.js')}}"></script>
  <script src="{{asset('assets/plugins/raphael/raphael.min.js')}}"></script>

  <!-- dashboard js -->
  <script src="{{asset('assets/pages/dashboard.int.js')}}"></script>

  <!-- App js -->
  <script src="{{asset('assets/js/app.js')}}"></script>

  <!-- Required datatable js -->
  <script src="{{asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('assets/plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>
  <!-- Buttons examples -->
  <script src="{{asset('assets/plugins/datatables/dataTables.buttons.min.js')}}"></script>
  <script src="{{asset('assets/plugins/datatables/buttons.bootstrap4.min.js')}}"></script>
  <script src="{{asset('assets/plugins/datatables/jszip.min.js')}}"></script>
  <script src="{{asset('assets/plugins/datatables/pdfmake.min.js')}}"></script>
  <script src="{{asset('assets/plugins/datatables/vfs_fonts.js')}}"></script>
  <script src="{{asset('assets/plugins/datatables/buttons.html5.min.js')}}"></script>
  <script src="{{asset('assets/plugins/datatables/buttons.print.min.js')}}"></script>
  <script src="{{asset('assets/plugins/datatables/buttons.colVis.min.js')}}"></script>
  <!-- Responsive examples -->
  <script src="{{asset('assets/plugins/datatables/dataTables.responsive.min.js')}}"></script>
  <script src="{{asset('assets/plugins/datatables/responsive.bootstrap4.min.js')}}"></script>

  <!-- Datatable init js -->
  <script src="{{asset('assets/pages/datatables.init.js')}}"></script>

  <script src="{{asset('assets/select2/js/select2.full.min.js')}}" type="text/javascript"></script>
  <!-- <script src="{{asset('assets/select2/js/components-select2.js')}}" type="text/javascript"></script> -->
  <script type="text/javascript">
    $(document).ready(function() {
      $('.select2').select2({
        placeholder: "select here"
      });
    });
  </script>

</body>

</html>