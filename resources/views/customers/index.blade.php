@extends('layouts.index')

@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="page-header-title">
                    <h5 class="m-b-10">{{$agent->name}} Customers</h5>
                </div>
            </div>
            <div class="col-md-4">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{route('home')}}"> <i class="fa fa-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#">Customers</a>
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
                <a href="{{route('show_agents')}}" style="right:0;" class="btn btn-primary">Back</a>&nbsp;&nbsp;&nbsp;
		<a href="{{route('show_add_customer', ['id'=> $agent->id])}}" style="right:0;" class="btn btn-primary">Add New Customer</a>
        <br>
                    <div class="card">
                        <div class="card-header">
                            <h5>Customer</h5>
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
                                    style="color: black; background:red;">
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
@endsection
