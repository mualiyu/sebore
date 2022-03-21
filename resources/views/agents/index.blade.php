@extends('layouts.index')

@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="page-header-title">
                    <h5 class="m-b-10">Agents</h5>
                </div>
            </div>
            <div class="col-md-4">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{route('home')}}"> <i class="fa fa-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#">Agent</a>
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
		<a href="{{route('show_add_agent')}}" style="right:0;" class="btn btn-primary">Add New Agent</a>
        <a href="{{route('show_all_agent_roles')}}" style="right:0;" class="btn btn-primary">Agent Roles</a>
                    <div class="card">
                        <div class="card-header">
                            <h5>Agents</h5>
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
                                <table id="data_table" class="table-sm table-striped table-bordered dt-responsive nowrap " style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>UserName</th>
                                            <th>Email</th>
					    <th>Phone</th>
					    <th>Role</th>
					    <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
					    <?php $i = count($agents); ?>
				        @foreach ($agents as $a)
					<tr>
						<th scope="row">{{$i}}</th>
						<td>{{$a->name}}</td>
						<td>{{$a->email}}</td>
						<td>{{$a->phone}}</td>
						<td>{{$a->role->name}}</td>
						<td>
						  <a href="{{route('show_single_agent', ['id'=>$a->id])}}" class="btn btn-success">Open</a>
						  <a href="{{url('/agents/'.$a->id.'/customers')}}" class="btn btn-primary">View Farmers</a>
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
