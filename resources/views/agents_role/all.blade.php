@extends('layouts.index')

@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="page-header-title">
                    <h5 class="m-b-10">Agent Roles</h5>
                </div>
            </div>
            <div class="col-md-4">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{route('home')}}"> <i class="fa fa-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#">Agent Role</a>
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
		        <a href="{{route('show_add_agent_role')}}" style="right:0;" class="btn btn-primary">Add New Role</a>
                {{-- <a href="{{route('show_add_direct_item')}}" style="right:0;" class="btn btn-primary">Add Item To Device</a> --}}
                <br>
                    <div class="card">
                        <div class="card-header">
                            <h5>Agent Roles</h5>
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
                                            <th>type</th>
					                        <th>Permission</th>
					                        <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
					    <?php $i_i = count($roles); ?>
				        @foreach ($roles as $r)
					<tr>
						<th scope="row">{{$i_i}}</th>
						<td>{{$r->name}}</td>
						<td>{{$r->type}}</td>
						<td>{{$r->permission == 'rw'? "Read & Write" : "Read only"}}</td>
						<td>
                            <form method="POST" id="delete-form[{{$i_i}}]" action="{{route('delete_agent_role',['id'=>$r->id])}}">
                                @csrf 
                                <a  onclick="
                                    if(confirm('Are you sure You want to Delete this Item -( {{$r->name}}, {{$r->id}} )? ')){
                                        document.getElementById('delete-form[{{$i_i}}]').submit();
                                    }
                                        event.preventDefault();"
                                    class="btn btn-warning" 
                                    style="color: black; background:red;">
                                    Delete
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
@endsection
