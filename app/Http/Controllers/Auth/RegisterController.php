<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AdminRole;
use App\Models\Organization;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        // dd($data);

        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'g_name' => ['required', 'string', 'max:255'],
            'g_phone' => ['string', 'max:255'],
            'g_description' => ['string', 'max:255'],
            'g_address' => ['string', 'max:255'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {

        $role = AdminRole::where('name', 'admin')->get();

        $organization = Organization::create([
            'name' => $data['g_name'],
            'description' => $data['g_description'],
            'address' => $data['g_address'],
            'phone' => $data['g_phone'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
        ]);

        User::where('id', '=', $user->id)->update([
            'organization_id' => $organization->id,
            'admin_role_id' => $role[0]->id,
        ]);


        Organization::where('id', '=', $organization->id)->update([
            'logo' => "default.jpg",
        ]);

        // $name = $data['g_name'];
        // $description = $data['g_description'];
        // $logo = url('/storage/pic/default.jpg');
        // $phone = $data['g_phone'];
        // $hash = hash('sha512', $name . $description . $logo . $phone);

        // $url = 'https://api.ajisaqsolutions.com/api/organization/add?apiUser=' .
        //     config('app.apiUser') . '&apiKey=' .
        //     config('app.apiKey') . '&hash=' .
        //     $hash . '&id=' .
        //     $organization->id . '&name=' .
        //     $name . '&description=' .
        //     $description . '&logoUrl=' .
        //     $logo . '&phone=' . $phone;

        // $response = Http::post($url);

        // $res = json_decode($response);

        // // dd($res);

        // if ($res->status != 'Ok') {
        //     return [0];
        //     // back()->with("error", "Sorry! Our system is having issues at this Time. but out Support Team are on it. ");
        // }

        return $user;
    }
}
