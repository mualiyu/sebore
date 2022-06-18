@extends('layouts.index')

@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="page-header-title">
                    <h5 class="m-b-10">OTP - Verification</h5>
                </div>
            </div>
            <div class="col-md-4">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{route('home')}}"> <i class="fa fa-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#">UnKnown</a>
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
		     {{-- @include('layouts.flash') --}}
                <!-- Basic table card start -->
		<div class="row">
                    <div class="col-sm-12">
			    <div class="card">
                              <div class="card-block">
                                  <form class="form-material" id="otp_form" method="POST" action="{{route('verify_otp_eyowo')}}">
					@csrf
					<input type="hidden" name="gateway" value="{{$info->gateway}}">
					<input type="hidden" name="client_id" value="{{$info->client_id}}">
					<input type="hidden" name="name" value="{{$info->name}}">
					<input type="hidden" name="eyowo_c_id" value="{{$val_info->id}}">
					<input type="hidden" name="eyowo_c_mobile" value="{{$val_info->mobile}}">
				      <div class="form-group form-default">
                                          <input type="text" id="otp" name="otp" value="" class="form-control">
                                          <span class="form-bar"></span>
                                          <label class="float-label">Enter <b>OTP</b>:</label>
                                          @error('otp')
                                                <Span style="color: red;">{{$message}}</Span>
                                          @enderror
                                      </div>
                                      <div class="form-group form-default">
					      {{-- <a  onclick="
                           			 if(confirm('Are you sure You want to Pay All Transactions ? ')){
                           			     document.getElementById('otp-form').submit();
                           			 }
                           			     event.preventDefault();"
                           			 class="btn btn-primary" 
                           			 style="color: black">
                           			 Confirm
                           			</a> --}}
                                          <input type="button" class="btn btn-primary"  value="Confirm" style="float: right;" id="submit">
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
<script type="text/javascript">
$(document).ready(function () {
             
        $('#submit').on('click',function() {
            var query = $('#otp_form').serialize(); 
            // console.log(query);
            $.ajax({
               
                url:"{{ route('verify_otp_eyowo') }}",
          
                type:"GET",
               
                data:{'customer':query},
               
                success:function (data) {
                  
                    // $('#customer_list').html(data);
		    console.log(data);
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
