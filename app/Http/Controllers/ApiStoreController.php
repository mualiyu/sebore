<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Api;
use App\Models\Item;
use App\Models\ItemInStore;
use App\Models\Organization;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ApiStoreController extends Controller
{
    public function get_stores(Request $request)
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

                if ($agent->role->type == "store") {
                    $stores = $agent->stores;

                    foreach ($stores as $s) {
                        $item_in_store = $s->items_in_store;
                        foreach ($item_in_store as $i) {
                            $i->item;
                            $i->item->item_cart;
                        }
                    }



                    if (count($stores) > 0) {
                        $res = [
                            'status' => true,
                            'data' => $stores,
                        ];
                        return response()->json($res);
                    } else {
                        $res = [
                            'status' => false,
                            'data' => 'Keeper does not belong to any Store',
                        ];
                        return response()->json($res);
                    }
                } else {
                    $res = [
                        'status' => false,
                        'data' => 'Agent is not a Store keeper',
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

    public function add_item(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'api_user' => 'required',
            'api_key' => 'required',
            'agent_id' => 'required',
            'store_id' => 'required',
            'item_id' => 'required',
            'quantity' => 'required',
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
                // $org = Organization::find(Auth::user()->organization_id);
                $store = Store::find($request->store_id);

                if ($store) {
                    $total_quantity = $store->total_num_of_items;
                    $total_amount = $store->total_amount;

                    $item = Item::find($request->item_id);
                    $quantity = $request->quantity;

                    if ($item) {
                        $amount = $item->item_cart->measure * $quantity;

                        $check = ItemInStore::where(["store_id" => $store->id, "item_id" => $item->id])->get();

                        if (count($check) == 0) {
                            $item_in_store = ItemInStore::create([
                                "org_id" => $store->org->id,
                                "store_id" => $store->id,
                                "item_id" => $item->id,
                                "quantity" => $quantity,
                                "amount" => $amount,
                            ]);

                            if ($item_in_store) {
                                $total_amount += $amount;
                                $total_quantity += $quantity;

                                $update_store = Store::where('id', '=', $store->id)->update([
                                    "total_num_of_items" => $total_quantity,
                                    "total_amount" => $total_amount,
                                ]);

                                $stor = Store::find($store->id);
                                $res = [
                                    'status' => true,
                                    'data' => $stor,
                                ];
                                return response()->json($res);
                            } else {
                                $res = [
                                    'status' => false,
                                    'data' => 'Item is not added to the store. Try again, or consider contacting your Admin.',
                                ];
                                return response()->json($res);
                            }
                        } else {
                            $res = [
                                'status' => false,
                                'data' => 'Item already exist in the store consider Updating the Item quantity.',
                            ];
                            return response()->json($res);
                        }
                    } else {
                        $res = [
                            'status' => false,
                            'data' => 'Item does not exist.',
                        ];
                        return response()->json($res);
                    }
                } else {
                    $res = [
                        'status' => false,
                        'data' => 'Store does not exist.',
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
