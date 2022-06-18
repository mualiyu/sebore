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
/* #up_btn {
    cursor:unset;
} */

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
                    <h5 class="m-b-10">Store Info</h5>
                </div>
            </div>
            <div class="col-md-4">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{route('home')}}"> <i class="fa fa-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#">Store</a>
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
			<div class="col-md-5 col-sm-4">
				<div class="card shadow" style="width:100%;">
				    <div class="card-body">  
				      <div class="row">
					<div class="col-sm-3">
					  <h5 class="mb-0" style="float: right;">Store Info</h5>
					</div>
					<div class="col-sm-3"></div>
					<div class="col-sm-3"></div>
					<div class="col-sm-3">
						<a href="{{route('sale_index', ['id'=>$store->id])}}" style="float: right" class="btn btn-primary">Sales</a>
					</div>
				      </div>
				      <hr>
				      <div class="row">
					<div class="col-sm-3">
					  <h6 class="mb-0" style="float: right;">Name:</h6>
					</div>
					<div class="col-sm-9 text-secondary">
					  {{$store->name}}
					</div>
				      </div>
				      <div class="row">
					<div class="col-sm-3">
					  <h6 class="mb-0" style="float: right;">Location:</h6>
					</div>
					<div class="col-sm-9 text-secondary">
					  {{$store->location}}
					</div>
				      </div>
				      <div class="row">
					    <div class="col-sm-3">
					      <h6 class="mb-0" style="float: right;">Total Items:</h6>
					    </div>
					    <div class="col-sm-9 text-secondary">
					      {{$store->total_num_of_items ?? "No"}} items
					    </div>
					  </div>
					<div class="row">
					    <div class="col-sm-3">
					      <h6 class="mb-0" style="float: right;">Total Amount:</h6>
					    </div>
					    <div class="col-sm-9 text-secondary">
					      {{$store->total_amount ?? "0"}} NGN
					    </div>
					  </div>
				       <div class="row">
					     <div class="col-sm-3">
					       <h6 class="mb-0" style="float: right;">Date Created: </h6>
					     </div>
					     <div class="col-sm-9 text-secondary">
						{{$store->created_at}}
					       <div id="small"></div>
					     </div>
					   </div>
				    </div>
				  </div>
			</div>
			<div class="col-md-7 col-sm-8">
				<div class="card">
                        <div class="card-header">
                            <h5>Store Keepers</h5>
			    <div style="float: right">
				<a href="#" onclick="document.getElementById('modal_agent').style.display = 'block';" class="btn btn-primary">Add Agent</a>
			    </div>
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
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>phone</th>
					    <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
					    <?php $i = 1;?>
					    
                        
				        @foreach ($store->agents as $a)
					
					<tr>
						<th scope="row">{{$i}}</th>
						<td>{{$a->name}}</td>
                        			<td>{{$a->phone}}</td>
						<td>
						  {{-- <a href="" class="btn btn-success">Open</a> --}}
                        			  <a  onclick="
                        			      if(confirm('Are you sure You want to Remove this Agent -({{$a->name}})? ')){
                        			          document.getElementById('remove_a_form[{{$i}}]').submit();
                        			      }
                        			          event.preventDefault();"
                        			      class="btn btn-warning" 
                        			      style="color: black; background:red;">
                        			      remove
                        			  </a>
                        			  <form method="POST" id="remove_a_form[{{$i}}]" action="{{route('store_remove_agent', ['s_id'=>$store->id, 'a_id'=>$a->id])}}">
                        			        @csrf 
                        			    </form>
						</td>
						<?php $i++?>
					</tr>
					@endforeach
					@if (count($store->agents) == 0)
					    <tr>
						    <td colspan="5" style="text-align: center"> No store Agents yet.... Wanna Create One? <a href="#" onclick="document.getElementById('modal_agent').style.display = 'block';">Click here</a> </td>
					    </tr>
					@endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
			</div>
		</div>

		<div class="row">
		<div class="col-12">
			<div class="card">
			    <div class="card-header">
				<h5>Items</h5>
				<div style="float: right; margin-right:10px;">
				    <a href="#" onclick="document.getElementById('modal_item').style.display = 'block';" class="btn btn-primary">Add item</a>
				</div>
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
						<th>Item name</th>
						<th>Item amount</th>
						<th>Quantity</th>
						<th>Total Amount</th>
						<th>Action</th>
					    </tr>
					</thead>
					<tbody>
						<?php $i = 1;?>
						
			    
					    @foreach ($items_in_store as $si)
					    
					    <tr>
					    
						    <th scope="row">{{$i}}</th>
						    <td>{{$si->item->item_cart->name}}</td>
						    <td id="am">{{$si->item->item_cart->measure}} NGN</td>
						    <td>
							    <form action="{{route('store_update_item', ['s_id'=>$store->id, 'i_id'=>$si->item->id])}}" method="POST" id="item_form[{{$i}}]">
								@csrf
								<input type="number" style="width: 70px;" name="quantity" value="{{$si->quantity}}"/> cartons</td>
							    </form>
						    <td id="t_am">{{$si->amount}} NGN</td>
						    <td>
						      <input type="button" value="Update" onclick="
							  if(confirm('Are you sure You want to Update Item({{$si->item->item_cart->name}}) Quantity in this store?')){
							      document.getElementById('item_form[{{$i}}]').submit();
							  }
							      event.preventDefault();"
						       class="btn btn-success"
						      >
    
						      <a  onclick="
							  if(confirm('Are you sure You want to remove this Item -({{$si->item->item_cart->name}})? ')){
							      document.getElementById('delete-form[{{$i}}]').submit();
							  }
							      event.preventDefault();"
							  class="btn btn-warning" 
							  style="color: black; background:red;">
							  remove
						      </a>
						      <form method="POST" id="delete-form[{{$i}}]" action="{{route('store_remove_item', ['s_id'=>$store->id, 'i_id'=>$si->item->id])}}">
							    @csrf 
							</form>
						    </td>
						    <?php $i++?>
					    </tr>
					    @endforeach
					    @if (count($items_in_store) == 0)
						<tr>
							<td colspan="5" style="text-align: center"> No Items in this store yet.... Wanna Add One? <a href="#" onclick="document.getElementById('modal_item').style.display = 'block';">Click here</a> </td>
						</tr>
					    @endif
					</tbody>
				    </table>
				    
				</div>
			    </div>
			</div>
		</div>
		</div>

		<div class="modal" style="display: none" id="modal_agent" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Add Agent</h5>
                        <button type="button" class="close" onclick="document.getElementById('modal_agent').style.display = 'none';" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                          
                        <form action="{{route('store_add_agent', ["id" => $store->id])}}" method="POST">
                            @csrf
                            <div class="form-group">
				    <label class="mb-1" for="amount">keeper</label>
				    {{-- <input name="name" required class="form-control py-4" id="name" type="text" step="any" aria-describedby="nameHelp" placeholder="Enter Name" /> --}}
				    <select name="agent" required class="form-control" id="name">
					<option value="">Select</option>
					<?php $agents = \App\Models\Agent::where("org_id", "=", $store->org_id)->get(); ?>
					@foreach ($agents as $a)
					@if ($a->role->type == 'store')
					<option value="{{$a->id}}">{{$a->name}} ({{$a->phone}})</option>
					@endif
					{{-- <option value="" disabled> No Agent found with the role of Store Keeper in system</option> --}}
					@endforeach
				    </select>
				</div>
                            <div class="form-group">
                                <input name="submit" class="btn btn-primary" id="submit" type="submit" aria-describedby="nameHelp" value="Add Store keeper" />
                            </div>
                        </form>
                      </div>
                      <div class="modal-footer">
                      </div>
                    </div>
                  </div>
                </div>


		<div class="modal " style="display: none; with:80%;" id="modal_item" data-backdrop="static" data-keyboard="false" tabindex="1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg modal-scrollable" style="width:100%;">
		    <form action="{{route("store_add_items", ["id"=>$store->id])}}" method="POST">
			@csrf
		    <div class="modal-content">
                      <div class="modal-header">Add Item To Store
                        <button type="button" class="close" data-dismiss="modal" onclick="document.getElementById('modal_item').style.display = 'none';" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
		      <?php $items = \App\Models\Item::where("org_id", "=", Auth::user()->organization_id)->get(); $j = 1; ?>
                      <div class="modal-body" style="height: 400px; overflow-y:scroll;">
			<div class="row">
			  @foreach ($items as $i)     
			  <div class="col-md-6 col-lg-4 col-sm-6">
				  <label>
				    <input type="checkbox" name="items[{{$j}}]" selected class="card-input-element" 
				    		onChange="document.getElementById('q[{{$j}}]').disabled = !this.checked"  value="{{$i->id}}"/>
				      <div class="card card-default card-input">
					<div class="card-header">{{$i->item_cart->name}}</div>
					<div class="card-body">
					  Measure : {{$i->item_cart->measure}} {{$i->item_cart->unit}} <br>
					  Quantity : <input type="number" style="width: 100%;" name="q[{{$i->id}}]" id="q[{{$j}}]" value="1" disabled >
					</div>
				      </div>
				  </label>
				</div>
				<?php $j++; ?>
			  @endforeach
			</div>
                      </div>
		      <div class="modal-footer" >
			<button type="submit" class="btn btn-primary" aria-label="Submit">
                         Add Item
                        </button>
                      </div>
		    </div>
		    </form>
                  </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
