@extends('layouts.index')

{{-- @section('style')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
@endsection --}}

@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="page-header-title">
                    <h5 class="m-b-10">Create Store</h5>
                </div>
            </div>
            <div class="col-md-4">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{route('home')}}"> <i class="fa fa-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Create Stores</a>
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
		    {{-- <a href="#" style="right:0;" class="btn btn-primary">Add New Category</a> --}}
		    {{-- <button type="button" class="btn btn-primary" onclick="document.getElementById('modal').style.display = 'block';"><i class="">+</i> Add New Category</button> --}}
        <br>
                <div class="row">
                    <div class="col-sm-12">
			            <div class="card">
                              <div class="card-header">
                                  <h5>Create Store</h5>
                                  <!--<span>Add class of <code>.form-control</code> with <code>&lt;input&gt;</code> tag</span>-->
                              </div>
                              <div class="card-block">
                                  <form class="form-material" method="POST" action="{{route('create_store')}}">
					                @csrf
					                {{-- <input type="hidden" name="device" value="{{$device->id}}"> --}}
                                      <div class="form-group form-default">
                                          <input type="text" name="name" value="{{old('name')}}" class="form-control" required>
                                          <span class="form-bar"></span>
                                          <label class="float-label">Name</label>
                                          @error('name')
                                                <Span style="color: red;">{{$message}}</Span>
                                          @enderror
                                      </div>
                                      <div class="form-group form-default">
                                          <input type="text" name="location" value="{{old('location')}}" class="form-control">
                                          <span class="form-bar"></span>
                                          <label class="float-label">Location</label>
                                          @error('location')
                                                <Span style="color: red;">{{$message}}</Span>
                                          @enderror
                                      </div>
				
                                      <div class="form-group form-default">
                                          <input type="submit" class="btn btn-primary" value="Create Store" id="">
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
