@extends('layouts.index')

@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="page-header-title">
                    <h6 class="m-b-10">{{$agent->name}} Customers</h6>
                </div>
            </div>
            <div class="col-md-4">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{route('home')}}"> <i class="fa fa-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#">Customers</a>
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
                <a href="{{route('show_agents')}}" style="right:0;" class="btn btn-primary">Back</a>&nbsp;&nbsp;&nbsp;
                <button class="btn btn-success"  data-toggle="modal" onclick="$('#modal').css('display', 'block')" data-target="#staticBackdrop"><i class=""></i> Upload</button>&nbsp;&nbsp;&nbsp;
		        <a href="{{route('show_add_customer', ['id'=> $agent->id])}}" style="right:0;" class="btn btn-primary">Add New Customers</a>&nbsp;&nbsp;&nbsp;
                <a class=" btn btn-success" href="{{route('export_customers_pdf', ['username'=>$agent->username])}}" >Export Customers QrCode</a>

                <br>
                    <div class="card">
                        <div class="card-header">
                            <h5>Customers</h5>
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
                                            <th>Email</th>
					                        <th>Phone</th>
					                        <th>Address</th>
					                        <th>LGA</th>
					                        <th>Sate</th>
                                            {{-- <th>Qr Code</th> --}}
					                        <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
					                    <?php $i = count($customers); ?>
				                        @foreach ($customers as $c)
					                    <tr>
					                    	<th scope="row">{{$i}}</th>
					                    	<td>{{$c->name}}</td>
					                    	<td>{{$c->email}}</td>
					                    	<td>{{$c->phone}}</td>
					                    	<td>{{$c->address}}</td>
					                    	<td>{{$c->lga}}</td>
					                    	<td>{{$c->state}}</td>
                                            {{-- <td>
                                                <img style="width: 100px; height:100px;" src="data:image/png;base64, {!! base64_encode(QrCode::format('png')
                                                                // ->merge('assets/images/logo.png', 0.3, true)
                                                                ->errorCorrection('H')
                                                                ->size(100)
                                                                ->generate($c->phone)) !!}" />
                                            </td> --}}
					                    	<td>
                                                <form method="POST" id="delete-form[{{$i}}]" action="{{route('delete_customer',['id'=>$c->id])}}">
                                                    <a href="{{route('show_edit_customer', ['a_id'=>$agent->id, 'c_id'=>$c->id])}}" class="btn btn-primary">Edit</a>
                                                    @csrf
                                                    <a  onclick="
                                                        if(confirm('Are you sure You want to Delete this Customer -( {{$c->name}} )? ')){
                                                            document.getElementById('delete-form[{{$i}}]').submit();
                                                        }
                                                            event.preventDefault();"
                                                        class="btn btn-warning"
                                                        style="color: black; background:red;">
                                                        Delete
                                                    </a>
                                                </form>
					                    	</td>
					                    	<?php $i--?>
					                    </tr>
					                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                    <div class="modal " style="display: none; with:80%;" id="modal" data-backdrop="static" data-keyboard="false" tabindex="1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg modal-scrollable" style="width:100%;">
                        <div class="modal-content">
                          <div class="modal-header">Upload CSV file
                            <button type="button" class="close" data-dismiss="modal" onclick="document.getElementById('modal').style.display = 'none';" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form action="{{route('import_customers')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="input-group">
                                    <input name="file" class="form-control" required onchange="Upload()" accept=".csv" id="fileUpload" type="file" placeholder="choose file" />
                                    <div class="input-group-prepend">
                                      <input name="submit" class="btn btn-success" id="submit" type="submit" aria-describedby="nameHelp" value="Upload" />
                                    </div>
                                </div>
                                 <div class="input-group">
                                    <?php $agents = \App\Models\Agent::where('org_id', '=', Auth::user()->organization_id)->get(); ?>
						                <select class="form-control"  disabled>
                                           <option value="">{{$agent->name}}</option>
                                           <hr>
						              	 @foreach ($agents as $a)
						              	 <option value="{{$a->id}}">{{$a->name}}</option>
						              	 @endforeach
						                </select>
                                </div>
                                <input type="hidden" name="agent" value="{{$agent->id}}">
                                <br><br>
                                <div class="row">
                                    <div id="dvCSV" class="table-responsive">
                                    </div>
                                </div>
                            </form>
                          </div>
                          <div class="modal-footer">
                            <a class="btn btn-warning" href="{{route('download_sample')}}">
                             Download csv Sample
                            </a>
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
    function Upload() {
        var fileUpload = document.getElementById("fileUpload");
        var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.csv|.txt|.xlsx)$/;
        if (regex.test(fileUpload.value.toLowerCase())) {
            if (typeof (FileReader) != "undefined") {
                var reader = new FileReader();
                reader.onload = function (e) {
                    var table = document.createElement("table");
                    table.setAttribute("class", "table table-bordered");
                    var rows = e.target.result.split("\n");
                    for (var i = 3; i < rows.length; i++) {
                        var cells = rows[i].split(",");
                        if (cells.length > 1) {
                            var row = table.insertRow(-1);
                            for (var j = 0; j < cells.length; j++) {
                                var cell = row.insertCell(-1);
                                cell.innerHTML = cells[j];
                            }
                        }
                    }
                    var dvCSV = document.getElementById("dvCSV");
                    dvCSV.innerHTML = "";
                    dvCSV.appendChild(table);
                }
                reader.readAsText(fileUpload.files[0]);
            } else {
                alert("This browser does not support HTML5.");
            }
        } else {
            alert("Please upload a valid CSV file.");
        }
    }
</script>
@endsection
