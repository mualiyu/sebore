<?php

namespace App\Http\Controllers;

use App\Models\Api;
use App\Models\Customer;
use App\Models\Device;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiTransactionController extends Controller
{

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function create(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'api_user' => 'required',
            'api_key' => 'required',
            'agent_id' => 'required',
            'ref_id' => 'required',
            'device_id' => 'required',
            'item_id' => 'required',
            'customer_phone' => 'required',
            'quantity' => 'required',
            'date' => 'required',
            'amount' => 'required',
        ]);

        if ($validator->fails()) {
            $res = [
                'status' => false,
                'data' => $validator->errors(),
            ];
            return response()->json($res);
        }

        $api = Api::where('api_user', '=', $request->api_user)->get();

        if (count($api) > 0) {
            if ($api[0]->api_key == $request->api_key) {

                $device = Device::find($request->device_id);

                $customer = Customer::where('phone', '=', $request->customer_phone)->get();

                $trans = Transaction::where('ref_id', '=', $request->ref_id)->get();

                if (count($trans) > 0) {
                    $res = [
                        'status' => false,
                        'data' => 'RECORD_EXIST',
                    ];
                    return response()->json($res);
                } else {

                    $transaction = Transaction::create([
                        'org_id' => $device->org_id,
                        'agent_id' => $request->agent_id,
                        'device_id' => $request->device_id,
                        'item_id' => $request->item_id,
                        'customer_id' => $customer[0]->id,
                        'quantity' => $request->quantity,
                        'date' => $request->date,
                        'amount' => $request->amount,
                        'ref_id' => $request->ref_id,
                    ]);

                    if ($transaction) {
                        $res = [
                            'status' => true,
                            'data' => $transaction
                        ];
                        return response()->json($res);
                    } else {
                        $res = [
                            'status' => false,
                            'data' => 'Fail to store transaction'
                        ];
                        return response()->json($res);
                    }
                }
            } else {
                $res = [
                    'status' => false,
                    'data' => 'API_KEY Not correct'
                ];
                return response()->json($res);
            }
        } else {
            $res = [
                'status' => false,
                'data' => 'API_USER Not Found'
            ];
            return response()->json($res);
        }
    }
}
