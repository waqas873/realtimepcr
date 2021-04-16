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
    var base_url = '<?php echo url('/');?>';
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

<li>
<a href="" class="waves-effect">
<img src="{{asset('assets/icons/sidebar-icons/icon4.svg')}}" class="sidebar_icons">
<span> Dashboard </span>
</a>
</li>
<li>
<a href="{{url('admin/cpanel')}}" class="waves-effect">
<img src="{{asset('assets/icons/sidebar-icons/icon3.svg')}}" class="sidebar_icons">
<span> App cPanel </span>
</a>
</li>
<li>
    
    <li class="has_sub">
<a href="javascript:void(0);" class="waves-effect"><img src="{{asset('assets/icons/sidebar-icons/icon8.svg')}}" class="sidebar_icons"> <span>Labs & CPs</span> <span class="menu-arrow float-right"><i class="mdi mdi-chevron-right"></i></span></a>
    
    
    <ul class="list-unstyled">
<li><a href="{{url('admin/labs')}}">Official Labs List</a></li>
<li><a href="{{url('admin/collection-points')}}">Registered CPs List</a></li>
<li><a href="{{url('admin/reports')}}">Labs & CPs Reports</a></li>
</ul>
</li>
    
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
<li class="has_sub">
<a href="javascript:void(0);" class="waves-effect"><img src="{{asset('assets/icons/sidebar-icons/icon8.svg')}}" class="sidebar_icons"> <span> Accounts </span> <span class="menu-arrow float-right"><i class="mdi mdi-chevron-right"></i></span></a>
<ul class="list-unstyled">
<li><a href="{{url('admin/accounts/vouchers')}}">Vouchers</a></li>
<li><a href="{{url('admin/accounts/cashbook')}}">CashBook</a></li>
<li><a href="javascript::">Trial Balance</a></li>
<li><a href="javascript::">Balance Sheet</a></li>
<li><a href="javascript::">Income Statment</a></li>
<li><a href="javascript::">Profit and Loss</a></li>
<li><a href="{{url('admin/accounts/ledgers')}}">Ledgers</a></li>
</ul>
</li>

<li>
<a href="" class="waves-effect">
<img src="{{asset('assets/icons/sidebar-icons/icon8.svg')}}" class="sidebar_icons">
<span> Inventory </span>
</a>
</li>
<!--
<li>
<a href="{{url('admin/reports')}}" class="waves-effect">
<img src="{{asset('assets/icons/sidebar-icons/icon8.svg')}}" class="sidebar_icons">
<span>Lab/CP Reports</span>
</a>
</li>
-->
<li>
<a href="{{url('admin/staff')}}" class="waves-effect">
<img src="{{asset('assets/icons/sidebar-icons/icon8.svg')}}" class="sidebar_icons">
<span>App Users</span>
</a>
</li>
<li>
<a href="" class="waves-effect">
<img src="{{asset('assets/icons/sidebar-icons/icon2.svg')}}" class="sidebar_icons">
<span> Invoices </span>
</a>
</li>
<li>
    
    
    <li class="has_sub">
<a href="javascript:void(0);" class="waves-effect"><img src="{{asset('assets/icons/sidebar-icons/icon8.svg')}}" class="sidebar_icons"> <span> Patients List </span> <span class="menu-arrow float-right"><i class="mdi mdi-chevron-right"></i></span></a>
    
    
    <ul class="list-unstyled">
<li><a href="{{url('admin/patients')}}">Registered patients</a></li>
<li><a href="{{url('admin/')}}">Deleted Patients</a></li>
<li><a href="{{url('admin/')}}">API Cancelled</a></li>
</ul>
</li>

<li class="has_sub">
<a href="javascript:void(0);" class="waves-effect"><img src="{{asset('assets/icons/sidebar-icons/icon8.svg')}}" class="sidebar_icons"> <span>Patient Tests</span> <span class="menu-arrow float-right"><i class="mdi mdi-chevron-right"></i></span></a>
    
    
    <ul class="list-unstyled">
<li><a href="{{url('admin/')}}">Open Cases</a></li>
<li><a href="{{url('admin/')}}">Reports Submitted</a></li>
</ul>
</li>
    
<!--    
<a href="{{url('admin/patients')}}" class="waves-effect">
<img src="{{asset('assets/icons/sidebar-icons/icon5.svg')}}" class="sidebar_icons">
<span> Patients List </span>
</a>
</li>
-->


<li>
<a href="{{url('admin/doctors')}}" class="waves-effect">
<img src="{{asset('assets/icons/sidebar-icons/icon7.svg')}}" class="sidebar_icons">
<span> Doctors List </span>
</a>
</li>
<li>
<a href="" class="waves-effect">
<img src="{{asset('assets/icons/sidebar-icons/icon1.svg')}}" class="sidebar_icons">
<span> Suppliers List </span>
</a>
</li>
<li>
<a href="" class="waves-effect">
<img src="{{asset('assets/icons/sidebar-icons/icon6.svg')}}" class="sidebar_icons">
<span> Progress Report </span>
</a>
</li>
<li>
<a href="{{url('admin/api')}}" class="waves-effect">
<img src="{{asset('assets/icons/sidebar-icons/icon1.svg')}}" class="sidebar_icons">
<span> Arham's API </span>
</a>
</li>
<li>
<a href="{{url('admin/logs')}}" class="waves-effect">
<img src="{{asset('assets/icons/sidebar-icons/icon1.svg')}}" class="sidebar_icons">
<span> Activity History </span>
</a>
</li>



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

</div>
</li>

<li class="list-inline-item dropdown notification-list nav-user">
<a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button"
aria-haspopup="false" aria-expanded="false">
<img src="{{asset('assets/images/users/avatar-6.jpg')}}" alt="user" class="rounded-circle">
<span class="d-none d-md-inline-block ml-1">
    {{ ucwords(Auth::user()->name) }}
<i class="mdi mdi-chevron-down"></i> </span>
</a>

</li>

</ul>


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

                <span><i>powered by</i></span> <span> <a href="https://www.artflow.pk" target="_blank">Artflow Studio</a></span</p
</footer>

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

</body>
</html>