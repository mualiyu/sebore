@extends('layouts.index')

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
@endsection

@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="page-header-title">
                    <h5 class="m-b-10">{{$user->name}} - Profile</h5>
                </div>
            </div>
            <div class="col-md-4">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{route('home')}}"> <i class="fa fa-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#">User Profile</a>
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

		     <?php $oragnization = App\Models\Organization::find(Auth::user()->organization_id); ?>

		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-8">
				<div class="row">
				<div class="card shadow " style="width: 100%;">
                                    <div class="card-header ">
                                        <p class="text-primary m-0 font-weight-bold">User Settings</p>
                                    </div>
                                    <div class="card-body">
                                        <form  method="POST" action="{{route('update_single_user', ['id'=> $user->id])}}">
						@csrf
                                            <div class="form-row">
                                                <div class="col">
                                                    <div class="form-group"><label for="username"><strong>Name</strong></label><input class="form-control" type="text" placeholder="Name" value="{{$user->name}}" name="name"></div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group"><label for="email"><strong>Email Address</strong></label><input class="form-control" value="{{$user->email}}" type="email" placeholder="user@example.com" name="email"></div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col">
                                                    <div class="form-group"><label for="first_name"><strong>Phone</strong></label><input class="form-control" value="{{$user->phone}}" type="number" placeholder="phone" name="phone"></div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group"><label for="last_name"><strong>Role</strong></label>
							{{-- <input class="form-control" type="text" placeholder="Doe" name=""> --}}
							<select name="role" id="" class="form-control">
								<option value="{{$user->role ?? ''}}">{{$user->role ?? ''}}</option>
								<option value="admin">Admin</option>
								<option value="suppervisor">Suppervisor</option>
								<option value="user">User</option>
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
			<div class="col-md-2"></div>
		</div>

            </div>
        </div>
    </div>
</div>
@endsection
