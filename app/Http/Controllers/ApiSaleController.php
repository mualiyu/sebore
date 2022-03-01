<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Api;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiSaleController extends Controller
{
    public function get_sales(Request $request)
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

                $agent = Agent::find($request->agent_id);

                if ($agent->role->type == "marketer") {
                    $sales = Sale::where(["marketer_id" => $agent->id, 'org_id' => $agent->org_id, "status" => 0])->with('item')->with("marketer")->get();

                    foreach ($sales as $s) {
                        # code...
                        $item_cart = $s->item->item_cart;
                        $item_cart->sale_amount = $s->amount;
                        $item_cart->sale_quantity = $s->quantity;

                        if ($item_cart->with_q == 1) {
                            $item_cart->with_q = true;
                        } else {
                            $item_cart->with_q = false;
                        }

                        if ($item_cart->with_p == 1) {
                            $item_cart->with_p = true;
                        } else {
                            $item_cart->with_p = false;
                        }
                    }

                    if (count($sales) > 0) {
                        $res = [
                            'status' => true,
                            'data' => $sales,
                        ];
                        return response()->json($res);
                    } else {
                        $res = [
                            'status' => false,
                            'data' => 'No available sales found for this Agent',
                        ];
                        return response()->json($res);
                    }
                } else {
                    $res = [
                        'status' => false,
                        'data' => 'Agent is not a Marketer',
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
