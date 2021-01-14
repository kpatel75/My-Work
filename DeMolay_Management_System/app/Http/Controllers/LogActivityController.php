<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class LogActivityController extends Controller
{
    // 
    public function index()
    {
        $logitems = DB::table('activity_logs')->get();  

        return view('admin.logs', ['logitems'=>$logitems]);

    }
}
