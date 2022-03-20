<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Item;
use App\Models\ItemInStore;
use App\Models\Organization;
use App\Models\Sale;
use App\Models\SaleTransaction;
use App\Models\Store;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SaleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index($id)
    {
        $store = Store::find($id);
        $sales = Sale::where(['store_id' => $store->id])->get();

        $arr = [];
        foreach ($sales as $s) {
            $no = $s->ref_num;
            array_push($arr, $no);
        }
        $s_s = array_unique($arr);
        $s_ss = array_reverse($s_s);

        return view("sale.index", compact("store", 's_ss'));
    }

    public function show_add($id)
    {
        $store = Store::find($id);
        $agents = Agent::where('org_id', '=', Auth::user()->organization_id)->with("role")->get();
        $items_in_store = ItemInStore::where(['store_id' => $id])->get();
        $items = Item::where('org_id', '=', Auth::user()->organization_id)->with("item_cart")->with("device")->orderBy('created_at', 'desc')->get();

        return view("sale.add_sale", compact('agents', 'items', "store", "items_in_store"));
    }

    public function create(Request $request, $id)
    {
        $org = Organization::find(Auth::user()->organization_id);
        $store = Store::find($id);

        $validator = Validator::make($request->all(), [
            'marketer_id' => ['required'],
            'store_keeper_id' => ['required'],
            'items' => ['required'],
            'quantity' => ['required'],
            'daterange' => ['required'],
            'expiration' => ['required'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }


        // date range
        $d = explode(' - ', $request->daterange);
        $f = explode('/', $d[0]);
        $from = $f[2] . '-' . $f[0] . '-' . $f[1];
        $t = explode('/', $d[1]);
        $to = $t[2] . '-' . $t[0] . '-' . $t[1];

        $ref_num = substr(str_shuffle(str_repeat($x = '0123456789', ceil(16 / strlen($x)))), 1, 16);

        $sale_total_amount = 0;
        $error_arr = [];

        foreach ($request->items as $i) {
            $item = Item::find($i);
            $items_in_store = ItemInStore::where(['store_id' => $store->id, 'item_id' => $item->id])->get();
            $e = [];
            if (count($items_in_store) > 0) {
                $quantity = $request->quantity[$i];
                $amount = $item->item_cart->measure * $quantity;
                $expiration = $request->expiration[$i];
                $ex = explode('/', $expiration);
                $expiration_date = $ex[2] . "-" . $ex[1] . "-" . $ex[0];

                // item in store data
                $amount_in_store = $items_in_store[0]->amount;
                $quantity_in_store = $items_in_store[0]->quantity;

                if ($quantity_in_store >= $quantity) {
                    $sale = Sale::create([
                        'org_id' => $org->id,
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
                        $sale_total_amount += $amount;

                        $new_quantity_in_store = $quantity_in_store - $quantity;
                        $new_amount_in_store = $amount_in_store - $amount;

                        $update_item_in_store = ItemInStore::where(['store_id' => $store->id, 'item_id' => $item->id])->update([
                            'quantity' => $new_quantity_in_store,
                            'amount' => $new_amount_in_store,
                        ]);
                    }
                } else {
                    $e = [
                        'id' => $item->id,
                        'msg' => "This Item quantity is not upto the number of quantities you're trying to give out from Store."
                    ];
                    array_push($error_arr, $e);
                    // return back()->with('error', "The Item " . $item->item_cart->name . " is not upto the number of quantities you're trying to give out from Store.");
                }
            } else {
                $e = [
                    'id' => $item->id,
                    'msg' => "You don't have " . $item->item_cart->name . " item in store."
                ];
                // return back()->with('error', "You don't have " . $item->item_cart->name . " item in store");
                array_push($error_arr, $e);
            }
        }

        // funding the agent wallet
        $agent = Agent::where('id', '=', $request->marketer_id)->update([
            'wallet' => $sale_total_amount,
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


        // handling error response
        if (!empty($error_arr) > 0) {
            $ee = [];
            foreach ($error_arr as $e_i) {
                $e_item = Item::find($e_i['id']);
                $message = $e_i['msg'];

                array_push($ee, "(Item: " . $e_item->item_cart->name . ", Error: " . $message . ")");
            }
            if (count($request->items) > 1) {
                return back()->with("success", "Successful, but some items are not added due to the following " . implode(" ", $ee) . ", Thank you for using our service.");
            } else {
                return back()->with("error", "Error, Item is not added due to the following " . implode(" ", $ee) . ", Thank you for using our service.");
            }
        } else {
            return redirect()->route('sale_index', ['id' => $store->id])->with("success", "sales created successfully, Thank you for using our service");
        }

        return 0;
    }

    public function show_info($id, $ref_num)
    {
        $sale = Sale::where('ref_num', '=', $ref_num)->get();

        $tran = SaleTransaction::where(['agent_id' => $sale[0]->marketer_id, 'sale_ref_num' => $sale[0]->ref_num])->get();
        $arr = [];
        foreach ($tran as $t) {
            array_push($arr, $t->ref_id);
        }
        $t_s = array_unique($arr);
        $t_ss = array_reverse($t_s);

        if (count($sale) > 0) {
            return view("sale.sale_info", compact('sale', 't_ss'));
        } else {
            return back()->with('error', "Error, No sale with this number");
        }
    }

    public function delete_sale(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ref_num' => ['required'],
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $sales = Sale::where(['ref_num' => $request->ref_num])->get();

        if (count($sales) > 0) {
            $sale_total_amount = 0;

            foreach ($sales as $sale) {
                # code...
                $items_in_store = ItemInStore::where(['store_id' => $sale->store_id, 'item_id' => $sale->item_id])->get();
                // item in store data
                $amount_in_store = $items_in_store[0]->amount;
                $quantity_in_store = $items_in_store[0]->quantity;

                $sale_total_amount += $sale->amount;

                $new_quantity_in_store = $quantity_in_store + $sale->quantity;
                $new_amount_in_store = $amount_in_store + $sale->amount;

                $update_item_in_store = ItemInStore::where(['store_id' => $sale->store_id, 'item_id' => $sale->item_id])->update([
                    'quantity' => $new_quantity_in_store,
                    'amount' => $new_amount_in_store,
                ]);

                Sale::where("id", "=", $sale->id)->delete();
            }

            $marketer = Agent::where('id', '=', $sales[0]->marketer_id)->get();
            $wallet = $marketer[0]->wallet + $sale_total_amount;

            $agent = Agent::where('id', '=', $sales[0]->marketer_id)->update([
                'wallet' => $wallet,
            ]);

            // store data
            $store_total_amount = 0;
            $store_total_num_of_items = 0;

            // new items in store data
            $new_items_in_store = ItemInStore::where(['store_id' => $sales[0]->store_id])->get();

            foreach ($new_items_in_store as $i_in_s) {
                $store_total_amount += $i_in_s->amount;
                $store_total_num_of_items += $i_in_s->quantity;
            }

            // update store data
            $update_store = Store::where(['id' => $sales[0]->store_id])->update([
                "total_amount" => $store_total_amount,
                "total_num_of_items" => $store_total_num_of_items,
            ]);

            return back()->with('success', 'One sale is deleted');
        } else {
            return back()->with('error', 'Failed to delete sale, Try again.');
        }
    }
}
