<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PDF - Customers Qr code</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" /> --}}
</head>

<body style="margin: 0;">
    <div class="container-fluid" >
        <h4 class="text-center mb-3">Agent({{$agent->name}} - {{$agent->email}}) Customers: </h4>

        <table class="table table-bordered" style="width: 100%; font-size:20px;">
            <thead>
                <tr class="table-header">
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    {{-- <th scope="col">Email</th> --}}
                    <th scope="col">Phone</th>
                    <th scope="col">Qrcode</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customers ?? '' as $data)
                <tr>
                    <th scope="row">{{ $data->id }}</th>
                    <td style="margin: auto;">{{ $data->name }}</td>
                    {{-- <td>{{ $data->email }}</td> --}}
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
        </table>

    </div>

    {{-- <script src="{{ asset('js/app.js') }}" type="text/js"></script> --}}
</body>

</html>
