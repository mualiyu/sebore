<!DOCTYPE html>
<html lang="en">

<head>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Mega Able Bootstrap admin template made using Bootstrap 4 and it has huge amount of ready made feature, UI components, pages which completely fulfills any dashboard needs." />
    <meta name="keywords" content="flat ui, admin Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
    <meta name="author" content="codedthemes" />
    <!-- Favicon icon -->
    <link rel="icon" href="{{asset('assets/images/logo.png')}}" type="image/x-icon">
    <!-- Google font-->     <link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/bootstrap/css/bootstrap.min.css')}}">
    <!-- waves.css -->
    <link rel="stylesheet" href="{{asset('assets/pages/waves/css/waves.min.css" type="text/css')}}" media="all">
    <!-- themify-icons line icon -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/icon/themify-icons/themify-icons.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/icon/font-awesome/css/font-awesome.min.css')}}">
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/jquery.mCustomScrollbar.css')}}">

    @yield('style')
</head>

<body>


<!-- Pre-loader start -->
<div class="theme-loader">
    <div class="loader-track">
        <div class="preloader-wrapper">
            <div class="spinner-layer spinner-blue">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="gap-patch">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
            <div class="spinner-layer spinner-red">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="gap-patch">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
            
            <div class="spinner-layer spinner-yellow">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="gap-patch">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
            
            <div class="spinner-layer spinner-green">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="gap-patch">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Pre-loader end -->

<?php 

// $organization = App\Models\Organization::find(Auth::user()->organization_id);
$organization = Auth::user()->organization()->get(); 
// dd($organization[0]);

