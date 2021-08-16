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
		<div class="row">
                    <div class="col-sm-12">
			    <div class="card">
                              <div class="card-header">
                                  <h5>Generate Payment</h5>
                                  <!--<span>Add class of <code>.form-control</code> with <code>&lt;input&gt;</code> tag</span>-->
                              </div>
                              <div class="card-block">
                                  <form class="form-material" method="POST" action="{{route('generate_pay')}}">
					@csrf
                                      <div class="form-group form-default">
                                          {{-- <input type="text" name="name" value="{{old('name')}}" class="form-control" required=""> --}}
					  <input name="daterange" value="{{old('daterange')}}" required class="form-control" id="range" type="text" >
                                          <span class="form-bar"></span>
                                          <label class="float-label">Chooce Range</label>
					  <p class="" id="small"></p>
                                          @error('daterange')
                                                <Span style="color: red;">{{$message}}</Span>
                                          @enderror
                                      </div><br>
				      <div class="form-group form-default">
                                          <input type="text" id="customer" name="customer" value="{{old('cus')}}" class="form-control">
                                          <span class="form-bar"></span>
                                          <label class="float-label"><b>Search</b> Name or Phone no:</label>
                                          @error('cus')
                                                <Span style="color: red;">{{$message}}</Span>
                                          @enderror
                                      </div>
				      <div class="form-group form-default" id="customer_list"></div>
                                      <div class="form-group form-default">
                                          <input type="submit" class="btn btn-primary"  value="Generate" style="float: right;" id="">
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
             
        $('#customer').on('keyup',function() {
            var query = $(this).val(); 
            $.ajax({
               
                url:"{{ route('customer_p') }}",
          
                type:"GET",
               
                data:{'customer':query},
               
                success:function (data) {
                  
                    $('#customer_list').html(data);
		//     console.log(data);
                }
            })
            // end of ajax call
        });

                
        // $(document).on('click', 'li', function(){
          
        //     var value = $(this).text();
        //     $('#customer').val(value);
        //     $('#customer_list').html("");
        // });
});
</script>
@endsection
