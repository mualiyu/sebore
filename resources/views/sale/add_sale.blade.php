@extends('layouts.index')
@section('style')
    <style>

label {
    width: 100%;
}

.card-input-element {
    display: none;
}

.card-input {
    margin: 10px;
    padding: 0px;
}

.card-input:hover {
    cursor: pointer;
}

.card-input-element:checked + .card-input {
     box-shadow: 0 0 1px 1px #2ecc71;
}
    </style>
@endsection

@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="page-header-title">
                    <h5 class="m-b-10"> Create Sale</h5>
                </div>
            </div>
            <div class="col-md-4">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{route('home')}}"> <i class="fa fa-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Create Sale</a>
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
       		 <br>
                <div class="row">
                    <div class="col-sm-12">
			    <div class="card">
                              <div class="card-header">
                                  <h5>Create Item</h5>
                                  <!--<span>Add class of <code>.form-control</code> with <code>&lt;input&gt;</code> tag</span>-->
                              </div>
                              <div class="card-block">
                                  <form class="form-material" method="POST" action="{{route('create_sale', ['id'=>$store->id])}}">
					@csrf
					<div class="row">
						<div class="col-md-6 col-lg-6 col-sm-6">
							<button type="button" class="btn btn-primary w-100" onclick="document.getElementById('modal_agent').style.display = 'block';">
								<i class="">+</i> Choose marketer</button>
							<br>
							<span id="agent_info"></span>
						</div>
						<div class="col-md-6 col-lg-6 col-sm-6">
							<button type="button" class="btn btn-primary w-100" onclick="document.getElementById('modal_store').style.display = 'block';">
								<i class="">+</i> choose Store keeper</button>
							<br>
							<span id="store_info"></span>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-md-6 col-lg-6 col-sm-6">
							<button type="button" class="btn btn-secondary w-100" onclick="document.getElementById('modal_item').style.display = 'block';">
								<i class="">+</i> Add Items</button>
							<br>
							<span id="item_info"></span>
						</div>
						<div class="col-md-6 col-lg-6 col-sm-6">
						<div class="form-group form-default">
                                      		    {{-- <input type="text" name="name" value="{{old('name')}}" class="form-control" required=""> --}}
						    <input name="daterange" value="{{old('daterange')}}" required class="form-control" id="range" type="text" >
                                      		    <span class="form-bar"></span>
                                      		    <label class="float-label">Chooce Range <small>(from - to)</small></label>
						    <p class="" id="small"></p>
                                      		    @error('daterange')
                                      		          <Span style="color: red;">{{$message}}</Span>
                                      		    @enderror
                                      		</div>
						</div>
					</div><br>
                                      <div class="form-group form-default">
                                          <input type="submit" class="btn btn-primary" value="Create Sale" id="">
                                      </div>

				      {{-- agents --}}
				      <div class="modal " style="display: none; with:80%;" id="modal_agent" data-backdrop="static" data-keyboard="false" tabindex="1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    			  <div class="modal-dialog modal-lg modal-scrollable" style="width:100%;">
                    			    <div class="modal-content">
                    			      <div class="modal-header">List Of Agents
                    			        <button type="button" class="close" data-dismiss="modal" onclick="document.getElementById('modal_agent').style.display = 'none';" aria-label="Close">
                    			          <span aria-hidden="true">&times;</span>
                    			        </button>
                    			      </div>
                    			      <div class="modal-body" style="height: 600px; overflow-y:scroll;">
							  <div class="row">
								  @foreach ($agents as $a)
								  @if ($a->role->type == "marketer")
								  <div class="col-md-6 col-lg-4 col-sm-6" onclick="document.getElementById('agent_info').innerHTML = '{{$a->name}}';">
									  <label>
									    <input type="radio" name="marketer_id" selected checked class="card-input-element" value="{{$a->id}}" />
									      <div class="card card-default card-input">
										<div class="card-header">{{$a->name}}</div>
										<div class="card-body">
										  Email : {{$a->email}} <br>
										  Role : {{$a->role->name}}
										</div>
									      </div>
									  </label>
									</div>
								  @endif    
								  @endforeach
							  </div>
                    			      </div>
                    			    </div>
                    			  </div>
                    			</div>


					{{-- store keeper --}}
					<div class="modal " style="display: none; with:80%;" id="modal_store" data-backdrop="static" data-keyboard="false" tabindex="1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    			  <div class="modal-dialog modal-lg modal-scrollable" style="width:100%;">
                    			    <div class="modal-content">
                    			      <div class="modal-header">List Of Store keepers
                    			        <button type="button" class="close" data-dismiss="modal" onclick="document.getElementById('modal_store').style.display = 'none';" aria-label="Close">
                    			          <span aria-hidden="true">&times;</span>
                    			        </button>
                    			      </div>
                    			      <div class="modal-body" style="height: 600px; overflow-y:scroll;">
							  <div class="row">
								  @foreach ($agents as $a)
								  @if ($a->role->type == "store")
								  <div class="col-md-6 col-lg-4 col-sm-6" onclick="document.getElementById('store_info').innerHTML = '{{$a->name}}';">
									  <label>
									    <input type="radio" name="store_keeper_id" selected checked class="card-input-element" value="{{$a->id}}" />
									      <div class="card card-default card-input">
										<div class="card-header">{{$a->name}}</div>
										<div class="card-body">
										  Email : {{$a->email}} <br>
										  Role : {{$a->role->name}}
										</div>
									      </div>
									  </label>
									</div>
								  @endif    
								  @endforeach
							  </div>
                    			      </div>
                    			    </div>
                    			  </div>
                    			</div>

					    {{-- items modal --}}
		    			<div class="modal " style="display: none; with:80%;" id="modal_item" data-backdrop="static" data-keyboard="false" tabindex="1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    			  <div class="modal-dialog modal-lg modal-scrollable" style="width:100%;">
                    			    <div class="modal-content">
                    			      <div class="modal-header">List Of Items
                    			        <button type="button" class="close" data-dismiss="modal" onclick="document.getElementById('modal_item').style.display = 'none';" aria-label="Close">
                    			          <span aria-hidden="true">&times;</span>
                    			        </button>
                    			      </div>
                    			      <div class="modal-body" style="height: 600px; overflow-y:scroll;">
							  <div class="row">
								  <?php $k = 0; ?>
								  @foreach ($items_in_store as $i)     
								  <div class="col-md-6 col-lg-4 col-sm-6">
									  <label>
									    <input type="checkbox" name="items[{{$k}}]" class="card-input-element" id="item_input[{{$k}}]" 
									    	onChange="
										    this.checked? document.getElementById('item_info').innerHTML += '{{$i->item->item_cart->name}}, ' : document.getElementById('item_info').innerHTML -= '{{$i->item->item_cart->name}}, '; 
										    document.getElementById('e[{{$i->item->id}}]').disabled = !this.checked;   
										    document.getElementById('q[{{$i->item->id}}]').disabled = !this.checked;"
										    value="{{$i->item->id}}"/>
									      <div class="card card-default card-input">
										<div class="card-header">{{$i->item->item_cart->name}}</div>
										<div class="card-body">
										  Measure : {{$i->item->item_cart->measure}} {{$i->item->item_cart->unit}} <br>
										  Quantity : <input type="number" style="width: 60px;" name="quantity[{{$i->item->id}}]" value="1" id="q[{{$i->item->id}}]" disabled> <br>
										  Expiration Date : <input type="text" placeholder="Format (day/month/year)" class="w-100" style=" font-size:12px;" name="expiration[{{$i->item->id}}]" id="e[{{$i->item->id}}]" disabled>
										</div>
									      </div>
									  </label>
									</div>
									<?php $k++; ?>
								  @endforeach
							  </div>
                    			      </div>
						</div>
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
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script>
$(function() {

    var start = moment();
    var end = moment().add(7, 'days');

    function cb(start, end) {
        $('#small').html(start.format('D MMMM, YYYY') + ' - ' + end.format('D MMMM, YYYY'));
    }

    $('input[name="daterange"]' || ' ').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
        //    'Today': [moment(), moment()],
        //    'This Month': [moment().startOf('month'), moment().endOf('month')],
        }
    }, cb);


    cb(start, end);

});
</script>
@endsection
