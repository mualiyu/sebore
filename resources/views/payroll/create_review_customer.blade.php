@extends('layouts.index')

@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="page-header-title">
                    <h5 class="m-b-10">Payroll By Customer</h5>
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
                                {{$t_q}}
                              </div>
                            </div>
                             <div class="row">
                              <div class="col-sm-3">
                                <h6 class="mb-0" style="float: right;"> No of Transactions </h6>
                              </div>
                              <div class="col-sm-9 text-secondary">
                                {{count($transactions)}}
                              </div>
                            </div>
                             <div class="row">
                    	       <div class="col-sm-3">
                    	         <h6 class="mb-0" style="float: right;">Date range </h6>
                    	       </div>
                    	       <div class="col-sm-9 text-secondary">
                    	           <?php $f = explode('-', $from); $f = $f[2]. ' '.$months[(int)$f[1]].', '.$f[0]; ?>
                    	           <?php $t = explode('-', $to); $t = $t[2].' '.$months[(int)$t[1]].', '.$t[0]; ?>
                    	         from {{$f}} to {{$t}}
                    	         <div id="small"></div>
                    	       </div>
                    	     </div>
                          </div>
                          <div class="row px-3 py-2">
                            <div class="col-sm-12">
                              <form action="{{route('payroll_store')}}" method="POST">
                                @csrf
                                <input type="hidden" name="tag" value="Customer({{$customer->id}})">
                                <input type="hidden" name="customer[]" value="{{$customer->id}}">
                                <input type="hidden" name="from" value="{{$from}}">
                                <input type="hidden" name="to" value="{{$to}}">
  
                                <button type="submit" class="btn btn-primary">Generate Payroll</button>
                              </form>
                            </div>
                          </div>
                        </div>


            </div>
        </div>
    </div>
</div>
@endsection
