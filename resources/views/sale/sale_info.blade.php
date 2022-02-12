@extends('layouts.index')

@section('style')
    <style>

label {
    width: 100%;
}

.card-input-element {
    display: none;
}

.card-input {
    margin: 10px;
    padding: 0px;
}

.card-input:hover {
    cursor: pointer;
}
/* #up_btn {
    cursor:unset;
} */

.card-input-element:checked + .card-input {
     box-shadow: 0 0 1px 1px #2ecc71;
}
    </style>
@endsection

@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="page-header-title">
                    <h5 class="m-b-10">Sale Info</h5>
                </div>
            </div>
            <div class="col-md-4">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{route('home')}}"> <i class="fa fa-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#">Store</a>
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
		<div class="row">
			<div class="col-md-5 col-sm-4">
				<div class="card shadow" style="width:100%;">
				    <div class="card-body">  
				      <div class="row">
					<div class="col-sm-3">
					  <h5 class="mb-0" style="float: right;">Sale Info</h5>
					</div>
					<div class="col-sm-3"></div>
					<div class="col-sm-3"></div>
					<div class="col-sm-3">
						<a href="#" onclick="history.back();" style="float: right" class="btn btn-primary">Sales</a>
					</div>
				      </div>
				      <hr>
				      <div class="row">
					<div class="col-sm-3">
					  <h6 class="mb-0" style="float: right;">Reference No:</h6>
					</div>
					<div class="col-sm-9 text-secondary">
					  {{$sale[0]->ref_num}}
					</div>
				      </div>
				      <div class="row">
					<div class="col-sm-3">
					  <h6 class="mb-0" style="float: right;">Store name:</h6>
					</div>
					<div class="col-sm-9 text-secondary">
					  {{$sale[0]->store->name}}
					</div>
				      </div>
				      <div class="row">
					    <div class="col-sm-3">
					      <h6 class="mb-0" style="float: right;">Items:</h6>
					    </div>
					    <div class="col-sm-9 text-secondary">
						<?php
                            			$amount = 0;
                            			$quantity = 0;
                            			foreach ($sale as $s) {
                            			    echo $s->item->item_cart->name. "($s->quantity pcs), ";
                            			    $amount += $s->amount; 
                            			    $quantity += $s->quantity; 
                            			}
                            			?>
					    </div>
					  </div>
					<div class="row">
					    <div class="col-sm-3">
					      <h6 class="mb-0" style="float: right;">Total Amount:</h6>
					    </div>
					    <div class="col-sm-9 text-secondary">
					      {{$amount ?? "0"}} NGN
					    </div>
					  </div>
				       <div class="row">
					     <div class="col-sm-3">
					       <h6 class="mb-0" style="float: right;">Date: </h6>
					     </div>
					     <div class="col-sm-9 text-secondary">
						From : {{$sale[0]->from}} To : {{$sale[0]->to}}
					       <div id="small"></div>
					     </div>
					   </div>
				    </div>
				  </div>
			</div>
			<div class="col-md-7 col-sm-8">
				<div class="card">
                        <div class="card-header">
                            <h5>Marketer</h5>
			    {{-- <div style="float: right">
				<a href="#" onclick="document.getElementById('modal_agent').style.display = 'block';" class="btn btn-primary">Add Agent</a>
			    </div> --}}
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
                                            <th>phone</th>
					    <th>Email</th>
                                        </tr>
                                    </thead>
                                    <tbody>
					    <?php $i = 1;?>
					    
                        
				        {{-- @foreach ($store->agents as $a) --}}
					
					<tr>
						<th scope="row">{{$i}}</th>
						<td>{{$sale[0]->marketer->name}}</td>
                        			<td>{{$sale[0]->marketer->phone}}</td>
						<td>{{$sale[0]->marketer->email}}</td>
						<?php $i++?>
					</tr>
					{{-- @endforeach --}}
					@if (!$sale[0]->marketer)
					    <tr>
						    <td colspan="5" style="text-align: center"> No Sale Agents yet....</td>
					    </tr>
					@endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
			</div>
		</div>

		<div class="row">
		<div class="col-12">
			<div class="card">
			    <div class="card-header">
				<h5>Transactions</h5>
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
					    <th>Item Name</th>
					    <th>Measure - Unit</th>
                                            <th>Quantity</th>
                                            <th>Total Amount</th>
                                            <th>Transaction Type</th>
					    <th>date</th>
                                            <th>Agent</th>
                                            <th>Customer Name</th>
                                            <th>Customer Phone</th>
                                            <th>Cummunity</th>
                                            <th>Status</th>
                                            <th>Bill Reference</th>
                                        </tr>
					</thead>
					<tbody>
						<?php $i = 1;
						$transactions = App\Models\Transaction::where(['agent_id' => $sale[0]->marketer_id, 'type'=>"sale", 'org_id' => Auth::user()->organization_id])
                						->whereBetween('date', [$sale[0]->from . '-00-00-00', $sale[0]->to . '-23-59-59'])
                						// ->whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59'])
                						->get();
						?>

				        @foreach ($transactions as $t)
					<?php $item = \App\Models\Item::find($t->item_id); ?>
					<tr>
						<th scope="row">{{$i}}</th>
						<td>{{$item->item_cart->name ?? "Null"}}</td>
						<td>{{$item->item_cart->measure ?? "Null"}} - {{$item->item_cart->unit ?? "Null"}}</td>
						<td>{{$t->quantity}}</td>
						<td>{{$t->amount}}</td>
            					<td>{{$t->type ?? "collection"}}</td>
						<td>
							{{$t->date}}
						</td>
            					<td>{{$t->agent->name ?? "Null"}}</td>
            					<td>{{$t->customer->name ?? "Null"}}</td>
            					<td>{{$t->customer->phone ?? "Null"}}</td>
            					<td>{{$t->device->community ?? "Null"}}</td>
            					<td><span style="color: red;">{{$t->p_status==0 ? "Not Confirmed":""  ?? ""}}</span> <span style="color: green;">{{$t->p_status==1 ? "Confirmed":""  ?? ""}}</span></td>
            					<td>{{$t->ref_id ?? ""}}</td>
						<?php $i++?>
					</tr>
					@endforeach
					    @if (count($transactions) == 0)
						<tr>
							<td colspan="13" style="text-align: center"> No Transaction yet...</td>
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
    </div>
</div>
@endsection
