@extends('layouts.index')

@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="page-header-title">
                    <h5 class="m-b-10">Create Customers<!--Customer--> {{ $agent != null ? ' - '.$agent->name : ' '}} </h5>
                </div>
            </div>
            <div class="col-md-4">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{route('home')}}"> <i class="fa fa-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Create Customers</a>
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
                <div class="row">
                    <div class="col-sm-12">
			            <div class="card">
                              <div class="card-header">
                                  <h5>Enter phone to check if customer exist</h5>
                                  <!--<span>Add class of <code>.form-control</code> with <code>&lt;input&gt;</code> tag</span>-->
                              </div>
                              <div class="card-block">
                                  <div class="form-material">
				                    <div class="form-group form-default">
                                          <input type="number" id="c_phone" name="c_phone" value="{{old('phone')}}" class="form-control" required="">
                                          <span class="form-bar"></span>
                                          <label class="float-label">Phone</label>
                                          @error('c_phone')
                                                <Span style="color: red;">{{$message}}</Span>
                                          @enderror
                                      </div>
                                      {{-- <div class="form-group form-default">
                                          <input type="submit" class="btn btn-primary" value="Register" id="">
                                      </div> --}}
                                    </div>
                              </div>
                            </div>
		                </div>


                    <div class="col-sm-12" id="c_form" style="display: none;">
			            <div class="card">
                              <div class="card-header">
                                  <h5>Customer Not Found, Create One</h5>
                                  <!--<span>Add class of <code>.form-control</code> with <code>&lt;input&gt;</code> tag</span>-->
                              </div>
                              <div class="card-block">
                                  <form class="form-material" method="POST" action="{{route('create_customer')}}">
					                    @csrf

                                      <div class="form-group form-default">
                                          <input type="text" name="name" value="{{old('name')}}" class="form-control" required="">
                                          <span class="form-bar"></span>
                                          <label class="float-label">Name</label>
                                          @error('name')
                                                <Span style="color: red;">{{$message}}</Span>
                                          @enderror
                                      </div>
                                      <div class="form-group form-default">
                                          <input type="email" name="email" value="{{old('email')}}" class="form-control" required="">
                                          <span class="form-bar"></span>
                                          <label class="float-label">Email (exa@gmail.com)</label>
                                          @error('email')
                                                <Span style="color: red;">{{$message}}</Span>
                                          @enderror
                                      </div>
				                    <div class="form-group form-default">
                                        <input type="hidden" id="phone" name="phone"required="">
                                          <input type="number" id="phone_d" disabled value="{{old('phone')}}" class="form-control" required="">
                                          <span class="form-bar"></span>
                                          <label class="label">Phone</label>
                                          @error('phone')
                                                <Span style="color: red;">{{$message}}</Span>
                                          @enderror
                                      </div>
                                      <div class="row">
                                          <div class="col-sm-8">
                                            <div class="form-group form-default">
                                                <input type="text" name="address" value="{{old('address')}}" class="form-control" required="">
                                                <span class="form-bar"></span>
                                                <label class="float-label">Address</label>
                                                @error('address')
                                                      <Span style="color: red;">{{$message}}</Span>
                                                @enderror
                                            </div>
                                          </div>
                                          <div class="col-sm-4">
                                              <?php $agents = \App\Models\Agent::where('org_id', '=', Auth::user()->organization_id)->get(); ?>

                                              <div class="form-group">
						                          <select name="agent" class="form-control"  required>
                                                      @if ($agent != null)
                                                      <option value="{{$agent->id}}">{{$agent->name}}</option>
                                                      @endif
						                        	 @foreach ($agents as $a)
						                        	 <option value="{{$a->id}}">{{$a->name}}</option>
						                        	 @endforeach
						                          </select>
						                          <span class="form-bar"></span>
						                          <label class="float-label">Agent</label>
                                                  @error('agent')
                                                          <Span style="color: red;">{{$message}}</Span>
                                                    @enderror
						                      </div>
                                            {{-- <input type="hidden" name="agent" value="{{$agent->id}}"> --}}
                                          </div>
                                      </div>
				      <div class="row">
                          <div class="col-sm-4">

                                <div class="form-group form-default">
                                  <select name="country" class="form-control" required id="country-select">
                                      <option value="nigeria">Nigeria</option>
                                  </select>
                                <span class="form-bar"></span>
                                <label class="float-label">Country:</label>
                                @error('country')
                                      <Span style="color: red;">{{$message}}</Span>
                                @enderror
                              </div>
                            </div>
                            <div class="col-sm-4">
                                 <div class="form-group form-default">
                                     <select name="state" class="form-control" id="state-select"></select>
                                   <span class="form-bar"></span>
                                   <label class="float-label">State:</label>
                                   @error('state')
                                                         <Span style="color: red;">{{$message}}</Span>
                                                   @enderror
                                 </div>
                            </div>
                            <div class="col-sm-4">
                                        <div class="form-group form-default">
                                            <select name="lga" class="form-control" id="lga-select"></select>
                                        <span class="form-bar"></span>
                                        <label class="float-label">LGA:</label>
                                        @error('lga')
                                                          <Span style="color: red;">{{$message}}</Span>
                                                    @enderror
                                        </div>
                            </div>
				      </div>



                                      <div class="form-group form-default">
                                          <input type="submit" class="btn btn-primary" value="Register" id="">
                                      </div>
                                  </form>
                              </div>
                            </div>
		    </div>


            <div class="col-sm-12" id="c_info" style="display: none;">
                         <div class="card shadow" style="width:100%;">
                          <div class="card-body">
                              <div class="row">
                                <div class="col-sm-12">
                                    <h5>Customer Already Exist</h5>
                                  {{-- <a class="btn btn-primary" onclick="edit()" style="color: white;">Edit</a>
                                   <a class=" btn btn-success" href="{{route('export_customers_pdf', ['username'=>$agent->username])}}" >Export Customers Qr Code</a> --}}
                                </div>
                              </div>
                              <br>
                              <br>
                            <div class="row">
                              <div class="col-sm-3">
                                <h6 class="mb-0" style="float: right;">Name: </h6>
                              </div>
                              <div class="col-sm-9 text-secondary" id="n">

                              </div>
                            </div>
                            {{-- <hr> --}}
                            <div class="row">
                              <div class="col-sm-3">
                                <h6 class="mb-0" style="float: right;">Email: </h6>
                              </div>
                              <div class="col-sm-9 text-secondary" id="e">
                              </div>
                            </div>
                            {{-- <hr> --}}
                            <div class="row">
                              <div class="col-sm-3">
                                <h6 class="mb-0" style="float: right;">Phone: </h6>
                              </div>
                              <div class="col-sm-9 text-secondary" id="p">
                              </div>
                            </div>
                            {{-- <hr> --}}
                            <div class="row">
                              <div class="col-sm-3">
                                <h6 class="mb-0" style="float: right;">Address: </h6>
                              </div>
                              <div class="col-sm-9 text-secondary" id="a">
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-sm-3">
                                <h6 class="mb-0" style="float: right;">Country: </h6>
                              </div>
                              <div class="col-sm-9 text-secondary" id="c">
                              </div>
                            </div>
                            <br>
                            <hr>
                            <br>
                            <form action="{{route('add_customer_to_agent')}}" class="form-material" method="POST">
                                @csrf
                            <div class="row">
                              <div class="col-sm-5">
                                    <div class="form-group">
						                <select name="agent" class="form-control"  required>
                                            @if ($agent != null)
                                            <option value="{{$agent->id}}">{{$agent->name}}</option>
                                            @endif
						              	    @foreach ($agents as $a)
						              	    <option value="{{$a->id}}">{{$a->name}}</option>
						              	    @endforeach
						                </select>
						                <span class="form-bar"></span>
						                <label class="float-label">Agent</label>
                                        @error('agent')
                                                <Span style="color: red;">{{$message}}</Span>
                                          @enderror
						            </div>
                                    <input type="hidden" name="customer" id="c_a_id">
                                </div>
                                <div class="col-sm-3">
                                    <button class="btn btn-primary" type="submit">Add customer to Agent</button>
                                </div>
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
<script>
    $(document).ready(function () {

        $('#c_phone').on('keyup',function() {
            let query = $('#c_phone').val();
	    if (query.length <= 11) {
            	$.ajax({
            	    url:"{{ route('check_customer_by_phone') }}",
            	    type:"GET",
            	    data:{'cus':query},

            	    success:function (data) {
                        if (!data) {
                            $('#c_info').css('display', 'none');
                            $('#c_form').css("display", 'block');
                            $('#phone').val($('#c_phone').val());
                            $('#phone_d').val($('#c_phone').val());
                        }else{
                            addr = data['address'] + ' ' + data['lga'] + ', ' + data['state'];
                            $('#c_form').css("display", 'none');
                            $('#c_info').css('display', 'block');
                            $('#n').html(data['name']);
                            $('#e').html(data['email']);
                            $('#p').html(data['phone']);
                            $('#a').html(addr);
                            $('#c').html(data['country']);
                            $('#c_a_id').val(data['id']);
                            console.log(data);
                        }
			            console.log(data['name']);
            	    }
            }).fail(function() {
		    $('#aac').css('display', 'none');
  		  	$('#ben_name').html("Beneficiary Not Found!");
  		})
	    }else{
		     $('#aac').css('display', 'none');
	    }
            // end of ajax call
        });

    });
</script>
@endsection
