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
                    <h5 class="m-b-10">Edit {{$item->name}}</h5>
                </div>
            </div>
            <div class="col-md-4">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{route('home')}}"> <i class="fa fa-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Edit Item</a>
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
		    <a href="{{url('/items')}}" style="right:0;" class="btn btn-primary">Back</a>&nbsp;&nbsp;&nbsp;
		    <button type="button" class="btn btn-primary" onclick="document.getElementById('modal').style.display = 'block';"><i class="">+</i> Add New Category</button>
        <br>
                <div class="row">
                    <div class="col-sm-12">
			    <div class="card">
                              <div class="card-header">
                                  <h5>Edit Item</h5>
                                  <!--<span>Add class of <code>.form-control</code> with <code>&lt;input&gt;</code> tag</span>-->
                              </div>
                              <div class="card-block">
                                  <form class="form-material" method="POST" action="{{route('update_item_cart', $item->id)}}">
					@csrf
					{{-- <input type="hidden" name="device" value="{{$device->id}}"> --}}
                                      <div class="form-group form-default">
                                          <input type="text" name="name" value="{{$item->name}}" class="form-control" required="">
                                          <span class="form-bar"></span>
                                          <label class="float-label">Name</label>
                                      </div>
                                      <div class="form-group form-default">
                                          <input type="number" name="measure" value="{{$item->measure}}" class="form-control" required="">
                                          <span class="form-bar"></span>
                                          <label class="float-label">Measure</label>
                                      </div>
				      <div class="form-group form-default">
                                          <input type="text" name="unit" value="{{$item->unit}}" class="form-control" required="">
                                          <span class="form-bar"></span>
                                          <label class="float-label">Unit <span style="font-size: 10px;">Ex (NGN, Kg, Meters, USD)</span></label>
                                      </div>
				      <div class="form-group form-default">
                                          <input type="text" name="code" value="{{$item->code}}" class="form-control" required="">
                                          <span class="form-bar"></span>
                                          <label class="float-label">code</label>
                                      </div>
				      <div class="row">
					<div class="col-sm-4">
						      <div class="form-group form-default">
							  <select name="with_q" class="form-control" required>
								  <option value="0" disabled>select</option>
								  @if ($item->with_q)
								      <option value="{{$item->with_q}}">Yes</option>
								  @else
								      <option value="{{$item->with_q}}">No</option>
								  @endif
								<option value="1">Yes</option>
								<option value="0">No</option>
							</select>
							  <span class="form-bar"></span>
							  <label class="float-label">With Quantity?</label>
						      </div>
					</div>
					<div class="col-sm-4">
						<div class="form-group form-default">
						  <select name="with_p" class="form-control" required>
							  <option value="0" disabled>select</option>
							   @if ($item->with_p)
							       <option value="{{$item->with_p}}">Yes</option>
							   @else
							       <option value="{{$item->with_p}}">No</option>
							   @endif
							<option value="1">Yes</option>
							<option value="0">No</option>
						  </select>
						  <span class="form-bar"></span>
						  <label class="float-label">With Payer Name?</label>
						</div>
					</div>
					<?php $categories = \App\Models\Category::where('org_id', '=', Auth::user()->organization_id)->get(); ?>
					<div class="col-sm-4">
						<div class="form-group form-default">
						  <select name="category" class="form-control" required>
							 <option value="0" disabled>select</option>
							 @if ($item->category_id)
							 	<?php $cat = \App\Models\Category::find($item->category_id); ?>
							      <option value="{{$cat->id}}">{{$cat->name}}</option>
							  @endif
							 @foreach ($categories as $c)    
							 <option value="{{$c->id}}">{{$c->name}}</option>
							 @endforeach
						  </select>
						  <span class="form-bar"></span>
						  <label class="float-label">Category</label>
						</div>
					</div>
				      </div>

				      

                                      <div class="form-group form-default">
                                          <input type="submit" class="btn btn-primary" value="Edit Item" id="">
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
