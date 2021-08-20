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
                                <p class="text-primary m-0 font-weight-bold">{{Auth::user()->organization()->get()[0]->name}} > {{Auth::user()->name}} > {{$agent->name}}</p>
                            </div>
                         </div>
                </div>

                <div class="row" id="e" style="display: none;">
				<div class="card shadow " style="width: 100%;">
                    <div class="card-body">
                                        <div class="row">
                                          <div class="col-sm-12">
                                            <a class="btn btn-primary" onclick="edit()" style="color: white;">close</a>
                                          </div>
                                        </div><br><br>
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
								<option value="{{$agent->role->name ?? ''}}">{{$agent->role->name ?? ''}}</option>
                <?php $roles = \App\Models\AgentRole::all(); ?>
                    @foreach ($roles as $r)
                    <option value="{{$r->id}}">{{$r->name}}</option>
                    @endforeach
								{{-- <option value="agent">Agent</option>
							    <option value="mareter">Marketer</option>
							    <option value="transporter">Transpoter</option>
							    <option value="aggregator">Aggregator</option> --}}
							</select>
						</div>
                                                </div>
                                            </div>
                                            <div class="form-group"><button class="btn btn-primary btn-sm" type="submit">Save Settings</button></div>
                                        </form>
                                    </div>                    
                </div>
				</div>


                <div class="row" id="p">
                         <div class="card shadow" style="width:100%;">
                          <div class="card-body">
                              <div class="row">
                                <div class="col-sm-12">
                                  <a class="btn btn-primary" onclick="edit()" style="color: white;">Edit</a>
                                </div>
                              </div>
                              <br>
                              <br>
                            <div class="row">
                              <div class="col-sm-3">
                                <h6 class="mb-0" style="float: right;">Full Name</h6>
                              </div>
                              <div class="col-sm-9 text-secondary">
                                {{$agent->name}}
                              </div>
                            </div>
                            {{-- <hr> --}}
                            <div class="row">
                              <div class="col-sm-3">
                                <h6 class="mb-0" style="float: right;">Email</h6>
                              </div>
                              <div class="col-sm-9 text-secondary">
                                {{$agent->email}}
                              </div>
                            </div>
                            {{-- <hr> --}}
                            <div class="row">
                              <div class="col-sm-3">
                                <h6 class="mb-0" style="float: right;">Username</h6>
                              </div>
                              <div class="col-sm-9 text-secondary">
                                {{$agent->username}}
                              </div>
                            </div>
                            {{-- <hr> --}}
                            <div class="row">
                              <div class="col-sm-3">
                                <h6 class="mb-0" style="float: right;">Address</h6>
                              </div>
                              <div class="col-sm-9 text-secondary">
                                {{$agent->address}}
                              </div>
                            </div>
                            {{-- <hr> --}}
                            <div class="row">
                              <div class="col-sm-3">
                                <h6 class="mb-0" style="float: right;">Local Goverment Area</h6>
                              </div>
                              <div class="col-sm-9 text-secondary">
                                {{$agent->lga}}
                              </div>
                            </div>
                            {{-- <hr> --}}
                            <div class="row">
                              <div class="col-sm-3">
                                <h6 class="mb-0" style="float: right;">State</h6>
                              </div>
                              <div class="col-sm-9 text-secondary">
                                {{$agent->state}}
                              </div>
                            </div>
                            {{-- <hr> --}}
                            <div class="row">
                              <div class="col-sm-3">
                                <h6 class="mb-0" style="float: right;">Country</h6>
                              </div>
                              <div class="col-sm-9 text-secondary">
                                {{$agent->country}}
                              </div>
                            </div>
                            {{-- <hr> --}}
                            <div class="row">
                              <div class="col-sm-3">
                                <h6 class="mb-0" style="float: right;">Role</h6>
                              </div>
                              <div class="col-sm-9 text-secondary">
                                {{$agent->role->name}}
                              </div>
                            </div>
                            {{-- <hr> --}}

                          </div>
                        </div>
                </div>

                <div class="row" >
                    <?php $customers = \App\Models\Customer::where('agent_id', '=', $agent->id)->get(); ?>
                    <div class="card" style="width: 100%;">
                        <div class="card-header">
                            <h5>Customer's</h5>
                            <div class="card-header-right">
                                <ul class="list-unstyled card-option">
                                    <li><i class="fa fa fa-wrench open-card-option"></i></li>
                                    <li><i class="fa fa-window-maximize full-card"></i></li>
                                    <li><i class="fa fa-minus minimize-card"></i></li>
                                    <li><i class="fa fa-refresh reload-card"></i></li>
                                    <li><i class="fa fa-trash close-card"></i></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-block table-border-style">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Email</th>
					    <th>Phone</th>
					    <th>Address</th>
					    <th>LGA</th>
					    <th>Sate</th>
					    <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
					    <?php $i = count($customers); ?>
				        @foreach ($customers as $c)
					<tr>
						<th scope="row">{{$i}}</th>
						<td>{{$c->name}}</td>
						<td>{{$c->email}}</td>
						<td>{{$c->phone}}</td>
						<td>{{$c->address}}</td>
						<td>{{$c->lga}}</td>
						<td>{{$c->state}}</td>
						<td>
                            <form method="POST" id="delete-form[{{$i}}]" action="{{route('delete_customer',['id'=>$c->id])}}">
                                <a href="{{route('show_edit_customer', ['a_id'=>$agent->id, 'c_id'=>$c->id])}}" class="btn btn-primary">Edit</a>
                                @csrf 
                                <a  onclick="
                                    if(confirm('Are you sure You want to Delete this Customer -( {{$c->name}} )? ')){
                                        document.getElementById('delete-form[{{$i}}]').submit();
                                    }
                                        event.preventDefault();"
                                    class="btn btn-warning" 
                                    style="color: black">
                                    Delete
                                </a>
                            </form>
						</td>
						<?php $i--?>
					</tr>
					@endforeach
                                    </tbody>
                                </table>
                            </div>
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

@section('script')
    <script>
        let e = document.getElementById('e');
        let p = document.getElementById('p');
        function edit() {
        // console.log(e);
            if (e.style.display == "none") {
                e.style.display = "block";
                p.style.display = 'none';
            }else{
                e.style.display = "none";
                p.style.display = 'block';
            }
        }
    </script>
@endsection
