<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PDF - Customers Qr code</title>
    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"> --}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" /> --}}
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<style>

.our-team {
  padding: 20px 0 20px;
  margin-bottom: 20px;
  background-color: white;
  border: black 1px solid;
  text-align: center;
  overflow: hidden;
  position: relative;
}

.our-team .picture {
  display: inline-block;
  height: 150px;
  width: 150px;
  margin-bottom: 25px;
  z-index: 1;
  position: relative;
}



.our-team .picture img {
  width: 100%;
  height: auto;
  /* border-radius: 50%; */
  transform: scale(1);
  transition: all 0.9s ease 0s;
}


.our-team .title {
  display: block;
  font-size: 15px;
  color: #4e5052;
  text-transform: capitalize;
}
</style>
</head>

<body style="margin: 0;">
    <div class="container-fluid" >
        <h4 class="text-center mb-3">Agent({{$agent->name}} - {{$agent->email}}) Customers: </h4>

        {{-- <table class="table table-bordered" style="width: 100%; font-size:20px;">
            <thead>
                <tr class="table-header">
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Qrcode</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customers ?? '' as $data)
                <tr>
                    <th scope="row">{{ $data->id }}</th>
                    <td style="margin: auto;">{{ $data->name }}</td>
                    <td>{{ $data->phone }}</td>
                    <td>
			<img style="width: 150px; height:160px;" src="data:image/png;base64, {!! base64_encode(QrCode::format('png')
                                ->errorCorrection('H')
                                ->size(200)
                                ->generate($data->phone)) !!}" />
		    </td>
                </tr>
                @endforeach
            </tbody>
        </table> --}}

        <div class="container">
          <div class="row">
            @foreach($customers ?? '' as $data)
            <div class="col-12 col-sm-4 col-md-4 col-lg-3">
              <div class="our-team">
                <div class="picture">
                  <img class="img-fluid" src="data:image/png;base64, {!! base64_encode(QrCode::format('png')
                                ->errorCorrection('H')
                                ->size(150)
                                ->generate($data->phone)) !!}">
                </div>
                <div class="team-content">
                  <h4 class="name">{{$data->name}}</h4>
                  <h5 class="title">{{$data->phone}}</h5>
                  <h5 class="title">{{$data->email}}</h5>
                </div>
              </div>
            </div>
            @endforeach
          </div>
        </div>

    </div>

    {{-- <script src="{{ asset('js/app.js') }}" type="text/js"></script> --}}
</body>

</html>
