<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">

<meta name="csrf-token" content="{{ csrf_token() }}">

<title>Lab User | RealtimePCR</title>
<meta content="Admin Dashboard" name="description" />
<meta content="ThemeDesign" name="author" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />

<link rel="shortcut icon" href="{{asset('assets/images/favicon.ico')}}">

<!-- morris css -->
<link rel="stylesheet" href="{{asset('assets/plugins/morris/morris.css')}}">

<link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('assets/css/icons.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('assets/css/style.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('assets/css/cmp-style.css')}}" rel="stylesheet" type="text/css">

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

<!-- <li>
<a href="{{url('lab/dashboard')}}" class="waves-effect">
<img src="{{asset('assets/icons/sidebar-icons/icon4.svg')}}" class="sidebar_icons">
<span> Dashboard </span>
</a>
</li> -->

<li>
<a href="{{url('lab/open-cases')}}" class="waves-effect">
<img src="{{asset('assets/icons/sidebar-icons/icon3.svg')}}" class="sidebar_icons">
<span> Open Cases  </span>
</a>
</li>

<li>
<a href="{{url('lab/reports')}}" class="waves-effect">
<img src="{{asset('assets/icons/sidebar-icons/icon6.svg')}}" class="sidebar_icons">
<span> Reports Submitted </span>
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

<!-- Search input -->
<div class="search-wrap" id="search-wrap">
<div class="search-bar">
<input class="search-input" type="search" placeholder="Search" />
<a href="#" class="close-search toggle-search" data-target="#search-wrap">
<i class="mdi mdi-close-circle"></i>
</a>
</div>
</div>

<ul class="list-inline float-right mb-0">
<li class="list-inline-item dropdown notification-list">
<a class="nav-link waves-effect toggle-search" href="#"  data-target="#search-wrap">
<i class="mdi mdi-magnify noti-icon"></i>
</a>
</li>

<li class="list-inline-item dropdown notification-list">
<a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button"
aria-haspopup="false" aria-expanded="false">
<i class="mdi mdi-bell-outline noti-icon"></i>
<span class="badge badge-danger badge-pill noti-icon-badge">3</span>
</a>
<div class="dropdown-menu dropdown-menu-right dropdown-arrow dropdown-menu-lg dropdown-menu-animated">
<!-- item-->
<div class="dropdown-item noti-title">
    <h5>Notification (3)</h5>
</div>

<div class="slimscroll-noti">
    <!-- item-->
    <a href="javascript:void(0);" class="dropdown-item notify-item active">
        <div class="notify-icon bg-success"><i class="mdi mdi-cart-outline"></i></div>
        <p class="notify-details"><b>Your order is placed</b><span class="text-muted">Dummy text of the printing and typesetting industry.</span></p>
    </a>

    <!-- item-->
    <a href="javascript:void(0);" class="dropdown-item notify-item">
        <div class="notify-icon bg-danger"><i class="mdi mdi-message-text-outline"></i></div>
        <p class="notify-details"><b>New Message received</b><span class="text-muted">You have 87 unread messages</span></p>
    </a>

    <!-- item-->
    <a href="javascript:void(0);" class="dropdown-item notify-item">
        <div class="notify-icon bg-info"><i class="mdi mdi-filter-outline"></i></div>
        <p class="notify-details"><b>Your item is shipped</b><span class="text-muted">It is a long established fact that a reader will</span></p>
    </a>

    <!-- item-->
    <a href="javascript:void(0);" class="dropdown-item notify-item">
        <div class="notify-icon bg-success"><i class="mdi mdi-message-text-outline"></i></div>
        <p class="notify-details"><b>New Message received</b><span class="text-muted">You have 87 unread messages</span></p>
    </a>

    <!-- item-->
    <a href="javascript:void(0);" class="dropdown-item notify-item">
        <div class="notify-icon bg-warning"><i class="mdi mdi-cart-outline"></i></div>
        <p class="notify-details"><b>Your order is placed</b><span class="text-muted">Dummy text of the printing and typesetting industry.</span></p>
    </a>

</div>


<!-- All-->
<a href="javascript:void(0);" class="dropdown-item notify-all">
    View All
</a>

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
$(document).ready(function(){
  $('.select2').select2({
    placeholder: "select here"
  });
});
</script>

</body>
</html>