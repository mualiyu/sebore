<?php

namespace App\Http\Controllers;

use App\Models\MobileMoney;
use App\Models\PaymentGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use PharIo\Manifest\Url;

class PaymentGatewayController extends Controller
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

    public function add_update_gateway_details(Request $request)
    {
        if ($request->ajax()) {

            $validator = Validator::make($request->all(), [
                'gateway' => ['required', 'string'],
                'client_id' => ['required', 'string', 'max:255'],
            ]);

            if ($validator->fails()) {
                return ['error' => 'Input fields required, Try again!'];
            }

            $mobile_money = MobileMoney::find($request->gateway);

            if ($mobile_money->url == 'https://api.console.eyowo.com') {
                $new = substr($request->client_id, -10);
                $num = '234' . $new;

                $validate_client = Http::withHeaders([
                    'Content-Type' => 'application/json ',
                    'X-App-Key' => config('app.eyowo_app_key'),
                ])->post($mobile_money->url . '/v1/users/auth/validate', [
                    'mobile' => $num,
                ]);

                $val = json_decode($validate_client);

                if ($val->success == true) {

                    $send_otp = Http::withHeaders([
                        'Content-Type' => 'application/json ',
                        'X-App-Key' => config('app.eyowo_app_key'),
                    ])->post($mobile_money->url . '/v1/users/auth', [
                        'mobile' => $num,
                        'factor' => 'sms',
                    ]);

                    $send_otp = json_decode($send_otp);

                    if ($send_otp->success == true) {
                        $info = $request->all();
                        $info = json_encode($info);
                        $info = json_decode($info);
                        $val_info = $val->data->user;

                        $data = [
                            'val_info' => $val_info,
                            'info' => $info,
                            // 'error' => '',
                            'success' => 'OTP is been sent to you phone. If Not seen after One minute, A re-send button wit appear to request Another OPT! Thank you.'
                        ];
                        return $data;
                        // return view('payment.otp', compact('info', 'val_info'))
                        //     ->with('success', 'OTP is been sent to you phone. If Not seen after One minute, A re-send button wit appear to request Another OPT! Thank you.');

                        // dd($info, $val_info);
                        // return redirect()
                        // ->route('show_otp_eyowo')
                        // ->with(compact('info', 'val_info'));
                        // ->with('info', $info)->with('val_info', $val_info);
                        // ->with('success', 'OTP is been sent to you phone. If Not seen after One minute, A re-send button wit appear to request Another OPT! Thank you.');
                    } else {
                        return ['error' => 'Eyowo says, ' . $send_otp->error];
                        // return back()->with('error', 'Eyowo says, ' . $send_otp->error);
                    }

                    // dd($val->data);
                    //08168221826
                    // return back()->with('success', 'Payment for ' . $request->i_name . ' is Successful! Thank you.');
                } else {
                    return ['error' => 'Eyowo says, ' . $val->error];
                    // return back()->with('error', 'Eyowo says, ' . $val->error);
                }
            }
        }



        // dd($request->all(), $mobile_money);
    }

    public function show_otp_eyowo()
    {
        return view('payment.otp');
    }

    public function verify_otp_eyowo(Request $request)
    {
        // dd($request->otp_code);
        $validator = Validator::make($request->all(), [
            'otp_code' => ['required'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $mobile_money = MobileMoney::find($request->otp_gateway);

        $new = substr($request->otp_eyowo_c_mobile, -10);
        $num = '234' . $new;

        $verify_otp = Http::withHeaders([
            'Content-Type' => 'application/json ',
            'X-App-Key' => config('app.eyowo_app_key'),
        ])->post($mobile_money->url . '/v1/users/auth', [
            'mobile' => $num,
            'factor' => 'sms',
            'passcode' => $request->otp_code,
        ]);

        $verify_otp = json_decode($verify_otp);

        if ($verify_otp->success == true) {

            $payment_gateway = PaymentGateway::create([
                'org_id' => Auth::user()->organization_id,
                'gateway_code' => $request->otp_gateway,
                'client_id' => $request->otp_eyowo_c_mobile,
                'token' => $verify_otp->data->refreshToken,
            ]);
            return back()->with('success', 'Eyowo says, ' . $verify_otp->message);
            // dd($verify_otp);
        } else {
            // return ['error' => 'Eyowo says, ' . $send_otp->error];
            return back()->with('error', 'Eyowo says, ' . $verify_otp->error);
        }


        // dd($request->all());
    }
}
