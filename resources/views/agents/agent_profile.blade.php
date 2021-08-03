@extends('layouts.index')

@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="page-header-title">
                    <h5 class="m-b-10">Agent Profile</h5>
                </div>
            </div>
            <div class="col-md-4">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{route('home')}}"> <i class="fa fa-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#">Agent Profile</a>
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
			<div class="col-md-12">
				<div class="row">
				<div class="card shadow " style="width: 100%;">
                                    <div class="card-header ">
                                        <p class="text-primary m-0 font-weight-bold">Agent Settings</p>
                                    </div>
                                    <div class="card-body">
                                        <form  method="POST" action="{{route('update_agent', ['id'=>$agent->id])}}">
						@csrf
                                            <div class="form-row">
                                                <div class="col">
                                                    <div class="form-group"><label for="username"><strong>Name</strong></label><input class="form-control" type="text" placeholder="Name" name="name" value="{{$agent->name}}"></div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group"><label for="email"><strong>Email Address</strong></label><input class="form-control" type="email" placeholder="user@example.com" value="{{$agent->email}}" name="email"></div>
                                                </div>
                                            </div>
					    <div class="form-row">
                                                <div class="col">
                                                    <div class="form-group"><label for="first_name"><strong>Username</strong></label><input value="{{$agent->username}}" class="form-control" type="text" placeholder="Username" name="username"></div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group"><label for="last_name"><strong>Address</strong></label>
							<input class="form-control" value="{{$agent->address}}" type="text" placeholder="Address" name="address">
						</div>
                                                </div>
                                            </div>
					    <div class="form-row">
                                                <div class="col">
                                                    <div class="form-group"><label for="first_name"><strong>LGA</strong></label><input value="{{$agent->lga}}" class="form-control" type="text" placeholder="lga" name="lga"></div>
                                                </div>
						<div class="col">
                                                    <div class="form-group"><label for="first_name"><strong>State</strong></label><input value="{{$agent->state}}" class="form-control" type="text" placeholder="state" name="state"></div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group"><label for="last_name"><strong>Country</strong></label>
							<input class="form-control" value="{{$agent->country}}" type="text" placeholder="Nigeria" name="country">
						</div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col">
                                                    <div class="form-group"><label for="first_name"><strong>Phone</strong></label><input value="{{$agent->phone}}" class="form-control" type="number" placeholder="phone" name="phone"></div>
                                                </div>
						<div class="col">
                                                    <div class="form-group"><label for="first_name"><strong>Gps</strong></label><input value="{{$agent->gps}}" class="form-control" type="text" placeholder="Location (gps)" name="gps"></div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group"><label for="last_name"><strong>Role</strong></label>
							{{-- <input class="form-control" type="text" placeholder="Doe" name=""> --}}
							<select name="role" id="" class="form-control">
								<option value="{{$agent->role ?? ''}}">{{$agent->role ?? ''}}</option>
								<option value="agent">Agent</option>
							    <option value="mareter">Marketer</option>
							    <option value="transporter">Transpoter</option>
							    <option value="aggregator">Aggregator</option>
							</select>
						</div>
                                                </div>
                                            </div>
                                            <div class="form-group"><button class="btn btn-primary btn-sm" type="submit">Save Settings</button></div>
                                        </form>
                                    </div>
                                </div>
				</div>
			</div>
		</div>

            </div>
        </div>
    </div>
</div>
@endsection
