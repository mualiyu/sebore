<!DOCTYPE html>
<html lang="en">
@guest
    <?php 
    $cookie_name = 'Ats_Theme';
        if (isset($_COOKIE[$cookie_name])) {
            $theme = json_decode($_COOKIE[$cookie_name], true);
            $tn = $theme['tn'];
            $th = $theme['th'];
            $bth = $theme['bth'];
            $card1 = $theme['card1'];
            $card2 = $theme['card2'];
            $card3 = $theme['card3'];
        }else{
            $tn = 'rgb(90,30,30)';
            $th = 'rgba(109, 41, 41, 0.7)';
            $bth = 'rgba(109, 41, 41, 0.4)';
            $card1 = 'rgb(109, 41, 41)';
            $card2 ='rgb(102, 41, 41)';
            $card3 = 'rgb(100, 41, 41)';
        }
    ?>
@else
<?php
        $org = Auth::user()->organization;
        if ($org->theme) {
            if ($org->theme == 1) {
                $tn = 'rgb(90,30,30)';
                $th = 'rgba(109, 41, 41, 0.7)';
                $bth = 'rgba(109, 41, 41, 0.4)';
                $card1 = 'rgb(109, 41, 41)';
                $card2 ='rgb(102, 41, 41)';
                $card3 = 'rgb(100, 41, 41)';
            }
            elseif ($org->theme == 2) {
                $tn = 'rgb(99,161,0)';
                $th = 'rgba(126, 170, 57, 0.7)';
                $bth = 'rgba(126, 170, 57, 0.4)';
                $card1 = 'rgb(126,170,57)';
                $card2 ='rgb(124,155,76)';
                $card3 = 'rgb(139,170,91)';
            }
            elseif ($org->theme == 3) {
                $tn = 'rgb(0,0,255)';
                $th = 'rgba(75, 75, 241, 0.7)';
                $bth = 'rgba(75, 75, 241, 0.4)';
                $card1 = 'rgb(75, 70, 245)';
                $card2 ='rgb(75, 70, 235)';
                $card3 = 'rgb(75, 70, 225)';
            }else{
                $tn = 'rgb(90,30,30)';
                $th = 'rgba(109, 41, 41, 0.7)';
                $bth = 'rgba(109, 41, 41, 0.4)';
                $card1 = 'rgb(109, 41, 41)';
                $card2 ='rgb(102, 41, 41)';
                $card3 = 'rgb(100, 41, 41)';
            }
        }else {
            $tn = 'rgb(90,30,30)';
            $th = 'rgba(109, 41, 41, 0.7)';
            $bth = 'rgba(109, 41, 41, 0.4)';
            $card1 = 'rgb(109, 41, 41)';
            $card2 = 'rgb(102, 41, 41)';
            $card3 = 'rgb(100, 41, 41)';
        }
    ?>
@endguest
<head>
    <title>{{ config('app.name', 'Ajisaq Ticketing System - ATS') }}</title>

      <!-- Meta -->
      <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Ajisaq ticketing system." />
    <meta name="keywords" content="Ticket, ticketing, system">
    <meta name="author" content="Ajisaq" />
      <!-- Favicon icon -->

      <link rel="icon" href="{{url('assets/images/logo.png" type="image/x-icon')}}">
      <!-- Google font-->     
      <link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">
      <!-- Required Fremwork -->
      <link rel="stylesheet" type="text/css" href="{{url('assets/css/bootstrap/css/bootstrap.min.css')}}">
      <!-- waves.css -->
      <link rel="stylesheet" href="{{url('assets/pages/waves/css/waves.min.css')}}" type="text/css" media="all">
      <!-- themify-icons line icon -->
      <link rel="stylesheet" type="text/css" href="{{url('assets/icon/themify-icons/themify-icons.css')}}">
      <!-- ico font -->
      <link rel="stylesheet" type="text/css" href="{{url('assets/icon/icofont/css/icofont.css')}}">
      <!-- Font Awesome -->
      <link rel="stylesheet" type="text/css" href="{{url('assets/icon/font-awesome/css/font-awesome.min.css')}}">
      <!-- Style.css -->
      <link rel="stylesheet" type="text/css" href="{{url('assets/css/style.css')}}">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />

      @yield('style')

      <style>
        /* line 11306 */
        body[themebg-pattern="theme1"] {
            background-color: /*rgba(99,161,0, 0.7)*/ {{$tn}};
        }
          .btn-primary,
        .sweet-alert button.confirm,
        .wizard > .actions a {
            background-color: {{$th}};
            border-color: {{$th}};
            color: #fff;
            cursor: pointer;
            -webkit-transition: all ease-in 0.3s;
            transition: all ease-in 0.3s;
        }
        .btn-primary:hover,
        .sweet-alert button.confirm:hover,
        .wizard > .actions a:hover {
            background-color: {{$bth}};
            border-color: {{$bth}};
        }
        .btn-primary:active,
        .sweet-alert button.confirm:active,
        .wizard > .actions a:active {
            background-color: {{$bth}} !important;
            border-color: {{$bth}};
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
            background-color: {{$bth}};
        }

        #togglePassword {
            margin-left: -30px;
            cursor: pointer;
        }
        #toggleCPassword {
            margin-left: -30px;
            cursor: pointer;
        }
      </style>
  </head>

  <body themebg-pattern="theme1">
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
  <section class="login-block" style="background: ">
        <!-- Container-fluid starts -->
        @yield('content')
        <!-- end of container-fluid -->
    </section>


<!-- Required Jquery -->
    <script type="text/javascript" src="{{url('assets/js/jquery/jquery.min.js')}}"></script>     
    <script type="text/javascript" src="assets/js/jquery-ui/jquery-ui.min.js "></script>     
    <script type="text/javascript" src="assets/js/popper.js/popper.min.js"></script>     
    <script type="text/javascript" src="assets/js/bootstrap/js/bootstrap.min.js "></script>
<!-- waves js -->
<script src="{{url('assets/pages/waves/js/waves.min.js')}}"></script>
<!-- jquery slimscroll js -->
<script type="text/javascript" src="{{url('assets/js/jquery-slimscroll/jquery.slimscroll.js')}}"></script>
<!-- modernizr js -->
    <script type="{{url('text/javascript" src="assets/js/SmoothScroll.js')}}"></script>     
    <script src="assets/js/jquery.mCustomScrollbar.concat.min.js "></script>
<!-- i18next.min.js -->
<script type="text/javascript" src="bower_components/i18next/js/i18next.min.js"></script>
<script type="text/javascript" src="bower_components/i18next-xhr-backend/js/i18nextXHRBackend.min.js"></script>
<script type="text/javascript" src="bower_components/i18next-browser-languagedetector/js/i18nextBrowserLanguageDetector.min.js"></script>
<script type="text/javascript" src="bower_components/jquery-i18next/js/jquery-i18next.min.js"></script>
<script type="text/javascript" src="{{url('assets/js/common-pages.js')}}"></script>

<script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', function (e) {
        // toggle the type attribute
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        // toggle the eye / eye slash icon
        this.classList.toggle('bi-eye');
    });

    const toggleCPassword = document.querySelector('#toggleCPassword');
    const cPassword = document.querySelector('#cPassword');

    toggleCPassword.addEventListener('click', function (e) {
        // toggle the type attribute
        const type = cPassword.getAttribute('type') === 'password' ? 'text' : 'password';
        cPassword.setAttribute('type', type);
        // toggle the eye / eye slash icon
        this.classList.toggle('bi-eye');
    });

</script>
@yield('script')
</body>

</html>
