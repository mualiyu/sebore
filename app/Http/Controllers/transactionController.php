<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Device;
use App\Models\Item;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class transactionController extends Controller
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
        return view('transactions.index');
    }

    public function get_transaction_list(Request $request)
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

        // if load type is set to all
        if ($request->request_type == "all") {

            $hash = hash(
                'sha512',
                $from .
                    $to
            );

            $url = 'https://api.ajisaqsolutions.com/api/transaction/list?apiUser=' . config('app.apiUser') .
                '&apiKey=' . config('app.apiKey') .
                '&hash=' . $hash .
                '&from=' . $from .
                '&to=' . $to;
            // dd($hash . "   " . $from . "  " . $to);

            if (
                $response = Http::get($url)
            ) {
                $res = json_decode($response);
                // return $response;
                if ($res->status == 'Ok') {
                    if (count($res->data) > 0) {
                        $transactions = $res->data;
                        return view('transactions.all', compact('transactions', 'from', 'to', 'months'));
                    } else {
                        return back()->with('error', 'No Transaction Within this range. Try Again!');
                    }
                } else {
                    return back()->with('error', 'Service Error, Try again later!');
                }
            }
        }

        // load transactions by customer
        if ($request->request_type == "customer") {
            if (!$request->data_d) {
                return back()->with('error', 'Make sure you select Customer.');
            }
            $customer = Customer::find($request->data_d);
            $hash = hash(
                'sha512',
                $customer->phone .
                    $from .
                    $to
            );

            $url = 'https://api.ajisaqsolutions.com/api/transaction/listByCustomer?apiUser=' . config('app.apiUser') .
                '&apiKey=' . config('app.apiKey') .
                '&hash=' . $hash .
                '&customerId=' . $customer->phone .
                '&from=' . $from .
                '&to=' . $to;
            // dd($url);
            if (
                $response = Http::get($url)
            ) {
                $res = json_decode($response);
                // return $response;
                if ($res->status == 'Ok') {
                    if (count($res->data) > 0) {
                        $transactions = $res->data;
                        // dd($res);
                        return view('transactions.customers', compact('transactions', 'customer', 'from', 'to', 'months'));
                    } else {
                        return back()->with('error', 'No Transaction for this Customer.');
                    }
                } else {
                    return back()->with('error', 'Service Error, Try again later!');
                }
            }
        }


        // load transactions by Agent
        if ($request->request_type == "agent") {
            if (!$request->data_d) {
                return back()->with('error', 'Make sure you select Agent.');
            }
            $agent = Agent::find($request->data_d);
            $hash = hash(
                'sha512',
                $agent->phone .
                    $from .
                    $to
            );

            $url = 'https://api.ajisaqsolutions.com/api/transaction/listByAgent?apiUser=' . config('app.apiUser') .
                '&apiKey=' . config('app.apiKey') .
                '&hash=' . $hash .
                '&agentId=' . $agent->phone .
                '&from=' . $from .
                '&to=' . $to;
            // dd($url);
            if (
                $response = Http::get($url)
            ) {
                $res = json_decode($response);
                // return $response;
                if ($res->status == 'Ok') {
                    if (count($res->data) > 0) {
                        $transactions = $res->data;
                        // dd($res);
                        return view('transactions.agents', compact('transactions', 'agent', 'from', 'to', 'months'));
                    } else {
                        return back()->with('error', 'No Transaction for this Agent.');
                    }
                } else {
                    return back()->with('error', 'Service Error, Try again later!');
                }
            }
        }

        // load transactions by Device
        if ($request->request_type == "device") {
            if (!$request->data_d) {
                return back()->with('error', 'Make sure you select a device.');
            }
            $device = Device::find($request->data_d);
            $hash = hash(
                'sha512',
                $device->id .
                    $from .
                    $to
            );

            $url = 'https://api.ajisaqsolutions.com/api/transaction/listByDevice?apiUser=' . config('app.apiUser') .
                '&apiKey=' . config('app.apiKey') .
                '&hash=' . $hash .
                '&deviceId=' . $device->id .
                '&from=' . $from .
                '&to=' . $to;
            // dd($url);
            if (
                $response = Http::get($url)
            ) {
                $res = json_decode($response);
                // return $response;
                if ($res->status == 'Ok') {
                    if (count($res->data) > 0) {
                        $transactions = $res->data;
                        // dd($res);
                        return view('transactions.devices', compact('transactions', 'device', 'from', 'to', 'months'));
                    } else {
                        return back()->with('error', 'No Transaction for this Device.');
                    }
                } else {
                    return back()->with('error', 'Service Error, Try again later!');
                }
            }
        }

        // load transactions by item
        if ($request->request_type == "item") {
            if (!$request->data_d) {
                return back()->with('error', 'Make sure you select Item.');
            }
            $item = Item::find($request->data_d);
            $hash = hash(
                'sha512',
                $item->id .
                    $from .
                    $to
            );

            $url = 'https://api.ajisaqsolutions.com/api/transaction/listByItem?apiUser=' . config('app.apiUser') .
                '&apiKey=' . config('app.apiKey') .
                '&hash=' . $hash .
                '&itemId=' . $item->id .
                '&from=' . $from .
                '&to=' . $to;
            // return $hash . "   " . $item->id . "  " . $from . " " . $to;
            if (
                $response = Http::get($url)
            ) {
                $res = json_decode($response);
                // return $response;
                if ($res->status == 'Ok') {
                    if (count($res->data) > 0) {
                        $transactions = $res->data;
                        // dd($res);
                        return view('transactions.items', compact('transactions', 'item', 'from', 'to', 'months'));
                    } else {
                        return back()->with('error', 'No Transaction for this Item.');
                    }
                } else {
                    return back()->with('error', 'Service Error, Try again later!');
                }
            }
        }

        return back();
    }


    // search data from database
    public function search_data_t(Request $request)
    {
        if ($request->ajax()) {
            $output = "";

            if ($request->req_type == "customer") {  //Search by customer
                $search = $request->data;

                $customers = Customer::where('org_id', Auth::user()->organization_id);
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

                        $output .= '<li class="list-group-item"  onclick="' . "$('#load').css('display', 'block');" . '"><div class="form-check"><input class="form-check-input" type="radio" name="data_d" value="'
                            . $row->id . '" id="flexCheckDefault[' . $i . ']"><label class="form-check-label" for="flexCheckDefault[' . $i . ']">'
                            . $row->name . ' - ' . $row->email . ' - ' . $row->phone .
                            '</label></div></li>';
                        $i++;
                    }
                    $output .= '</ul>';
                } else {

                    $output .= '<li class="list-group-item">' . 'No Customer' . '</li>';
                }
                return $output;
            }
            if ($request->req_type == "agent") {  //Search by Agent
                $search = $request->data;

                $agents = Agent::where('org_id', Auth::user()->organization_id);
                if (is_string($search) && strlen($search) > 0) {

                    $agents = $agents->where(function ($q) use ($search) {
                        $q->where('name', 'LIKE', '%' . $search . '%')
                            ->orWhere('phone', 'LIKE', '%' . $search . '%')
                            ->orWhere('email', 'LIKE', '%' . $search . '%')
                            ->orWhere('address', 'LIKE', '%' . $search . '%');
                    });
                }
                $data = $agents->get();

                if (count($data) > 0) {
                    $output = '<ul class="list-group" style="display: block;">';
                    $i = 0;
                    foreach ($data as $row) {

                        $output .= '<li class="list-group-item" onclick="' . "$('#load').css('display', 'block');" . '"><div class="form-check"><input class="form-check-input" type="radio" name="data_d" value="'
                            . $row->id . '" id="flexCheckDefault[' . $i . ']"><label class="form-check-label" for="flexCheckDefault[' . $i . ']">'
                            . $row->name . ' - ' . $row->email . ' - ' . $row->phone .
                            '</label></div></li>';
                        $i++;
                    }
                    $output .= '</ul>';
                } else {

                    $output .= '<li class="list-group-item">' . 'No Agent' . '</li>';
                }
                return $output;
            }
            if ($request->req_type == "device") {  //Search by device
                $search = $request->data;

                $devices = Device::where('org_id', Auth::user()->organization_id);
                if (is_string($search) && strlen($search) > 0) {

                    $devices = $devices->where(function ($q) use ($search) {
                        $q->where('name', 'LIKE', '%' . $search . '%')
                            ->orWhere('type', 'LIKE', '%' . $search . '%')
                            ->orWhere('device_id', 'LIKE', '%' . $search . '%')
                            ->orWhere('state', 'LIKE', '%' . $search . '%');
                    });
                }
                $data = $devices->get();

                // $output = '';
                if (count($data) > 0) {
                    $output = '<ul class="list-group" style="display: block;">';
                    $i = 0;
                    foreach ($data as $row) {

                        $output .= '<li class="list-group-item" onclick="' . "$('#load').css('display', 'block');" . '"><div class="form-check"><input class="form-check-input" type="radio" name="data_d" value="'
                            . $row->id . '" id="flexCheckDefault[' . $i . ']"><label class="form-check-label" for="flexCheckDefault[' . $i . ']">'
                            . $row->name . ' - ' . $row->type  .
                            '</label></div></li>';
                        $i++;
                    }
                    $output .= '</ul>';
                } else {

                    $output .= '<li class="list-group-item">' . 'No Device' . '</li>';
                }
                return $output;
            }
            if ($request->req_type == "item") {  //Search by item
                $search = $request->data;

                $items = Item::where('org_id', Auth::user()->organization_id);
                if (is_string($search) && strlen($search) > 0) {

                    $items = $items->where(function ($q) use ($search) {
                        $q->where('name', 'LIKE', '%' . $search . '%')
                            ->orWhere('code', 'LIKE', '%' . $search . '%')
                            ->orWhere('unit', 'LIKE', '%' . $search . '%');
                        // ->orWhere('address', 'LIKE', '%' . $search . '%');
                    });
                }
                $data = $items->get();

                // $output = '';
                if (count($data) > 0) {
                    $output = '<ul class="list-group" style="display: block;">';
                    $i = 0;
                    foreach ($data as $row) {
                        $category = Category::find($row->category_id);
                        // $device = Device::find($row->device_id);
                        $output .= '<li class="list-group-item" onclick="' . "$('#load').css('display', 'block');" . '"><div class="form-check"><input class="form-check-input" type="radio" name="data_d" value="'
                            . $row->id . '" id="flexCheckDefault[' . $i . ']"><label class="form-check-label" for="flexCheckDefault[' . $i . ']">'
                            . $row->name . ' - ' . $category->name . ' - ' . $row->code .
                            '</label></div></li>';
                        $i++;
                    }
                    $output .= '</ul>';
                } else {

                    $output .= '<li class="list-group-item">' . 'No Item' . '</li>';
                }
                return $output;
            }
            // return '';
        }
    }
}