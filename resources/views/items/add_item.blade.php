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
                    <h5 class="m-b-10">Add Item to {{$device != null ? ' - '. $device->name : ''}}</h5>
                </div>
            </div>
            <div class="col-md-4">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{route('home')}}"> <i class="fa fa-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Create Item</a>
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
                                  <h5>Create Item</h5>
                                  <!--<span>Add class of <code>.form-control</code> with <code>&lt;input&gt;</code> tag</span>-->
                              </div>
                              <div class="card-block">
                                  <form class="form-material" method="POST" action="{{route('create_item')}}">
					@csrf
					{{-- <input type="hidden" name="device" value="{{$device->id}}"> --}}
                                      <div class="form-group form-default">
                                          <input type="text" name="name" value="{{old('name')}}" class="form-control" required="">
                                          <span class="form-bar"></span>
                                          <label class="float-label">Name</label>
                                          @error('name')
                                                <Span style="color: red;">{{$message}}</Span>
                                          @enderror
                                      </div>
                                      <div class="form-group form-default">
                                          <input type="number" name="measure" value="{{old('measure')}}" class="form-control" required="">
                                          <span class="form-bar"></span>
                                          <label class="float-label">Measure</label>
                                          @error('measure')
                                                <Span style="color: red;">{{$message}}</Span>
                                          @enderror
                                      </div>
				      <div class="form-group form-default">
                                          <input type="text" name="unit" value="{{old('unit')}}" class="form-control" required="">
                                          <span class="form-bar"></span>
                                          <label class="float-label">Unit <span style="font-size: 10px;">Ex (NGN, Kg, Meters, USD)</span></label>
                                        @error('unit')
                                                <Span style="color: red;">{{$message}}</Span>
                                          @enderror
                                        </div>
				      <div class="form-group form-default">
                                          <input type="text" name="code" value="{{old('code')}}" class="form-control" required="">
                                          <span class="form-bar"></span>
                                          <label class="float-label">code</label>
                                          @error('code')
                                                <Span style="color: red;">{{$message}}</Span>
                                          @enderror
                                      </div>
				      <div class="row">
					<div class="col-sm-6">
                        <div class="form-group form-default">
                            <select name="with_q" class="form-control" required>
                                <option value="0" disabled>select</option>
								<option value="1">Yes</option>
								<option value="0">No</option>
							</select>             
              {{-- 
                <input class="form-check-input" type="radio" name="with_q" id="flexRadioDefault1">
                <label class="form-check-label" for="flexRadioDefault1">
                  Yes
                </label>
                <br>
                <input class="form-check-input" type="radio" name="with_q" id="flexRadioDefault2" >
                <label class="form-check-label" for="flexRadioDefault2">
                  No
                </label> --}}
							  <span class="form-bar"></span>
                <label class="float-label">With Quantity?</label>
                              @error('with_q')
                                <Span style="color: red;">{{$message}}</Span>
                              @enderror
						      </div>
					</div>
					<div class="col-sm-6">
						<div class="form-group form-default">
						  <select name="with_p" class="form-control" required>
							  <option value="0" disabled>select</option>
							<option value="1">Yes</option>
							<option value="0">No</option>
						  </select>
						  <span class="form-bar"></span>
						  <label class="float-label">With Payer Name?</label>
                          @error('with_p')
                                                <Span style="color: red;">{{$message}}</Span>
                                          @enderror
						</div>
					</div>
                      </div>
                      <div class="row">
					<?php $categories = \App\Models\Category::where('org_id', '=', Auth::user()->organization_id)->get(); ?>
					<div class="col-sm-6">
						<div class="form-group form-default">
						  <select name="category" class="form-control" required>
							 <option value="0" disabled>select</option>
							 @foreach ($categories as $c)    
							 <option value="{{$c->id}}">{{$c->name}}</option>
							 @endforeach
						  </select>
						  <span class="form-bar"></span>
						  <label class="float-label">Category</label>
                          @error('category')
                                                <Span style="color: red;">{{$message}}</Span>
                                          @enderror
						</div>
					</div>
                    <div class="col-sm-2">
						<div class="form-group form-default">
						  <button type="button" class="btn btn-primary" onclick="document.getElementById('modal').style.display = 'block';"><i class="">+</i> Add New Category</button>
						</div>
					</div>

          <div class="col-sm-4">
            <?php $devices = \App\Models\Device::where('org_id', '=', Auth::user()->organization_id)->get(); ?>
						<div class="form-group form-default">
						  <select name="device" class="form-control" required>
                @if ($device != null)
                <option value="{{$device->id}}">{{$device->name}}</option>
                @endif
							 @foreach ($devices as $d)    
							 <option value="{{$d->id}}">{{$d->name}}</option>
							 @endforeach
						  </select>
						  <span class="form-bar"></span>
						  <label class="float-label">Device</label>
                          @error('device')
                                <Span style="color: red;">{{$message}}</Span>
                          @enderror
						</div>
					</div>
				      </div>

				      

                                      <div class="form-group form-default">
                                          <input type="submit" class="btn btn-primary" value="Add Item" id="">
                                      </div>
                                  </form>
                              </div>
                            </div>
		    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
                                <div class="modal" style="display: none" id="modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel">Add Category</h5>
                                        <button type="button" class="close" onclick="document.getElementById('modal').style.display = 'none';" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                          
                                        <form action="{{route('create_category')}}" method="POST">
                                            @csrf
					    <input type="hidden" name="org" value="{{Auth::user()->organization_id}}" id="">

                                            <div class="form-group">
                                                <label class="mb-1" for="amount">Category Name</label>
                                                <input name="name" required class="form-control py-4" id="name" type="text" step="any" aria-describedby="nameHelp" placeholder="Enter Name" />
                                            </div>
                                            <div class="form-group">
                                                <input name="submit" class="btn btn-primary" id="submit" type="submit" aria-describedby="nameHelp" value="Add to Category" />
                                            </div>
                                        </form>
                                      </div>
                                      <div class="modal-footer">
                                      </div>
                                    </div>
                                  </div>
                                </div>
</div>
@endsection
