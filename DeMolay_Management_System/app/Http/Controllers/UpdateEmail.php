<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UpdateEmail extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function updateEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email']
        ]);
        if (Auth::user()->email == $request->input('email')) {
            return back()->with('error', 'Must enter different email address than current one');
        }
        $id = Auth::user()->id;
        $email = $request->input('email');
        $exists = DB::table('users')->where('email',$email)->first();
        if(empty($exists)){
            $user = DB::table('users')->where('id', $id)->update(['email' => $email]); 
            //for logging purposes
            $logmessage =  "Update email to $email on user". Auth::user()->first_name." ".Auth::user()->last_name;
            LogActivity::log('Update', $logmessage);
            return back()->with('success', 'Email updated!');
        }
        else{
            return back()->with('error', 'This email is alredy in use');
        }
    }
}
