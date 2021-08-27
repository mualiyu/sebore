@extends('layouts.index')

@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="page-header-title">
                    <h5 class="m-b-10">Transactons</h5>
                </div>
            </div>
            <div class="col-md-4">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{route('home')}}"> <i class="fa fa-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#">Transactions</a>
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
		<div class="card">
                        <div class="card-header">
                            <h5>Transaction's</h5>
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
					    <th>date</th>
					    {{-- <th>Action</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
					    <?php $i = count($transactions);?>
				        @foreach ($transactions as $t)
					<?php
					// $t_amount = (float)$t_amount + (float)$t->amount;

					$hash = hash('sha512',$t->id);

					$url = 'https://api.ajisaqsolutions.com/api/transaction/get?apiUser=' . config('app.apiUser') .
            					'&apiKey=' . config('app.apiKey') .
            					'&hash=' . $hash .
            					'&id=' . $t->id;
					$response = Http::get($url);
            				// return $response;
            				$res = json_decode($response);
					//     dd($res);
					?>
					<tr>
						<th scope="row">{{$i}}</th>
						<td>{{$res->data->item->name}}</td>
						<td>{{$res->data->item->measure}} - {{$res->data->item->unit}}</td>
						<td>{{$t->quantity}}</td>
						<td>{{$t->amount}}</td>
						<td>
							{{$t->date}}
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
