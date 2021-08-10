@extends('layouts.auth')


@section('content')
    
<!-- Container-fluid starts -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <form method="POST" action="{{ route('register') }}" class="md-float-material form-material">
                @csrf
                <div class="text-center" style="margin-bottom: 7px;">
                    {{-- <img src="assets/images/logo.png" alt="logo.png"> --}}
                        <a href="{{url('/')}}" style="color: white; font-size:25px; text-decoration:bold;"><img src="assets/images/auth/Logo-small-bottom.png" style="width: 40px; height:40px;" alt="small-logo.png">  <b>ATS</b></a>
                <br>
                    </div>
                <div class="card" style="margin:0 auto; max-width:850px;">
                    <div class="card-block" style="width: 100%">
                        <div class="row m-b-20">
                            <div class="col-md-12">
                                <h3 class="text-center txt-primary">Sign up</h3>
                            </div>
                        </div>
                        <div class="row">&nbsp;&nbsp;&nbsp;<p style="color:rgba(90,30,30,0.7);">Personal Info: </p> </div>
                        <div class="form-group form-primary">
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <span class="form-bar"></span>
                            <label class="float-label">Enter Name</label>
                        </div>
                        <div class="form-group form-primary">
                            <input type="text"  class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <span class="form-bar"></span>
                            <label class="float-label">Your Email Address</label>
                        </div>
                        <div class="form-group form-primary">
                            <input id="phone" type="number"  class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone">
                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <span class="form-bar"></span>
                            <label class="float-label">Phone</label>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group form-primary">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"  name="password" required autocomplete="new-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <span class="form-bar"></span>
                                    <label class="float-label">Password</label>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group form-primary">
                                    <input type="password" name="password_confirmation" class="form-control" required>
                                    <span class="form-bar"></span>
                                    <label class="float-label">Confirm Password</label>
                                </div>
                            </div>
                        </div>

                        <br>
                        <div class="row">&nbsp;&nbsp;&nbsp;<p style="color:rgba(90,30,30,0.7);">Organization Info: </p></div>
                        <div class="form-group form-primary">
                            <input type="text" class="form-control" name="g_name" value="{{ old('g_name') }}" required autocomplete="g_name" autofocus>
                            @error('g_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <span class="form-bar"></span>
                            <label class="float-label">Organization Name</label>
                        </div>
                        <div class="form-group form-primary">
                            <input type="text" class="form-control" name="g_description" value="{{ old('g_description') }}" autocomplete="g_description" >
                            @error('g_description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <span class="form-bar"></span>
                            <label class="float-label">Describe The organization <small>(optional)</small></label>
                        </div>
                        <div class="form-group form-primary">
                            <input id="g_phone" type="number"  class="form-control @error('g_phone') is-invalid @enderror" name="g_phone" value="{{ old('g_phone') }}" autocomplete="g_phone">
                            @error('g_phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <span class="form-bar"></span>
                            <label class="float-label">Organization Phone No:</label>
                        </div>
                        <div class="form-group form-primary">
                            <input id="g_address" type="text"  class="form-control @error('g_address') is-invalid @enderror" name="g_address" value="{{ old('g_address') }}" autocomplete="g_phone">
                            @error('g_address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <span class="form-bar"></span>
                            <label class="float-label">Address:</label>
                        </div>

                        <div class="row m-t-30">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">Sign up now</button>
                            </div>
                        </div>
                        <hr/>
                        <div class="row">
                            <div class="col-md-10">
                                {{-- <p class="text-inverse text-left m-b-0">Thank you.</p> --}}
                                <p class="text-inverse text-left"><a href="{{route('login')}}"><b>Login</b></a></p>
                            </div>
                            <div class="col-md-2">
                                <img src="assets/images/auth/Logo-small-bottom.png" style="width: 50px; height:50px;" alt="small-logo.png">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- end of col-sm-12 -->
    </div>
    <!-- end of row -->
</div>

@endsection
