@extends('layouts.index')

@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="page-header-title">
                    <h5 class="m-b-10">Tarnsactions By Customer</h5>
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
                                <h6 class="mb-0" style="float: right;">Customer Phone:</h6>
                              </div>
                              <div class="col-sm-9 text-secondary">
                                {{$customer->phone}}
                              </div>
                            </div>
			    <div class="row">
                    	      <div class="col-sm-3">
                    	        <h6 class="mb-0" style="float: right;">Total Amount</h6>
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
                                <h6 class="mb-0" style="float: right;"> No of Quantities </h6>
                              </div>
                              <div class="col-sm-9 text-secondary">
                                {{$t_q}} Liters
                              </div>
                            </div>
                             <div class="row">
                    	       <div class="col-sm-3">
                    	         <h6 class="mb-0" style="float: right;">Date range </h6>
                    	       </div>
                    	       <div class="col-sm-9 text-secondary">
                    	           <?php $f = explode('-', $from); $from = $f[2]. ' '.$months[(int)$f[1]].', '.$f[0]; ?>
                    	           <?php $t = explode('-', $to); $to = $t[2].' '.$months[(int)$t[1]].', '.$t[0]; ?>
                    	         from {{$from}} to {{$to}}
                    	         <div id="small"></div>
                    	       </div>
                    	     </div><br>
                          </div>
                        </div>

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
                                        </tr>
                                    </thead>
                                    <tbody>
					    <?php $i = 1;?>
				        @foreach ($transactions as $t)
					
					<tr>
						<th scope="row">{{$i}}</th>
						<td>{{$t->item->name}}</td>
						<td>{{$t->item->measure}} - {{$t->item->unit}}</td>
						<td>{{$t->quantity}}</td>
						<td>{{$t->amount}}</td>
						<td>
							{{$t->date}}
						</td>
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