@extends('layouts.index')

@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="page-header-title">
                    <h5 class="m-b-10">User's</h5>
                </div>
            </div>
            <div class="col-md-4">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{route('home')}}"> <i class="fa fa-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#">User</a>
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
		<a href="{{route('show_add_user')}}" style="right:0;" class="btn btn-secondary"> Register user</a>
                    <div class="card">
                        <div class="card-header">
                            <h5>Users</h5>
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
                                            <th>Role</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
					    <?php $i = count($users); ?>
				        @foreach ($users as $u)
					<tr>
						<th scope="row">{{$i}}</th>
						<td>{{$u->name}}</td>
						<td>{{$u->email}}</td>
						<td>{{$u->phone}}</td>
						<td>{{$u->role->name}}</td>
                        <td>
                            {{-- <a href="" class="btn btn-warning">Delete</a>
                            <a href="" class="btn btn-primary">Edit</a> --}}
                            <form method="POST" id="delete-form" action="{{route('delete_user',['id'=>$u->id])}}">
                                <a href="{{route('show_single_user', ['id'=>$u->id])}}" class="btn btn-primary">Open</a>
                                @csrf 
                                <a  onclick="
                                    if(confirm('Are you sure You want to Delete this Customer -( {{$u->name}} )? ')){
                                        document.getElementById('delete-form').submit();
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
@endsection
