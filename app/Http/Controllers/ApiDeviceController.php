<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApiDeviceResource;
use App\Models\Api;
use App\Models\Device;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\HttpCache\ResponseCacheStrategy;

class ApiDeviceController extends Controller
{
    public function __construct()
    {
    }

    public function show(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'api_user' => 'required',
            'api_key' => 'required',
            'device_code' => 'required',
        ]);

        if ($validator->fails()) {
            $res = [
                'status' => false,
                'data' => $validator
            ];
            return response()->json($res);
        }

        $api = Api::where('api_user', '=', $request->api_user)->get();
        if (count($api) > 0) {
            if ($api[0]->api_key == $request->api_key) {

                $device = Device::where('device_id', '=', $request->device_code)->get();

                if (count($device) > 0) {
                    $res = [
                        'status' => true,
                        'data' => $device
                    ];
                    return response()->json($res);
                } else {
                    $res = [
                        'status' => false,
                        'data' => 'No data found in system'
                    ];
                    return response()->json($res);
                }
                //
            } else {
                $res = [
                    'status' => false,
                    'data' => 'API_KEY Not correct'
                ];
                return response()->json($res);
            }
        } else {
            $res = [
                'status' => false,
                'data' => 'API_USER Not Found'
            ];
            return response()->json($res);
        }
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @param [type] $id
     * @return void
     */
    public function update_code(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'api_user' => 'required',
            'api_key' => 'required',
            'device_id' => 'required',
            'device_code' => ['required', 'max:255'],
        ]);

        if ($validator->fails()) {
            $res = [
                'status' => false,
                'data' => $validator
            ];
            return response()->json($res);
        }

        $api = Api::where('api_user', '=', $request->api_user)->get();
        if (count($api) > 0) {
            if ($api[0]->api_key == $request->api_key) {

                Device::where('id', '=', $request->device_id)->update([
                    'device_id' => $request->device_code
                ]);

                $device = Device::find($request->device_id);

                if ($device) {
                    $res = [
                        'status' => true,
                        'data' => $device
                    ];
                    return response()->json($res);
                } else {
                    $res = [
                        'status' => false,
                        'data' => 'No data found in system'
                    ];
                    return response()->json($res);
                }
                //
            } else {
                $res = [
                    'status' => false,
                    'data' => 'API_KEY Not correct'
                ];
                return response()->json($res);
            }
        } else {
            $res = [
                'status' => false,
                'data' => 'API_USER Not Found'
            ];
            return response()->json($res);
        }
    }
}
