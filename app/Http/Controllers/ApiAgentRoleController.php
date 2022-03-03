<?php

namespace App\Http\Controllers;

use App\Models\AgentRole;
use App\Models\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiAgentRoleController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function get_role(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'api_user' => 'required',
            'api_key' => 'required',
            'org_id' => 'required',
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

                $roles = AgentRole::where('org_id', '=', $request->org_id)->get();
                if (count($roles)) {

                    $res = [
                        'status' => true,
                        'data' => $roles,
                    ];
                    return response()->json($res);
                } else {
                    $res = [
                        'status' => false,
                        'data' => 'Role Not Found',
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

    public function get_marketers_by_org(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'api_user' => 'required',
            'api_key' => 'required',
            'org_id' => 'required',
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

                // $agents = Agent::where(['org_id' => $request->org_id])->with("role")->get();
                $roles = AgentRole::where(['org_id' => $request->org_id, 'type' => 'marketer'])->with('agents')->get();
                $agents = [];
                foreach ($roles as $r) {
                    foreach ($r->agents as $a) {
                        array_push($agents, $a);
                    }
                }

                if (count($agents)) {
                    $res = [
                        'status' => true,
                        'data' => $agents,
                    ];
                    return response()->json($res);
                } else {
                    $res = [
                        'status' => false,
                        'data' => 'No marketers found in your system.',
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
