@extends('layouts.index')

@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="page-header-title">
                    <h5 class="m-b-10"> Items</h5>
                </div>
            </div>
            <div class="col-md-4">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{route('home')}}"> <i class="fa fa-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#">Items</a>
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
                <a href="{{url('/items')}}" style="right:0;" class="btn btn-secondary">Back</a>&nbsp;&nbsp;&nbsp;
		<a href="{{route('show_add_direct_item_cart')}}" style="right:0;" class="btn btn-primary">Add New Item</a>
        <br>
                    <div class="card">
                        <div class="card-header">
                            <h5>Item</h5>
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
					    <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
					    <?php $i_i = count($items); ?>
				        @foreach ($items as $i)
					<?php  $cat = \App\Models\Category::find($i->category_id); ?>
					<tr>
						<th scope="row">{{$i_i}}</th>
						<td>{{$i->name}}</td>
						<td>{{$cat->name}}</td>
						<td>{{$i->measure/100}}</td>
						<td>{{$i->unit}}</td>
						<td>{{$i->code}}</td>
						<td>{{$i->with_q ? 'Yes':'No'}}</td>
						<td>{{$i->with_p ? 'Yes':'No'}}</td>
						<td>
                            <form method="POST" id="delete-form[{{$i_i}}]" action="{{route('delete_item',['id'=>$i->id])}}">
                                <a href="{{route('show_edit_item', ['d_id'=>$device->id, 'i_id'=>$i->id])}}" class="btn btn-primary">Edit</a>
                                @csrf 
                                <a  onclick="
                                    if(confirm('Are you sure You want to Delete this Item -( {{$i->name}}, {{$i->id}} )? ')){
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
