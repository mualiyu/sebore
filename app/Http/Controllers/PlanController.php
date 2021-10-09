<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\PlanDetail;
use App\Models\PlanPaymentRecord;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Unicodeveloper\Paystack\Facades\Paystack;

class PlanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $plans = Plan::all();

        $plan_detail = PlanDetail::where('org_id', '=', Auth::user()->organization_id)->orderBy('id', 'desc')->first();

        return view('plan.index', compact('plans', 'plan_detail'));
    }

    public function pay($id)
    {
        // return Paystack::getAuthorizationUrl()->redirectNow();

        $plan_details = PlanDetail::where('org_id', '=', Auth::user()->organization_id)->orderBy('id', 'desc')->first();
        if ($plan_details) {
            if ($plan_details->status == 1) {

                $plan = Plan::find($plan_details->plan_id);

                if ($plan->id == $id) {
                    return back()->with('error', "You're Already subscribed to " . $plan->name . " ");
                } else {
                    $plan_s = Plan::find($id);
                    return redirect()->route('plan_show_upgrade', ['id' => $plan_s->id, 'p_d' => $plan_details->id]);
                    // return back()->with('error', "Do you want to Upgrade to $plan_s->name <a href='/plan'>Upgrade</a>");
                }
            }
        }
        try {
            return Paystack::getAuthorizationUrl()->redirectNow();
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => 'Sorry an error occur, Please refresh the page and try again.']);
        }
    }

    function plan_show_upgrade($id, $p_d)
    {
        $plan_detail = PlanDetail::find($p_d);
        $plan_s = Plan::find($id);

        return view('plan.single', compact('plan_s', 'plan_detail'));
    }
    public function plan_upgrade()
    {
        try {
            return Paystack::getAuthorizationUrl()->redirectNow();
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => 'Sorry an error occur, Please refresh the page and try again.']);
        }
    }

    public function add_plan_detail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'plan_id' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->with('error', 'Failed, Refresh the page and try again.');
        }

        $plan = Plan::find($request->plan_id);
        $plan_detail = PlanDetail::where('org_id', '=', Auth::user()->organization_id)->orderBy('id', 'desc')->first();
        if ($plan_detail) {
            return back()->with('error', 'failed to Add Free plan seems like your not Eligible for this Plan');
        }
        $p = explode(' ', now());
        $from = $p[0];
        $date = new DateTime($p[0]); // Y-m-d
        $date->add(new DateInterval('P30D'));
        $to = $date->format('Y-m-d');
        // return $to . '    ' . $from;

        $paymentDetail = PlanDetail::create([
            'plan_id' => $request->plan_id,
            'org_id' => Auth::user()->organization_id,
            'status' => '1',
            'from' => $from,
            'to' => $to,
        ]);
        if ($paymentDetail) {
            return redirect()->route('home')->with('success', 'You have successfully subscribed for ' . $plan->name . ' plan Monthly. Email is sent at ' . Auth::user()->email . ' ');
        }
    }

    public function payment_callback()
    {
        // return 0;
        $paymentDetails = Paystack::getPaymentData();

        // dd($paymentDetails);

        if ($paymentDetails) {
            # code...
            if ($paymentDetails['status'] == true) {

                $data = $paymentDetails['data'];
                $plan = Plan::find($data['metadata']['plan_id']);

                if ($data['status'] == 'success') {

                    if ($data['metadata']['upgrade'] == 0) {
                        # code...
                        $plan_payment_record = PlanPaymentRecord::create([
                            'org_id' => Auth::user()->organization_id,
                            'plan_id' => $data['metadata']['plan_id'],
                            'amount' => $data['amount'],
                            'status' => '1',
                            'ref_num' => $data['reference'],
                            'transaction_date' => $data['transaction_date'],
                            'customer_code' => $data['customer']['customer_code'],
                        ]);

                        if ($plan_payment_record) {
                            $paid_at = $data['paid_at'];
                            $p = explode('T', $paid_at);
                            $from = $p[0];
                            $date = new DateTime($p[0]); // Y-m-d
                            $date->add(new DateInterval('P30D'));
                            $to = $date->format('Y-m-d');
                            // return $to . '    ' . $from;

                            $paymentDetail = PlanDetail::create([
                                'plan_id' => $data['metadata']['plan_id'],
                                'org_id' => Auth::user()->organization_id,
                                'status' => '1',
                                'from' => $from,
                                'to' => $to,
                            ]);

                            if ($paymentDetail) {
                                return redirect('/plan')->with('success', 'You have successfully subscribed for ' . $plan->name . ' plan Monthly. Email is sent at ' . Auth::user()->email . ' ');
                            }
                        }
                    } else {

                        $plan_detail = PlanDetail::where('org_id', '=', Auth::user()->organization_id)->orderBy('id', 'desc')->first();

                        PlanDetail::where('id', '=', $plan_detail->id)->update([
                            'status' => 0
                        ]);

                        $plan_payment_record = PlanPaymentRecord::create([
                            'org_id' => Auth::user()->organization_id,
                            'plan_id' => $data['metadata']['plan_id'],
                            'amount' => $data['amount'],
                            'status' => '1',
                            'ref_num' => $data['reference'],
                            'transaction_date' => $data['transaction_date'],
                            'customer_code' => $data['customer']['customer_code'],
                        ]);

                        if ($plan_payment_record) {
                            $paid_at = $data['paid_at'];
                            $p = explode('T', $paid_at);
                            $from = $p[0];
                            $date = new DateTime($p[0]); // Y-m-d
                            $date->add(new DateInterval('P30D'));
                            $to = $date->format('Y-m-d');
                            // return $to . '    ' . $from;

                            $paymentDetail = PlanDetail::create([
                                'plan_id' => $data['metadata']['plan_id'],
                                'org_id' => Auth::user()->organization_id,
                                'status' => '1',
                                'from' => $from,
                                'to' => $to,
                            ]);

                            if ($paymentDetail) {
                                return redirect('/plan')->with('success', 'You have successfully subscribed for ' . $plan->name . ' plan Monthly. Email is sent at ' . Auth::user()->email . ' ');
                            }
                        }
                    }
                } else {
                    return back()->with('error', 'Payment has not been made. Try again!');
                }
            } else {
                return back()->with('error', $paymentDetails['message']);
            }
        } else {
            return back()->with('error', 'Sorry, Make sure you are connected to network and Try again!');
        }
        // dd($paymentDetails);
    }
}
