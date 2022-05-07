<!DOCTYPE html>
<html lang="en">

<head>

    <?php
        $org = Auth::user()->organization;
        if ($org->theme) {
            $cookie_name = 'Ats_Theme';
            
            if ($org->theme == 1) {
                $tn = 'rgb(90,30,30)';
                $th = 'rgba(109, 41, 41, 0.7)';
                $bth = 'rgba(109, 41, 41, 0.4)';
                $card1 = 'rgb(109, 41, 41)';
                $card2 ='rgb(102, 41, 41)';
                $card3 = 'rgb(100, 41, 41)';

                $cookie_value = [
                    "tn" => 'rgb(90,30,30)',
                    "th" => 'rgba(109, 41, 41, 0.7)',
                    "bth" => 'rgba(109, 41, 41, 0.4)',
                    "card1" => 'rgb(109, 41, 41)',
                    "card2" =>'rgb(102, 41, 41)',
                    "card3" => 'rgb(100, 41, 41)',
                ];
            }
            elseif ($org->theme == 2) {
                $tn = 'rgb(99,161,0)';
                $th = 'rgba(126, 170, 57, 0.7)';
                $bth = 'rgba(126, 170, 57, 0.4)';
                $card1 = 'rgb(126,170,57)';
                $card2 ='rgb(124,155,76)';
                $card3 = 'rgb(139,170,91)';

                $cookie_value = [
                    "tn" => 'rgb(99,161,0)',
                    "th" => 'rgba(126, 170, 57, 0.7)',
                    "bth" => 'rgba(126, 170, 57, 0.4)',
                    "card1" => 'rgb(126,170,57)',
                    "card2" =>'rgb(124,155,76)',
                    "card3" => 'rgb(124,155,76)',
                ];
            }
            elseif ($org->theme == 3) {
                $tn = 'rgb(0,0,255)';
                $th = 'rgba(75, 75, 241, 0.7)';
                $bth = 'rgba(75, 75, 241, 0.4)';
                $card1 = 'rgb(75, 70, 245)';
                $card2 ='rgb(75, 70, 235)';
                $card3 = 'rgb(75, 70, 225)';

                $cookie_value = [
                    "tn" => 'rgb(0,0,255)',
                    "th" => 'rgba(75, 75, 241, 0.7)',
                    "bth" => 'rgba(75, 75, 241, 0.4)',
                    "card1" => 'rgb(75, 70, 245)',
                    "card2" =>'rgb(75, 70, 235)',
                    "card3" => 'rgb(75, 70, 255)',
                ];
            }else{
                $tn = 'rgb(90,30,30)';
                $th = 'rgba(109, 41, 41, 0.7)';
                $bth = 'rgba(109, 41, 41, 0.4)';
                $card1 = 'rgb(109, 41, 41)';
                $card2 ='rgb(102, 41, 41)';
                $card3 = 'rgb(100, 41, 41)';

                $cookie_value = [
                    "tn" => 'rgb(90,30,30)',
                    "th" => 'rgba(109, 41, 41, 0.7)',
                    "bth" => 'rgba(109, 41, 41, 0.4)',
                    "card1" => 'rgb(109, 41, 41)',
                    "card2" =>'rgb(102, 41, 41)',
                    "card3" => 'rgb(100, 41, 41)',
                ];
            }
            setcookie($cookie_name, json_encode($cookie_value), time() + (86400 * 30), '/');

        }else {
            $tn = 'rgb(90,30,30)';
            $th = 'rgba(109, 41, 41, 0.7)';
            $bth = 'rgba(109, 41, 41, 0.4)';
            $card1 = 'rgb(109, 41, 41)';
            $card2 = 'rgb(102, 41, 41)';
            $card3 = 'rgb(100, 41, 41)';
        }
    ?>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Ajisaq ticketing system." />
    <meta name="keywords" content="Ticket, ticketing, system">
    <meta name="author" content="Ajisaq" />
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/jquery.mCustomScrollbar.css')}}">
     <!-- morris chart -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/morris.js/css/morris.css')}}">
    
    {{-- cdn --}}
    {{-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css"> --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.min.css">
     
    {{-- <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap4.min.js"></script> --}}
    @yield('style')

    <style>

        .page-header:before {
            background: {{$th}};
        }

        /* line 6529 */
        .text-primary {
            color: {{$th}} !important;
        }

        /* line 13688 */

        .btn-primary,
        .sweet-alert button.confirm,
        .wizard > .actions a {
            background-color: {{$th}} /*rgba(90, 30, 30, 0.7)*/;
            border-color: {{$tn}} /*rgba(90, 30, 30, 0.7)*/;
            color: #fff;
            cursor: pointer;
            -webkit-transition: all ease-in 0.3s;
            transition: all ease-in 0.3s;
        }
        .btn-primary:hover,
        .sweet-alert button.confirm:hover,
        .wizard > .actions a:hover {
            background-color: {{$bth}} /*rgba(90, 30, 30, 0.4)*/;
            border-color: {{$bth}} /*rgba(90, 30, 30, 0.4)*/;
        }
        .btn-primary:active,
        .sweet-alert button.confirm:active,
        .wizard > .actions a:active {
            background-color: {{$bth}} /*rgba(90, 30, 30, 0.4)*/ !important;
            border-color: {{$bth}} /*rgba(90, 30, 30, 0.4)*/;
            -webkit-box-shadow: none;
            box-shadow: none;
            color: #fff;
        }
        .btn-primary:focus,
        .sweet-alert button.confirm:focus,
        .wizard > .actions a:focus {
            -webkit-box-shadow: none;
            box-shadow: none;
            color: #fff;
            background-color: {{$th}};
        }

        /* 11788 */
        .pcoded .pcoded-navbar[active-item-theme="theme1"] .pcoded-item li:hover > a {
            color: {{$th}} !important;
        }
        .pcoded
        .pcoded-navbar[active-item-theme="theme1"]
        .pcoded-item
        li:hover
        > a
        .pcoded-micon {
        color: {{$th}} /*rgba(90, 30, 30, 0.7)*/ !important;
        }
        .pcoded
            .pcoded-navbar[active-item-theme="theme1"]
            .pcoded-item
            li:hover
            > a:before {
            border-left-color: transparent;
        }
        .pcoded
            .pcoded-navbar[active-item-theme="theme1"]
            .pcoded-item
            > li.active
            > a {
            background: <?php echo $th;?> /*rgba(90, 30, 30, 0.7)*/;
            color: #fff !important;
        }
        .modal{
            background:rgba(0, 0, 0, 0.5);
        }
    </style>
</head>

<body id="body">


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
        <nav class="navbar header-navbar pcoded-header" style="background: {{$tn}};">
            {{-- rgb(90,30,30) --}}
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
                                    <a href="{{route('plan_index')}}">
                                        <i class="ti-user"></i> Upgrade
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
                            {{-- <div class="main-menu-header">
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
                            </div> --}}
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
                                    <span class="pcoded-micon"><i class="ti-mobile" aria-hidden="true"></i><b>D</b></span>
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
                                <a href="{{route('show_all_customers')}}" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="fa fa-users" aria-hidden="true"></i><b>D</b></span>
                                    <span class="pcoded-mtext" data-i18n="nav.dash.main">Customers</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>

                            <li class="">
                                <a href="{{route('show_all_items')}}" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-layout-grid2-alt" aria-hidden="true"></i><b>D</b></span>
                                    <span class="pcoded-mtext" data-i18n="nav.dash.main">Items</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                    
                        </ul>
                        <ul class="pcoded-item pcoded-left-item">
                             <li class="">
                                <a href="{{route('show_transactions')}}" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-layout-grid2-alt" aria-hidden="true"></i><b>D</b></span>
                                    <span class="pcoded-mtext" data-i18n="nav.dash.main">Transactions</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                            <li class="">
                                <a href="{{route('payroll_index')}}" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="fas fa-money-bill-wave"></i><b>D</b></span>
                                    <span class="pcoded-mtext" data-i18n="nav.dash.main">Payrolls</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                            {{-- <li class="">
                                <a href="{{route('show_payment')}}" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="fas fa-dollar-sign"></i><b>D</b></span>
                                    <span class="pcoded-mtext" data-i18n="nav.dash.main">Payment</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li> --}}
                        </ul>
                        <ul class="pcoded-item pcoded-left-item">
                             <li class="">
                                <a href="{{route('store_index')}}" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="fas fa-store-alt" aria-hidden="true"></i><b>D</b></span>
                                    <span class="pcoded-mtext" data-i18n="nav.dash.main">Stores</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                            {{-- <li class="">
                                <a href="{{route('sale_index')}}" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-layout-grid2-alt" aria-hidden="true"></i><b>D</b></span>
                                    <span class="pcoded-mtext" data-i18n="nav.dash.main">Sales</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li> --}}

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

<!-- Morris Chart js -->
<script src="{{asset('assets/js/raphael/raphael.min.js')}}"></script>
<script src="{{asset('assets/js/morris.js/morris.js')}}"></script>

<!-- Custom js -->
{{-- <script src="{{asset('assets/js/morris-custom-chart.js')}}"></script> --}}
<script type="text/javascript" src="{{asset('assets/js/script.js')}}"></script>


{{-- dtat --}}
{{-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}
<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap4.min.js"></script>

@yield('script')

<script>
$(document).ready(function() {
    
    $('#data_table').DataTable();

    var html_code = '';
    var html_code_lga = '';

    $.getJSON('/assets/json/NigeriaState.json', function(data){

   html_code += '<option value="">Select</option>';

   html_code_lga += '<option value="">Select</option>'; 

   $.each(data, function(key, value){
       
    html_code += '<option value="'+key+'" id= "'+value.id+'">'+value.name+'</option>';  
    
    $('#state-select').on('change', function() {
        var id = this.value;
          if (key == id) {   
              $.each(value.locals, function(k, v) { 
                  html_code_lga += '<option value="'+v.name+'" id= "'+v.id+'">'+v.name+'</option>';
                });
                $('#lga-select').html(html_code_lga);

                html_code_lga = "";
          }
    });

    });
    

    $('#state-select').html(html_code);

    
//    console.log(data);

  });

})

$(document).ready(function() {
    $('#table_mm').DataTable();
} );
</script>

</body>

</html>
