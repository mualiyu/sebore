<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Device;
use App\Models\Item;
use App\Models\ItemInStore;
use App\Models\Organization;
use App\Models\Plan;
use App\Models\PlanDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Undocumented function
     *
     * @param [type] $id
     * @return void
     */
    public function show_items($id)
    {
        $device = Device::find($id);

        $items = Item::where('device_id', '=', $id)->orderBy('created_at', 'desc')->get();
        // dd($customers);

        return view('items.index', compact('items', 'device'));
    }

    public function show_all_items()
    {
        $items = Item::where('org_id', '=', Auth::user()->organization_id)->orderBy('created_at', 'desc')->get();

        return view('items.all', compact('items'));
    }

    public function show_add_item($id)
    {
        $device = Device::find($id);
        return view('items.add_item', compact('device'));
    }

    public function show_add_direct_item()
    {
        $device = null;
        return view('items.add_item', compact('device'));
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function create_item(Request $request)
    {
        $org = Organization::find(Auth::user()->organization_id);

        $validator = Validator::make($request->all(), [
            'item' => ['required', 'string', 'max:255'],
            'device' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $plan_detail = PlanDetail::where('org_id', '=', $org->id)->orderBy('id', 'desc')->first();

        if ($plan_detail && $plan_detail->status == 1) {

            $plan = Plan::find($plan_detail->plan_id);

            $items = Item::where('org_id', '=', $org->id)->get();

            if (count($items) < $plan->no_items) {

                $device = Device::find($request['device']);
                $category = Category::find($request['category']);

                $check = Item::where(["item_cart_id" => $request->item, "device_id" => $request->device])->get();
                if (count($check) > 0) {
                    return back()->with("error", "Item Already Exist In The Device, Please try another device.");
                }
                $item = Item::create([
                    'item_cart_id' => $request['item'],
                    'device_id' => $request['device'],
                    'org_id' => Auth::user()->organization_id,
                ]);

                Item::where('id', '=', $item->id)->update([
                    'item_cart_id' => $request['item'],
                    'device_id' => $request['device'],
                    'org_id' => Auth::user()->organization_id,
                ]);

                return redirect()->route('show_items', ['id' => $request['device']])->with(['success' => $item->item_cart->name . ' is added to system as Item']);
            } else {
                return back()->with('error', "Sorry, You have reached the maximum number of Items allowed for your Plan. Upgrade to enjoy more of our services");
            }
        } else {
            return back()->with('error', "You don't have any active plan, Subscribe and try again.");
        }

        // //Api
        // $with_q = $request['with_q'] ? 'true' : 'false';
        // $with_p = $request['with_p'] ? 'true' : 'false';

        // $hash = hash(
        //     'sha512',
        //     $request['code'] .
        //         $device->id .
        //         $category->name .
        //         $request['name'] .
        //         $request['measure'] .
        //         $request['unit'] .
        //         $with_q .
        //         $with_p
        // );

        // $url = 'https://api.ajisaqsolutions.com/api/item/add?apiUser=' .
        //     config('app.apiUser') . '&apiKey=' .
        //     config('app.apiKey') . '&hash=' .
        //     $hash .  '&code=' .
        //     $request['code'] . '&id=' .
        //     $item->id . '&deviceId=' .
        //     $device->id . '&category=' .
        //     $category->name . '&name=' .
        //     $request['name'] . '&measure=' .
        //     $request['measure'] . '&unit=' .
        //     $request['unit'] . '&withQuantity=' .
        //     $with_q . '&withFromTo=' .
        //     $with_p;

        // $response = Http::post($url);
        // $res = json_decode($response);

        // if ($res->status != "Ok") {
        //     $item->delete();
        //     return back()->with(['error' => 'Sorry, An error was encountered, Come back later.'])->withInput();
        // }
        // //End api

        // return redirect()->route('show_items', ['id' => $request['device']])->with(['success' => $item->name . ' is added to system as Item']);
    }

    public function create_category(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'org' => ['required', 'int', 'max:255'],
        ]);

        if ($validator->fails()) {
            return back()->with('error', 'Category not Created. Try again!');
        }

        $car = Category::create([
            'name' => $request['name'],
        ]);


        Category::where('id', '=', $car->id)->update([
            'org_id' => $request['org'],
        ]);

        return back()->with(['success' => 'Category is Created to system']);
    }


    // public function show_edit_item($d_id, $i_id)
    // {
    //     $device = Device::find($d_id);
    //     $item = Item::find($i_id);

    //     return view('items.edit', compact('device', 'item'));
    // }

    // public function update_item(Request $request, $id)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'name' => ['required', 'string', 'max:255'],
    //         'measure' => ['required', 'int', 'max:255'],
    //         'unit' => ['required', 'string', 'max:255'],
    //         'code' => ['required', 'string', 'max:255'],
    //         'with_q' => ['required', 'int', 'max:255'],
    //         'with_p' => ['required', 'iny', 'max:255'],
    //         'category' => ['required', 'string', 'max:255'],
    //     ]);

    //     if (!$validator) {
    //         return back()->with('error', 'Item not Updated. Try again!');
    //     }

    //     $item = Item::where('id', '=', $id)->update([
    //         'name' => $request['name'],
    //         'measure' => $request['measure'] * 100,
    //         'unit' => $request['unit'],
    //         'code' => $request['code'],
    //         'with_q' => $request['with_q'],
    //         'with_p' => $request['with_p'],
    //     ]);


    //     Item::where('id', '=', $id)->update([
    //         'category_id' => $request['category'],
    //     ]);

    //     return back()->with(['success' => 'Item is Updated successfully']);
    // }

    public function delete_item($id)
    {

        $item_in_device = Item::where('id', $id)->get();

        if(count($item_in_device) > 0){

            $state_of_item = false;

            foreach ($item_in_device as $i_in_d) {
                $check_item_in_store = ItemInStore::where('item_id', '=', $i_in_d->id)->get();
                $state_of_item = count($check_item_in_store) > 0 ? true : false;
            }

            if ($state_of_item) {
                return back()->with(['error' => "SORRY, Can't delete Item. \nMake sure that the item is not existing in a store."]);
            }
            
            $res = Item::where('id', $id)->delete();
    
            if ($res) {
                return back()->with(['success' => 'One Item is Deleted from system']);
            } else {
                return back()->with(['error' => 'Item NOT Deleted from system. Try Again!']);
            }
        }

    }
}
