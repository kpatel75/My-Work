<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use App\Models\TypeOfActivity;
use Illuminate\Http\Request;

class TypeOfActivityController extends Controller
{
    public function index()
    {
        return view('type-of-activity');
    }

    public function create(Request $input)
    {
        $input = request()->validate([
            'activity' => ['required', 'string', 'max:100'],
        ]);

        TypeOfActivity::create([
            'activity' => $input['activity']
        ]); 
        LogActivity::log('Create', "Create activity type".$input['activity']);
        return redirect()->back()->with("success","New activity type successfully added.");
    }
}
