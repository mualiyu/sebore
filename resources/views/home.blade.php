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

                <div class="row">
                    <!-- Bar Chart start -->
                    <div class="col-md-6 col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h5>Collections Summary</h5>
                                {{-- <span>Collections Chart Summary</span> --}}
                                {{-- <div style="float: right;"> --}}
                                <div class="card-header-right">
                                    <ul class="list-unstyled card-option">
                                        <li>
                                            <i class="fa fa-refresh load"  id="loader"></i>
                                        </li>
                                    </ul>
                                </div>
                                    <div class="row" style="margin-buttom:0;">
                                        <div class="col-5">
                                            <select id="req_type" placehoder="choose cartegory" name="request_type" class="form-control">
					                        	  {{-- <option value="all">All</option> --}}
					                        	  <option value="agents">Agents Summary</option>
					                        	  <option value="customers">Customers Summary</option>
					                        	  <option value="devices" >Community Summary</option>
					                        	  {{-- <option value="item">By Item</option> --}}
					                        </select>
                                            <label class="float-label px-3">Select Cartegory</label>
                                        </div>
                                        <div class="col-5">
                                            <input name="daterange" required class="form-control" id="range" type="text" >
                                            <span class="form-bar"></span>
                                            <label class="float-label">Chooce Range <small>(from - to)</small></label>
					                        
                                        </div>
                                        <div class="col-2">
                                            <button id="search" class="btn btn-primary btn-sm"> Search </button>
                                        </div>
                                    </div>
                                {{-- </div> --}}
                            </div>
                            <div class="card-block">
                                <div id="chartContainer">
                                    <p style="text-align: center; margin:0;">Select The Fields Above to Display Summary Charts!</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <div class="card">
                            <div class="card-header" >
                                <h5 id="bar-head">Chart Summary D3</h5>
                                <div class="card-header-right">
                                    <ul class="list-unstyled card-option">
                                        <li>
                                            <i class="fa fa-refresh load"  id="loader"></i>
                                        </li>
                                    </ul>
                                </div>
                                {{-- </div> --}}
                            </div>
                            <div class="card-block">
                                <svg width="100%" id="dd"></svg>
                                {{-- <div id="chartContainer">
                                    <p style="text-align: center; margin:0;">Select The Fields Above to Display Summary Charts!</p>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    <!-- Bar Chart Ends -->
                </div>

                {{-- Payment history  --}}
                <?php 
                $p_to = date('Y-m-d');
                $p_from = date('Y-m-d', strtotime($p_to. ' - 14 days'));
                $tr = \App\Models\Transaction::where(['org_id' => Auth::user()->organization_id, 'p_status' => 1])->orderBy('updated_at', 'desc')->whereBetween('date', [$p_from . '-00-00-01', $p_to . '-23-59-59'])->get();
                ?>
                @if (count($tr)>0)
                    
                <div class="card">
                    <div class="card-header">
                        <h5>Payments History <small>for two weeks</small></h5>
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
                            <td>{{$t->ref_id ?? ""}} transaction</td>
                
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

@section('script')
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>


 <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script>
$(function() {
    var start = moment().subtract(29, 'days');
    var end = moment();

    function cb(start, end) {
        $('#small').html(start.format('D MMMM, YYYY') + ' - ' + end.format('D MMMM, YYYY'));
    }
    $('input[name="daterange"]' || ' ').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);
    cb(start, end);
});


function query(range, type) {
    var range = range; 
    var req_type = type;

    $.ajax({
        url:"{{ route('bar_chart') }}",

        type:"GET",
        
        data:{'range':range, 'req_type':req_type},
        
        success:function (data) {  

            // console.log(data);
            // $("#chartContainer").css('height', '400px');

            // var chart = new CanvasJS.Chart("chartContainer", {
            //     animationEnabled: true,
            //     theme: "light2",
            //     title:{
            //         text: data['type']
            //     },
            //     axisY: {
            //         title: data['detail']+"(in Naira)"
            //     },
            //     data: [{
            //         type: "column",
            //         yValueFormatString: "#,##0.## Naira",
            //         dataPoints: data['data']
            //     }]
            // });
            
            // chart.render();

            // fsddfgfhgjhjkl

        var svg = d3.select("svg"),
            margin = 300,
            width = 200,
            height = 300;
        // width = svg.attr("width") - margin,
        // height = svg.attr("height") - margin;

        $('#bar-head').html(data['type']);

    var x = d3.scaleBand().range([0, width]).padding(0.4),
        y = d3.scaleLinear().range([height, 0]);

    var g = svg.append("g")
            .attr("transform", "translate(" + 50 + "," + 10 + ")");

    // var json = $.parseJSON(data['data']);
    var csv = JSON2CSV(data['data']);
    var blob = new Blob(["\ufeff", csv]);
    var url = URL.createObjectURL(blob);
    
    d3.csv(url, function(error, data) {
        if (error) {
            throw error;
        }
        // console.log(data);

        x.domain(data.map(function(d) { return d.year; }));
        y.domain([0, d3.max(data, function(d) { return d.value; })]);

        g.append("g")
         .attr("transform", "translate(0," + height + ")")
         .call(d3.axisBottom(x))
         .append("text")
         .attr("y", height - 120)
         .attr("x", width - 45)
         .attr("text-anchor", "end")
         .attr("stroke", "black")
         .text(data['type']);

        g.append("g")
         .call(d3.axisLeft(y).tickFormat(function(d){
             return "$" + d;
         }).ticks(10))
         .append("text")
         .attr("transform", "rotate(-90)")
         .attr("y", 6)
        //  .attr("dy", "-5.1em")
         .attr("text-anchor", "end")
         .attr("stroke", "black")
         .text(data['detail']);

        g.selectAll(".bar")
         .data(data)
         .enter().append("rect")
         .attr("class", "bar")
         .on("mouseover", onMouseOver) //Add listener for the mouseover event
         .on("mouseout", onMouseOut)   //Add listener for the mouseout event
         .attr("x", function(d) { return x(d.year); })
         .attr("y", function(d) { return y(d.value); })
         .attr("width", x.bandwidth())
         .transition()
         .ease(d3.easeLinear)
         .duration(1000)
         .delay(function (d, i) {
             return i * 50;
         })
         .attr("height", function(d) { return height - y(d.value); });
    });
    
    //mouseover event handler function
    function onMouseOver(d, i) {
        d3.select(this).attr('class', 'highlight');
        d3.select(this)
          .transition()     // adds animation
          .duration(400)
          .attr('width', x.bandwidth() + 5)
          .attr("y", function(d) { return y(d.value) - 10; })
          .attr("height", function(d) { return height - y(d.value) + 10; });

        g.append("text")
         .attr('class', 'val') 
         .attr('x', function() {
             return x(d.year);
         })
         .attr('y', function() {
             return y(d.value) - 15;
         })
         .text(function() {
             return [ '$' +d.value];  // Value of the text
         });
    }

    //mouseout event handler function
    function onMouseOut(d, i) {
        // use the text label class to remove label on mouseout
        d3.select(this).attr('class', 'bar');
        d3.select(this)
          .transition()     // adds animation
          .duration(400)
          .attr('width', x.bandwidth())
          .attr("y", function(d) { return y(d.value); })
          .attr("height", function(d) { return height - y(d.value); });

        d3.selectAll('.val')
          .remove()
    }

    $('#dd').css('height', height+50);

    // hrasdfglhlkjh

	        
        }
    })
}



function JSON2CSV(objArray) {
    var array = typeof objArray != 'object' ? JSON.parse(objArray) : objArray;
    var str = '';
    var line = '';

    str +='value,year' + "\r\n";

    if ($("#labels").is(':checked')) {
        var head = array[0];
        if ($("#quote").is(':checked')) {
            for (var index in array[0]) {
                var value = index + "";
                line += '"' + value.replace(/"/g, '""') + '",';
            }
        } else {
            for (var index in array[0]) {
                line += index + ',';
            }
        }

        line = line.slice(0, -1);
        str += line + '\r\n';
    }

    for (var i = 0; i < array.length; i++) {
        var line = '';

        if ($("#quote").is(':checked')) {
            for (var index in array[i]) {
                var value = array[i][index] + "";
                line += '"' + value.replace(/"/g, '""') + '",';
            }
        } else {
            for (var index in array[i]) {
                line += array[i][index] + ',';
            }
        }

        line = line.slice(0, -1);
        
        str += line + '\r\n';
    }
    console.log(str);
    return str;
}

$(document).ready(function () {
            
	$('#search').on('click', function() {
        var req_value = $('#req_type option:selected').val();

        var range = $('#range').val();
        
        query(range, req_value);
          
    	});
});


</script>

{{-- D3 script --}}
{{-- <script>

    var svg = d3.select("svg"),
        margin = 100,
        width = svg.attr("width") - margin,
        height = svg.attr("height") - margin;

    svg.append("text")
       .attr("transform", "translate(100,0)")
       .attr("x", 50)
       .attr("y", 50)
       .attr("font-size", "24px")
       .text("Customers stock report")

    var x = d3.scaleBand().range([0, width]).padding(0.4),
        y = d3.scaleLinear().range([height, 0]);

    var g = svg.append("g")
            .attr("transform", "translate(" + 100 + "," + 100 + ")");

    
    d3.csv("data.csv", function(error, data) {
        if (error) {
            throw error;
        }

        x.domain(data.map(function(d) { return d.year; }));
        y.domain([0, d3.max(data, function(d) { return d.value; })]);

        g.append("g")
         .attr("transform", "translate(0," + height + ")")
         .call(d3.axisBottom(x))
         .append("text")
         .attr("y", height - 250)
         .attr("x", width - 100)
         .attr("text-anchor", "end")
         .attr("stroke", "black")
         .text("Year");

        g.append("g")
         .call(d3.axisLeft(y).tickFormat(function(d){
             return "$" + d;
         }).ticks(10))
         .append("text")
         .attr("transform", "rotate(-90)")
         .attr("y", 6)
         .attr("dy", "-5.1em")
         .attr("text-anchor", "end")
         .attr("stroke", "black")
         .text("Amount collected");

        g.selectAll(".bar")
         .data(data)
         .enter().append("rect")
         .attr("class", "bar")
         .on("mouseover", onMouseOver) //Add listener for the mouseover event
         .on("mouseout", onMouseOut)   //Add listener for the mouseout event
         .attr("x", function(d) { return x(d.year); })
         .attr("y", function(d) { return y(d.value); })
         .attr("width", x.bandwidth())
         .transition()
         .ease(d3.easeLinear)
         .duration(400)
         .delay(function (d, i) {
             return i * 50;
         })
         .attr("height", function(d) { return height - y(d.value); });
    });
    
    //mouseover event handler function
    function onMouseOver(d, i) {
        d3.select(this).attr('class', 'highlight');
        d3.select(this)
          .transition()     // adds animation
          .duration(400)
          .attr('width', x.bandwidth() + 5)
          .attr("y", function(d) { return y(d.value) - 10; })
          .attr("height", function(d) { return height - y(d.value) + 10; });

        g.append("text")
         .attr('class', 'val') 
         .attr('x', function() {
             return x(d.year);
         })
         .attr('y', function() {
             return y(d.value) - 15;
         })
         .text(function() {
             return [ '$' +d.value];  // Value of the text
         });
    }

    //mouseout event handler function
    function onMouseOut(d, i) {
        // use the text label class to remove label on mouseout
        d3.select(this).attr('class', 'bar');
        d3.select(this)
          .transition()     // adds animation
          .duration(400)
          .attr('width', x.bandwidth())
          .attr("y", function(d) { return y(d.value); })
          .attr("height", function(d) { return height - y(d.value); });

        d3.selectAll('.val')
          .remove()
    }

</script> --}}
@endsection
