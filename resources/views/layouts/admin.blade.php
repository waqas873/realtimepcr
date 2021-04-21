<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Admin Panel | Realtime PCR</title>
  <meta content="Admin Dashboard" name="description" />
  <meta content="ThemeDesign" name="author" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />

  <link rel="shortcut icon" href="{{asset('assets/images/favicon.ico')}}">

  <!-- morris css -->
  <link rel="stylesheet" href="{{asset('assets/plugins/morris/morris.css')}}">

  <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
  <link href="{{asset('assets/css/icons.css')}}" rel="stylesheet" type="text/css">
  <link href="{{asset('assets/css/style.css')}}" rel="stylesheet" type="text/css">
  <link href="{{asset('assets/developer/developer.css')}}" rel="stylesheet" type="text/css">
  

  <link href="{{asset('assets/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{asset('assets/select2/css/select2-bootstrap.min.css')}}" rel="stylesheet" type="text/css" />

  <link href="{{asset('assets/css/bootstrap-toggle.min.css')}}" rel="stylesheet" type="text/css">

  <link href="{{asset('assets/plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{asset('assets/plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
  <!-- Responsive datatable examples -->
  <link href="{{asset('assets/plugins/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />

  <script type="text/javascript">
    var base_url = '<?php echo url('/'); ?>';
  </script>

  <script src="{{asset('assets/js/jquery.min.js')}}"></script>
  <script src="{{asset('assets/js/bootstrap-toggle.min.js')}}"></script>
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
            <li style="text-align: center;border-radius: 5px;border: solid 1px #c3c3c3;margin: auto;width: 80%;" id="account_balance">
              <h6>Account Balance: </h6>
              <h5> <b style="color:#00c169">------</b></h5>
            </li>
            <?php
            $permissions = permissions();
            ?>

            <?php
            if ($permissions['role'] == 1 || (!empty($permissions['dashboard_read']))) { ?>
              <li>
                <a href="" class="waves-effect">
                  <img src="{{asset('assets/icons/sidebar-icons/icon4.svg')}}" class="sidebar_icons">
                  <span> Dashboard </span>
                </a>
              </li>
            <?php } ?>

            <?php
            if ($permissions['role'] == 1) { ?>
              <li>
                <a href="{{url('admin/sub-admins')}}" class="waves-effect">
                  <img src="{{asset('assets/icons/sidebar-icons/icon3.svg')}}" class="sidebar_icons">
                  <span>Sub Admins </span>
                </a>
              </li>
            <?php } ?>
            <?php
            if ($permissions['role'] == 1 || (!empty($permissions['app_cpanel_read']))) { ?>
              <li>
                <a href="{{url('admin/cpanel')}}" class="waves-effect">
                  <img src="{{asset('assets/icons/sidebar-icons/icon3.svg')}}" class="sidebar_icons">
                  <span> App cPanel </span>
                </a>
              </li>
            <?php } ?>

            <!-- <li> -->

            <?php
            $lbcp = false;
            if ($permissions['role'] == 1 || (!empty($permissions['labs_read']))) {
              $lbcp = true;
            } elseif ($permissions['role'] == 1 || (!empty($permissions['cp_read']))) {
              $lbcp = true;
            } elseif ($permissions['role'] == 1 || (!empty($permissions['labs_and_cp_reports_read']))) {
              $lbcp = true;
            }
            if ($lbcp == true) {
            ?>

              <li class="has_sub">
                <a href="javascript:void(0);" class="waves-effect"><img src="{{asset('assets/icons/sidebar-icons/icon8.svg')}}" class="sidebar_icons">
                  <span>Labs & CPs</span> <span class="menu-arrow float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                <ul class="list-unstyled">
                  <?php
                  if ($permissions['role'] == 1 || (!empty($permissions['labs_read']))) { ?>
                    <li><a href="{{url('admin/labs')}}">Official Labs List</a></li>
                  <?php
                  }
                  if ($permissions['role'] == 1 || (!empty($permissions['cp_read']))) {
                  ?>
                    <li><a href="{{url('admin/collection-points')}}">Registered CPs List</a></li>
                  <?php
                  }
                  if ($permissions['role'] == 1 || (!empty($permissions['labs_and_cp_reports_read']))) {
                  ?>
                    <li><a href="{{url('admin/reports')}}">Labs & CPs Reports</a></li>
                  <?php
                  }
                  ?>
                </ul>
              </li>
            <?php } ?>

            <!--    
    
<a href="{{url('admin/labs')}}" class="waves-effect">
<img src="{{asset('assets/icons/sidebar-icons/icon8.svg')}}" class="sidebar_icons">
<span> Labs List </span>
</a>
</li>
<li>
<a href="{{url('admin/collection-points')}}" class="waves-effect">
<img src="{{asset('assets/icons/sidebar-icons/icon8.svg')}}" class="sidebar_icons">
<span>Colection Points </span>
</a>
</li>

