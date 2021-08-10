<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Device;
use App\Models\Item;
use Illuminate\Http\Request;
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

    public function show_items($id)
    {
        $device = Device::find($id);

        $items = Item::where('device_id', '=', $id)->orderBy('created_at', 'desc')->get();
        // dd($customers);

        return view('items.index', compact('items', 'device'));
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

    public function create_item(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'measure' => ['required', 'int'],
            'unit' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:255'],
            'with_q' => ['required', 'int', 'max:255'],
            'with_p' => ['required', 'int', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        // dd($request->all());

        $item = Item::create([
            'name' => $request['name'],
            'measure' => $request['measure'] * 100,
            'unit' => $request['unit'],
            'code' => $request['code'],
            'with_q' => $request['with_q'],
            'with_p' => $request['with_p'],
        ]);


        Item::where('id', '=', $item->id)->update([
            'category_id' => $request['category'],
            'device_id' => $request['device'],
        ]);

        return redirect()->route('show_items', ['id' => $request['device']])->with(['success' => $item->name . ' is Created to system']);

        // dd($request->all());
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

        // dd($request->all());
    }


    public function show_edit_item($d_id, $i_id)
    {
        $device = Device::find($d_id);
        $item = Item::find($i_id);
        // dd($customer);

        return view('items.edit', compact('device', 'item'));
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
        // dd($request->all());

        $item = Item::where('id', '=', $id)->update([
            'name' => $request['name'],
            'measure' => $request['measure'] * 100,
            'unit' => $request['unit'],
            'code' => $request['code'],
            'with_q' => $request['with_q'],
            'with_p' => $request['with_p'],
        ]);


        Item::where('id', '=', $id)->update([
            'category_id' => $request['category'],
        ]);

        return back()->with(['success' => 'Item is Updated successfully']);

        // dd($request->all());
    }

    public function delete_item($id)
    {
        // dd($id);
        $res = Item::where('id', $id)->delete();

        if ($res) {
            return back()->with(['success' => 'One Item is Deleted from system']);
        } else {
            return back()->with(['error' => 'Item NOT Deleted from system. Try Again!']);
        }
    }
}
