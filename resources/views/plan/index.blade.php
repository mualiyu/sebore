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
             <a href="{{url('/')}}" style="color: white; font-size:25px; text-decoration:bold;"><img src="assets/images/auth/Logo-small-bottom.png" style="width: 40px; height:40px;" alt="small-logo.png">  <b>ATS</b></a>
        </div>
<div class="row m-auto text-center w-100" >

<div class="col-3 princing-item">
    <div class="pricing-divider">
	<h3 class="text-light">FREE</h3>
	<h4 class="my-0 display-2 text-light font-weight-normal mb-3"><span class="h3">₦</span> 0.00 <span class="h5">/month</span></h4> 
	<svg class='pricing-divider-img' enable-background='new 0 0 300 100' height='100px' preserveAspectRatio='none' version='1.1' viewBox='0 0 300 100' width='300px' x='0px' xml:space='preserve' y='0px'>
	<path class='deco-layer deco-layer--4' d='M-34.667,62.998c0,0,56-45.667,120.316-27.839C167.484,57.842,197,41.332,232.286,30.428	c53.07-16.399,104.047,36.903,104.047,36.903l1.333,36.667l-372-2.954L-34.667,62.998z' fill='#FFFFFF'></path>
	</svg>
    </div>

    <div class="card-body bg-white mt-0 shadow">
	<ul class="list-unstyled mb-5 position-relative">
	    <li>3 Device only</li>
	    <li>3 Agents</li>
	    <li>15 customers</li>
	    <li>100 transactions Per month</li>
	</ul> <button type="button" class="btn btn-lg btn-block btn-custom ">Procced</button>
    </div>
</div>

<div class="col-3 princing-item">
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
</div>

<div class="col-3 princing-item red">
    <div class="pricing-divider ">
	<h3 class="text-light">STANDARD</h3>
	<h4 class="my-0 display-2 text-light font-weight-normal mb-3"><span class="h3">₦</span> 6500 <span class="h5">/month</span></h4> 
	<svg class='pricing-divider-img' enable-background='new 0 0 300 100' height='100px' id='Layer_1' preserveAspectRatio='none' version='1.1' viewBox='0 0 300 100' width='300px' x='0px' xml:space='preserve' y='0px'>
	    <path class='deco-layer deco-layer--4' d='M-34.667,62.998c0,0,56-45.667,120.316-27.839C167.484,57.842,197,41.332,232.286,30.428	c53.07-16.399,104.047,36.903,104.047,36.903l1.333,36.667l-372-2.954L-34.667,62.998z' fill='#FFFFFF'></path>
	</svg>
    </div>
    <div class="card-body bg-white mt-0 shadow">
	<ul class="list-unstyled mb-5 position-relative">
	    <li>20 Device only</li>
	    <li>25 Agents</li>
	    <li>200 customers</li>
	    <li>1000 transactions Per month</li>
	</ul> <button type="button" class="btn btn-lg btn-block btn-custom ">Pay now </button>
    </div>
</div>

<div class="col-3 princing-item red">
    <div class="pricing-divider ">
	<h3 class="text-light">PREMIUM</h3>
	<h4 class="my-0 display-2 text-light font-weight-normal mb-3"><span class="h3">₦</span> 8000 <span class="h5">/month</span></h4> 
	<svg class='pricing-divider-img' enable-background='new 0 0 300 100' height='100px' preserveAspectRatio='none' version='1.1' viewBox='0 0 300 100' width='300px' x='0px' xml:space='preserve' y='0px'>
	<path class='deco-layer deco-layer--4' d='M-34.667,62.998c0,0,56-45.667,120.316-27.839C167.484,57.842,197,41.332,232.286,30.428	c53.07-16.399,104.047,36.903,104.047,36.903l1.333,36.667l-372-2.954L-34.667,62.998z' fill='#FFFFFF'></path>
	</svg>
    </div>
    <div class="card-body bg-white mt-0 shadow">
	<ul class="list-unstyled mb-5 position-relative">
	    <li>100 Device only</li>
	    <li>Unlimited Agents</li>
	    <li>Unlimited customers</li>
	    <li>Unlimited transactions Per month</li>
	</ul> <button type="button" class="btn btn-lg btn-block btn-custom ">Pay now </button>
    </div>
</div>

</div>

</div>
@endsection
