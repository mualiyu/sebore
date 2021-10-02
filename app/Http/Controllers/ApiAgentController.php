<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiAgentController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function get_by_phone(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'api_user' => 'required',
            'api_key' => 'required',
            'phone' => 'required'
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

                $agent = Agent::where('phone', '=', $request->phone)->get();
                if (count($agent) > 0) {
                    $res = [
                        'status' => true,
                        'data' => $agent
                    ];
                    return response()->json($res);
                } else {

                    $res = [
                        'status' => false,
                        'data' => 'Agent Not Found'
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'api_user' => 'required',
            'api_key' => 'required',
            'agent_id' => 'required',
            'password' => 'required'
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
                $a = Agent::where('id', '=',  $request->agent_id)->update([
                    'password' => $request->password
                ]);

                if ($a) {
                    $agent = Agent::find($request->agent_id);
                    if ($agent) {
                        $res = [
                            'status' => true,
                            'data' => $agent
                        ];
                        return response()->json($res);
                    } else {
                        $res = [
                            'status' => false,
                            'data' => 'No data found'
                        ];
                        return response()->json($res);
                    }
                } else {
                    $res = [
                        'status' => false,
                        'data' => 'Sorry cannot update Password, try later.'
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
}
