<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CustomersImport;
use App\Models\Organization;
use App\Models\Plan;
use App\Models\PlanDetail;
use PHPExcelReader\SpreadsheetReader as Reader;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

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

        $customers = $agent->customers;
        // $customers = Customer::where('agent_id', '=', $id)->orderBy('created_at', 'desc')->get();

        return view('customers.index', compact('customers', 'agent'));
    }

    public function show_all_customers()
    {
        $customers = Customer::where('org_id', '=', Auth::user()->organization_id)->orderBy('created_at', 'desc')->get();

        return view('customers.all', compact('customers'));
    }

    public function show_add_customer($id)
    {
        $agent = Agent::find($id);
        return view('customers.add_customer', compact('agent'));
    }

    public function show_add_direct_customer()
    {
        $agent = null;
        return view('customers.add_customer', compact('agent'));
    }

    public function create_customer(Request $request)
    {
        $org = Organization::find(Auth::user()->organization_id);
        // return $request->all();
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255', 'unique:customers'],
            'address' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'lga' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'gps' => ['nullable', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $plan_detail = PlanDetail::where('org_id', '=', $org->id)->orderBy('id', 'desc')->first();

        if ($plan_detail && $plan_detail->status == 1) {

            $plan = Plan::find($plan_detail->plan_id);

            // return $plan;
            $cus = Customer::where('org_id', '=', $org->id)->get();

            if (count($cus) < $plan->no_customers) {

                $agent = Agent::find($request['agent']);

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
                    'org_id' => Auth::user()->organization_id,
                ]);

                $agent_customer = DB::table('agent_customer')->insert([
                    'agent_id' => $agent->id,
                    'customer_id' => $customer->id
                ]);

                return redirect()->route('show_customers', ['id' => $request['agent']])->with(['success' => $customer->name . ' is created to system']);
            } else {
                return back()->with('error', "Sorry, You have reached the maximum number of Customers allowed for your Plan. Upgrade to enjoy more of ATS services");
            }
        } else {
            return back()->with('error', "You don't have any active plan, Subscribe and try again.");
        }
    }

    public function delete_customer($id)
    {
        $res = Customer::where('id', $id)->delete();
        if ($res) {
            $a_c = DB::table('agent_customer')->where('customer_id', $id)->delete();
            return back()->with(['success' => 'One Customer is Deleted from system']);
        } else {
            return back()->with(['error' => 'Customer NOT Deleted from system. Try Again!']);
        }
    }

    public function remove_customer_from_agent($c_id, $a_id)
    {
        $res = DB::table('agent_customer')->where(['customer_id' => $c_id, 'agent_id' => $a_id])->delete();

        if ($res) {
            return back()->with(['success' => 'One Customer is removed from system']);
        } else {
            return back()->with(['error' => 'Customer NOT Deleted from system. Try Again!']);
        }
    }

    public function show_edit_customer($c_id)
    {
        // $agent = Agent::find($a_id);
        $customer = Customer::find($c_id);
        // dd($customer);

        return view('customers.edit', compact('customer'));
    }


    public function update_customer(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'lga' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return back()->with('error', "Update fail. Make sure all field's are correct, And Try again!")->withInput();
        }

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

        return back()->with(['success' => 'Customer is Updated Successfully']);
    }

    public function import_customers(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "file" => "required",
        ]);

        if ($validator->fails()) {
            return back()->with(['error' => 'Make sure you upload a csv file'])->withInput();
        }

        $id = $request->agent;
        Excel::import(new CustomersImport($id), $request->file('file'));

        return back()->with(['success' => "Customers uploaded Successful"]);
    }

    public function download_sample()
    {
        $filePath = public_path("assets/sample/sample_customers.csv");

        $headers = ['Content-Type: text/csv'];
        $fileName = 'sample_' . time() . '.csv';

        return response()->download($filePath, $fileName, $headers);
    }

    public function check_customer_by_phone(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->cus;

            $cus = Customer::where('phone', '=', $data)->get();
            if (count($cus) > 0) {
                # code...
                $data = $cus[0];
            } else {
                $data = null;
            }
            return $data;
        }
        return 0;
    }

    public function add_customer_to_agent(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'agent' => ['required'],
            'customer' => ['required']
        ]);

        if ($validator->fails()) {
            return back()->with('error', "Agent is required, Tray again.");
        }

        $agent = Agent::find($request->agent);

        if ($agent) {
            $customer = Customer::find($request->customer);

            if ($customer) {
                $a_c = DB::table('agent_customer')->where(['agent_id' => $agent->id, 'customer_id' => $customer->id])->get();
                if (count($a_c) > 0) {
                    return back()->with('error', "Customer is Already Added To This Agent.");
                } else {
                    $agent_customer = DB::table('agent_customer')->insert([
                        'agent_id' => $agent->id,
                        'customer_id' => $customer->id
                    ]);
                    return redirect()->route('show_customers', ['id' => $request['agent']])->with(['success' => $customer->name . ' is added to ' . $agent->name]);
                }
            } else {
                return back()->with('error', 'Customer Not found');
            }
        } else {
            return back()->with('error', 'Agent Not found');
        }
    }
}
