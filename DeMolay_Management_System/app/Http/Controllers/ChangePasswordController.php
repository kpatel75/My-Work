<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;


class changePasswordController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

   public function showChangePasswordForm(){
       return view('auth.changePassword');
    }

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function changePassword(Request $request){

        if (!(Hash::check($request->get('current-password'), auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
        }

        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            //Current password and new password are same
            return redirect()->back()->with("error","New Password cannot be same as your current password. Please choose a different password.");
        }

        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed',
        ]);

        //Change Password
        $user = auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();
        
        LogActivity::log('Update', "User Update password");

        return redirect()->back()->with("success","Password changed successfully !");

    }
    
}
