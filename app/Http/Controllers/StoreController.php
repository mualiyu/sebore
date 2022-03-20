<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemInStore;
use App\Models\Organization;
use App\Models\Store;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class StoreController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $stores = Store::where("org_id", "=", Auth::user()->organization_id)->get();
        return view("store.index", compact("stores"));
    }

    public function show_create()
    {
        return view("store.create_store");
    }

    public function create(Request $request)
    {
        $org = Organization::find(Auth::user()->organization_id);

        $validator = FacadesValidator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'location' => ['nullable', 'string'],
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $store = Store::create([
            'name' => $request->name,
            'location' => $request->location,
            'org_id' => $org->id,
            'total_num_of_items' => 0,
            'total_amount' => 0,
        ]);

        if ($store) {
            return redirect()->route('store_index')->with('success', 'Congrats, Store is been created. Check the table below to confirm.');
        } else {
            return back()->with('error', 'Agent Role is not Added.')->withInput();
        }
        return back();
    }

    public function info($id)
    {
        $store = Store::find($id);
        if ($store) {
            $items_in_store = ItemInStore::where('store_id', '=', $store->id)->get();

            return view("store.store_info", compact("store", "items_in_store"));
        } else {
            return back()->with('error', 'Store not found in system');
        }
    }

    public function add_agent(Request $request, $id)
    {
        $org = Organization::find(Auth::user()->organization_id);

        $validator = FacadesValidator::make($request->all(), [
            'agent' => ['required'],
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $check = DB::table('agent_store')->where(["agent_id" => $request->agent, "store_id" => $id])->get();
        if (count($check) > 0) {
            return back()->with("error", "Agent is already exist as a store keeper in this store.");
        } else {
            $agent_store = DB::table('agent_store')->insert([
                'agent_id' => $request->agent,
                'store_id' => $id
            ]);
            if ($agent_store) {
                return back()->with("success", "Agent is added to this store.");
            } else {
                return back()->with("error", "Agent Not Added, Try again after some time.");
            }
        }
    }

    public function remove_agent($s_id, $a_id)
    {
        $agent_store = DB::table('agent_store')->where(['agent_id' => $a_id, 'store_id' => $s_id])->delete();

        if ($agent_store) {
            return back()->with("success", "Store keeper Agent is removed successfully.");
        } else {
            return back()->with("error", "Store keeper is not removed, Try again after some time.");
        }
    }

    public function add_items(Request $request, $id)
    {
        $org = Organization::find(Auth::user()->organization_id);
        $store = Store::find($id);

        $validator = FacadesValidator::make($request->all(), [
            'items' => ['required'],
            'q' => ['required'],
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $total_quantity = $store->total_num_of_items;
        $total_amount = $store->total_amount;
        $error = [];

        foreach ($request->items as $i) {
            $item = Item::find($i);
            $quantity = $request->q[$i];
            $amount = $item->item_cart->measure * $quantity;

            $check = ItemInStore::where(["store_id" => $store->id, "item_id" => $item->id])->get();

            if (count($check) == 0) {
                $item_in_store = ItemInStore::create([
                    "org_id" => $org->id,
                    "store_id" => $store->id,
                    "item_id" => $item->id,
                    "quantity" => $quantity,
                    "amount" => $amount,
                ]);

                if ($item_in_store) {
                    $total_amount += $amount;
                    $total_quantity += $quantity;
                } else {
                    array_push($error, $item->item_cart->name);
                }
            } else {
                array_push($error, $item->item_cart->name);
            }
        }

        $update_store = Store::where('id', '=', $store->id)->update([
            "total_num_of_items" => $total_quantity,
            "total_amount" => $total_amount,
        ]);

        if (!empty($error)) {
            return back()->with("success", "Some Items may be added successfully, And the following Items are not Added (" . implode(", ", $error) . "), Because it's already existing in store");
        } else {
            return back()->with("success", "Store items are added successfully");
        }

        return 0;
    }

    public function remove_item($s_id, $i_id)
    {
        $store = Store::find($s_id);
        $item_in_store = ItemInStore::where(['store_id' => $s_id, 'item_id' => $i_id])->get();
        // return $item_in_store;
        $item_in_store = $item_in_store[0];
        $store_total_amount = $store->total_amount;
        $store_total_num_of_items = $store->total_num_of_items;

        if ($item_in_store) {
            $store_total_amount -= $item_in_store->amount;
            $store_total_num_of_items -= $item_in_store->quantity;

            $update_store = Store::where("id", '=', $s_id)->update([
                "total_num_of_items" => $store_total_num_of_items,
                "total_amount" => $store_total_amount,
            ]);

            $delete_item_in_store = ItemInStore::where(['store_id' => $s_id, 'item_id' => $i_id])->delete();

            if ($delete_item_in_store) {
                return back()->with("success", "Item(" . $item_in_store->item->item_cart->name . ") is removed from " . $store->name . "  successfully.");
            } else {
                return back()->with("error", "Store keeper is not Removed, Try again after some time.");
            }
        } else {
            return back()->with("error", "Store keeper is not removed, Try again after some time.");
        }
    }

    public function update_item(Request $request, $s_id, $i_id)
    {
        $org = Organization::find(Auth::user()->organization_id);
        $store = Store::find($s_id);

        $validator = FacadesValidator::make($request->all(), [
            'quantity' => ['required'],
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $item_in_store = ItemInStore::where(['store_id' => $s_id, 'item_id' => $i_id])->get();
        $item_in_store = $item_in_store[0];

        $store_total_amount = $store->total_amount;
        $store_total_num_of_items = $store->total_num_of_items;

        // remove item data from store data
        $store_total_amount -= $item_in_store->amount;
        $store_total_num_of_items -= $item_in_store->quantity;

        // new ItemInStore data
        $new_quantity = $request->quantity;
        $new_amount = $item_in_store->item->item_cart->measure * $new_quantity;

        // Update ItemInStore with new data
        $update_item_in_store = ItemInStore::where(['store_id' => $s_id, 'item_id' => $i_id])->update([
            "amount" => $new_amount,
            "quantity" => $new_quantity,
        ]);

        if ($update_item_in_store) {
            $new_item_in_store = ItemInStore::where(['store_id' => $s_id, 'item_id' => $i_id])->get();
            $new_item_in_store = $new_item_in_store[0];

            $store_total_amount += $new_item_in_store->amount;
            $store_total_num_of_items += $new_item_in_store->quantity;

            // update Store with the new data
            $new_store = Store::where("id", '=', $s_id)->update([
                "total_num_of_items" => $store_total_num_of_items,
                "total_amount" => $store_total_amount,
            ]);

            if ($new_store) {
                return back()->with("success", "Item(" . $new_item_in_store->item->item_cart->name . ") is Updated successfully.");
            } else {
                return back()->with("error", "Item(" . $new_item_in_store->item->item_cart->name . ") is Not Updated, Try again after some time.");
            }
        } else {
            return back()->with("error", "Item(" . $item_in_store->item->item_cart->name . ") is not updated, Try again after some time.");
        }
    }
}