if ($organization[0]->logo) {
    	$pic = $organization[0]->logo;
}else {
    	$pic = "default.jpg";
}
?>
<div id="pcoded" class="pcoded">
    <div class="pcoded-overlay-box"></div>
    <div class="pcoded-container navbar-wrapper">
        <nav class="navbar header-navbar pcoded-header" style="background: rgba(90,30,30,0.7);">
            <div class="navbar-wrapper">
                <div class="navbar-logo">
                    <a class="mobile-menu waves-effect waves-light" id="mobile-collapse" href="#!">
                        <i class="ti-menu"></i>
                    </a>
                    <div class="mobile-search waves-effect waves-light">
                        <div class="header-search">
                            <div class="main-search morphsearch-search">
                                <div class="input-group">
                                    <span class="input-group-addon search-close"><i class="ti-close"></i></span>
                                    <input type="text" class="form-control" placeholder="Enter Keyword">
                                    <span class="input-group-addon search-btn"><i class="ti-search"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="#">
                        {{-- <img class="img-fluid" src="{{asset('assets/images/logo.png')}}" alt="Theme-Logo" /> --}}
                        <a class="img-fluid">{{$organization[0]->name}}</a>
                    </a>
                    <a class="mobile-options waves-effect waves-light">
                        <i class="ti-more"></i>
                    </a>
                </div>
            
                <div class="navbar-container container-fluid">
                    <ul class="nav-left">
                        <li>
                            <div class="sidebar_toggle"><a href="javascript:void(0)"><i class="ti-menu"></i></a></div>
                        </li>
                         <li class="header-search">
                            <div class="main-search morphsearch-search">
                                <div class="input-group">
                                    <span class="input-group-addon search-close"><i class="ti-close"></i></span>
                                    <input type="text" class="form-control">
                                    <span class="input-group-addon search-btn"><i class="ti-search"></i></span>
                                </div>
                            </div>
                         </li>
                        <li>
                            <a href="#!" onclick="javascript:toggleFullScreen()" class="waves-effect waves-light">
                                <i class="ti-fullscreen"></i>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav-right">

                        <li class="user-profile header-notification">
                            <a href="#!" class="waves-effect waves-light">
                                <img src="{{asset('storage/pic/'.$pic)}}" class="img-radius" alt="User-Profile-Image">
                                <span>{{Auth::user()->name}}</span>
                                <i class="ti-angle-down"></i>
                            </a>
                            <ul class="show-notification profile-notification">
                                <li class="waves-effect waves-light">
                                    <a href="{{route('profile')}}">
                                        <i class="ti-user"></i> Profile
                                    </a>
                                </li>
                                <li class="waves-effect waves-light">
                                     <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>


    
        <div class="pcoded-main-container">
            <div class="pcoded-wrapper">
                <nav class="pcoded-navbar">
                    <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
                    <div class="pcoded-inner-navbar main-menu">
                        <div class="">
                            <div class="main-menu-header">
                                <img class="img-80 img-radius" src="{{asset('storage/pic/'.$pic)}}" alt="User-Profile-Image">
                                <div class="user-details">
                                    <span id="more-details">{{Auth::user()->name}}<i class="fa fa-caret-down"></i></span>
                                </div>
                            </div>
                        
                            <div class="main-menu-content">
                                <ul>
                                    <li class="more-details">
                                        <a href="{{route('profile')}}"><i class="ti-user"></i>View Profile</a>
                                        <a href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="pcoded-navigation-label" data-i18n="nav.category.navigation"></div>
                        <ul class="pcoded-item pcoded-left-item">
                            <li class="">
                                <a href="{{route('home')}}" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
                                    <span class="pcoded-mtext" data-i18n="nav.dash.main">Dashboard</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
			                <li class="">
                                <a href="{{route('show_users')}}" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-user"></i><b>D</b></span>
                                    <span class="pcoded-mtext" data-i18n="nav.dash.main">Users</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                            <li class="">
                                <a href="{{route('show_agents')}}" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="fa fa-users" aria-hidden="true"></i><b>D</b></span>
                                    <span class="pcoded-mtext" data-i18n="nav.dash.main">Agents</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>

                            <li class="">
                                <a href="{{route('show_devices')}}" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="fas fa-table" aria-hidden="true"></i><b>D</b></span>
                                    <span class="pcoded-mtext" data-i18n="nav.dash.main">Devices</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                            {{-- <li class="">
                                <a href="{{route('show_customers')}}" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-layout-grid2-alt"></i><b>D</b></span>
                                    <span class="pcoded-mtext" data-i18n="nav.dash.main">Customers</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li> --}}
			    
                        </ul>
                    
                        {{-- <div class="pcoded-navigation-label" data-i18n="nav.category.forms">Chart &amp; Maps</div> --}}
                        <ul class="pcoded-item pcoded-left-item">
                            
                            <li class="">
                                <a href="{{route('show_add_direct_customer')}}" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="fa fa-users" aria-hidden="true"></i><b>D</b></span>
                                    <span class="pcoded-mtext" data-i18n="nav.dash.main">Create Customers's</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>

                            <li class="">
                                <a href="{{route('show_add_direct_item')}}" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="fa fa-users" aria-hidden="true"></i><b>D</b></span>
                                    <span class="pcoded-mtext" data-i18n="nav.dash.main">Create Item's</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                    
                        </ul>
                    
                        
                    </div>
                </nav>
                <div class="pcoded-content">

		            @yield('content')
		    
                </div>
                <div id="styleSelector">
                
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Required Jquery -->
    <script type="text/javascript" src="{{asset('assets/js/jquery/jquery.min.js')}}"></script>     <script type="text/javascript" src="assets/js/jquery-ui/jquery-ui.min.js "></script>     <script type="text/javascript" src="assets/js/popper.js/popper.min.js"></script>     
    <script type="text/javascript" src="assets/js/bootstrap/js/bootstrap.min.js "></script>
<!-- waves js -->
<script src="{{asset('assets/pages/waves/js/waves.min.js')}}"></script>
<!-- jquery slimscroll js -->
<script type="text/javascript" src="{{asset('assets/js/jquery-slimscroll/jquery.slimscroll.js')}}"></script>
<!-- modernizr js -->
    <script type="text/javascript" src="{{asset('assets/js/SmoothScroll.js')}}"></script>     
    <script src="{{asset('assets/js/jquery.mCustomScrollbar.concat.min.js')}}"></script>
<script src="{{asset('assets/js/pcoded.min.js')}}"></script>
<script src="{{asset('assets/js/vertical-layout.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.mCustomScrollbar.concat.min.js')}}"></script>
<!-- Custom js -->
<script type="text/javascript" src="{{asset('assets/js/script.js')}}"></script>
@yield('script')

</body>

</html>
