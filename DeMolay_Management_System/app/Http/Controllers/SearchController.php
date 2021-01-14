<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Role;



class SearchController extends Controller
{
  
    public function search(){

        if (Auth::user()->jurisdiction_id == null && Auth::user()->chapter_id == null) {
            $members = DB::table('members')
                ->select('members.id', 'members.first_name', 'members.last_name', 
                'members.email', 'positions.position_name')
                ->leftjoin('positions', 'positions.id', '=', 'members.position_id')
                ->get();
        }else if (Auth::user()->chapter_id == null) {
            $members = DB::table('members')
                    ->select('members.id', 'members.first_name', 'members.last_name', 
                    'members.email', 'positions.position_name')
                    ->leftjoin('positions', 'positions.id', '=', 'members.position_id')
                    ->where('members.jurisdiction_id', '=', Auth::user()->jurisdiction_id)
                    ->get();
        } else {
            $members = DB::table('members')
                    ->select('members.id', 'members.first_name', 'members.last_name', 
                    'members.email', 'positions.position_name')
                    ->leftjoin('positions', 'positions.id', '=', 'members.position_id')
                    ->where([
                        ['members.chapter_id', '=', Auth::user()->chapter_id],
                        ['members.jurisdiction_id', '=', Auth::user()->jurisdiction_id]
                    ])
                    ->get();
        }

          return view('auth.search', ['members'=>$members]);
  
      }
      

}


    
