@extends('layouts.index')

@section('content')
<!-- Page-header start -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="page-header-title">
                    <h5 class="m-b-10">Dashboard</h5>
                </div>
            </div>
            <div class="col-md-4">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{route('home')}}"> <i class="fa fa-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Dashboard</a>
                    </li>
                    {{-- <li class="breadcrumb-item"><a href="#!">Sample Page</a>
                    </li> --}}
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
	            {{-- <div class="row">
                    <div class="alert alert-info alert-block" style="width: 100%;">
                        <strong>Transaction Record</strong>
                    </div>
                </div> --}}
                {{-- @extends('layouts.flash') --}}

                @if (count($transactions) > 0)    
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
                        <h6 class="mb-0" style="float: right;">Count</h6>
                      </div>
                      <div class="col-sm-9 text-secondary">
                        {{count($transactions ?? '')}}
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-3">
                        <h6 class="mb-0" style="float: right;">Date range </h6>
                      </div>
                      <div class="col-sm-9 text-secondary">
                          <?php $f = explode('-', $from); $from = $f[2]. ' '.$months[(int)$f[1]].', '.$f[0]; ?>
                          <?php $t = explode('-', $to); $to = $t[2].' '.$months[(int)$t[1]].', '.$t[0]; ?>
                        {{-- from {{$from}} to {{$to}} --}}
                        Today
                        <div id="small"></div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-3">
                        <h6 class="mb-0" style="float: right;">Total Quantities</h6>
                      </div>
                      <?php
                      $t_amount = 0;
                      $t_q = 0;
                        foreach ($transactions ?? '' as $t) {
                            $t_amount = $t_amount + $t->amount;
                            $t_q = $t_q + $t->quantity;
                        }
                      ?>
                      <div class="col-sm-9 text-secondary">
                        {{$t_q}} Liters
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-3">
                        <h6 class="mb-0" style="float: right;">Total Amount of All transactions is</h6>
                      </div>
                      <div class="col-sm-9 text-secondary">
                        NGN {{$t_amount}}
                      </div>
                    </div><br>
                  </div>
                </div>
                @else
                <div class="row">
                    <div class="alert alert-info alert-block" style="width: 100%;">
                        <strong>No Transaction History For Today!</strong>
                    </div>
                </div>
                @endif

                <div class="row">
                    <div class="col-xl-4 col-md-6">
                        <?php $users = \App\Models\User::where('organization_id', '=', Auth::user()->organization_id)->get(); ?>
                        <div class="card">
                            <div class="card-block">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h4 class="text-c" style="color: {{$card1 ?? ''}};">{{count($users)}}</h4>
                                        <h6 class="text-muted m-b-0">No of Users</h6>
                                    </div>
                                    <div class="col-4 text-right">
                                        <i class="fa fa-user f-28"></i>
                                    </div>
                                </div>
                            </div>
                            <a href="{{url('/users')}}">
                                <div class="card-footer" style="background: {{$card1 ?? ''}};">
                                    <div class="row align-items-center">
                                        <div class="col-9">
                                            <p class="text-white m-b-0">% Open</p>
                                        </div>
                                        <div class="col-3 text-right">
                                            <i class="fa fa-line-chart text-white f-16"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <?php $agents = \App\Models\Agent::where('org_id', '=', Auth::user()->organization_id)->get(); ?>
                        <div class="card">
                            <div class="card-block">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h4 class="text-c" style="color: {{$card2 ?? ''}};">{{count($agents)}}</h4>
                                        <h6 class="text-muted m-b-0">No of Agents</h6>
                                    </div>
                                    <div class="col-4 text-right">
                                        <i class="fa fa-users f-28"></i>
                                    </div>
                                </div>
                            </div>
                            <a href="{{url('/agents')}}">
                            <div class="card-footer" style="background: {{$card2 ?? ''}};">
                                <div class="row align-items-center">
                                    <div class="col-9">
                                        <p class="text-white m-b-0">% Open</p>
                                    </div>
                                    <div class="col-3 text-right">
                                        <i class="fa fa-line-chart text-white f-16"></i>
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <?php $devices = \App\Models\Device::where('org_id', '=', Auth::user()->organization_id)->get(); ?>
                        <div class="card">
                            <div class="card-block">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h4 class="text-c" style="color: {{$card3 ?? ''}};">{{count($devices)}}</h4>
                                        <h6 class="text-muted m-b-0">No of Device</h6>
                                    </div>
                                    <div class="col-4 text-right">
                                        <i class="ti-mobile f-28"></i>
                                    </div>
                                </div>
                            </div>
                            <a href="{{url('/devices')}}">
                            <div class="card-footer" style="background: {{$card3 ?? ''}};">
                                <div class="row align-items-center">
                                    <div class="col-9">
                                        <p class="text-white m-b-0">% Open</p>
                                    </div>
                                    <div class="col-3 text-right">
                                        <i class="fa fa-line-chart text-white f-16"></i>
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-xl-4 col-md-6">
                        <?php $categories = \App\Models\Category::where('org_id', '=', Auth::user()->organization_id)->get(); ?>
                        <div class="card">
                            <div class="card-block">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h4 class="text-c" style="color: {{$card3 ?? ''}};">{{count($categories)}}</h4>
                                        <h6 class="text-muted m-b-0">No of Categories</h6>
                                    </div>
                                    <div class="col-4 text-right">
                                        <i class="fa fa-table f-28"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer" style="background: {{$card3 ?? ''}};">
                                <div class="row align-items-center">
                                    <div class="col-9">
                                        <p class="text-white m-b-0">% Open</p>
                                    </div>
                                    <div class="col-3 text-right">
                                        <i class="fa fa-line-chart text-white f-16"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <?php $customers = \App\Models\Customer::where('org_id', '=', Auth::user()->organization_id)->get(); ?>
                        <div class="card">
                            <div class="card-block">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h4 class="text-c" style="color: {{$card2 ?? ''}};">{{count($customers)}}</h4>
                                        <h6 class="text-muted m-b-0">No of Customers</h6>
                                    </div>
                                    <div class="col-4 text-right">
                                        <i class="fa fa-users f-28"></i>
                                    </div>
                                </div>
                            </div>
                            <a href="{{url('/customers')}}">
                            <div class="card-footer" style="background: {{$card2 ?? ''}};">
                                <div class="row align-items-center">
                                    <div class="col-9">
                                        <p class="text-white m-b-0">% Open</p>
                                    </div>
                                    <div class="col-3 text-right">
                                        <i class="fa fa-line-chart text-white f-16"></i>
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <?php $items = \App\Models\Item::where('org_id', '=', Auth::user()->organization_id)->get(); ?>
                        <div class="card">
                            <div class="card-block">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h4 class="text-c" style="color: {{$card1 ?? ''}};">{{count($items)}}</h4>
                                        <h6 class="text-muted m-b-0">No of Items</h6>
                                    </div>
                                    <div class="col-4 text-right">
                                        <i class="ti-layout-grid2-alt f-28"></i>
                                    </div>
                                </div>
                            </div>
                            <a href="{{url('/items')}}">
                            <div class="card-footer" style="background: {{$card1 ?? ''}};">
                                <div class="row align-items-center">
                                    <div class="col-9">
                                        <p class="text-white m-b-0">% Open</p>
                                    </div>
                                    <div class="col-3 text-right">
                                        <i class="fa fa-line-chart text-white f-16"></i>
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div>
                    </div>

                </div>

                {{-- Payment history  --}}
                <?php 
                $tr = \App\Models\Transaction::where(['org_id' => Auth::user()->organization_id, 'p_status' => 1])->orderBy('updated_at', 'desc')->get();
                ?>
                @if (count($tr)>0)
                    
                <div class="card">
                    <div class="card-header">
                        <h5>Payments History</h5>
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
                            <table id="data_table" class="table-sm table-striped table-bordered dt-responsive nowrap " style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Customer name</th>
                                        <th>Customer phone</th>
                                        <th>Amount</th>
                                        <th>Item name</th>
                                        <th>Measure-Unit</th>
                                        <th>Quantity</th>
                                        <th>Time</th>
                                        <th>Agent</th>
                                        <th>Cummunity</th>
                                        <th>Status</th>
                                        <th>Bill Reference</th>
                                    </tr>
                                </thead>
                                <tbody>
                    <?php $i = 1;?>
                    @foreach ($tr as $t)
                    @if ($t->type != "sale")       
                    <?php $item = \App\Models\Item::find($t->item_id); ?>
                    
                        <tr>
                            <th scope="row">{{$i}}</th>
                            <td>{{$t->customer->name ?? "Null"}}</td>
                            <td>{{$t->customer->phone ?? "Null"}}</td>
                            <td>{{$t->amount}}</td>
                            <td>{{$item->item_cart->name ?? "Null"}}</td>
                            <td>{{$item->item_cart->measure ?? "Null"}} - {{$item->item_cart->unit ?? "Null"}}</td>
                            <td>{{$t->quantity}}</td>
                            <td>{{$t->updated_at}}</td>
                            <td>{{$t->agent->name ?? "Null"}}</td>
                            <td>{{$t->device->community ?? "Null"}}</td>
                            <td><span style="color: red;">{{$t->p_status==0 ? "Failed":""  ?? ""}}</span> <span style="color: green;">{{$t->p_status==1 ? "Successful":""  ?? ""}}</span></td>
                            <td>{{$t->ref_id ?? ""}}</td>
                
                            <?php $i++?>
                        </tr>
                    @endif
                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif

                
            </div>
        </div>
    </div>
</div>
@endsection
