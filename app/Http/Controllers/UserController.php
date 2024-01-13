<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function exportExcel(){
        return Excel::download(new UsersExport, 'users.xlsx');
    }
    public function updateUser(Request $request, User $user)
    {
        if ($request->method() == 'GET') {


            $userdata = $user->where('id',$request->id)->first();
            return view('dashboard.signup',['userdata'=>$userdata]);
        } else if ($request->method() == 'POST') {
            $rules = [
                'fname' => 'required|min:3|max:50',
                'email' => 'required|unique:users,email,'.$request->id,
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
                $userdata = $user->where('id',$request->id)->first();

                $userdata->name = $request->fname;
                $userdata->email = $request->email;
                $userdata->password = bcrypt($request->password);
                $userdata->dob = $request->dob;
                $userdata->age = Carbon::parse($request->dob)->age; // auto
                $userdata->gender = $request->gender;
                $userdata->mobile = $request->mobile;
                $userdata->address = $request->city . ' ' . $request->pincode . ' ' . $request->state;
                $userdata->city = $request->city;
                $userdata->pincode = $request->pincode;
                $userdata->state = $request->state;


                if ($userdata->update()) {
                    return redirect('/dashboard/user/list')->with('status', "User Updated");
                } else {
                    return redirect()->back()->with('status', "User Update Fails");
                }
            }
        }
    }
    public function deleteUser(Request $request, User $user)
    {
        $userdata = $user->find($request->id);
        if (is_null($userdata)) return redirect('/dashboard/user/list')->with('status', 'User Not Found');
        if ($userdata->delete()) {
            return redirect('/dashboard/user/list')->with('status', "User Deleted");
        } else {
            return redirect()->back()->with('status', "User Delete Fails");
        }
    }
    public function listUser(User $user)
    {
        $userdata = User::paginate(50);

        return view('dashboard.list-users', ['userdata' => $userdata]);
    }
}
