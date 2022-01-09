@extends('layouts.index')

@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="page-header-title">
                    <h5 class="m-b-10">Payroll {{$payrolls[0]->tag}}</h5>
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
			$t_t_amount = 0;
			$t_t_q =0;
        		foreach ($payrolls as $p) {
        		    $c = $p->customer_id;
			    $t_t_amount += $p->transaction->amount;
			    $t_t_q += $p->transaction->quantity;
        		    array_push($arr, $c);
        		}
        		$c_s = array_unique($arr);
        		$c_ss = array_reverse($c_s);

			$tag = $payrolls[0]->tag;
			$tag = explode("(", $tag);
        		$tag_data = explode(")", $tag[1]);
		    ?>
		      <div class="card shadow" style="width:100%;">
                          <div class="card-body">  
			    <div class="row">
                              <div class="col-sm-3">
                                <h5 class="mb-0" style="float: right;">Payroll Summary</h5>
                              </div>
                              <div class="col-sm-9 text-secondary">
				      @if ($payrolls[0]->status == 0)
				      <span style="float: right; color:red; ">Not Processed</span>
				      @else
				      <span style="float: right; color:green; ">Processed</span>
				      @endif
                              </div>
                            </div>
                            <hr>
                            <div class="row">
                              <div class="col-sm-3">
                                <h6 class="mb-0" style="float: right;">Payroll Tag:</h6>
                              </div>
                              <div class="col-sm-9 text-secondary">
                                {{$payrolls[0]->tag}}
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-sm-3">
                                <h6 class="mb-0" style="float: right;">Payroll Ref_id:</h6>
                              </div>
                              <div class="col-sm-9 text-secondary">
                                {{$payrolls[0]->ref_id}}
                              </div>
                            </div>
			    <div class="row">
                    	      <div class="col-sm-3">
                    	        <h6 class="mb-0" style="float: right;">Total Amount is:</h6>
                    	      </div>
                    	      <div class="col-sm-9 text-secondary">
                    	        {{$t_t_amount}} NGN
                    	      </div>
                    	    </div>
			    <div class="row">
                              <div class="col-sm-3">
                                <h6 class="mb-0" style="float: right;"> Quantities in Payroll is: </h6>
                              </div>
                              <div class="col-sm-9 text-secondary">
                                {{$t_t_q}} 
                              </div>
                            </div>
                             <div class="row">
                    	       <div class="col-sm-3">
                    	         <h6 class="mb-0" style="float: right;">Date Created: </h6>
                    	       </div>
                    	       <div class="col-sm-9 text-secondary">
                    	          {{$payrolls[0]->created_at}}
                    	         <div id="small"></div>
                    	       </div>
                    	     </div>
			@if ($payrolls[0]->status == 0)
			    <div class="row px-3 py-2">
			      <div class="col-sm-12">
				<form action="{{route('payroll_make_payment', ['ref_id'=>$payrolls[0]->ref_id])}}" id="paymentform" method="POST">
				  @csrf
				  <input type="hidden" name="tag" value="{{$payrolls[0]->tag}}">
				  @foreach ($c_ss as $customer)
				  <input type="hidden" name="customer[]" value="{{$customer}}">
				  @endforeach
				  {{-- <input type="hidden" name="from" value="{{$from}}">
				  <input type="hidden" name="to" value="{{$to}}"> --}}
				  <input type="hidden" name="amount" value="{{$t_t_amount}}">
				  {{-- <button type="submit" class="btn btn-primary">Make Payment</button> --}}
				</form>
				 <a  onclick="
                              if(confirm('Are you sure You want to make payment for this payroll - {{$tag[0]}}? \n\n If yes click OK \n Else click Cancel.')){
                                  document.getElementById('paymentform').submit();
                              }
                                  event.preventDefault();"
                              class="btn btn-primary" >
                              Make Payment
                          </a>
			      </div>
			    </div>
			    
			@endif
                          </div>
                        </div>

                <!-- Basic table card start -->
		<div class="card">
                        <div class="card-header">
                            <h5>Payroll customers</h5>
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

					

					if ($tag[0] == "Customer") {
						$trans = \App\Models\Transaction::where(["customer_id"=>$customer, "org_id"=>Auth::user()->organization_id])->get(); 
					}
					if ($tag[0] == "Agent") {
						$trans = \App\Models\Transaction::where(["customer_id"=>$customer, "agent_id"=> $tag_data[0], "org_id"=>Auth::user()->organization_id])->get(); 
					}
					if ($tag[0] == "Device") {
						$trans = \App\Models\Transaction::where(["customer_id"=>$customer, "device_id"=> $tag_data[0], "org_id"=>Auth::user()->organization_id])->get(); 
					}

					$c_t_amount = 0;
					$c_t_quantity = 0;
					foreach ($trans as $t) {
						foreach ($payrolls as $p) {
							if ($t->id == $p->transaction_id) {
								$c_t_amount = $c_t_amount + $t->amount;
								$c_t_quantity = $c_t_quantity + $t->quantity;
						    	}
        					}
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
