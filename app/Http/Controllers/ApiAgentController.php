<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiAgentController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'api_user' => 'required',
            'api_key' => 'required',
            'phone_or_username' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            $res = [
                'status' => false,
                'data' => $validator->errors(),
            ];
            return response()->json($res);
        }

        $api = Api::where('api_user', '=', $request->api_user)->get();

        if (count($api) > 0) {
            if ($api[0]->api_key == $request->api_key) {

                $user = $request->phone_or_username;

                if (is_numeric($user) == true) {
                    $agent = Agent::where('phone', '=', $user)->get();
                } else {
                    $agent = Agent::where('username', '=', $user)->get();
                }

                if (count($agent) > 0) {

                    // $p = Hash::make($request->password);

                    // return $p;
                    if (Hash::check($request->password, $agent[0]->password)) {
                        # code...
                        $a = Agent::where('id', '=', $agent[0]->id)->with('customers')->get();
                        $res = [
                            'status' => true,
                            'data' => $a
                        ];
                        return response()->json($res);
                    } else {
                        $res = [
                            'status' => false,
                            'data' => 'Incorrect Password',
                        ];
                        return response()->json($res);
                    }
                } else {

                    $res = [
                        'status' => false,
                        'data' => 'Username or Phone is not valid',
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
            'old_password' => 'required',
            'new_password' => 'required',
        ]);

        if ($validator->fails()) {
            $res = [
                'status' => false,
                'data' => $validator->errors(),
            ];
            return response()->json($res);
        }

        $api = Api::where('api_user', '=', $request->api_user)->get();
        if (count($api) > 0) {
            if ($api[0]->api_key == $request->api_key) {

                $agent = Agent::find($request->agent_id);

                if ($agent) {
                    if (Hash::check($request->old_password, $agent->password)) {

                        $a = Agent::where('id', '=',  $request->agent_id)->update([
                            'password' => Hash::make($request->new_password)
                        ]);

                        if ($a) {
                            // $a_new = 
                            $res = [
                                'status' => true,
                                'data' => "Password successfully updated",
                            ];
                            return response()->json($res);
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
                            'data' => 'Old password is wrong, Try again',
                        ];
                        return response()->json($res);
                    }
                } else {
                    $res = [
                        'status' => false,
                        'data' => 'Agent not found',
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
