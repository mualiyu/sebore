@extends('layouts.index')

@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="page-header-title">
                    <h5 class="m-b-10">Stores</h5>
                </div>
            </div>
            <div class="col-md-4">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{route('home')}}"> <i class="fa fa-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#">Stores
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
                <!-- Basic table card start -->
		            <a href="{{route('store_show_create')}}" style="right:0;" class="btn btn-primary">Create a Store?</a>
                    <div class="card">
                        <div class="card-header">
                            <h5>Available Stores</h5>
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
                                            <th>Location</th>
					                        <th>Total number of items</th>
					                        <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
					    <?php $i = 1; $k= ['12'] ?>
					    
                        
				        @foreach ($stores as $s)
					
					<tr style="{{$s->delete_status == 1 ? 'background-color: #ddd; cursor: not-allowed;' : ''}}">
						<th scope="row">{{$i}}</th>
						<td>{{$s->name}}</td>
                        			<td>{{$s->location}}</td>
						<td>{{$s->total_num_of_items ?? "Store is empty"}}</td>
						<td>
						  <a href="{{route("store_info", ['id'=>$s->id])}}" class="btn btn-success {{$s->delete_status == 1 ? 'disabled' : ''}}" style="{{$s->delete_status == 1 ? 'opacity:0.5; cursor: not-allowed;' : ''}}">Show info</a>
                          @if ($s->delete_status == 1)   
                          <a  onclick='
                              if(confirm("NOTE: This will delete store permanently .\n\nAre you sure You want to Delete this Store -(Name: {{$s->name}})? ")){
                                //   document.getElementById("delete-formm[{{$i}}]").submit();
                              }
                                  event.preventDefault();'
                              class="btn btn-warning" 
                              style="color: black; opacity:0.8; background:red;">
                              Delete permanently
                          </a>
                          @else 
                          <a  onclick='
                              if(confirm("NOTE: This is soft delete (i.e Temporarily).\n\nAre you sure You want to Delete this Store -(Name: {{$s->name}})? ")){
                                  document.getElementById("delete-form[{{$i}}]").submit();
                              }
                                  event.preventDefault();'
                              class="btn btn-warning " 
                              style="color: black; background:red;">
                              Delete
                          </a>
                          <form method="POST" id="delete-form[{{$i}}]" action="{{route('delete_store')}}">
                                @csrf
                                <input type="hidden" value="{{$s->id}}" name="id">
                          </form>
                          @endif
						</td>
						<?php $i--?>
					</tr>
					@endforeach
					@if (count($stores) == 0)
					    <tr>
						    <td colspan="5" style="text-align: center"> No stores yet.... Wanna Create One? <a href="{{route("store_show_create")}}">Click here</a> </td>
					    </tr>
					@endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

            </div>
        </div>
    </div>
</div>
@endsection
