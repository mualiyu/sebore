@extends('layouts.index')

@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="page-header-title">
                    <h5 class="m-b-10">Create Farmers<!--Customer--> {{ $agent != null ? ' - '.$agent->name : ' '}} </h5>
                </div>
            </div>
            <div class="col-md-4">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{route('home')}}"> <i class="fa fa-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Create Farmers</a>
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
                                  <h5>Create Farmers</h5>
                                  <!--<span>Add class of <code>.form-control</code> with <code>&lt;input&gt;</code> tag</span>-->
                              </div>
                              <div class="card-block">
                                  <form class="form-material" method="POST" action="{{route('create_customer')}}">
					@csrf
					
                                      <div class="form-group form-default">
                                          <input type="text" name="name" value="{{old('name')}}" class="form-control" required="">
                                          <span class="form-bar"></span>
                                          <label class="float-label">Name</label>
                                          @error('name')
                                                <Span style="color: red;">{{$message}}</Span>
                                          @enderror
                                      </div>
                                      <div class="form-group form-default">
                                          <input type="email" name="email" value="{{old('email')}}" class="form-control" required="">
                                          <span class="form-bar"></span>
                                          <label class="float-label">Email (exa@gmail.com)</label>
                                          @error('email')
                                                <Span style="color: red;">{{$message}}</Span>
                                          @enderror
                                      </div>
				                    <div class="form-group form-default">
                                          <input type="number" name="phone" value="{{old('phone')}}" class="form-control" required="">
                                          <span class="form-bar"></span>
                                          <label class="float-label">Phone</label>
                                          @error('phone')
                                                <Span style="color: red;">{{$message}}</Span>
                                          @enderror
                                      </div>
                                      <div class="row">
                                          <div class="col-sm-8">
                                            <div class="form-group form-default">
                                                <input type="text" name="address" value="{{old('address')}}" class="form-control" required="">
                                                <span class="form-bar"></span>
                                                <label class="float-label">Address</label>
                                                @error('address')
                                                      <Span style="color: red;">{{$message}}</Span>
                                                @enderror
                                            </div>
                                          </div>
                                          <div class="col-sm-4">
                                              <?php $agents = \App\Models\Agent::where('org_id', '=', Auth::user()->organization_id)->get(); ?>

                                              <div class="form-group">
						                          <select name="agent" class="form-control"  required>
                                                      @if ($agent != null)
                                                      <option value="{{$agent->id}}">{{$agent->name}}</option>
                                                      @endif
						                        	 @foreach ($agents as $a)    
						                        	 <option value="{{$a->id}}">{{$a->name}}</option>
						                        	 @endforeach
						                          </select>
						                          <span class="form-bar"></span>
						                          <label class="float-label">Agent</label>
                                                  @error('agent')
                                                          <Span style="color: red;">{{$message}}</Span>
                                                    @enderror
						                      </div>
                                            {{-- <input type="hidden" name="agent" value="{{$agent->id}}"> --}}
                                          </div>
                                      </div>
				      <div class="row">
					<div class="col-sm-3">
						      <div class="form-group form-default">
							  <input type="text" name="lga" value="{{old('lga')}}" class="form-control" required>
							  <span class="form-bar"></span>
							  <label class="float-label">LGA:</label>
                              @error('lga')
                                                <Span style="color: red;">{{$message}}</Span>
                                          @enderror
						      </div>
					</div>
					<div class="col-sm-3">
					    <div class="form-group form-default">
					  	<input type="text" name="state" value="{{old('state')}}" class="form-control" required>
					  	<span class="form-bar"></span>
					  	<label class="float-label">State:</label>
                          @error('state')
                                                <Span style="color: red;">{{$message}}</Span>
                                          @enderror
					    </div>
					</div>
					<div class="col-sm-3">
					    <div class="form-group form-default">
					  	<input type="text" name="country" value="{{old('country')}}" class="form-control" required>
					  	<span class="form-bar"></span>
					  	<label class="float-label">Country:</label>
                          @error('country')
                                                <Span style="color: red;">{{$message}}</Span>
                                          @enderror
					    </div>
					</div>
					<div class="col-sm-3">
						<div class="form-group form-default">
						    <input type="text" name="gps" value="{{old('gps')}}" class="form-control" required>
						    <span class="form-bar"></span>
						    <label class="float-label">Location <small>(Gps)</small></label>
                            @error('gps')
                                                <Span style="color: red;">{{$message}}</Span>
                                          @enderror
						</div>
					</div>
				      </div>

				      

                                      <div class="form-group form-default">
                                          <input type="submit" class="btn btn-primary" value="Register" id="">
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
