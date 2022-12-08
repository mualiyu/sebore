<?php

namespace App\Http\Controllers;

use App\Models\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ApiApiController extends Controller
{
    public function get_by_name(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'api_user' => 'required',
            'api_key' => 'required',
            'name' => 'required',
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
                $a = Api::where('name', '=', $request->name)->get();

                if (count($a) > 0) {
                    $res = [
                        'status' => true,
                        'data' => $a
                    ];
                    return response()->json($res);
                } else {
                    $res = [
                        'status' => false,
                        'data' => 'No Api related to this name'
                    ];
                    return response()->json($res);
                }
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

    // public function create(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'api_user' => 'required',
    //         'api_key' => 'required',
    //         'name' => ['required', 'unique:apis'],
    //         'new_api_user' => 'required',
    //         'permission' => 'nullable'
    //     ]);

    //     if ($validator->fails()) {
    //         $res = [
    //             'status' => false,
    //             'data' => $validator
    //         ];
    //         return response()->json($res);
    //     }

    //     $api = Api::where('api_user', '=', $request->api_user)->get();
    //     $token = Str::random(60);

    //     if (count($api) > 0) {
    //         if ($api[0]->api_key == $request->api_key) {
    //             $a = Api::create([
    //                 'name' => $request->name,
    //                 'api_user' => $request->new_api_user,
    //                 'api_key' => $token,
    //                 'permission' => $request->permission
    //             ]);

    //             if ($a) {
    //                 $res = [
    //                     'status' => true,
    //                     'data' => $a
    //                 ];
    //                 return response()->json($res);
    //             } else {
    //                 $res = [
    //                     'status' => false,
    //                     'data' => 'Fail To Create New API Credential'
    //                 ];
    //                 return response()->json($res);
    //             }
    //         } else {
    //             $res = [
    //                 'status' => false,
    //                 'data' => 'API_KEY Not correct'
    //             ];
    //             return response()->json($res);
    //         }
    //     } else {
    //         $res = [
    //             'status' => false,
    //             'data' => 'API_USER Not Found'
    //         ];
    //         return response()->json($res);
    //     }
    // }
}
