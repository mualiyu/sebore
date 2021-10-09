@extends('layouts.auth')

@section('style')
    <style>


ul li {
    margin-bottom: 1.4rem
}

.row{
	margin: 20px;
}
.text-center{

	margin-top: 10px;
	margin-bottom: 50px;
}
.pricing-divider {
    border-radius: 20px;
    background-color: rgb(136,72,77) !important;
    padding: 1em 0 4em;
    position: relative
}

.pricing-divider-img {
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 100%;
    height: 80px
}

.deco-layer {
    -webkit-transition: -webkit-transform 0.5s;
    transition: transform 0.5s
}


.btn-custom {
    background: rgb(136,72,77);
    color: #fff;
    border-radius: 20px
}

.img-float {
    width: 50px;
    position: absolute;
    top: -3.5rem;
    right: 1rem
}

.princing-item {
    transition: all 150ms ease-out
}

.princing-item:hover {
    transform: scale(1.05)
}

.princing-item:hover .deco-layer--1 {
    -webkit-transform: translate3d(15px, 0, 0);
    transform: translate3d(15px, 0, 0)
}

.princing-item:hover .deco-layer--2 {
    -webkit-transform: translate3d(-15px, 0, 0);
    transform: translate3d(-15px, 0, 0)
}
    </style>
@endsection

@section('content')

<div class="container-fluid w-90">

	<div class="text-center">
             <a href="{{url('/')}}" style="color: white; font-size:25px; text-decoration:bold;"><img src="{{asset('assets/images/auth/Logo-small-bottom.png')}}" style="width: 40px; height:40px;" alt="small-logo.png">  <b>ATS</b>
		<h1>Subscription Plan</h1>
        
	     </a>
    </div>
    @include('layouts.flash')
<br>
	<div class="row m-auto w-100 text-center " style="margin-bottom:5px;">
		<a href="{{route('home')}}" style="right:0;" class="btn btn-primary">back</a>
		<br>
	</div><br>
<div class="row m-auto text-center w-100" >

@foreach ($plans as $p)
@if ($p->price == 0)
<div class="col-md-3 princing-item">
    <div class="pricing-divider">
	<h3 class="text-light">{{$p->name}}</h3>
	<h4 class="my-0 display-2 text-light font-weight-normal mb-3"><span class="h3">₦</span> {{$p->price/100}} <span class="h5">/month</span></h4> 
	<svg class='pricing-divider-img' enable-background='new 0 0 300 100' height='100px' preserveAspectRatio='none' version='1.1' viewBox='0 0 300 100' width='300px' x='0px' xml:space='preserve' y='0px'>
	<path class='deco-layer deco-layer--4' d='M-34.667,62.998c0,0,56-45.667,120.316-27.839C167.484,57.842,197,41.332,232.286,30.428	c53.07-16.399,104.047,36.903,104.047,36.903l1.333,36.667l-372-2.954L-34.667,62.998z' fill='#FFFFFF'></path>
	</svg>
    </div>

    <div class="card-body bg-white mt-0 shadow">
	<ul class="list-unstyled mb-5 position-relative">
	    <li>{{$p->no_devices}} Device</li>
	    <li>{{$p->no_agents}} Agents</li>
	    <li>{{$p->no_customers}} Customers</li>
	    <li>{{$p->no_transactions}} transactions</li>
	</ul> 
    <form action="{{route('plan_add')}}" method="POST">
        @csrf
        <input type="hidden" value="{{$p->id}}" name="plan_id">
        {{-- <input type="hidden" name="currency" value="NGN">
        <input type="hidden" name="metadata" value="{{ json_encode($array = ['plan_id'=> $p->id, 'org_id' => Auth::user()->organisation_id,]) }}" >  --}}
        <input type="hidden" name="email" value="{{Auth::user()->email}}">
        <button type="submit" class="btn btn-lg btn-block btn-custom ">Proceed</button>
    </form>
    </div>
</div>  
@endif
@if ($p->price != 0)    
<div class="col-md-3 princing-item">
    <div class="pricing-divider">
	<h3 class="text-light">{{$p->name}}</h3>
	<h4 class="my-0 display-2 text-light font-weight-normal mb-3"><span class="h3">₦</span> {{$p->price/100}} <span class="h5">/month</span></h4> 
	<svg class='pricing-divider-img' enable-background='new 0 0 300 100' height='100px' preserveAspectRatio='none' version='1.1' viewBox='0 0 300 100' width='300px' x='0px' xml:space='preserve' y='0px'>
	<path class='deco-layer deco-layer--4' d='M-34.667,62.998c0,0,56-45.667,120.316-27.839C167.484,57.842,197,41.332,232.286,30.428	c53.07-16.399,104.047,36.903,104.047,36.903l1.333,36.667l-372-2.954L-34.667,62.998z' fill='#FFFFFF'></path>
	</svg>
    </div>

    <div class="card-body bg-white mt-0 shadow">
	<ul class="list-unstyled mb-5 position-relative">
	    <li>{{$p->no_devices}} Device</li>
	    <li>{{$p->no_agents}} Agents</li>
	    <li>{{$p->no_customers}} Customers</li>
	    <li>{{$p->no_transactions}} transactions</li>
	</ul> 
    <form action="{{route('plan_pay', ['id'=>$p->id])}}" method="POST">
        @csrf
        <?php 
            $metadata = [
                'plan_id'=> $p->id,'org_id' => Auth::user()->organisation_id,
            ];
            
        ?>
        <input type="hidden" value="{{$p->price}}" name="amount">
        <input type="hidden" name="currency" value="NGN">
        <input type="hidden" name="metadata" value="{{ json_encode($array = [
            'plan_id'=> $p->id, 
            'org_id' => Auth::user()->organization_id,
            "upgrade" => 0,
            "plan_detail" => '',
            ]) }}" > 
        <input type="hidden" name="email" value="{{Auth::user()->email}}">
        <input type="hidden" name="reference" value="{{ Paystack::genTranxRef()}}">
        <button type="submit" class="btn btn-lg btn-block btn-custom ">Pay</button>
    </form>
    </div>
</div>
@endif


@endforeach

{{-- <div class="col-3 princing-item">
    <div class="pricing-divider">
	<h3 class="text-light">BASIC</h3>
	<h4 class="my-0 display-2 text-light font-weight-normal mb-3"><span class="h3">₦</span> 5000 <span class="h5">/month</span></h4> 
	<svg class='pricing-divider-img' enable-background='new 0 0 300 100' height='100px' preserveAspectRatio='none' version='1.1' viewBox='0 0 300 100' width='300px' x='0px' xml:space='preserve' y='0px'>
	<path class='deco-layer deco-layer--4' d='M-34.667,62.998c0,0,56-45.667,120.316-27.839C167.484,57.842,197,41.332,232.286,30.428	c53.07-16.399,104.047,36.903,104.047,36.903l1.333,36.667l-372-2.954L-34.667,62.998z' fill='#FFFFFF'></path>
	</svg>
    </div>

    <div class="card-body bg-white mt-0 shadow">
	<ul class="list-unstyled mb-5 position-relative">
	    <li>10 Device only</li>
	    <li>15 Agents</li>
	    <li>100 customers</li>
	    <li>500 transactions Per month</li>
	</ul> <button type="button" class="btn btn-lg btn-block btn-custom ">Pay now </button>
    </div>
</div> --}}

</div>

</div>
@endsection
