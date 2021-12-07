@extends('layouts.index')

@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="page-header-title">
                    <h5 class="m-b-10">Payment</h5>
                </div>
            </div>
            <div class="col-md-4">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{route('home')}}"> <i class="fa fa-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#">Payment</a>
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
					                                  <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
					    <?php $i = count($transactions); $t_amount = 0;?>
				        @foreach ($transactions as $t)
					<?php
					$t_amount = (float)$t_amount + (float)$t->amount;

          $item = \App\Models\Item::find($t->item_id);

          

					// $hash = hash('sha512',$t->id);

					// $url = 'https://api.ajisaqsolutions.com/api/transaction/get?apiUser=' . config('app.apiUser') .
          //   					'&apiKey=' . config('app.apiKey') .
          //   					'&hash=' . $hash .
          //   					'&id=' . $t->id;
					// $response = Http::get($url);
          //   				// return $response;
          //   				$res = json_decode($response);
					// //     dd($res);
					?>
					<tr>
						<th scope="row">{{$i}}</th>
						<td>{{$t->item->item_cart->name ?? "Null"}}</td>
						<td>{{$t->item->item_cart->measure ?? "Null"}} - {{$t->item->item_cart->unit ?? "Null"}}</td>
						<td>{{$t->quantity}}</td>
						<td>{{$t->amount}}</td>
						<td>
							{{$t->date}}
						</td>
						<td>
                            <form method="POST" id="pay-form[{{$i}}]" action="{{route('pay_single_t')}}">
                                @csrf 
                                <input type="hidden" name="customerNum" value="{{$t->customer->phone}}">
                                <input type="hidden" name="customerId" value="{{$t->customer->id}}">
                                <input type="hidden" name="i_name" value="{{$t->item->item_cart->name  ?? "Null"}}">
                                <input type="hidden" name="amount" value="{{$t->amount}}">
                            </form>
							              <a  onclick="
                           	 if(confirm('Are you sure You want to Pay only for - ({{ $t->item->item_cart->name ?? 'Null'}}) ? ')){
                           	     document.getElementById('pay-form[{{$i}}]').submit();
                           	 }
                           	     event.preventDefault();"
                           	 class="btn btn-primary" 
                           	 style="color: black">
                           	 Pay
                           	</a>
						</td>
						<?php $i--?>
					</tr>
					@endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

		
			 <div class="card shadow" style="width:100%;">
                          <div class="card-body">  
			    <div class="row">
                              <div class="col-sm-3">
                                <h5 class="mb-0" style="float: right;">Transaction Summary</h5>
                              </div>
                              <div class="col-sm-9 text-secondary">
                              </div>
                            </div>
                            <hr>
                            <div class="row">
                              <div class="col-sm-3">
                                <h6 class="mb-0" style="float: right;">Customer Name</h6>
                              </div>
                              <div class="col-sm-9 text-secondary">
                                {{$customer->name}}
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-sm-3">
                                <h6 class="mb-0" style="float: right;">Customer Phone No:</h6>
                              </div>
                              <div class="col-sm-9 text-secondary">
                                {{$customer->phone}}
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-sm-3">
                                <h6 class="mb-0" style="float: right;">Total Amount of All transactions is</h6>
                              </div>
                              <div class="col-sm-9 text-secondary">
                                {{$t_amount}} NGN
                              </div>
                            </div><br>
                            <div class="row">
                              <div class="col-sm-3">
                                {{-- <h6 class="mb-0" style="float: right;">Location</h6> --}}
                              </div>
                              <div class="col-sm-9 text-secondary">
                                  <form method="POST" id="pay-all-form" action="{{route('pay_all_tran_p_c')}}">
                                      @csrf 
                                      <input type="hidden" name="c_number" value="{{$customer->phone}}">
                                      <input type="hidden" name="c_name" value="{{$customer->name}}">
                                       <input type="hidden" name="c_customerId" value="{{$customer->id}}">
                                      <input type="hidden" name="t_amount" value="{{$t_amount}}">
                                  </form>
                                	<a  onclick="
                           		 if(confirm('Are you sure You want to Pay All Transactions ? ')){
                           		     document.getElementById('pay-all-form').submit();
                           		 }
                           		     event.preventDefault();"
                           		 class="btn btn-primary" 
                           		 style="color: black">
                           		 Pay for All
                           		</a>
                              </div>
                            </div>
                          </div>
                        </div>
            </div>
        </div>
    </div>
</div>
@endsection
