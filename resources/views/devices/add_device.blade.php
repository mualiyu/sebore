@extends('layouts.index')

@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="page-header-title">
                    <h5 class="m-b-10">Create device</h5>
                </div>
            </div>
            <div class="col-md-4">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{route('home')}}"> <i class="fa fa-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Create Device</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Page-header end -->

<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
		    @include('layouts.flash')
                <div class="row">
                    <div class="col-sm-12">
			            <div class="card">
                              <div class="card-header">
                                  <h5>Create Device</h5>
                                  <!--<span>Add class of <code>.form-control</code> with <code>&lt;input&gt;</code> tag</span>-->
                              </div>
                              <div class="card-block">
                                  <form class="form-material" method="POST" action="{{route('create_device')}}">
					                @csrf
                                      <div class="form-group form-default">
                                          <input type="text" name="name" value="{{old('name')}}" class="form-control" required="">
                                          <span class="form-bar"></span>
                                          <label class="float-label">Name</label>
                                          @error('name')
                                                <Span style="color: red;">{{$message}}</Span>
                                          @enderror
                                      </div>
                                      {{-- <div class="row">
                                            <div class="col-sm-2">
                                             <div class="form-group form-default">
                                                 <input type="button" class="btn btn-primary bg-light" value="Use Map" id="" style="color:black;width: 100%;">
                                             </div>
                                            </div>
                                            <div class="col-sm-10">
                                              <div class="form-group form-default">
                                                  <input type="text" name="location" value="{{old('location')}}" class="form-control" required="">
                                                  <span class="form-bar"></span>
                                                  <label class="float-label">Location (gps eg, 5.9999, 6.00092)</label>
                                                  @error('location')
                                                        <Span style="color: red;">{{$message}}</Span>
                                                  @enderror
                                              </div>
                                            </div>
                                      </div> --}}
				                      <div class="form-group form-default">
                                          <input type="text" name="type" value="{{old('type')}}" class="form-control" required="">
                                          <span class="form-bar"></span>
                                          <label class="float-label">Type</label>
                                          @error('type')
                                                <Span style="color: red;">{{$message}}</Span>
                                          @enderror
                                      </div>

                                      <div class="row">
                                          <div class="col-sm-4">
                                              <div class="form-group form-default">
                                                  <select name="state" class="form-control" id="state-select"></select>
                                                {{-- <input type="text" name="state" value="{{old('state')}}" class="form-control" required> --}}
                                                <span class="form-bar"></span>
                                                <label class="float-label">State:</label>
                                                @error('state')
                                                                      <Span style="color: red;">{{$message}}</Span>
                                                                @enderror
                                              </div>
                                            </div>
                                            <div class="col-sm-4">
                                                      <div class="form-group form-default">
                                                          <select name="lga" class="form-control" id="lga-select"></select>
                                                      {{-- <input type="text" name="lga" value="{{old('lga')}}" class="form-control" required> --}}
                                                      <span class="form-bar"></span>
                                                      <label class="float-label">LGA:</label>
                                                      @error('lga')
                                                                        <Span style="color: red;">{{$message}}</Span>
                                                                  @enderror
                                                      </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group form-default">
                                                          <input type="text" name="community" value="{{old('community')}}" class="form-control" required>
                                                          <span class="form-bar"></span>
                                                          <label class="float-label">Community:</label>
                                                          @error('community')
                                                                                <Span style="color: red;">{{$message}}</Span>
                                                                          @enderror
                                                        </div>
                                                    </div>
				                        </div>

                                      <div class="form-group form-default">
                                          <input type="submit" class="btn btn-primary" value="Register Device" id="">
                                      </div>
                                  </form>
                              </div>
                            </div>
		            </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
