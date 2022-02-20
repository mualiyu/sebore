<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Device;
use App\Models\Item;
use App\Models\ItemsCart;
use App\Models\Organization;
use App\Models\Plan;
use App\Models\PlanDetail;
// use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ItemsCartController extends Controller
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

    public function show_all_items()
    {
        $items = ItemsCart::where('org_id', '=', Auth::user()->organization_id)->orderBy('created_at', 'desc')->get();

        return view('items_cart.all', compact('items'));
    }

    public function show_add_item()
    {
        return view('items_cart.add_item');
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
            'name' => ['required', 'string', 'max:255'],
            'measure' => ['required', 'int'],
            'unit' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:255'],
            'with_q' => ['required', 'int', 'max:255'],
            'with_p' => ['required', 'int', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            "image" => "image|mimes:jpeg,jpg,png,gif|max:9000",
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $plan_detail = PlanDetail::where('org_id', '=', $org->id)->orderBy('id', 'desc')->first();

        if ($plan_detail && $plan_detail->status == 1) {

            $plan = Plan::find($plan_detail->plan_id);

            $items = Item::where('org_id', '=', $org->id)->get();

            if (count($items) < $plan->no_items) {

                if ($request->hasFile("image")) {
                    $imageNameWExt = $request->file("image")->getClientOriginalName();
                    $imageName = pathinfo($imageNameWExt, PATHINFO_FILENAME);
                    $imageExt = $request->file("image")->getClientOriginalExtension();

                    $imageNameToStore = $imageName . "_" . time() . "." . $imageExt;

                    $request->file("image")->storeAs("public/item/pic", $imageNameToStore);
                    $image_url = url('/storage/item/pic/' . $imageNameToStore);
                } else {
                    // $imageNameToStore = $user[0]->picture;
                    $image_url = url('/storage/item/pic/default.jpg');
                    // return back()->with('error', 'Item Image not Uploaded. Try again!');
                }

                $category = Category::find($request['category']);

                $item = ItemsCart::create([
                    'name' => $request['name'],
                    'measure' => $request['measure'],
                    'unit' => $request['unit'],
                    'code' => $request['code'],
                    'with_q' => $request['with_q'],
                    'with_p' => $request['with_p'],
                    'image' => $image_url,
                ]);

                ItemsCart::where('id', '=', $item->id)->update([
                    'category_id' => $request['category'],
                    // 'device_id' => $request['device'],
                    'org_id' => Auth::user()->organization_id,
                    'image' => $image_url,
                ]);

                return redirect()->route('show_all_items')->with(['success' => $item->name . ' is added to system as Item']);
            } else {
                return back()->with('error', "Sorry, You have reached the maximum number of Items allowed for your Plan. Upgrade to enjoy more of ATS services");
            }
        } else {
            return back()->with('error', "You don't have Any Active plan, Subscribe and try again.");
        }
    }

    public function show_edit_item($id)
    {
        $item = ItemsCart::find($id);

        return view('items_cart.edit', compact('item'));
    }

    public function update_item(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'measure' => ['required', 'int', 'max:255'],
            'unit' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:255'],
            'with_q' => ['required', 'int', 'max:255'],
            'with_p' => ['required', 'iny', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
        ]);

        if (!$validator) {
            return back()->with('error', 'Item not Updated. Try again!');
        }

        $i = ItemsCart::find($id);

        if ($request->hasFile("image")) {
            $imageNameWExt = $request->file("image")->getClientOriginalName();
            $imageName = pathinfo($imageNameWExt, PATHINFO_FILENAME);
            $imageExt = $request->file("image")->getClientOriginalExtension();

            $imageNameToStore = $imageName . "_" . time() . "." . $imageExt;

            $request->file("image")->storeAs("public/item/pic", $imageNameToStore);
            $image_url = url('/storage/item/pic/' . $imageNameToStore);
        } else {
            // $imageNameToStore = $user[0]->picture;
            if ($i->image) {
                # code...
                $image_url = $i->image;
            } else {
                $image_url = url('/storage/item/pic/default.jpg');
            }
            // return back()->with('error', 'Item Image not Uploaded. Try again!');
        }


        $item = ItemsCart::where('id', '=', $id)->update([
            'name' => $request['name'],
            'measure' => $request['measure'],
            'unit' => $request['unit'],
            'code' => $request['code'],
            'with_q' => $request['with_q'],
            'with_p' => $request['with_p'],
            'image' => $image_url,
        ]);


        ItemsCart::where('id', '=', $id)->update([
            'category_id' => $request['category'],
            'image' => $image_url,
        ]);

        return back()->with(['success' => 'Item is Updated successfully']);
    }

    public function delete_item($id)
    {

        $i = Item::where('item_cart_id', '=', $id)->delete();

        if ($i) {
            $res = ItemsCart::where('id', '=', $id)->delete();

            if ($res) {
                return back()->with(['success' => 'One Item is Deleted from system']);
            } else {
                return back()->with(['error' => 'Item NOT Deleted from system. Try Again!']);
            }
        } else {
            $res = ItemsCart::where('id', '=', $id)->delete();

            if ($res) {
                return back()->with(['success' => 'One Item is Deleted from system']);
            } else {
                return back()->with(['error' => 'Item NOT Deleted from system. Try Again!']);
            }
        }
        return back()->with(['error' => 'Item NOT Deleted from system, Try Again!']);
    }
}