-->
            <?php
            if ($permissions['role'] == 1 || (!empty($permissions['accounts_read']))) { ?>
              <li class="has_sub">
                <a href="javascript:void(0);" class="waves-effect"><img src="{{asset('assets/icons/sidebar-icons/icon8.svg')}}" class="sidebar_icons">
                  <span> Accounts </span> <span class="menu-arrow float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                <ul class="list-unstyled">
                <li><a href="{{url('admin/accounts/')}}">Assets / Liabilities</a></li>
                  <li><a href="{{url('admin/accounts/transfers')}}">Transactions / Transfers</a></li>
                  <li><a href="{{url('admin/accounts/vouchers')}}">Vouchers / Invoices</a></li>
                  <li><a href="{{url('admin/accounts/cashbook')}}">CashBook</a></li>
                  <li><a href="{{url('admin/accounts/trial-balance')}}">Trial Balance</a></li>
                  <li><a href="{{url('admin/accounts/balance-sheet')}}">Balance Sheet</a></li>
                  <li><a href="{{url('admin/accounts/income-statment')}}">Income Statment</a></li>
                  <!-- <li><a href="javascript::">Profit and Loss</a></li> -->
                  <li><a href="{{url('admin/accounts/ledgers')}}">Ledgers</a></li>
                </ul>
              </li>
            <?php
            }
            ?>

            <?php
            if ($permissions['role'] == 1 || (!empty($permissions['products_read']))) { ?>
              <li>
                <a href="{{url('admin/products')}}" class="waves-effect">
                  <img src="{{asset('assets/icons/sidebar-icons/icon8.svg')}}" class="sidebar_icons">
                  <span> Inventory </span>
                </a>
              </li>
            <?php
            }
            ?>
            <!--
<li>
<a href="{{url('admin/reports')}}" class="waves-effect">
<img src="{{asset('assets/icons/sidebar-icons/icon8.svg')}}" class="sidebar_icons">
<span>Lab/CP Reports</span>
</a>
</li>
-->
            <?php
            if ($permissions['role'] == 1 || (!empty($permissions['app_users_read']))) { ?>
              <li>
                <a href="{{url('admin/staff')}}" class="waves-effect">
                  <img src="{{asset('assets/icons/sidebar-icons/icon8.svg')}}" class="sidebar_icons">
                  <span>App Users</span>
                </a>
              </li>
            <?php } ?>
            <?php
            if ($permissions['role'] == 1 || (!empty($permissions['invoices_read']))) { ?>
              <li>
                <a href="" class="waves-effect">
                  <img src="{{asset('assets/icons/sidebar-icons/icon2.svg')}}" class="sidebar_icons">
                  <span> Invoices </span>
                </a>
              </li>

              <li>
              <?php } ?>

              <?php
              if ($permissions['role'] == 1 || (!empty($permissions['patients_read']) || !empty($permissions['patients_read_write']))) { ?>
              <li class="has_sub">
                <a href="javascript:void(0);" class="waves-effect"><img src="{{asset('assets/icons/sidebar-icons/icon8.svg')}}" class="sidebar_icons">
                  <span> Patients List </span> <span class="menu-arrow float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                <ul class="list-unstyled">
                  <li><a href="{{url('admin/patients')}}">Registered patients</a></li>
                  <?php
                  if ($permissions['role'] == 1 || (!empty($permissions['deleted_patients_read']))) { ?>
                    <li><a href="{{url('admin/deleted-patients')}}">Deleted Patients</a></li>

                    <!-- API Cancelled-->

                  <?php } ?>
                  <!--<li><a href="{{url('admin/')}}">API Cancelled</a></li>-->
                </ul>
              </li>
            <?php } ?>


            <?php
            if ($permissions['role'] == 1 || (!empty($permissions['patient_tests_read']))) { ?>
              <li class="has_sub">
                <a href="javascript:void(0);" class="waves-effect"><img src="{{asset('assets/icons/sidebar-icons/icon8.svg')}}" class="sidebar_icons">
                  <span>Lab Tests</span> <span class="menu-arrow float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                <ul class="list-unstyled">
                  <li><a href="{{url('admin/')}}">Open Cases</a></li>
                  <li><a href="{{url('admin/')}}">Reports Submitted</a></li>
                </ul>
              </li>
            <?php } ?>

            <!--    
