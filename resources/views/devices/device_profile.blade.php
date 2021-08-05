@extends('layouts.index')

@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="page-header-title">
                    <h5 class="m-b-10">{{$device->name}} - Info</h5>
                </div>
            </div>
            <div class="col-md-4">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{route('home')}}"> <i class="fa fa-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#">Device</a>
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
                                        <p class="text-primary m-0 font-weight-bold">Device Settings</p>
                                    </div>
                                    <div class="card-body">
                                        <form  method="POST" action="{{route('update_device', ['id'=>$device->id])}}">
						@csrf
                                            <div class="form-row">
                                                <div class="col">
                                                    <div class="form-group"><label for="username"><strong>Name</strong></label>
							<input class="form-control" type="text" placeholder="Name" name="name" value="{{$device->name}}"></div>
                                                </div>
					    </div>
					    <div class="form-row">
                                                <div class="col">
                                                    <div class="form-group"><label for="first_name"><strong>location</strong></label>
							<input value="{{$device->location}}" class="form-control" type="text" placeholder='location' name="location"></div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group"><label for="last_name"><strong>type</strong></label>
							<input class="form-control" value="{{$device->type}}" type="text" placeholder="type" name="type">
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
