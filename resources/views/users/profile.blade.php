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
                                <p class="text-primary m-0 font-weight-bold">{{Auth::user()->organization()->get()[0]->name}} > {{$user->name}} </p>
                            </div>
                         </div>
                </div>
                <div class="row" id="e" style="display: none;">
                    <div class="card shadow " style="width: 100%;">

                        <div class="card-body">
                            <div class="row">
                                          <div class="col-sm-12">
                                            <a class="btn btn-primary" onclick="edit()" style="color: white;">close</a>
                                          </div>
                                        </div><br><br>
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
                    <option value="{{$user->role->id ?? ''}}">{{$user->role->name ?? ''}}</option>
                    <?php $roles = \App\Models\AdminRole::all(); ?>
                    @foreach ($roles as $r)
                    <option value="{{$r->id}}">{{$r->name}}</option>
                    @endforeach
                    {{-- <option value="suppervisor">Suppervisor</option>
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

                <div class="row" id="p">
                         <div class="card shadow" style="width:100%;">
                          <div class="card-body">
                              <div class="row">
                                <div class="col-sm-12">
                                  <a class="btn btn-primary" onclick="edit()" style="color: white;">Edit</a>
                                </div>
                              </div>
                              <br>
                              <br>
                            <div class="row">
                              <div class="col-sm-3">
                                <h6 class="mb-0" style="float: right;">User Name</h6>
                              </div>
                              <div class="col-sm-9 text-secondary">
                                {{$user->name}}
                              </div>
                            </div>
                            {{-- <hr> --}}
                            <div class="row">
                              <div class="col-sm-3">
                                <h6 class="mb-0" style="float: right;">Email</h6>
                              </div>
                              <div class="col-sm-9 text-secondary">
                                {{$user->email}}
                              </div>
                            </div>
                            {{-- <hr> --}}
                            <div class="row">
                              <div class="col-sm-3">
                                <h6 class="mb-0" style="float: right;">Phone</h6>
                              </div>
                              <div class="col-sm-9 text-secondary">
                                {{$user->phone ?? 'Null'}}
                              </div>
                            </div>
                            {{-- <hr> --}}
                            <div class="row">
                              <div class="col-sm-3">
                                <h6 class="mb-0" style="float: right;">Role</h6>
                              </div>
                              <div class="col-sm-9 text-secondary">
                                {{$user->role->name}}
                              </div>
                            </div>
                            {{-- <hr> --}}
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

@section('script')
    <script>
        let e = document.getElementById('e');
        let p = document.getElementById('p');
        function edit() {
        // console.log(e);
            if (e.style.display == "none") {
                e.style.display = "block";
                p.style.display = 'none';
            }else{
                e.style.display = "none";
                p.style.display = 'block';
            }
        }
    </script>
@endsection

