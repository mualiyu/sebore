<?php

namespace App\Http\Controllers;

use App\Models\Api;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiStockController extends Controller
{
    public function create(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'api_user' => 'required',
            'api_key' => 'required',
            'org_id' => 'required',
            'issuer' => 'required',
            // 'collector' => 'nullable',
            'amount' => 'required',
            'status' => 'nullable',
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
                $stock = Stock::create([
                    'org_id' => $request->org_id,
                    'issuer' => $request->issuer,
                    'amount' => $request->amount,
                    'status' => $request->status,

                ]);

                if ($stock) {
                    $s = Stock::where('id', '=', $stock->id)->with("issuer")->get();
                    $res = [
                        'status' => true,
                        'data' => $s[0],
                    ];
                    return response()->json($res);
                } else {
                    $res = [
                        'status' => false,
                        'data' => 'Fail To Create Stock',
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

    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'api_user' => 'required',
            'api_key' => 'required',
            'stock_id' => 'required',
            'collector' => 'required',
            'status' => 'nullable',
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
                $s_c = Stock::find($request->stock_id);

                if ($s_c) {
                    $stock = Stock::where('id', '=', $s_c->id)->update([
                        'collector' => $request->collector,
                        'status' => $request->status,
                    ]);

                    if ($stock) {
                        $s = Stock::where('id', '=', $s_c->id)->with("issuer")->with("collector")->get();
                        $res = [
                            'status' => true,
                            'data' => $s[0],
                        ];
                        return response()->json($res);
                    } else {
                        $res = [
                            'status' => false,
                            'data' => 'Fail To Update Stock',
                        ];
                        return response()->json($res);
                    }
                } else {
                    $res = [
                        'status' => false,
                        'data' => 'Stock With This Qr-code Not Found ',
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

    public function get_stock(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'api_user' => 'required',
            'api_key' => 'required',
            'stock_id' => 'required',
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

                $s_c = Stock::where("id", "=", $request->stock_id)->with("issuer")->with("collector")->get();

                if (count($s_c) > 0) {
                    $res = [
                        'status' => true,
                        'data' => $s_c[0],
                    ];
                    return response()->json($res);
                } else {
                    $res = [
                        'status' => false,
                        'data' => 'Stock With This Qr-code Not Found ',
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
