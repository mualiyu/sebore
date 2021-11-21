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
                                <p class="text-primary m-0 font-weight-bold">{{Auth::user()->organization()->get()[0]->name}} > {{Auth::user()->name}} > {{$device->name}}</p>
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
                                                {{-- <div class="col">
                                                    <div class="form-group"><label for="last_name"><strong>Device Id</strong></label>
							<input class="form-control" value="{{$device->device_id}}" type="text" placeholder="type" name="type">
						</div>
                                                </div> --}}
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
                                <h6 class="mb-0" style="float: right;">Device Name</h6>
                              </div>
                              <div class="col-sm-9 text-secondary">
                                {{$device->name}}
                              </div>
                            </div>
                            {{-- <hr> --}}
                            <div class="row">
                              <div class="col-sm-3">
                                <h6 class="mb-0" style="float: right;">Location</h6>
                              </div>
                              <div class="col-sm-9 text-secondary">
                                {{$device->location}}
                              </div>
                            </div>
                            {{-- <hr> --}}
                            <div class="row">
                              <div class="col-sm-3">
                                <h6 class="mb-0" style="float: right;">Type</h6>
                              </div>
                              <div class="col-sm-9 text-secondary">
                                {{$device->type}}
                              </div>
                            </div>
                            {{-- <hr> --}}
                            <div class="row">
                              <div class="col-sm-3">
                                <h6 class="mb-0" style="float: right;">Device Id</h6>
                              </div>
                              <div class="col-sm-9 text-secondary">
                                {{$device->device_id}}
                              </div>
                            </div>
                            <hr>
                          </div>
                        </div>
                </div>


                <div class="row">

                    <?php $items = \App\Models\Item::where('device_id', '=', $device->id)->get(); ?>
                    <div class="card" style="width: 100%;">
                        <div class="card-header">
                            <h5>Item's</h5>
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
                                            <th>Category</th>
					    <th>Measure</th>
					    <th>Unit</th>
					    <th>Code</th>
					    <th>With Quantity?</th>
					    <th>With Payer Name?</th>
					    <th>Code</th>
                                        </tr>
                                    </thead>
                                    <tbody>
					    <?php $i_i = count($items); ?>
				        @foreach ($items as $i)
					<?php  $cat = \App\Models\Category::find($i->item_cart->category_id); ?>
					<tr>
						<th scope="row">{{$i_i}}</th>
						<td>{{$i->item_cart->name}}</td>
						<td>{{$cat->name}}</td>
						<td>{{$i->item_cart->measure/100}}</td>
						<td>{{$i->item_cart->unit}}</td>
						<td>{{$i->item_cart->code}}</td>
						<td>{{$i->item_cart->with_q ? 'Yes':'No'}}</td>
						<td>{{$i->item_cart->with_p ? 'Yes':'No'}}</td>
						<td>
                            <form method="POST" id="delete-form[{{$i_i}}]" action="{{route('delete_item',['id'=>$i->id])}}">
                                <a href="{{route('show_edit_item_cart', ['id'=>$i->item_cart->id])}}" class="btn btn-primary">Edit</a>
                                @csrf 
                                <a  onclick="
                                    if(confirm('Are you sure You want to remove this Item -({{$i->item_cart->name}}) form {{$device->name}}? ')){
                                        document.getElementById('delete-form[{{$i_i}}]').submit();
                                    }
                                        event.preventDefault();"
                                    class="btn btn-warning" 
                                    style="color: black">
                                    Remove
                                </a>
                            </form>
						</td>
						<?php $i_i--?>
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
