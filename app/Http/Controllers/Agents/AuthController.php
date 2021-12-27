<?php

namespace App\Http\Controllers\Agents;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    //

    public function login(Request $request, Closure $next)
    {

        $request->validate([
            'user' => 'required',
            'pin' => 'required',
        ]);

        $credentials = $request->only('user', 'pin');

        $user = $request->user;

        if (is_numeric($user) == true) {
            $agent = Agent::where('phone', '=', $user)->get();
        } else {
            $agent = Agent::where('username', '=', $user)->get();
        }

        if (count($agent) > 0) {

            if (Hash::check($request->pin, $agent[0]->password)) {
                # code...
                $a = Agent::where('id', '=', $agent[0]->id)->with('org')->get();

                session(['Agent' => $a[0]]);

                return redirect()->route('agent_dashboard');
            } else {
                return back()->with('error', "Pin not correct");
            }
        } else {

            return back()->with('Username or Phone is not found');
        }

        return redirect("login")->withSuccess('Login details are not valid');
    }


    public function signOut()
    {
        Session::flush();
        Auth::logout();

        return Redirect('login');
    }
}
