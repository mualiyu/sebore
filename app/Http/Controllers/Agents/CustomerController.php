<?php

namespace App\Http\Controllers\Agents;

use App\Http\Controllers\Controller;
use App\Imports\CustomersImport;
use App\Models\Agent;
use App\Models\Customer;
use App\Models\Organization;
use App\Models\Plan;
use App\Models\PlanDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('AgentAuth');
    }

    public function index()
    {
        $a = session('Agent');

        $agent = Agent::where('id', '=', $a->id)->with('customers')->get();
        $agent = $agent[0];

        return view('sites.agent.customer.all', compact('agent'));
    }

    public function show_add_customer()
    {
        $agent = session('Agent');

        return view('sites.agent.customer.add_customer', compact('agent'));
    }

    public function create_customer(Request $request)
    {
        $agent = session('Agent');
        $org = Organization::find($agent->org_id);
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
                    'org_id' => $org->id,
                ]);

                $agent_customer = DB::table('agent_customer')->insert([
                    'agent_id' => $agent->id,
                    'customer_id' => $customer->id
                ]);

                return redirect()->route('agent_show_customers')->with(['success' => $customer->name . ' is created to system']);
            } else {
                return back()->with('error', "Sorry, You have reached the maximum number of Customers allowed for your Plan. Contact Your admin for upgrade");
            }
        } else {
            return back()->with('error', "You don't have any active plan, Subscribe and try again.");
        }
    }

    public function delete_customer($id)
    {
        $res = DB::table('agent_customer')->where(['customer_id' => $id, 'agent_id' => session('Agent')->id])->delete();

        if ($res) {
            return back()->with(['success' => 'One Customer is Deleted from system']);
        } else {
            return back()->with(['error' => 'Customer NOT Deleted from system. Try Again!']);
        }
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
                    return back()->with('error', "Customer is Already Added.");
                } else {
                    $agent_customer = DB::table('agent_customer')->insert([
                        'agent_id' => $agent->id,
                        'customer_id' => $customer->id
                    ]);
                    return redirect()->route('agent_show_customers')->with(['success' => $customer->name . ' is added to ' . $agent->name]);
                }
            } else {
                return back()->with('error', 'Customer Not found');
            }
        } else {
            return back()->with('error', 'Agent Not found');
        }
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
}
