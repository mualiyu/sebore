<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Customer;
use Illuminate\Http\Request;
// use Barryvdh\DomPDF\PDF;
use Barryvdh\DomPDF\Facade as PDF;

class PdfController extends Controller
{
    public function get_customers($username)
    {
        $agent = Agent::where('username', '=', $username)->get();

        if (count($agent) > 0) {
            # code...
            $customers = Customer::where('agent_id', '=', $agent[0]->id)->get();
            $agent = $agent[0];

            $pdf = PDF::loadView('pdf.customer _qrcode', compact('agent', 'customers'))->setPaper('a4');

            return $pdf->stream('customers_(' . $agent->username . ')_' . now() . '.pdf');
        } else {
            return back()->with('error', 'Agent Not Found In System');
        }
    }
}
