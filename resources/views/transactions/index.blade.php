@extends('layouts.index')

@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="page-header-title">
                    <h5 class="m-b-10">Transactions</h5>
                </div>
            </div>
            <div class="col-md-4">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{route('home')}}"> <i class="fa fa-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#">transaction</a>
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
		<div class="row">
                    <div class="col-sm-12">
			    <div class="card">
                              <div class="card-header">
                                  <h5>Load transactions</h5>
                                  <!--<span>Add class of <code>.form-control</code> with <code>&lt;input&gt;</code> tag</span>-->
                              </div>
                              <div class="card-block">
                                  <form class="form-material" method="POST" action="{{route('get_transaction_list')}}">
					@csrf
                                      <div class="form-group form-default">
                                          {{-- <input type="text" name="name" value="{{old('name')}}" class="form-control" required=""> --}}
					  <input name="daterange" value="{{old('daterange')}}" required class="form-control" id="range" type="text" >
                                          <span class="form-bar"></span>
                                          <label class="float-label">Chooce Range <small>(from - to)</small></label>
					  <p class="" id="small"></p>
                                          @error('daterange')
                                                <Span style="color: red;">{{$message}}</Span>
                                          @enderror
                                      </div><br>
				      <div class="form-group form-default">
					  <select id="req_type" name="request_type" class="form-control">
						  <option value="all">All</option>
						  <option value="agent">By Agent</option>
						  <option value="customer">By Customer</option>
						  <option value="device">By Device</option>
						  {{-- <option value="item">By Item</option> --}}
					  </select>
                                          {{-- <input type="text" id="customer" name="customer" value="{{old('cus')}}" class="form-control"> --}}
                                          <span class="form-bar"></span>
                                          <label class="float-label"><b>Load Type:</b></label>
                                          @error('request_type')
                                                <Span style="color: red;">{{$message}}</Span>
                                          @enderror
                                      </div><br>
				      <div class="form-group form-default" id="search_req" style="display: none;">
                                          <input type="text" id="s_d" name="s_d" class="form-control">
                                          <span class="form-bar"></span>
                                          <label class="float-label"><b>Search</b> :</label>
                                          
                                      </div>
				      <div class="form-group form-default" id="data_list"></div>
                                      <div class="form-group form-default">
                                          <input type="submit" class="btn btn-primary" id="load"  value="Load" style="float: right;" id="">
                                      </div>
                                  </form>
                              </div>
                            </div>
		    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('script')

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
</script>
 <script type="text/javascript">
$(document).ready(function () {
             

	$('#req_type').on('change', function() {
        var req_value = this.value;

          if (req_value == "agent" || req_value == "customer" || req_value == "device" || req_value == "item") {   
		
		$('#search_req').css('display', 'block');
		$('#data_list').css('display', 'block');
		// document.getElementById('load').disabled = true;
		$('#load').css('display', 'none');
 		$('#s_d').on('keyup',function() {
        	    var query = $(this).val(); 
        	    $.ajax({
		
        	        url:"{{ route('search_data_t') }}",
		
        	        type:"GET",
		
        	        data:{'data':query, 'req_type':req_value},
		
        	        success:function (data) {
			
        	            $('#data_list').html(data);
			//     console.log(data);
        	        }
        	    })
        	    // end of ajax call
        	});

        
          }else{
		$('#search_req').css('display', 'none');
		$('#data_list').css('display', 'none');
        $('#load').css('display', 'block');
	  }
    	});
});
</script>
@endsection
