<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Customer;
use App\Models\Device;
use App\Models\MobileMoney;
use App\Models\Payment;
use App\Models\PaymentGateway;
use App\Models\Payroll;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class PayrollController extends Controller
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

    public function index()
    {
        $payrolls = Payroll::where("org_id", '=', Auth::user()->organization_id)->get();

        $arr = [];
        foreach ($payrolls as $p) {
            $no = $p->ref_id;
            array_push($arr, $no);
        }
        $p_s = array_unique($arr);
        $p_ss = array_reverse($p_s);

        return view("payroll.index", compact("p_ss"));
    }

    public function show_create()
    {
        return view("payroll.create");
    }

    public function show_review(Request $request)
    {
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

        // load transactions by customer
        if ($request->request_type == "customer") {

            if (!$request->data_d) {
                return back()->with('error', 'Make sure you select Customer.');
            }
            $customer = Customer::find($request->data_d);

            $transactions = Transaction::where(['customer_id' => $customer->id, 'p_status' => 0, 'type' => "collection"])
                ->whereBetween('date', [$from . '-00-00-00', $to . '-23-59-59'])
                // ->whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59'])
                ->get();

            if ($transactions) {
                if (count($transactions) > 0) {
                    return view('payroll.create_review_customer', compact('transactions', 'customer', 'from', 'to', 'months'));
                } else {
                    return back()->with('error', 'No Transaction for this ' . $request->request_type . ".");
                }
            }
        }

        // load transactions by Agent
        if ($request->request_type == "agent") {
            if (!$request->data_d) {
                return back()->with('error', 'Make sure you select Agent.');
            }
            $agent = Agent::find($request->data_d);
            $transactions = Transaction::where(['agent_id' => $agent->id, 'p_status' => 0, 'type' => "collection"])
                ->whereBetween('date', [$from . '-00-00-00', $to . '-23-59-59'])
                ->get();
            if ($transactions) {
                if (count($transactions) > 0) {
                    return view('payroll.create_review_agent', compact('transactions', 'agent', 'from', 'to', 'months'));
                } else {
                    return back()->with('error', 'No Transaction for this Agent.');
                }
            }
        }

        // load transactions by Device
        if ($request->request_type == "device") {
            if (!$request->data_d) {
                return back()->with('error', 'Make sure you select a device.');
            }
            $device = Device::find($request->data_d);
            $transactions = Transaction::where(['device_id' => $device->id, 'p_status' => 0, 'type' => "collection"])
                ->whereBetween('date', [$from . '-00-00-00', $to . '-23-59-59'])
                // ->whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59'])
                ->get();
            if ($transactions) {
                if (count($transactions) > 0) {
                    return view('payroll.create_review_device', compact('transactions', 'device', 'from', 'to', 'months'));
                } else {
                    return back()->with('error', 'No Transaction from this Device.');
                }
            }
        }

        return $request->all();
    }

    public function store_payroll(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tag' => ['required', 'string', 'max:255'],
            'customer' => ['required'],
            'from' => ['required'],
            'to' => ['required'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $tag = explode("(", $request->tag);
        $tag_data = explode(")", $tag[1]);
        $ref_id = sha1(time());

        foreach ($request->customer as $c) {
            if ($tag[0] == "Customer") {
                $trans = Transaction::where(["org_id" => Auth::user()->organization_id, "customer_id" => $c, "p_status" => 0, 'type' => "collection"])
                    ->whereBetween('date', [$request->from . '-00-00-00', $request->to . '-23-59-59'])
                    // ->whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59'])
                    ->get();
            }
            if ($tag[0] == "Agent") {
                $trans = Transaction::where(["org_id" => Auth::user()->organization_id, "customer_id" => $c, "p_status" => 0, "agent_id" => $tag_data[0], 'type' => "collection"])
                    ->whereBetween('date', [$request->from . '-00-00-00', $request->to . '-23-59-59'])
                    // ->whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59'])
                    ->get();
            }
            if ($tag[0] == "Device") {
                $trans = Transaction::where(["org_id" => Auth::user()->organization_id, "customer_id" => $c, "p_status" => 0, "device_id" => $tag_data[0], 'type' => "collection"])
                    ->whereBetween('date', [$request->from . '-00-00-00', $request->to . '-23-59-59'])
                    // ->whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59'])
                    ->get();
            }

            foreach ($trans as $t) {
                Payroll::create([
                    "org_id" => Auth::user()->organization_id,
                    "transaction_id" => $t->id,
                    "customer_id" => $c,
                    "status" => 0,
                    "tag" => $request->tag,
                    "ref_id" => $ref_id,
                ]);
            }
        }
        return redirect()->route("payroll_index")->with("success", "Payroll Is Created Successfully");
    }

    public function get_payroll_by_ref_id($ref_id)
    {
        $payrolls = Payroll::where(["ref_id" => $ref_id])->get();

        return view('payroll.payroll_detail', compact('payrolls'));
    }

    public function delete($ref_id)
    {
        $payroll = Payroll::where("ref_id", "=", $ref_id)->delete();

        if ($payroll) {
            return back()->with("success", "You have successfully deleted a payroll.");
        } else {
            return back()->with("error", "Failed to delete Payroll, Try again.");
        }
    }

    public function payroll_make_payment(Request $request, $ref_id)
    {
        $validator = Validator::make($request->all(), [
            'tag' => ['required', 'string', 'max:255'],
            'customer' => ['required'],
            // 'from' => ['required'],
            // 'to' => ['required'],
            'amount' => ['required'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $gateway = PaymentGateway::where('org_id', '=', Auth::user()->organization_id)->get();

        // dd(Auth::user()->organization->name);

        foreach ($gateway as $g) {

            $mobile_money = MobileMoney::find($g->gateway_code);

            if ($mobile_money->url == 'https://api.console.eyowo.com') {

                $refresh_t = Http::withHeaders([
                    'Content-Type' => 'application/json ',
                    'X-App-Key' => config('app.eyowo_app_key'),
                ])->post($mobile_money->url . '/v1/users/accessToken', [
                    'refreshToken' => $g->token,
                ]);
                $ref_t = json_decode($refresh_t);

                if ($ref_t->success == true) {

                    foreach ($request->customer as $cus) {
                        $customer = Customer::find($cus);
                        $payrolls = Payroll::where(['ref_id' => $ref_id, "customer_id" => $cus])->get();
                        $transactions = [];
                        $a = 0;
                        $tran = Transaction::where(['p_status' => 0, 'customer_id' => $cus, 'type' => "collection"])->get();
                        foreach ($tran as $tr) {
                            foreach ($payrolls as $p) {
                                if ($tr->id == $p->transaction_id) {
                                    array_push($transactions, $p->transaction_id);
                                    $a += $p->transaction->amount;
                                }
                            }
                        }

                        $new = substr($customer->phone, -10);
                        $num = '234' . $new;

                        //transfer to phone start
                        $response = Http::withHeaders([
                            'Content-Type' => 'application/json ',
                            'X-App-Key' => config('app.eyowo_app_key'),
                            'X-App-Wallet-Access-Token' => $ref_t->data->accessToken,
                        ])->post($mobile_money->url . '/v1/users/transfers/phone', [
                            'sendSms' => false,
                            'mobile' => $num,
                            'amount' => $a * 100,
                        ]);
                        $res = json_decode($response);

                        if ($res->success == true) {

                            $payments = Payment::create([
                                'from_id' => Auth::user()->organization_id,
                                'to_id' => $customer->id,
                                'status' => true,
                                'type' => 'Transaction payment from ' . Auth::user()->organization->name . ' to ' . $customer->name,
                                'ref_num' => $res->data->transaction->reference,
                                'amount' => $a,
                                'gateway_code' => $mobile_money->id,
                            ]);
                            Payment::where('id', '=', $payments->id)->update([
                                'amount' => $a,
                            ]);

                            foreach ($transactions as $t) {
                                $transaction = Transaction::where('id', '=', $t)->update([
                                    'p_status' => 1,
                                ]);
                            }
                            Payroll::where(["ref_id" => $ref_id, 'customer_id' => $customer->id])->update([
                                "status" => 1,
                            ]);
                        } else {
                            return back()->with('error', $res->error);
                        }
                        //transfer to phone end
                    }
                    return back()->with('success', 'Payment to ' . $customer->name . ' for all his transactions is successful, Thank you.');
                } else {
                    return back()->with('error', $ref_t->error);
                }
            } else {
                return back()->with('error', 'Wallet Not found! Make sure you Have added Wallet in Your Profile.');
            }
        }
    }

    // py for all transaction but one customer
    public function pay_all_tran_p_c($c_number, $c_customerId, $c_name, $t_amount, $transactions)
    {

        $gateway = PaymentGateway::where('org_id', '=', Auth::user()->organization_id)->get();

        // dd(Auth::user()->organization->name);

        foreach ($gateway as $g) {

            $new = substr($c_number, -10);
            $num = '234' . $new;

            $mobile_money = MobileMoney::find($g->gateway_code);

            if ($mobile_money->url == 'https://api.console.eyowo.com') {

                $refresh_t = Http::withHeaders([
                    'Content-Type' => 'application/json ',
                    'X-App-Key' => config('app.eyowo_app_key'),
                ])->post($mobile_money->url . '/v1/users/accessToken', [
                    'refreshToken' => $g->token,
                ]);
                $ref_t = json_decode($refresh_t);

                if ($ref_t->success == true) {

                    //transfer to phone start
                    $response = Http::withHeaders([
                        'Content-Type' => 'application/json ',
                        'X-App-Key' => config('app.eyowo_app_key'),
                        'X-App-Wallet-Access-Token' => $ref_t->data->accessToken,
                    ])->post($mobile_money->url . '/v1/users/transfers/phone', [
                        'sendSms' => false,
                        'mobile' => $num,
                        'amount' => $t_amount * 100,
                    ]);
                    $res = json_decode($response);

                    if ($res->success == true) {
                        $customer = Customer::where('id', $c_customerId)->get();

                        $payments = Payment::create([
                            'from_id' => Auth::user()->organization_id,
                            'to_id' => $customer[0]->id,
                            'status' => true,
                            'type' => 'Transaction payment from ' . Auth::user()->organization->name . ' to ' . $customer[0]->name,
                            'ref_num' => $res->data->transaction->reference,
                            'amount' => $t_amount,
                            'gateway_code' => $mobile_money->id,
                        ]);

                        foreach ($transactions as $t) {
                            $transaction = Transaction::where('id', '=', $t)->update([
                                'p_status' => 1,
                            ]);
                        }
                        // return back()->with('success', 'Payment to ' . $request->c_name . ' for All transactions is successful, Thank you.');
                    } else {
                        return back()->with('error', $res->error);
                    }
                    //transfer to phone end

                } else {
                    return back()->with('error', $ref_t->error);
                }
            } else {
                return back()->with('error', 'Wallet Not found! Make sure you Have added Wallet in Your Profile.');
            }
        }

        return back()->with('error', 'No Wallet Gateway is allocated to this Organization.');
    }
}