<a href="{{url('admin/patients')}}" class="waves-effect">
<img src="{{asset('assets/icons/sidebar-icons/icon5.svg')}}" class="sidebar_icons">
<span> Patients List </span>
</a>
</li>
-->

            <?php
            if ($permissions['role'] == 1 || (!empty($permissions['doctors_read']))) { ?>
              <li>
                <a href="{{url('admin/doctors')}}" class="waves-effect">
                  <img src="{{asset('assets/icons/sidebar-icons/icon7.svg')}}" class="sidebar_icons">
                  <span> Doctors List </span>
                </a>
              </li>
            <?php }
            if ($permissions['role'] == 1 || (!empty($permissions['suppliers_read']))) { ?>
              <li>
                <a href="{{url('admin/suppliers')}}" class="waves-effect">
                  <img src="{{asset('assets/icons/sidebar-icons/icon1.svg')}}" class="sidebar_icons">
                  <span> Vendors List </span>
                </a>
              </li>
            <?php }
            if ($permissions['role'] == 1 || (!empty($permissions['progress_report_read']))) { ?>
              <li>
                <a href="" class="waves-effect">
                  <img src="{{asset('assets/icons/sidebar-icons/icon6.svg')}}" class="sidebar_icons">
                  <span> Progress Report </span>
                </a>
              </li>
            <?php }
            if ($permissions['role'] == 1 || (!empty($permissions['api_read']))) { ?>
              <li>
                <a href="{{url('admin/api')}}" class="waves-effect">
                  <img src="{{asset('assets/icons/sidebar-icons/icon1.svg')}}" class="sidebar_icons">
                  <span> Arham's API </span>
                </a>
              </li>
            <?php }
            if ($permissions['role'] == 1 || (!empty($permissions['logs_read']))) { ?>
              <li>
                <a href="{{url('admin/logs')}}" class="waves-effect">
                  <img src="{{asset('assets/icons/sidebar-icons/icon1.svg')}}" class="sidebar_icons">
                  <span> Activity History </span>
                </a>
              </li>
            <?php } ?>



            <!-- <li class="has_sub">
<a href="javascript:void(0);" class="waves-effect"><i class="dripicons-briefcase"></i> <span> Elements </span> <span class="menu-arrow float-right"><i class="mdi mdi-chevron-right"></i></span></a>
<ul class="list-unstyled">
<li><a href="ui-alerts.html">Alerts</a></li>
<li><a href="ui-badge.html">Badge</a></li>
<li><a href="ui-buttons.html">Buttons</a></li>
<li><a href="ui-cards.html">Cards</a></li>
<li><a href="ui-dropdowns.html">Dropdowns</a></li>
<li><a href="ui-navs.html">Navs</a></li>
<li><a href="ui-tabs-accordions.html">Tabs &amp; Accordions</a></li>
<li><a href="ui-modals.html">Modals</a></li>
<li><a href="ui-images.html">Images</a></li>
<li><a href="ui-progressbars.html">Progress Bars</a></li>
<li><a href="ui-pagination.html">Pagination</a></li>
<li><a href="ui-popover-tooltips.html">Popover & Tooltips</a></li>
<li><a href="ui-spinner.html">Spinner</a></li>
<li><a href="ui-carousel.html">Carousel</a></li>
<li><a href="ui-video.html">Video</a></li>
<li><a href="ui-typography.html">Typography</a></li>
<li><a href="ui-grid.html">Grid</a></li>
</ul>
</li> -->


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
                  <a class="dropdown-item" href="{{url('user-update')}}"><i class="dripicons-user text-muted"></i> Profile</a></i>
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

                <script>
                  function editPatient() {
                    var x = document.getElementById("edit_patient").value;
                    var url = "https://pcr.realtimepcr.pk/admin/patient-update/";
                    var link = url + x;
                    window.open(link, "_blank");

                  }
                </script>
                <input type="text" id="edit_patient" class="input-search" placeholder="Enter Patient ID" style="
    height: 35px;
    border-radius: 2px;
    border: none;
    padding: 10px;
">
                <button type="button" id="edit_patient" class="btn" style="
    color: white;
" onclick="editPatient()">Edit Patient</button>

              </li>

            </ul>


          </nav>

        </div>
        <!-- Top Bar End -->

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
              window.location.replace(redirect_url);
            });

            $(document).on('click', '#search_patient', function(e) {
              e.preventDefault();
              var id = $('#search_patient_val').val();
              if (id == '') {
                return false;
              }
              var url = '<?php echo url('/'); ?>';
              var redirect_url = url + '/patient-detail/' + id + '/HbN';
              window.location.replace(redirect_url);
            });

          });
        </script>

        <div class="page-content-wrapper ">

          @yield('content')

        </div> <!-- Page content Wrapper -->

      </div> <!-- content -->

      <footer class="footer">
        <p class="font-size-sm mb-0">Copyright &copy;
          <script type="text/javascript">
            document.write(new Date().getFullYear());
          </script>. Realtime PCR Lab <span class="d-none d-sm-inline-block">

            <span><i>powered by</i></span> <span> <a href="https://www.artflow.pk" target="_blank">Artflow
                Studio</a></span< /p </footer>

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

  <!-- App js -->
  <script src="{{asset('assets/js/app.js')}}"></script>

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