<?php

namespace App\Http\Controllers\Agents;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
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
        return view('sites.agent.transaction.index');
    }

    public function get_transaction_list(Request $request)
    {
        $a = session('Agent');
        $agent = Agent::find($a->id);

        $validator = Validator::make($request->all(), [
            'daterange' => ['required', 'string', 'max:255'],
            'request_type' => ['required'],
            'data_d' => ['string'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $d = explode(' - ', $request->daterange);

        $f = explode('/', $d[0]);
        $from = $f[2] . '-' . $f[0] . '-' . $f[1];
        $t = explode('/', $d[1]);
        $to = $t[2] . '-' . $t[0] . '-' . $t[1];

        $months = array(
            '',
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July ',
            'August',
            'September',
            'October',
            'November',
            'December',
        );

        // if load type is set to all
        if ($request->request_type == "all") {

            $transactions = Transaction::where(['org_id' => $agent->org_id, 'agent_id' => $agent->id])->whereBetween('date', [$from . '-00-00-00', $to . '-23-59-59'])->orderBy('date', 'desc')->get();
            // return $transactions;
            if ($transactions) {

                if (count($transactions) > 0) {
                    // dd(Auth::user()->organization->name);
                    // return view('transactions.all', compact('transactions', 'from', 'to', 'months'));
                    return view('sites.agent.transaction.agents', compact('transactions', 'agent', 'from', 'to', 'months'));
                } else {
                    return back()->with('error', 'No Transaction Within this range. Try Again!');
                }
            }
        }

        // load transactions by customer
        if ($request->request_type == "customer") {

            if (!$request->data_d) {
                return back()->with('error', 'Make sure you select Customer.');
            }
            $customer = Customer::find($request->data_d);

            $transactions = Transaction::where(['customer_id' => $customer->id, 'agent_id' => $agent->id])
                ->whereBetween('date', [$from . '-00-00-00', $to . '-23-59-59'])
                // ->whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59'])
                ->orderBy('date', 'desc')
                ->get();

            if ($transactions) {
                if (count($transactions) > 0) {
                    return view('sites.agent.transaction.customers', compact('transactions', 'customer', 'from', 'to', 'months'));
                } else {
                    return back()->with('error', 'No Transaction for this Customer.');
                }
            }
        }

        return back();
    }


    // search data from database
    public function search_data_t(Request $request)
    {
        $a = session('Agent');
        $agent = Agent::find($a->id);

        if ($request->ajax()) {
            $output = "";

            if ($request->req_type == "customer") {  //Search by customer
                $search = $request->data;

                $customers = Customer::where('org_id', $agent->org_id);
                if (is_string($search) && strlen($search) > 0) {

                    $customers = $customers->where(function ($q) use ($search) {
                        $q->where('name', 'LIKE', '%' . $search . '%')
                            ->orWhere('phone', 'LIKE', '%' . $search . '%')
                            ->orWhere('email', 'LIKE', '%' . $search . '%')
                            ->orWhere('address', 'LIKE', '%' . $search . '%');
                    });
                }
                $data = $customers->get();

                if (count($data) > 0) {
                    $output = '<ul class="list-group" style="display: block;">';
                    $i = 0;
                    foreach ($data as $row) {
                        foreach ($agent->customers as $c) {
                            if ($c->id == $row->id) {
                                $output .= '<li class="list-group-item"  onclick="' . "$('#load').css('display', 'block');" . '"><div class="form-check"><input class="form-check-input" type="radio" name="data_d" value="'
                                    . $row->id . '" id="flexCheckDefault[' . $i . ']"><label class="form-check-label" for="flexCheckDefault[' . $i . ']">'
                                    . $row->name . ' - ' . $row->email . ' - ' . $row->phone .
                                    '</label></div></li>';
                                $i++;
                            }
                        }
                    }
                    $output .= '</ul>';
                } else {

                    $output .= '<li class="list-group-item">' . 'No Customer' . '</li>';
                }
                return $output;
            }

            // return '';
        }
    }
}
