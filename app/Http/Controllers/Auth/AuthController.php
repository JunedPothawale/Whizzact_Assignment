<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function viewSignUp()
    {
        $pincode = Storage::disk('local')->get('/json/pincode.json');
        return view('signup', ['pincode' => $pincode]);
    }

    public function signUp(Request $request, User $user)
    {
        // dd(Carbon::parse($request->dob)->age);
        $rules = [
            'fname' => 'required|min:3|max:50',
            'email' => 'required|unique:users,email',
            'password' => 'required',
            'password_confirmation' => 'required|same:password',
            'dob' => 'required',
            'gender' => 'required|in:0,1',
            'pincode' => 'required',
            'mobile' => 'required',
            'city' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        } else {
            $userdata = [
                $user->name = $request->fname,
                $user->email = $request->email,
                $user->password = bcrypt($request->password),
                $user->dob = $request->dob,
                $user->age = Carbon::parse($request->dob)->age, // auto
                $user->gender = $request->gender,
                $user->mobile = $request->mobile,
                $user->address = $request->city . ' ' . $request->pincode . ' ' . $request->state,
                $user->city = $request->city,
                $user->pincode = $request->pincode,
                $user->state = $request->state
            ];

            if ($user->save($userdata)) {
                return redirect('/dashboard')->with('status', "Login Success");
            } else {
                return redirect()->back()->with('status', "Sign Up fail");
            }
        }
    }
    public function logIn(Request $request)
    {
        $rules = [
            'email' => 'required|email|max:50',
            'password' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect('/login')->withErrors($validator->errors());
        } else {

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return redirect('/dashboard')->with('status', 'Welcome');
            } else {
                return redirect('/login')->with('status', 'Invalid Creadentials');
            }
        }
    }
    public function logOut()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function loginApi(Request $request)
    {
        $data = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($data)) {
            return response(['error_message' => 'Incorrect Details.
            Please try again']);
        }
        $user = auth()->user();
        $token = $user->createToken('auth_token')->accessToken;
        return response(['user' => auth()->user(), 'token' => $token]);
    }
}
