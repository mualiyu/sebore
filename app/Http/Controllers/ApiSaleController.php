<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Api;
use App\Models\Item;
use App\Models\ItemInStore;
use App\Models\Sale;
use App\Models\Store;
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

    public function create_sales(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'api_user' => 'required',
            'api_key' => 'required',
            'marketer_id' => ['required'],
            'store_keeper_id' => ['required'],
            'store_id' => 'required',
            'item_id' => ['required'],
            'quantity' => ['required'],
            'daterange' => ['required'],
            'expiration' => ['required'],
            'ref_num' => 'required',
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

                $store = Store::find($request->store_id);

                if ($store) {
                    $marketer = Agent::find($request->marketer_id);
                    $store_keeper = Agent::find($request->store_keeper_id);

                    if ($marketer) {
                        // date range
                        $d = explode('-', $request->daterange);
                        $f = explode('/', $d[0]);
                        $from = $f[2] . '-' . $f[1] . '-' . $f[0];
                        $t = explode('/', $d[1]);
                        $to = $t[2] . '-' . $t[1] . '-' . $t[0];

                        $ref_num = $request->ref_num;

                        // $ref_num = substr(str_shuffle(str_repeat($x = '0123456789', ceil(16 / strlen($x)))), 1, 16);

                        // $sale_total_amount = 0;
                        // $error_arr = [];

                        // foreach ($request->items as $i) {
                        $item = Item::find($request->item_id);
                        if ($item) {
                            $items_in_store = ItemInStore::where(['store_id' => $store->id, 'item_id' => $item->id])->get();
                            // $e = [];
                            if (count($items_in_store) > 0) {
                                $quantity = $request->quantity;
                                $amount = $item->item_cart->measure * $quantity;
                                $expiration = $request->expiration;
                                $ex = explode('/', $expiration);
                                $expiration_date = $ex[2] . "-" . $ex[1] . "-" . $ex[0];

                                // item in store data
                                $amount_in_store = $items_in_store[0]->amount;
                                $quantity_in_store = $items_in_store[0]->quantity;

                                if ($quantity_in_store >= $quantity) {
                                    $sale = Sale::create([
                                        'org_id' => $store->org->id,
                                        'marketer_id' => $request->marketer_id,
                                        'store_id' => $store->id,
                                        'store_keeper_id' => $request->store_keeper_id,
                                        'item_id' => $item->id,
                                        'from' => $from,
                                        'to' => $to,
                                        'expiration' => $expiration_date,
                                        'amount' => $amount,
                                        'quantity' => $quantity,
                                        'ref_num' => $ref_num,
                                        'status' => '0',
                                    ]);
                                    // Sale::where("id", "=", $sale->id)->update([
                                    //     "amount" => $amount,
                                    // ]);

                                    if ($sale) {
                                        $sale_total_amount = $amount;

                                        $new_quantity_in_store = $quantity_in_store - $quantity;
                                        $new_amount_in_store = $amount_in_store - $amount;

                                        $update_item_in_store = ItemInStore::where(['store_id' => $store->id, 'item_id' => $item->id])->update([
                                            'quantity' => $new_quantity_in_store,
                                            'amount' => $new_amount_in_store,
                                        ]);

                                        // funding the agent wallet
                                        if ($marketer->wallet == null) {
                                            $agent_wallet = $sale_total_amount;
                                        } else {
                                            $agent_wallet = $marketer->wallet + $sale_total_amount;
                                        }
                                        $agent = Agent::where('id', '=', $request->marketer_id)->update([
                                            'wallet' => $agent_wallet,
                                        ]);

                                        // store data
                                        $store_total_amount = 0;
                                        $store_total_num_of_items = 0;

                                        // new items in store data
                                        $new_items_in_store = ItemInStore::where(['store_id' => $store->id])->get();

                                        foreach ($new_items_in_store as $i_in_s) {
                                            $store_total_amount += $i_in_s->amount;
                                            $store_total_num_of_items += $i_in_s->quantity;
                                        }

                                        // update store data
                                        $update_store = Store::where(['id' => $store->id])->update([
                                            "total_amount" => $store_total_amount,
                                            "total_num_of_items" => $store_total_num_of_items,
                                        ]);
                                        $res = [
                                            'status' => true,
                                            'data' => "Sale is created successfully, Thank you."
                                        ];
                                        return response()->json($res);
                                    } else {
                                        $res = [
                                            'status' => false,
                                            'data' => "Sale not created."
                                        ];
                                        return response()->json($res);
                                    }
                                } else {
                                    $res = [
                                        'status' => false,
                                        'data' => "This Item quantity is not upto the number of quantities you're trying to give out from Store."
                                    ];
                                    return response()->json($res);
                                }
                            } else {
                                $res = [
                                    'status' => false,
                                    'data' => "You don't have " . $item->item_cart->name . " in this store."
                                ];
                                return response()->json($res);
                            }
                        } else {
                            $res = [
                                'status' => false,
                                'data' => "No item with this Name."
                            ];
                            return response()->json($res);
                        }
                        // }

                        // // funding the agent wallet
                        // $agent = Agent::where('id', '=', $request->marketer_id)->update([
                        //     'wallet' => $sale_total_amount,
                        // ]);

                        // // store data
                        // $store_total_amount = 0;
                        // $store_total_num_of_items = 0;

                        // // new items in store data
                        // $new_items_in_store = ItemInStore::where(['store_id' => $store->id])->get();

                        // foreach ($new_items_in_store as $i_in_s) {
                        //     $store_total_amount += $i_in_s->amount;
                        //     $store_total_num_of_items += $i_in_s->quantity;
                        // }

                        // // update store data
                        // $update_store = Store::where(['id' => $store->id])->update([
                        //     "total_amount" => $store_total_amount,
                        //     "total_num_of_items" => $store_total_num_of_items,
                        // ]);

                        // handling error response
                        // if (!empty($error_arr) > 0) {
                        //     $ee = [];
                        //     foreach ($error_arr as $e_i) {
                        //         $e_item = Item::find($e_i['id']);
                        //         $message = $e_i['msg'];

                        //         array_push($ee, "(Item: " . $e_item->item_cart->name . ", Error: " . $message . ")");
                        //     }
                        //     if (count($request->items) > 1) {
                        //         $res = [
                        //             'status' => true,
                        //             'data' => "Successful, but some items are not added due to the following " . implode(" ", $ee) . ", Thank you for using our service."
                        //         ];
                        //         return response()->json($res);
                        //         // return back()->with("success", "Successful, but some items are not added due to the following " . implode(" ", $ee) . ", Thank you for using our service.");
                        //     } else {
                        //         $res = [
                        //             'status' => false,
                        //             'data' => "Error, Item is not added due to the following " . implode(" ", $ee) . ", Thank you for using our service."
                        //         ];
                        //         return response()->json($res);
                        //         // return back()->with("error", "Error, Item is not added due to the following " . implode(" ", $ee) . ", Thank you for using our service.");
                        //     }
                        // } else {
                        //     $res = [
                        //         'status' => true,
                        //         'data' => 'sales created successfully, and the marketer wallet is funded. Thank you for using our service.'
                        //     ];
                        //     return response()->json($res);
                        //     // return back()->with("success", "sales created successfully, Thank you for using our service");
                        // }
                    } else {
                        $res = [
                            'status' => false,
                            'data' => 'Marketer not found from this organization'
                        ];
                        return response()->json($res);
                    }
                } else {
                    $res = [
                        'status' => false,
                        'data' => 'Store not found'
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
