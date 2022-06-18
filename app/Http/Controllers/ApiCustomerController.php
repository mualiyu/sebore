<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Api;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ApiCustomerController extends Controller
{
    public function get_by_agent(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'api_user' => 'required',
            'api_key' => 'required',
            'agent_id' => 'required',
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

                $customers = Customer::where('agent_id', '=', $request->agent_id)->with('transactions')->get();

                if (count($customers) > 0) {
                    $res = [
                        'status' => true,
                        'data' => $customers
                    ];
                    return response()->json($res);
                } else {
                    $res = [
                        'status' => false,
                        'data' => 'No Customer found in system'
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

    public function check_by_phone(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'api_user' => 'required',
            'api_key' => 'required',
            'customer_phone' => 'required',
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

                $customers = Customer::where('phone', '=', $request->customer_phone)->get();

                if (count($customers) > 0) {
                    $res = [
                        'status' => true,
                        'data' => $customers[0],
                    ];
                    return response()->json($res);
                } else {
                    $res = [
                        'status' => false,
                        'data' => 'No Customer found in system'
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

    public function add_customer_to_agent(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'api_user' => 'required',
            'api_key' => 'required',
            'customer_id' => 'required',
            'agent_id' => 'required',
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
                    $customer = Customer::find($request->customer_id);

                    if ($customer) {
                        $a_c = DB::table('agent_customer')->where(['agent_id' => $agent->id, 'customer_id' => $customer->id])->get();
                        if (count($a_c) > 0) {
                            $res = [
                                'status' => false,
                                'data' => 'Customer is Already Added To This Agent.'
                            ];
                            return response()->json($res);
                            // return back()->with('error', "Customer is Already Added To This Agent.");
                        } else {
                            $agent_customer = DB::table('agent_customer')->insert([
                                'agent_id' => $agent->id,
                                'customer_id' => $customer->id
                            ]);

                            $res = [
                                'status' => true,
                                'data' => $customer,
                            ];
                            return response()->json($res);
                            // return redirect()->route('show_customers', ['id' => $request['agent']])->with(['success' => $customer->name . ' is added to ' . $agent->name]);
                        }
                    } else {
                        $res = [
                            'status' => false,
                            'data' => 'customer Not Found'
                        ];
                        return response()->json($res);
                        // return back()->with('error', 'Customer Not found');
                    }
                } else {
                    $res = [
                        'status' => false,
                        'data' => 'Agent Not Found'
                    ];
                    return response()->json($res);
                    // return back()->with('error', 'Agent Not found');
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

    public function create(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'api_user' => 'required',
            'api_key' => 'required',
            'agent_id' => 'required',
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required|unique:customers',
            'address' => 'required',
            'lga' => 'required',
            'state' => 'required',
            'country' => 'required',
            'gps' => 'nullable'
        ]);

        if ($validator->fails()) {
            $res = [
                'status' => false,
                'data' => $validator->errors()
            ];
            return response()->json($res);
        }

        $api = Api::where('api_user', '=', $request->api_user)->get();

        if (count($api) > 0) {
            if ($api[0]->api_key == $request->api_key) {

                $agent = Agent::find($request->agent_id);

                $customer = Customer::create([
                    'org_id' => $agent->org_id,
                    'agent_id' => $request->agent_id,
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'lga' => $request->lga,
                    'state' => $request->state,
                    'country' => $request->country,
                    'gps' => $request->gps,
                ]);

                Customer::where('id', '=', $customer->id)->update([
                    'org_id' => $agent->org_id,
                    'agent_id' => $request->agent_id,
                ]);

                $agent_customer = DB::table('agent_customer')->insert([
                    'agent_id' => $agent->id,
                    'customer_id' => $customer->id,
                ]);

                if ($customer) {
                    $res = [
                        'status' => true,
                        'data' => $customer,
                    ];
                    return response()->json($res);
                } else {
                    $res = [
                        'status' => false,
                        'data' => 'Fail to Create Customer'
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
