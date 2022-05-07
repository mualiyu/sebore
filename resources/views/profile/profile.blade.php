@extends('layouts.index')
@section('style')
    <style>
.load{
    
    -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
    </style>
@endsection
@section("script")
<script>
    function showUploadImage(src,target) {
        const fr = new FileReader();
        fr.onload = function(e) {  target.src = this.result;  };

        src.addEventListener("change", function() {
          fr.readAsDataURL(src.files[0]);
        });
      }

      function imageQ(s,t) {
        var src = document.getElementById(s);
        var target = document.getElementById(t);
        showUploadImage(src,target);
      }
</script>
 <script type="text/javascript">
$(document).ready(function () {

     $('#loader').hide();
             
        $('#submit_g').on('click',function() {
            var query = $('#gateway_form').serialize(); 
            // console.log(query);
            $.ajax({
               
                url:"{{ route('add_update_gateway_details') }}",
          
                type:"GET",
               
                data:query,

                beforeSend: function() // Do the following before sending the request
                {
                  //Upload progress
                  $('#card_eyowo').addClass("card-load");
                  $('#card_eyowo').append('<div class="card-loader"><i class="fa fa-spinner rotate-refresh"></div>');
                },

                // uploadProgress : function (event, position, total, percentComplete) {
                //   $('#prog').width(percentComplete+'%');
                //   $('#percent').html(percentComplete+'%');
                // },
               
                success:function (data) {
                     $('#card_eyowo').children(".card-loader").remove();
                     $('#card_eyowo').removeClass("card-load");
                    //  $('#loader').hide();
                  
                      if (data['error']) {
                          $('#error_p').css('display', 'block');
                          $('#error_c').html(data['error']);
                      }else{
                          $('input[name="otp_gateway"]').val(data['info']['gateway']);
                          $('input[name="otp_client_id"]').val(data['info']['client_id']);
                        //   $('input[name="otp_name"]').val(data['info']['name']);
                          $('input[name="otp_eyowo_c_id"]').val(data['val_info']['id']);
                          $('input[name="otp_eyowo_c_mobile"]').val(data['val_info']['mobile']);

                          $('#success_p').css('display', 'block');
                          $('#success_c').html(data['success']);
                          $('#modal_otp').css('display', 'block');
                      }
		    // console.log(data['info']['name']);
                }
            })
            // end of ajax call
        });



        // eddit gate way
        $('#submit_e_g').on('click',function() {
            var query = $('#gateway_e_form').serialize(); 
            // console.log(query);
            $.ajax({
               
                url:"{{ route('add_update_gateway_details') }}",
          
                type:"GET",
               
                data:query,

                beforeSend: function() // Do the following before sending the request
                {
                  //Upload progress
                  $('#card_eyowo').addClass("card-load");
                  $('#card_eyowo').append('<div class="card-loader"><i class="fa fa-spinner rotate-refresh"></div>');
                },

               
                success:function (data) {
                     $('#card_eyowo').children(".card-loader").remove();
                     $('#card_eyowo').removeClass("card-load");
                    //  $('#loader').hide();
                  
                      if (data['error']) {
                          $('#error_p').css('display', 'block');
                          $('#error_c').html(data['error']);
                      }else{
                          $('input[name="otp_gateway"]').val(data['info']['gateway']);
                          $('input[name="otp_client_id"]').val(data['info']['client_id']);
                        //   $('input[name="otp_name"]').val(data['info']['name']);
                          $('input[name="otp_eyowo_c_id"]').val(data['val_info']['id']);
                          $('input[name="otp_eyowo_c_mobile"]').val(data['val_info']['mobile']);

                          $('#success_p').css('display', 'block');
                          $('#success_c').html(data['success']);
                          $('#modal_otp').css('display', 'block');
                          $('#modal_gt').css('display', 'none');
                      }
		    // console.log(data['info']['name']);
                }
            })
            // end of ajax call
        });

});
</script>
@endsection

@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="page-header-title">
                    <h5 class="m-b-10">Profile</h5>
                </div>
            </div>
            <div class="col-md-4">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{route('home')}}"> <i class="fa fa-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#">Profile</a>
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
             <div class="alert alert-danger alert-block" id="error_p" style="display: none;"> 
                <button type="button" class="close" onclick="document.getElementById('error_p').style.display = 'none';">×</button>
                <strong id="error_c"></strong>
            </div>
            <div class="row">
                <div class="col-sm-4"></div>
                <div class="col-sm-4">
                    {{-- <div id="loader" class="loader"></div> --}}
                </div>
                <div class="col-sm-4"></div>
            </div>

		     <?php $oragnization = App\Models\Organization::find(Auth::user()->organization_id); ?>
		<div class="row">
			<div class="col-md-4">
				 <div class="card mb-3">
					<?php 
					if ($organization->logo) {
						$pic = $organization->logo;
					}else {
						$pic = "default.jpg";
					}
					?>
                         	   <div class="card-body text-center shadow"><img id="addimage" class="rounded-circle mb-5 mt-6" src="{{asset('storage/pic/'.$pic)}}" width="160" height="160">
					                <form action="{{route('update_org_pic', ['id'=>$organization->id])}}" method="POST" enctype="multipart/form-data">
					                	<div class="row">
					                		@csrf
					                		<div class="col-md-8">
					                			{{-- <input type="file" class="form-control" name="file"> --}}
					                			 <input class="form-control" type="file" id="addIsrc" onclick="imageQ('addIsrc','addimage');" name="image" value="default_category.png">
					                		</div>
					                		<div class="col-md-4">
					                			<button style="width: 100%;" class="btn btn-primary btn-sm" type="submit">Change Logo</button>
					                		</div>
					                	</div>
					                </form>
                         	   </div>
                </div>
			</div>
			<div class="col-md-8">
				<div class="row">
				<div class="card" style="width: 100%;">
                    <div class="card-header ">
                        <p class="text-primary m-0 font-weight-bold">User Settings</p>
                    </div>
                    <div class="card-body">
                                        <form  method="POST" action="{{route('update_user')}}">
						                    @csrf
                                            <div class="form-row">
                                                <div class="col">
                                                    <div class="form-group"><label for="username"><strong>Name</strong></label><input class="form-control" type="text" placeholder="Name" value="{{Auth::user()->name}}" name="name"></div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group"><label for="email"><strong>Email Address</strong></label><input class="form-control" value="{{Auth::user()->email}}" type="email" placeholder="user@example.com" name="email"></div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col">
                                                    <div class="form-group"><label for="first_name"><strong>Phone</strong></label><input class="form-control" value="{{Auth::user()->phone}}" type="number" placeholder="phone" name="phone"></div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group"><label for="last_name"><strong>Role</strong></label>
                                                        {{-- <input class="form-control" type="text" placeholder="Doe" name=""> --}}
                                                        <select name="role" id="" class="form-control">
                                                            <option value="{{Auth::user()->role->name ?? ''}}">{{Auth::user()->role->name ?? ''}}</option>
                                                            <?php $roles = \App\Models\AdminRole::all(); ?>
                                                            @foreach ($roles as $r)
                                                            <option value="{{$r->id}}">{{$r->name}}</option>
                                                            e.style.display == "n                                @endforeach
                                                            {{-- <option value="admin">Admin</option>
                                                            <option value="suppervisor">Suppervisor</option>
                                                            <option value="user">User</option> --}}
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group"><button class="btn btn-primary btn-sm" type="submit">Save Settings</button></div>
                                        </form>
                                    </div>
                                   
                                </div>
				</div>  
			</div>
		</div>
        <div class="row">
            <div class="col-md-4">
				<div class="card shadow" id="card_eyowo" style="width: 100%;">
                    <div class="card-header">
                        <p class="text-primary m-0 font-weight-bold">Payment Gateway Settings
                            <div class="card-header-right">
                                <ul class="list-unstyled card-option">
                                    <li>
                                        <i class="fa fa-refresh load"  id="loader"></i>
                                        {{-- <div id="loader" class="loader"></div> --}}
                                    </li>
                                    {{-- <li><i class="fa fa-window-maximize full-card"></i></li>
                                    <li><i class="fa fa-minus minimize-card"></i></li>
                                    <li><i class="fa fa-refresh reload-card"></i></li>
                                    <li><i class="fa fa-trash close-card"></i></li> --}}
                                </ul>
                            </div>
                        </p>
                    </div>
                    
                                    <div class="card-body" id="card_b">
                                        @foreach ($p_gateway as $p_g)
                                        <?php $mobile_money = \App\Models\MobileMoney::find($p_g->gateway_code); ?>
                                        @endforeach
                                        <?php $mobile_moneys = \App\Models\MobileMoney::all(); ?>
                                        <form method="" id="gateway_form">
                                             
						                    @csrf
                                            <div class="form-group"><label for="gateway"><strong>Select Gateway</strong></label>
                                                <select class="form-control" <?php foreach ($p_gateway as $p_g) {if($p_g->id > 0){ echo'disabled';}} ?> name="gateway" id="gateway">
                                                    @foreach ($p_gateway as $p_g)
                                                    <option value="{{$mobile_money->id}}">{{$mobile_money->name}}</option>
                                                    @endforeach
                                                    {{-- @if ($p_gateway[0]->id > 0)
                                                    @endif --}}
                                                    @foreach ($mobile_moneys as $m)
                                                        <option value="{{$m->id}}">{{$m->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @foreach ($p_gateway as $p_g)
                                                <div class="form-group"><label for="name"><strong>Token</strong></label>
                                                    <input class="form-control disabled" value="{{$p_g->token}}" disabled type="text" name="token">
                                                </div>
                                            @endforeach

					                        <div class="form-group">
                                                <label for="city"><strong>Wallet Id <small>(Eg. phone)</small></strong></label>
                                                <input class="form-control" value="{{$p_gateway[0]->client_id ?? ''}}" name="client_id">
                                            </div>
                                            @foreach ($p_gateway as $p_g)
                                            <div class="form-group"><button class="btn btn-primary btn-sm" type="button" onclick="$('#modal_gt').css('display', 'block');" >Edit&nbsp;Gateway</button></div>
                                            @endforeach

                                            <div class="form-group"><button <?php foreach ($p_gateway as $p_g) {if($p_g->id > 0){ echo'style="display:none;"';}} ?> class="btn btn-primary btn-sm" type="button" id="submit_g" >Save&nbsp;Gateway</button></div>
                                            
                                        </form>
                                    </div>
                                </div>
            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="card shadow" style="width: 100%;">
                                <div class="card-header">
                                    <p class="text-primary m-0 font-weight-bold">Organization Settings</p>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="{{route('update_organization', ['id'=>$oragnization->id])}}">
                                        @csrf
                                        <div class="form-group"><label for="address"><strong>Name</strong></label><input class="form-control" value="{{$oragnization->name}}" type="text" placeholder="john" name="name"></div>
                                        <div class="form-row">
                                            <div class="col">
                                                <div class="form-group"><label for="city"><strong>Description</strong></label><textarea class="form-control" value="{{$oragnization->description}}" name="description">{{$oragnization->description}}</textarea></div>
                                            </div>
                                            <div class="col">
                                                <?php 
                                                    $plan_detail = \App\Models\PlanDetail::where('org_id', '=', Auth::user()->organization_id)->orderBy('id', 'desc')->first();
                                                    $plan =  \App\Models\Plan::find($plan_detail->plan_id);
                                                ?>
                                                <div class="form-group"><label for="address"><strong>Plan</strong></label><input class="form-control" value="{{$plan->name}}" type="text" placeholder="john" name="name" disabled></div>
                                            </div>
                                        </div>
                    
                                        <div class="form-row">
                                            <div class="col">
                                                <div class="form-group"><label for="city"><strong>Phone</strong></label><input class="form-control" type="number" value="{{$oragnization->phone}}" placeholder="Phone" name="phone"></div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group"><label for="country"><strong>Address</strong></label><input class="form-control" type="text" value="{{$oragnization->address}}" placeholder="Sunset Blvd, 38" name="address"></div>
                                            </div>
                                             <div class="col">
                                                <div class="form-group"><label for="country"><strong>Select Theme</strong></label>
                                                    <select name="theme" id="theme" class="form-control">
                                                        <option value="{{$organization->theme ?? "1"}}"><?php if($organization->theme == 1){ echo 'Ajisaq Theme';}elseif($organization->theme == 2){ echo 'Green Theme';}elseif($organization->theme == 3){ echo 'Blue Theme';}else{echo 'Ajisaq Theme';} ?></option>
                                                        <option value="1">Ajisaq Theme</option>
                                                        <option value="2">Green Theme</option>
                                                        <option value="3">Blue Theme</option>
                                                        <option value="1">Dark Theme</option>
                                                    </select>
                                                    {{-- <input class="form-control" type="text" value="{{$oragnization->address}}" placeholder="Sunset Blvd, 38" name="address"> --}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group"><button class="btn btn-primary btn-sm" type="submit">Save&nbsp;Settings</button></div>
                                    </form>
                                </div>
                            </div>
            </div>
            </div>
        </div>

            </div>
        </div>
    </div>

    {{-- modal for OTP --}}
    <div class="modal lx" style="display: none;" id="modal_otp" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Verify OTP</h5>
            <button type="button" class="close" onclick="document.getElementById('modal_otp').style.display = 'none';" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="alert alert-success alert-block" id="success_p" style="display: none;"> 
                <button type="button" class="close" onclick="document.getElementById('error_p').style.display = 'none';">×</button>
                <strong id="success_c"></strong>
            </div>
            <form action="{{route('verify_otp_eyowo')}}" method="POST">
                @csrf
                <input type="hidden" name="otp_gateway" value="">
				<input type="hidden" name="otp_client_id" value="">
				<input type="hidden" name="otp_eyowo_c_id" value="">
				<input type="hidden" name="otp_eyowo_c_mobile" value="">

                <div class="form-group">
                    <label class="mb-1" for="amount">Enter OTP</label>
                    <input name="otp_code" required class="form-control py-4" id="otp_code" type="number" step="any" aria-describedby="nameHelp" placeholder="Enter OTP" />
                </div>
                <div class="form-group">
                    <input name="submit" class="btn btn-primary" id="submit" type="submit" aria-describedby="nameHelp" value="Confirm OTP" />
                </div>
            </form>
          </div>
          <div class="modal-footer">
          </div>
        </div>
      </div>
    </div>



     {{-- modal for Edit Paymrnt get way --}}
    <div class="modal lx" style="display: none;" id="modal_gt" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Change Gateway</h5>
            <button type="button" class="close" onclick="document.getElementById('modal_gt').style.display = 'none';" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="alert alert-success alert-block" id="success_p" style="display: none;"> 
                <button type="button" class="close" onclick="document.getElementById('error_p').style.display = 'none';">×</button>
                <strong id="success_c"></strong>
            </div>
            <form method="" id="gateway_e_form">
                                             
			    @csrf
                <div class="form-group"><label for="gateway"><strong>Select Gateway</strong></label>
                    <select class="form-control" name="gateway" id="gateway">
                        @foreach ($p_gateway as $p_g)
                        <option value="{{$mobile_money->id}}">{{$mobile_money->name}}</option>
                        @endforeach
                        {{-- @if ($p_gateway[0]->id > 0)
                        @endif --}}
                        @foreach ($mobile_moneys as $m)
                            <option value="{{$m->id}}">{{$m->name}}</option>
                        @endforeach
                    </select>
                </div>
			    <div class="form-group">
                    <label for="city"><strong>Wallet Id <small>(Eg. phone)</small></strong></label>
                    <input class="form-control" value="{{$p_gateway[0]->client_id ?? ''}}" name="client_id">
                </div>
                @foreach ($p_gateway as $p_g)
                    <div class="form-group"><button class="btn btn-primary btn-sm" type="button" id="submit_e_g" >Edit&nbsp;Gateway</button></div>
                @endforeach
                {{-- <div class="form-group"><button <?php foreach ($p_gateway as $p_g) {if($p_g->id > 0){ echo'style="display:none;"';}} ?> class="btn btn-primary btn-sm" type="button" id="submit_g" >Save&nbsp;Gateway</button></div> --}}
                
            </form>
          </div>
          <div class="modal-footer">
          </div>
        </div>
      </div>
    </div>

</div>
@endsection

