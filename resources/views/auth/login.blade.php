@extends('layouts.auth')


@section('content')
    
        <!-- Container-fluid starts -->
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Authentication card start -->
                    
                        <div class="md-float-material form-material" >
                            <div class="text-center">
                                <a href="{{url('/')}}" style="color: white; font-size:25px; text-decoration:bold;"><img src="assets/images/auth/Logo-small-bottom.png" style="width: 40px; height:40px;" alt="small-logo.png">  <b>ATS</b></a>
                                
                            </div>
                            <div class="auth-box card">
                                <div class="card-block">
                                    <div class="row m-b-20">
                                        <div class="col-md-12">
                                            <h3 class="text-center">Sign In</h3>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="card w-100 py-1" style="border: black 1px ">
                                            <div class="card-block my-0 py-0"  id="cc">
                                                <label for="admin" style="border: #d7d7d7 1px solid; width:100%; padding:3px;">
                                                    <input type="radio" class="type" name="type" id="admin" value="admin" checked>
                                                    Login As Admin
                                                </label><br>
                                                <label for="agent" style="border: #d7d7d7 1px solid; width:100%; padding:3px;">
                                                    <input type="radio" class="type" name="type" id="agent" value="agent">
                                                    Login As Agent
                                                </label>
                                            </div>  
                                        </div>
                                    </div>

                                    {{-- Admin login Start --}}
                                    <form method="POST" action="{{ route('login') }}" id="admin_l">
                                    @csrf
                                    <div class="form-group form-primary">
                                        <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <span class="form-bar"></span>
                                        <label class="float-label">Your Email Address</label>
                                    </div>
                                    <div class="form-group form-primary">
                                        <input type="password"  class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                         @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <span class="form-bar"></span>
                                        <label class="float-label">Password</label>
                                    </div>
                                    <div class="row m-t-25 text-left">
                                        <div class="col-12">
                                            <div class="checkbox-fade fade-in-primary d-">
                                                <label>
                                                    <input type="checkbox"  name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                    <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                    <span class="text-inverse">Remember me</span>
                                                </label>
                                            </div>
                                            <div class="forgot-phone text-right f-right">
                                                @if (Route::has('password.request'))
                                                    <a class="text-right f-w-600" href="{{ route('password.request') }}">
                                                        {{ __('Forgot Your Password?') }}
                                                    </a>
                                                    {{-- <a href="#" class="text-right f-w-600"> Forgot Password?</a> --}}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row m-t-30">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20">Sign in</button>
                                        </div>
                                    </div>
                                    </form>
                                    {{-- Admin login ends --}}


                                    {{-- Agent login start --}}
                                     <form method="POST" action="{{ route('agent_dashboard_login') }}" id="agent_l" style="display: none;">
                                    @csrf 
                                    <div class="form-group form-primary">
                                        <input type="text" class="form-control @error('user') is-invalid @enderror" name="user" value="{{ old('user') }}" required autocomplete="phone">
                                        @error('user')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <span class="form-bar"></span>
                                        <label class="float-label">Your Phone Number</label>
                                    </div>
                                    <div class="form-group form-primary">
                                        <input type="password"  class="form-control @error('pin') is-invalid @enderror" name="pin" required>
                                         @error('pin')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <span class="form-bar"></span>
                                        <label class="float-label">Pin</label>
                                    </div>
                                    <div class="row m-t-25 text-left">
                                        <div class="col-12">
                                            {{-- <div class="checkbox-fade fade-in-primary d-">
                                                <label>
                                                    <input type="checkbox"  name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                    <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                    <span class="text-inverse">Remember me</span>
                                                </label>
                                            </div> --}}
                                            <div class="forgot-phone text-right f-right">
                                                @if (Route::has('password.request'))
                                                    <a class="text-right f-w-600" href="{{ route('password.request') }}">
                                                        {{ __('Forgot Your Pin?') }}
                                                    </a>
                                                    {{-- <a href="#" class="text-right f-w-600"> Forgot Password?</a> --}}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row m-t-30">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20">Sign in</button>
                                        </div>
                                    </div>
                                    </form>
                                    {{-- Agent login end --}}
                                    <hr/>
                                    <div class="row">
                                        <div class="col-md-10">
                                            <p class="text-inverse text-left"><a href="{{route('register')}}"><b>Register</b></a></p>
                                        </div>
                                        <div class="col-md-2">
                                            <img src="assets/images/auth/Logo-small-bottom.png" style="width: 50px; height:50px;" alt="small-logo.png">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end of form -->
                </div>
                <!-- end of col-sm-12 -->
            </div>
            <!-- end of row -->
        </div>
@endsection

@section('script')
<script>
    $(document).ready(function () {
             
        $("input[name='type']").on('click', function() {
            var type = $("input[name='type']:checked").val();

            if (type == 'admin') {
                $('#admin_l').css('display', 'block');
                $('#agent_l').css('display', 'none');
            }

            if (type == 'agent') {
                $('#agent_l').css('display', 'block');
                $('#admin_l').css('display', 'none');
            }
        });
        
    });
</script>
@endsection
