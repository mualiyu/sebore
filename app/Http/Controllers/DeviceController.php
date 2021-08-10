<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DeviceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show_devices()
    {
        $devices = Device::where('org_id', '=', Auth::user()->organization_id)->orderBy('created_at', 'desc')->get();

        return view('devices.index', compact('devices'));
    }

    public function show_add_device()
    {
        return view('devices.add_device');
    }


    public function create_device(Request $request)
    {
        $org = Organization::find(Auth::user()->organization_id);

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string'],
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        // dd($request->all());

        $device = Device::create([
            'name' => $request['name'],
            'location' => $request['location'],
            'type' => $request['type'],
        ]);

        Device::where('id', '=', $device->id)->update([
            'user_id' => Auth::user()->id,
            'org_id' => Auth::user()->organization_id,
        ]);

        return redirect('/devices')->with(['success' => $device->name . ' is Created to system']);

        // dd($request->all());
    }


    public function show_single_device($id)
    {
        $device = Device::find($id);

        return view('devices.device_profile', compact('device'));
    }

    public function update_device(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:1000'],
            'type' => ['required', 'string'],
        ]);
        if ($validator->fails()) {
            return back()->with('error', 'device not updated. Try again!');
        }
        // dd($request->all());

        $agent = Device::where('id', '=', $id)->update([
            'name' => $request['name'],
            'location' => $request['location'],
            'type' => $request['type'],
        ]);

        // Agent::where('id', '=', $agent->id)->update([
        //     'user_id' => Auth::user()->id,
        // ]);

        return redirect()->route('show_single_device', ['id' => $id])->with(['success' => $request['name'] . ' is Updated']);

        // dd($request->all());
    }
}
