@extends('layouts.index')

@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="page-header-title">
                    <h5 class="m-b-10">Payrolls By Device</h5>
                </div>
            </div>
            <div class="col-md-4">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{route('home')}}"> <i class="fa fa-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#">Payrolls</a>
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

		     <?php
		    	$arr = [];
        		foreach ($transactions as $t) {
        		    $c = $t->customer_id;
        		    array_push($arr, $c);
        		}
        		$c_s = array_unique($arr);
        		$c_ss = array_reverse($c_s);
		    ?>
		      <div class="card shadow" style="width:100%;">
                          <div class="card-body">  
			    <div class="row">
                              <div class="col-sm-3">
                                <h5 class="mb-0" style="float: right;">Payroll Summary</h5>
                              </div>
                              <div class="col-sm-9 text-secondary">
                              </div>
                            </div>
                            <hr>
                            <div class="row">
                              <div class="col-sm-3">
                                <h6 class="mb-0" style="float: right;">Device Name:</h6>
                              </div>
                              <div class="col-sm-9 text-secondary">
                                {{$device->name}}
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-sm-3">
                                <h6 class="mb-0" style="float: right;">Community:</h6>
                              </div>
                              <div class="col-sm-9 text-secondary">
                                {{$device->community}}
                              </div>
                            </div>
			                    <div class="row">
                    	      <div class="col-sm-3">
                    	        <h6 class="mb-0" style="float: right;">Total Amount is:</h6>
                    	      </div>
                    	      <?php
                    	      $t_amount = 0;
				                    $t_q = 0;
                    	        foreach ($transactions as $t) {
                    	            $t_amount = $t_amount + $t->amount;
				                          $t_q = $t_q + $t->quantity;
                    	        }
                    	      ?>
                    	      <div class="col-sm-9 text-secondary">
                    	        {{$t_amount}} NGN
                    	      </div>
                    	    </div>
			                    <div class="row">
                              <div class="col-sm-3">
                                <h6 class="mb-0" style="float: right;"> Quantities in Payroll is: </h6>
                              </div>
                              <div class="col-sm-9 text-secondary">
                                {{$t_q}} 
                              </div>
                            </div>
                             <div class="row">
                    	       <div class="col-sm-3">
                    	         <h6 class="mb-0" style="float: right;">Date range: </h6>
                    	       </div>
                    	       <div class="col-sm-9 text-secondary">
                    	           <?php $f = explode('-', $from); $f = $f[2]. ' '.$months[(int)$f[1]].', '.$f[0]; ?>
                    	           <?php $t = explode('-', $to); $t = $t[2].' '.$months[(int)$t[1]].', '.$t[0]; ?>
                    	         from {{$f}} to {{$t}}
                    	         <div id="small"></div>
                    	       </div>
                    	     </div>
			  <div class="row px-3 py-2">
                            <div class="col-sm-12">
                              <form action="{{route('payroll_store')}}" method="POST">
                                @csrf
                                <input type="hidden" name="tag" value="Device({{$device->id}})">
				@foreach ($c_ss as $customer)
                                <input type="hidden" name="customer[]" value="{{$customer}}">
				@endforeach
                                <input type="hidden" name="from" value="{{$from}}">
                                <input type="hidden" name="to" value="{{$to}}">
  
                                <button type="submit" class="btn btn-primary">Generate Payroll</button>
                              </form>
                            </div>
                          </div>
                          </div>
                        </div>

                <!-- Basic table card start -->
		<div class="card">
                        <div class="card-header">
                            <h5>Payroll's</h5>
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
					    <th>customer Phone</th>
                                            <th>Total Amount</th>
                                            <th>No of Quantities</th>
                                            <th>No of Transactions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
					    <?php $i = 1;?>
				        @foreach ($c_ss as $customer)
					<?php 
					$cus = \App\Models\Customer::find($customer);
					$trans = \App\Models\Transaction::where(["customer_id"=>$customer, "device_id"=> $device->id, "org_id"=>Auth::user()->organization_id, "p_status"=>0])
                  ->whereBetween('date', [$from . '-00-00-00', $to . '-23-59-59'])
                  ->get(); 
					$c_t_amount = 0;
					$c_t_quantity = 0;
					foreach ($trans as $t) {
						$c_t_amount = $c_t_amount + $t->amount;
				    		$c_t_quantity = $c_t_quantity + $t->quantity;
					}
					?>
					
					<tr>
						<th scope="row">{{$i}}</th>
						<td>{{$cus->name ?? "Null"}}</td>
						<td>{{$cus->phone ?? "Null"}}</td>
						<td>{{$c_t_amount}}</td>
						<td>{{$c_t_quantity}}</td>
						<td>{{count($trans)}}</td>
						<?php $i++?>
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
