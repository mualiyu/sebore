<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     * 
     */
    public function index()
    {

        return view('home');
    }

    public function show_profile()
    {
        $organization = Organization::find(Auth::user()->organization_id);
        $user = Auth::user();

        return view('profile.profile', compact('organization', 'user'));
    }

    public function show_users()
    {
        $users = User::where('organization_id', '=', Auth::user()->organization_id)->orderBy('created_at', 'desc')->get();

        return view('users.index', compact('users'));
    }

    public function show_add_user()
    {
        return view('users.add_user');
    }

    public function create_user(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string']
        ]);
        if ($validator->fails()) {
            // dd($validator);
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'password' => Hash::make($request['password']),
            'role' => $request['role'],
        ]);

        User::where('id', '=', $user->id)->update([
            'organization_id' => Auth::user()->organization_id,
        ]);

        return redirect('/users')->with(['success' => 'New User is Created']);
    }

    public function update_user(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'role' => ['required', 'string'],
        ]);
        if ($validator->fails()) {
            return back()->with('error', 'User not Updated. Try again!');
        }

        $user = User::where('id', '=', Auth::user()->id)->update([
            'name' => $request['name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'role' => $request['role'],
        ]);

        return redirect()->route('profile')->with(['success' => 'Profile is Updated']);
    }

    public function update_organization(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'address' => ['required', 'string'],
        ]);
        if ($validator->fails()) {
            return back()->with('error', 'Organization not Updated. Try again!');
        }

        $user = Organization::where('id', '=', $id)->update([
            'name' => $request['name'],
            'description' => $request['description'],
            'phone' => $request['phone'],
            'address' => $request['address'],
        ]);

        return redirect()->route('profile')->with(['success' => 'Organization is Updated']);
    }

    public function update_org_pic(Request $request, $id)
    {

        // dd($user[0]->picture);
        $validator = Validator::make($request->all(), [
            "image" => "image|mimes:jpeg,jpg,png,gif|max:9000",
        ]);

        if ($validator->fails()) {
            return back()->with('error', 'Organization Logo not Uploaded. Try again!');
        }

        if ($request->hasFile("image")) {
            $imageNameWExt = $request->file("image")->getClientOriginalName();
            $imageName = pathinfo($imageNameWExt, PATHINFO_FILENAME);
            $imageExt = $request->file("image")->getClientOriginalExtension();

            $imageNameToStore = $imageName . "_" . time() . "." . $imageExt;

            $request->file("image")->storeAs("public/pic", $imageNameToStore);
        } else {
            // $imageNameToStore = $user[0]->picture;
            return back()->with('error', 'Organization Logo not Uploaded. Try again!');
        }

        $arrayToStore = [
            "logo" => $imageNameToStore,
        ];
        Organization::where('id', '=', $id)->update($arrayToStore);


        return redirect()->route("profile")->with(['success' => "Organization Logo is Uploaded and Updated."]);
    }



    public function change_user_role(Request $request)
    {
        dd($request->all());
    }

    public function show_single_user($id)
    {
        $user = User::find($id);

        return view('users.profile', compact('user'));
    }

    public function delete_user($id)
    {
        $res = User::where('id', $id)->delete();

        if ($res) {
            return back()->with(['success' => 'One User is Deleted from system']);
        } else {
            return back()->with(['error' => 'User NOT Deleted. Try Again!']);
        }
    }

    public function update_single_user(Request $request, $id)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'role' => ['required', 'string'],
        ]);
        if ($validator->fails()) {
            return back()->with('error', 'User not Updated. Try again!');
        }

        $user = User::where('id', '=', $id)->update([
            'name' => $request['name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'role' => $request['role'],
        ]);

        if ($user) {
            return back()->with(['success' => 'Profile is Updated']);
        } else {
            return back()->with('error', 'User not Updated. Try again!');
        }

        // dd($request->all());
    }
}
