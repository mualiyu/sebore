<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
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

    public function show_customers($id)
    {
        $agent = Agent::find($id);

        $customers = Customer::where('agent_id', '=', $id)->orderBy('created_at', 'desc')->get();
        // dd($customers);

        return view('customers.index', compact('customers', 'agent'));
    }

    public function show_add_customer($id)
    {
        $agent = Agent::find($id);
        return view('customers.add_customer', compact('agent'));
    }

    public function create_customer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'lga' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'gps' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return back()->with('error', 'Customer not Created. Try again!');
        }
        // dd($request->all());

        $customer = Customer::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'gps' => $request['gps'],
            'state' => $request['state'],
            'country' => $request['country'],
            'address' => $request['address'],
            'lga' => $request['lga'],
        ]);


        Customer::where('id', '=', $customer->id)->update([
            'agent_id' => $request['agent'],
        ]);

        return redirect()->route('show_customers', ['id' => $request['agent']])->with(['success' => $customer->name . ' is Created to system']);

        // dd($request->all());
    }

    public function delete_customer($id)
    {
        $res = Customer::where('id', $id)->delete();

        if ($res) {
            return back()->with(['success' => 'One Customer is Deleted from system']);
        } else {
            return back()->with(['error' => 'Customer NOT Deleted from system. Try Again!']);
        }
    }

    public function show_edit_customer($a_id, $c_id)
    {
        $agent = Agent::find($a_id);
        $customer = Customer::find($c_id);
        // dd($customer);

        return view('customers.edit', compact('agent', 'customer'));
    }


    public function update_customer(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'lga' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'gps' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return back()->with('error', "Update fail. Make sure all field's are correct, And Try again!");
        }
        // dd($request->all());

        $customer = Customer::where('id', '=', $id)->update([
            'name' => $request['name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'gps' => $request['gps'],
            'state' => $request['state'],
            'country' => $request['country'],
            'address' => $request['address'],
            'lga' => $request['lga'],
        ]);


        // Customer::where('id', '=', $customer->id)->update([
        //     'agent_id' => $request['agent'],
        // ]);

        return back()->with(['success' => 'Customer is Updated Successfully']);

        // dd($request->all());
    }
}
