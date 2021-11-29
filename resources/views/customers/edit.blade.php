@extends('layouts.index')
@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="page-header-title">
                    <h5 class="m-b-10">Edit Farmers from {{$agent->name}}</h5>
                </div>
            </div>
            <div class="col-md-4">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{route('home')}}"> <i class="fa fa-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Edit Farmers</a>
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

		    <a onclick="window.history.back()" style="right:0;" class="btn btn-primary">Back</a>&nbsp;&nbsp;&nbsp;
                <div class="row">
                    <div class="col-sm-12">
			    <div class="card">
                              <div class="card-header">
                                  <h5>edit Farmers</h5>
                                  <!--<span>Add class of <code>.form-control</code> with <code>&lt;input&gt;</code> tag</span>-->
                              </div>
                              <div class="card-block">
                                  <form class="form-material" method="POST" action="{{route('update_customer', ['id'=>$customer->id])}}">
					@csrf
					<input type="hidden" name="agent" value="{{$agent->id}}">
                                      <div class="form-group form-default">
                                          <input type="text" name="name" class="form-control" value="{{$customer->name ?? ''}}" required="">
                                          <span class="form-bar"></span>
                                          <label class="float-label">Name</label>
                                      </div>
                                      <div class="form-group form-default">
                                          <input type="email" name="email" value="{{$customer->email ?? ''}}" class="form-control" required="">
                                          <span class="form-bar"></span>
                                          <label class="float-label">Email (exa@gmail.com)</label>
                                      </div>
				      <div class="form-group form-default">
                                          <input type="number" value="{{$customer->phone ?? ''}}" name="phone" class="form-control" required="">
                                          <span class="form-bar"></span>
                                          <label class="float-label">Phone</label>
                                      </div>
				      <div class="form-group form-default">
                                          <input type="text" name="address" value="{{$customer->address ?? ''}}" class="form-control" required="">
                                          <span class="form-bar"></span>
                                          <label class="float-label">Address</label>
                                      </div>
				      <div class="row">
                          <div class="col-sm-3">
                                <div class="form-group form-default">
                                  <select name="country" value="{{$customer->country ?? ''}}"  class="form-control" required id="country-select">
                                      <option value="nigeria">Nigeria</option>
                                  </select>
                                <span class="form-bar"></span>
                                <label class="float-label">Country:</label>
                              </div>
                            </div>
                            <div class="col-sm-3">
                                {{-- <div class="form-group form-default">
                                    <input type="text" name="state" value="{{$customer->state ?? ''}}" class="form-control" required>
                                    <span class="form-bar"></span>
                                    <label class="float-label">State:</label>
                                </div> --}}

                                <div class="form-group form-default">
                                     <select name="state" class="form-control" id="state-select">
                                         <option value="{{$customer->state ?? ''}}">{{$customer->state ?? ''}}</option>
                                     </select>
                                   <span class="form-bar"></span>
                                   <label class="float-label">State:</label>
                                 </div>
                            </div>
                            <div class="col-sm-3">
                                      {{-- <div class="form-group form-default">
                                      <input type="text" name="lga" value="{{$customer->lga  ?? ''}}" class="form-control" required>
                                      <span class="form-bar"></span>
                                      <label class="float-label">LGA:</label>
                                      </div> --}}

                                      <div class="form-group form-default">
                                            <select name="lga" class="form-control" id="lga-select">
                                                <option value="{{$customer->lga  ?? ''}}">{{$customer->lga  ?? ''}}</option>
                                            </select>
                                        <span class="form-bar"></span>
                                        <label class="float-label">LGA:</label>
                                        @error('lga')
                                                          <Span style="color: red;">{{$message}}</Span>
                                                    @enderror
                                        </div>
                            </div>
					{{-- <div class="col-sm-3">
						<div class="form-group form-default">
						    <input type="text" name="gps" value="{{$customer->gps ?? ''}}" class="form-control" required>
						    <span class="form-bar"></span>
						    <label class="float-label">Location <small>(Gps)</small></label>
						</div>
					</div> --}}
				      </div>

				      

                                      <div class="form-group form-default">
                                          <input type="submit" class="btn btn-primary" value="Edit" id="">
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
