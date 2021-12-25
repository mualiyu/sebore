<?php

namespace App\Http\Controllers\Agents;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
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
        $agent = session('Agent');
        // return $agent;

        $d = now();
        $da = explode("T", $d);
        $date = explode(" ", $da[0]);

        $from = $date[0];
        $to = $date[0];
        // $from = "2021-08-28";
        // $to = "2021-08-28";

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

        $transactions = [];
        $org = $agent->org;
        $transactions = Transaction::where(['org_id' => $org->id, 'agent_id' => $agent->id])->whereBetween('date', [$from . '-00-00-01', $to . '-23-59-59'])->get();

        if ($org->theme) {
            if ($org->theme == 1) {
                $card1 = 'rgb(94,46,46)';
                $card2 = 'rgb(109,61,61)';
                $card3 = 'rgb(127,79,79)';
            } elseif ($org->theme == 2) {
                $card1 = 'rgb(126,170,57)';
                $card2 = 'rgb(124,155,76)';
                $card3 = 'rgb(139,170,91)';
            } elseif ($org->theme == 3) {
                $card1 = 'rgb(75, 70, 245)';
                $card2 = 'rgb(75, 70, 235)';
                $card3 = 'rgb(75, 70, 225)';
            } else {
                $card1 = 'rgb(109, 41, 41)';
                $card2 = 'rgb(100, 41, 41)';
                $card3 = 'rgb(91, 41, 41)';
            }
        } else {
            $card1 = 'rgb(109, 41, 41)';
            $card2 = 'rgb(100, 41, 41)';
            $card3 = 'rgb(91, 41, 41)';
        }

        return view('sites.agent.index', compact('agent', 'transactions', 'card1', 'card2', 'card3', 'from', 'to', 'months'));
    }


    public function show_agent_profile()
    {
        $a = session('Agent');

        $agent = Agent::find($a->id);

        return view('sites.agent.profile.agent_profile', compact('agent'));
    }

    public function update_agent(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'lga' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'gps' => ['nullable', 'string', 'max:255'],
            'role' => ['required', 'string'],
        ]);
        if ($validator->fails()) {
            return back()->with('error', 'Fail to update Agent. Try again!');
        }


        $agent = Agent::where('id', '=', $id)->update([
            'name' => $request['name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'agent_role_id' => $request['role'],
            'username' => $request['username'],
            'gps' => $request['gps'],
            'state' => $request['state'],
            'country' => $request['country'],
            'address' => $request['address'],
            'lga' => $request['lga'],
        ]);


        return redirect()->route('agent_show_agent_profile')->with(['success' => $request['name'] . ' is Updated']);

        // dd($request->all());
    }
}
