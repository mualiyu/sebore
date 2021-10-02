<?php

namespace App\Http\Controllers;

use App\Models\Api;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiItemController extends Controller
{
    public function get_by_device(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'api_user' => 'required',
            'api_key' => 'required',
            'device_id' => 'required',
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

                $items = Item::where('device_id', '=', $request->device_id)->get();

                if (count($items) > 0) {
                    $res = [
                        'status' => true,
                        'data' => $items
                    ];
                    return response()->json($res);
                } else {
                    $res = [
                        'status' => false,
                        'data' => 'No Item found in system'
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
