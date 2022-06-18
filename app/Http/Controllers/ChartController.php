<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function PHPSTORM_META\type;

class ChartController extends Controller
{

    public function bar(Request $request)
    {
        if ($request->ajax()) {
            $d = explode(' - ', $request->range);

            $f = explode('/', $d[0]);
            $from = $f[2] . '-' . $f[0] . '-' . $f[1];
            $t = explode('/', $d[1]);
            $to = $t[2] . '-' . $t[0] . '-' . $t[1];

            $type = $request->req_type;

            $transactions = Transaction::where(['org_id' => Auth::user()->organization_id, 'type' => 'collection'])->whereBetween('date', [$from . '-00-00-00', $to . '-23-59-59'])->get();

            if ($type == "agents") {
                $agentss = [];
                foreach ($transactions as $t) {
                    array_push($agentss, $t->agent_id);
                }
                $agents = array_unique($agentss);

                $data = [];
                foreach ($agents as $a) {
                    $a_transactions = Transaction::where(['org_id' => Auth::user()->organization_id, 'agent_id' => $a, 'type' => 'collection'])->whereBetween('date', [$from . '-00-00-00', $to . '-23-59-59'])->get();
                    $agent_name = $a_transactions[0]->agent->name;
                    $amount = 0;
                    foreach ($a_transactions as $tt) {
                        $amount += $tt->amount;
                    }

                    // $arr = [
                    //     'value' => $amount,
                    //     'year' => $agent_name,
                    // ];

                    // $ar = array("y" => $amount, "label" =>  $agent_name);
                    $ar = array("value" => (int)$amount, "year" =>  $agent_name);

                    array_push($data, $ar);
                }

                // $data = json_encode($data, JSON_NUMERIC_CHECK);

                $info = [
                    "type" => "Agents",
                    "detail" => "Agents summary",
                    "data" => $data
                ];
                return $info;
            }

            if ($type == "customers") {
                $cuss = [];
                foreach ($transactions as $t) {
                    array_push($cuss, $t->customer_id);
                }
                $customers = array_unique($cuss);

                // cuntinue same for customers
                $data = [];
                foreach ($customers as $c) {
                    $c_transactions = Transaction::where(['org_id' => Auth::user()->organization_id, 'customer_id' => $c, 'type' => 'collection'])->whereBetween('date', [$from . '-00-00-00', $to . '-23-59-59'])->get();
                    $customer_name = $c_transactions[0]->customer->name;
                    $amount = 0;
                    foreach ($c_transactions as $tt) {
                        $amount += $tt->amount;
                    }
                    $ar = array("y" => $amount, "label" =>  $customer_name);

                    array_push($data, $ar);
                }

                // $data = json_encode($data, JSON_NUMERIC_CHECK);

                $info = [
                    "type" => "customers",
                    "detail" => "customers summary",
                    "data" => $data
                ];
                return $info;
            }

            if ($type == "devices") {
                $dev = [];
                foreach ($transactions as $t) {
                    array_push($dev, $t->device_id);
                }
                $devices = array_unique($dev);

                // same for customers
                $data = [];
                foreach ($devices as $d) {
                    $d_transactions = Transaction::where(['org_id' => Auth::user()->organization_id, 'device_id' => $d, 'type' => 'collection'])->whereBetween('date', [$from . '-00-00-00', $to . '-23-59-59'])->get();

                    // return $d_transactions;
                    $device_name = $d_transactions[0]->device->name;
                    $amount = 0;
                    foreach ($d_transactions as $tt) {
                        $amount += $tt->amount;
                    }
                    $ar = array("y" => $amount, "label" =>  $device_name);

                    array_push($data, $ar);
                }

                // $data = json_encode($data, JSON_NUMERIC_CHECK);

                $info = [
                    "type" => "Communities",
                    "detail" => "community summary",
                    "data" => $data
                ];
                return $info;
            }
        }
        // return $request->all();
    }
}
