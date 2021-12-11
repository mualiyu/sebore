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
                            <h5>Customers Transaction</h5>
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
					                        <th>Customer Name</th>
					                        <th>Phone</th>
                                            <th>Quantities</th>
                                            <th>Total Amount</th>
					                        {{-- <th>date</th> --}}
					                        <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
					    <?php $i = 1; $t_amount = 0; $t_q = 0; $c_names = []; $info=[];?>
				        @foreach ($data as $d)
					<?php
					$customer = \App\Models\Customer::find($d['customer_id']);
                    $ii = [
                        'customer_id' => $d['customer_id'],
                        'transactions' => $d['transactions']
                    ];
					array_push($info, $ii);
                    array_push($c_names, $customer->name);
					$q_amount = 0;
					$ts_amount = 0.00;
					foreach ($d['transactions'] as $t) {
						$q_amount = $q_amount + (float)$t->quantity;
						$ts_amount = $ts_amount + (float)$t->amount;
					}


					$t_amount = (float)$t_amount + (float)$ts_amount;
					$t_q = (float)$t_q + (float)$q_amount;

					
					?>
					<tr>
						<th scope="row">{{$i}}</th>
						<td>{{$customer->name}}</td>
						<td>{{$customer->phone}}</td>
						<td>{{$q_amount}}</td>
						<td>NGN {{$ts_amount}}</td>
						{{-- <td>
							{{$t->date}}
						</td> --}}
						<td>
                            <form method="POST" id="pay-form[{{$i}}]" action="{{route('pay_all_tran_p_c')}}">
                                @csrf 
                                <input type="hidden" name="c_number" value="{{$customer->phone}}">
                                <input type="hidden" name="c_name" value="{{$customer->name}}">
                                <input type="hidden" name="c_customerId" value="{{$customer->id}}">
                                <input type="hidden" name="t_amount" value="{{$ts_amount}}">
                                @foreach ($d['transactions'] as $t)
                                <input type="hidden" name="transactions[]" value="{{$t->id}}">
                                @endforeach
                            </form>
                                <a  onclick="
                           	 if(confirm('Are you sure You want to Pay only one Customer? ')){
                           	     document.getElementById('pay-form[{{$i}}]').submit();
                           	 }
                           	     event.preventDefault();"
                           	 class="btn btn-primary" 
                           	 style="color: black">
                           	 Pay
                           	</a>
						</td>
						<?php $i++?>
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
                                <h5 class="mb-0" style="float: right;">Payment Summary</h5>
                              </div>
                              <div class="col-sm-9 text-secondary">
                              </div>
                            </div>
                            <hr>
                            <div class="row">
                              <div class="col-sm-3">
                                <h6 class="mb-0" style="float: right;">Customers Names </h6>
                              </div>
                              <div class="col-sm-9 text-secondary">
                                {{$c_names[0]}}, {{$c_names[1]}} <?php if(count($c_names) > 2){ echo ' and others'; } ?>
                              </div>
                            </div>
                            
			                <div class="row">
                              <div class="col-sm-3">
                                <h6 class="mb-0" style="float: right;">Total Quantities </h6>
                              </div>
                              <div class="col-sm-9 text-secondary">
                                {{$t_q}} {{--Liters--}}
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
                              </div>
                              <div class="col-sm-9 text-secondary">
                                  <form method="POST" id="pay-all-form" action="{{route('pay_all_tran_p_c_bulk')}}">
                                      @csrf 
                                      @foreach ($data as $d)
                                      <input type="hidden" name="info[]" value="{{$d['customer_id']}}">
                                      <?php  
                                        // $q_amount = 0;
					                    $ts_amount = 0.00;
                                        $t_array = [];
					                    foreach ($d['transactions'] as $t) {
					                    	// $q_amount = $q_amount + (float)$t->quantity;
					                    	$ts_amount = $ts_amount + (float)$t->amount;
                                            array_push($t_array, $t->id);
                                            echo '<input type="hidden" name="transactions['.$d["customer_id"].']" value="'.json_encode($t_array).'">';
					                    }
                                      ?>
                                        <input type="hidden" name="amount[{{$d['customer_id']}}]" value="{{$ts_amount}}">
                                      @endforeach
                                       {{-- <input type="hidden" name="c_customerId" value="{{$res->data->customer->id}}">
                                      <input type="hidden" name="t_amount" value="{{$t_amount}}"> --}}
                                  </form>
                                	<a  onclick="
                           		 if(confirm('Are you sure You want to Pay All Selected Customers ? ')){
                           		     document.getElementById('pay-all-form').submit();
                           		 }
                           		     event.preventDefault();"
                           		 class="btn btn-primary" 
                           		 style="color: black">
                           		 Pay All Customers
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
