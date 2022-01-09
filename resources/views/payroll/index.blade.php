@extends('layouts.index')

@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="page-header-title">
                    <h5 class="m-b-10">Payrolls</h5>
                </div>
            </div>
            <div class="col-md-4">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{route('home')}}"> <i class="fa fa-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#">Payroll</a>
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
		            <a href="{{route('payroll_show_create')}}" style="right:0;" class="btn btn-primary">create New Payroll</a>
                    <div class="card">
                        <div class="card-header">
                            <h5>payrolls</h5>
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
                                            <th>Tag</th>
					    <th>Ref_id</th>
                                            <th>Date - Time</th>
					    <th>Status</th>
					    <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
					    <?php $i = count($p_ss); ?>
                        
				        @foreach ($p_ss as $p)
					<?php $payrolls = \App\Models\Payroll::where("ref_id", '=', $p)->get();
                    $tag = $payrolls[0]->tag;
			        $tag = explode("(", $tag);
                     ?>
					<tr>
						<th scope="row">{{$i}}</th>
						<td>{{$tag[0]}}</td>
						<td>{{$p}}</td>
						<td>{{$payrolls[0]->created_at}}</td>
						<td>
                            <span style="float: right; color:red; ">{{$payrolls[0]->status==0? "Not Processed":""}}</span>
                            <span style="float: right; color:green; "> {{$payrolls[0]->status==0? "":"Processed"}}</span>
                        </td>
						<td>
						  <a href="{{route('payroll_by_ref_id', ['ref_id'=>$p])}}" class="btn btn-success">Open</a>
                          <a  onclick="
                              if(confirm('Are you sure You want to Delete this payroll -( {{$payrolls[0]->tag}}, {{$payrolls[0]->ref_id}} )? ')){
                                  document.getElementById('delete-form[{{$i}}]').submit();
                              }
                                  event.preventDefault();"
                              class="btn btn-warning" 
                              style="color: black; background:red;">
                              Delete
                          </a>
                          <form method="POST" id="delete-form[{{$i}}]" action="{{route('payroll_delete',['ref_id'=>$payrolls[0]->ref_id])}}">
                                @csrf 
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
