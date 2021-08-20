<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\AgentRole;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class AgentController extends Controller
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


    public function show_agents()
    {
        $agents = Agent::where('org_id', '=', Auth::user()->organization_id)->orderBy('created_at', 'desc')->get();

        return view('agents.index', compact('agents'));
    }

    public function show_single_agent($id)
    {
        $agent = Agent::find($id);

        return view('agents.agent_profile', compact('agent'));
    }

    public function show_add_agent()
    {
        return view('agents.add_agent');
    }

    public function create_agent(Request $request)
    {
        $org = Organization::find(Auth::user()->organization_id);

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:agents'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'lga' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'gps' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string'],
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        // dd($org->uuid);
        $role = AgentRole::find($request['role']);
        //Api
        $hash = hash(
            'sha512',
            $org->uuid .
                $request['name'] .
                $request['email'] .
                $request['password'] .
                $request['phone'] .
                $role->name
        );
        $url = 'https://api.ajisaqsolutions.com/api/agent/add?apiUser=' .
            config('app.apiUser') . '&apiKey=' .
            config('app.apiKey') . '&hash=' .
            $hash . '&organizationId=' .
            $org->uuid . '&name=' .
            $request['name'] . '&email=' .
            $request['email'] . '&password=' .
            $request['password'] . '&phone=' .
            $request['phone'] . '&type=' .
            $role->name;


        $response = Http::post($url);
        $res = json_decode($response);

        // dd($res);
        if ($res->status != "Ok") {
            return back()->with(['error' => 'Sorry, An error was encountered, Please try again later.'])->withInput();
        }
        //End Api

        $agent = Agent::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'password' => Hash::make($request['password']),
            'agent_role_id' => $request['role'],
            'username' => $request['username'],
            'gps' => $request['gps'],
            'state' => $request['state'],
            'country' => $request['country'],
            'address' => $request['address'],
            'lga' => $request['lga'],
        ]);

        Agent::where('id', '=', $agent->id)->update([
            'user_id' => Auth::user()->id,
            'org_id' => Auth::user()->organization_id,
            'uuid' => $res->data->id,
        ]);

        return redirect('/agents')->with(['success' => $agent->name . ' is Created to system']);

        // dd($request->all());
    }

    public function update_agent(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'lga' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'gps' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string'],
        ]);
        if ($validator->fails()) {
            return back()->with('error', 'Agent not Created. Try again!');
        }
        // dd($request->all());

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


        return redirect()->route('show_single_agent', ['id' => $id])->with(['success' => $request['name'] . ' is Updated']);

        // dd($request->all());
    }
}
