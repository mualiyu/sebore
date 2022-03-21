@extends('layouts.index')

@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="page-header-title">
                    <h5 class="m-b-10">Sales</h5>
                </div>
            </div>
            <div class="col-md-4">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{route('home')}}"> <i class="fa fa-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#">Sales>
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
		            <a href="{{route('sale_show_add', ['id'=>$store->id])}}" style="right:0;" class="btn btn-primary">Add Sale</a>
                    <div class="card">
                        <div class="card-header">
                            <h5>Available Sales</h5>
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
                                            <th>Marketer</th>
                                            <th>Store</th>
					    <th>Ref No:</th>
					    <th>Items</th>
                        <th>Quantity</th>
                        <th>Total Amount</th>
                                            <th>Date - Time</th>
					    <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
					    <?php $i = 1; ?>
					    
                        
				        @foreach ($s_ss as $num)
                        <?php $sale = App\Models\Sale::where(['ref_num'=>$num])->get();?>
					
					<tr>
						<th scope="row">{{$i}}</th>
						<td>{{$sale[0]->marketer->name}}</td>
                        <td>{{$sale[0]->store->name}}</td>
						<td>{{$sale[0]->ref_num}}</td>
						<td>
                            <?php
                            $amount = 0;
                            $quantity = 0;
                            foreach ($sale as $s) {
                                echo $s->item->item_cart->name. ", ";
                                $amount += $s->amount; 
                                $quantity += $s->quantity; 
                            }
                            ?>
                        </td>
                        <td>{{$quantity}}</td>
                        <td>{{$amount}}</td>
						<td>From : {{$sale[0]->from}} <br> To : {{$sale[0]->to}} <small>(Expexted return day)</small>
                            {{-- <span style="float: right; color:red; ">{{$payrolls[0]->status==0? "Not Processed":""}}</span>
                            <span style="float: right; color:green; "> {{$payrolls[0]->status==0? "":"Processed"}}</span> --}}
                        </td>
						<td>
						  <a href="{{route('sale_show_info', ['id'=>$store->id, 'ref_num'=>$sale[0]->ref_num])}}" class="btn btn-success">Open</a>
                          <a  onclick="
                              if(confirm('Did you want to delete sale({{$sale[0]->ref_num}})? \nTransactions that are under this sale will also be deleted. \n\nAre you sure about this???')){
                                  document.getElementById('delete-form[{{$i}}]').submit();
                              }
                                  event.preventDefault();"
                              class="btn btn-warning" 
                              style="color: black; background:red;">
                              Delete
                          </a>
                          <form method="POST" id="delete-form[{{$i}}]" action="{{route('delete_sale')}}">
                                @csrf 
                                <input type="hidden" value="{{$sale[0]->ref_num}}" name="ref_num">
                            </form>
						</td>
						<?php $i++;?>
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
