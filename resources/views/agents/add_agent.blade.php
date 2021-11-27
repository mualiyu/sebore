@extends('layouts.index')

@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="page-header-title">
                    <h5 class="m-b-10">Create Agent</h5>
                </div>
            </div>
            <div class="col-md-4">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{route('home')}}"> <i class="fa fa-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Create Agent</a>
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
                                  <h5>Create Agents</h5>
                                  <!--<span>Add class of <code>.form-control</code> with <code>&lt;input&gt;</code> tag</span>-->
                              </div>
                              <div class="card-block">
                                  <form class="form-material" method="POST" action="{{route('create_agent')}}">
					@csrf
                                      <div class="form-group form-default">
                                          <input type="text" name="name" class="form-control" value="{{old('name')}}" required="">
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
					  <input type="text" name="username" value="{{old('username')}}" class="form-control" required="">
					  <span class="form-bar"></span>
					  <label class="float-label">UserName</label>
					  @error('username')
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
				      <div class="form-group form-default">
                                          <input type="text" name="address" value="{{old('address')}}" class="form-control" required="">
                                          <span class="form-bar"></span>
                                          <label class="float-label">Address</label>
					  @error('address')
                                                <Span style="color: red;">{{$message}}</Span>
                                          @enderror
                                      </div>
				      <div class="row">
                          <div class="col-sm-4">
                              <div class="form-group form-default">
                                  <select name="country" class="form-control" required id="country-select">
                                      <option value="nigeria">Nigeria</option>
                                  </select>
                                {{-- <input type="text" name="country" value="{{old('country') ?? 'Nigeria'}}" class="form-control" required> --}}
                                <span class="form-bar"></span>
                                <label class="float-label">Country:</label>
                                @error('country')
                                      <Span style="color: red;">{{$message}}</Span>
                                @enderror
                              </div>
                          </div>
                          <div class="col-sm-4">
                              <div class="form-group form-default">
                                  <select name="state" class="form-control" id="state-select"></select>
                                {{-- <input type="text" name="state" class="form-control" value="{{old('state')}}" required> --}}
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
                                      {{-- <input type="text" name="lga" class="form-control" value="{{old('lga')}}" required> --}}
                                      <span class="form-bar"></span>
                                      <label class="float-label">LGA:</label>
                                      @error('lga')
                                                        <Span style="color: red;">{{$message}}</Span>
                                                  @enderror
                                      </div>
                            </div>
				      </div>

				       <div class="row">
                           <div class="col-sm-2">
                            <div class="form-group form-default">
                                <input type="button" class="btn btn-primary bg-light" value="Use Map" id="" style="width: 100%; color:black;">
                            </div>
                           </div>
					<div class="col-sm-5">
						      <div class="form-group form-default">
							  <input type="text" name="gps" class="form-control" value="{{old('gps')}}" required>
							  <span class="form-bar"></span>
							  <label class="float-label">Location <small>(Gps)</small></label>
							  @error('gps')
                                                <Span style="color: red;">{{$message}}</Span>
                                          @enderror
						      </div>
					</div>
					<div class="col-sm-5">
					    <div class="form-group form-default">
						<select type="text" name="role" class="form-control" required="">
                            <?php $roles = \App\Models\AgentRole::where('org_id', '=', Auth::user()->organization_id)->get(); ?>
                            @foreach ($roles as $r)
                            <option value="{{$r->id}}">{{$r->name}}</option>
                            @endforeach
							{{-- <option value="agent">Agent</option>
							<option value="mareter">Marketer</option>
							<option value="transporter">Transpoter</option>
							<option value="aggregator">Aggregator</option> --}}
						</select>
						<span class="form-bar"></span>
						<label class="float-label">Role</label>
						@error('role')
                                                <Span style="color: red;">{{$message}}</Span>
                                          @enderror
					    </div>
					</div>
				      </div>

				      <div class="row">
					<div class="col-sm-6">
						      <div class="form-group form-default">
							  <input type="password" name="password" class="form-control" required>
							  <span class="form-bar"></span>
							  <label class="float-label">Password</label>
							  @error('password')
                                                <Span style="color: red;">{{$message}}</Span>
                                          @enderror
						      </div>
					</div>
					<div class="col-sm-6">
					    <div class="form-group form-default">
					  	<input type="password" name="password_confirmation" class="form-control" required>
					  	<span class="form-bar"></span>
					  	<label class="float-label">Confirm Password</label>
					    </div>
					</div>
				      </div>


                                      <div class="form-group form-default">
                                          <input type="submit" class="btn btn-primary" value="Register Agent" id="">
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

@section('script')
@endsection
